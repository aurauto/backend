ARG PYTHON_VER=3.12
ARG PHP_VERSION=8.3
ARG ALPINE_VERSION=3.20
ARG WP_VERSION=6.6.2

# ==============================================
FROM php:${PHP_VERSION}-zts-alpine${ALPINE_VERSION} AS php
FROM wordpress:${WP_VERSION}-php${PHP_VERSION}-fpm AS wp-src
FROM wordpress:cli-php${PHP_VERSION} AS wp-cli

# ==============================================

FROM ubuntu AS unit
ARG PYTHON_VER
ARG PHP_VERSION

# WordPress specific php configuration
COPY --from=wp-src ["/usr/local/etc/php/conf.d/opcache-recommended.ini", "/usr/local/etc/php/conf.d/error-logging.ini", "/usr/local/etc/php/conf.d/"]
COPY --from=php ["/usr/local/bin/docker-php-ext-configure", "/usr/local/bin/docker-php-ext-install", "/usr/local/bin/docker-php-ext-enable", "/usr/local/bin/docker-php-source", "/usr/local/bin/"]
COPY --from=php /usr/src/php.tar.xz /usr/src/php.tar.xz

RUN set -eux; \
    savedAptMark="$(apt-mark showmanual)"; \
    apt update && \
    apt install -y build-essential software-properties-common && \
    add-apt-repository ppa:deadsnakes/ppa && \
    add-apt-repository ppa:chris-needham/ppa && \
    apt update && \
    apt install -y \
      bash \
      build-essential \
      ca-certificates \
      cron \
      curl \
      ffmpeg \
      fonts-dejavu \
      fonts-liberation \
      freetds-dev \
      ghostscript \
      git \
      imagemagick \
      libargon2-dev \
      libaspell-dev \
      libatomic-ops-dev \
      libcurl4-openssl-dev \
      libdawgdic-dev \
      libfreetype-dev \
      libgettextpo-dev \
      libicu-dev \
      libjpeg-turbo8-dev \
      libmagickcore-dev \
      libmagickwand-dev \
      libmemcached-dev \
      libmsgpack-dev \
      libonig-dev \
      libpcre2-dev \
      libpcre3-dev \
      libpng-dev \
      libpq-dev \
      libreadline-dev \
      libsodium-dev \
      libsqlite3-dev \
      libssl-dev \
      libwebp-dev \
      libxml2-dev \
      libxslt-dev \
      libzip-dev \
      m4 \
      njs \
      pkg-config \
      php-imagick-all-dev \
      php-parser \
      php${PHP_VERSION} \
      php${PHP_VERSION}-cgi \
      php${PHP_VERSION}-cli \
      php${PHP_VERSION}-common \
      php${PHP_VERSION}-dev \
      php${PHP_VERSION}-fpm \
      php${PHP_VERSION}-imagick \
      python${PYTHON_VER} \
      python${PYTHON_VER}-dev \
      python${PYTHON_VER}-full \
      python${PYTHON_VER}-venv \
      python3-pip \
      tzdata \
      wget \
      zlib1g-dev

ENV PHP_INI_DIR /usr/local/etc/php
RUN set -eux; \
	mkdir -p "$PHP_INI_DIR/conf.d"; \
	mkdir -p /var/www/html; \
	chown www-data:www-data /var/www/html; \
	chmod 1777 /var/www/html

# Apply stack smash protection to functions using local buffers and alloca()
# Make PHP's main executable position-independent (improves ASLR security mechanism, and has no performance impact on x86_64)
# Enable optimization (-O2)
# Enable linker optimization (this sorts the hash buckets to improve cache locality, and is non-default)
# https://github.com/docker-library/php/issues/272
# -D_LARGEFILE_SOURCE and -D_FILE_OFFSET_BITS=64 (https://www.php.net/manual/en/intro.filesystem.php)
ENV PHP_CFLAGS="-fstack-protector-strong -fpic -fpie -O2 -D_LARGEFILE_SOURCE -D_FILE_OFFSET_BITS=64"
ENV PHP_CPPFLAGS="$PHP_CFLAGS"
ENV PHP_LDFLAGS="-Wl,-O1 -pie"

# Install php
RUN set -eux; \
	export \
		CFLAGS="$PHP_CFLAGS" \
		CPPFLAGS="$PHP_CPPFLAGS" \
		LDFLAGS="$PHP_LDFLAGS" \
	; \
	docker-php-source extract; \
	cd /usr/src/php; \
	gnuArch="$(dpkg-architecture --query DEB_BUILD_GNU_TYPE)"; \
	debMultiarch="$(dpkg-architecture --query DEB_BUILD_MULTIARCH)"; \
	if [ ! -d /usr/include/curl ]; then \
		ln -sT "/usr/include/$debMultiarch/curl" /usr/local/include/curl; \
	fi; \
	./configure \
		--build="$gnuArch" \
		--with-config-file-path="$PHP_INI_DIR" \
		--with-config-file-scan-dir="$PHP_INI_DIR/conf.d" \
		--enable-option-checking=fatal \
		--with-mhash \
		--with-pic \
		--enable-mbstring \
		--enable-mysqlnd \
		--with-password-argon2 \
		--with-sodium=shared \
		--with-pdo-sqlite=/usr \
		--with-sqlite3=/usr \
		--with-curl \
		--with-iconv \
		--with-openssl \
		--with-readline \
		--with-zlib \
		--enable-phpdbg \
		--enable-phpdbg-readline \
		--with-pear \
		$(test "$gnuArch" = 's390x-linux-gnu' && echo '--without-pcre-jit') \
		--with-libdir="lib/$debMultiarch" \
		--enable-embed \
	; \
	make -j "$(nproc)"; \
	find -type f -name '*.a' -delete; \
	make install; \
	find \
		/usr/local \
		-type f \
		-perm '/0111' \
		-exec sh -euxc ' \
			strip --strip-all "$@" || : \
		' -- '{}' + \
	; \
	make clean; \
	cp -v php.ini-* "$PHP_INI_DIR/"; \
	cd /; \
	docker-php-source delete; \
	php --version

# Install php extensions
ENV PHP_INI_DIR=/usr/local/etc/php
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-configure opcache --enable-opcache && \
    apt install -y freetds-dev libsqlite3-dev libargon2-dev && \
    docker-php-ext-install -j "$(nproc)" \
      bcmath \
      exif \
      gd \
      intl \
      mysqli \
      opcache \
      pdo \
      pdo_dblib \
      pdo_mysql \
      pdo_pgsql \
      pdo_sqlite \
      pgsql \
      xsl \
      xml \
      zip && \
    pecl channel-update pecl.php.net && \
    pecl install apcu && \
    docker-php-ext-enable apcu && \
    pecl install \
      igbinary \
      memcached \
      msgpack \
      redis && \
    docker-php-ext-enable \
      igbinary \
      memcached \
      msgpack \
      redis && \
    apt install -y \
      php${PHP_VERSION}-cgi \
      php${PHP_VERSION}-cli \
      php${PHP_VERSION}-fpm

# Install Nginx unit
RUN cd /tmp && \
    git clone https://github.com/nginx/unit.git  && \
    cd unit && \
    NCPU="$(getconf _NPROCESSORS_ONLN)" && \
    DEB_HOST_MULTIARCH="$(dpkg-architecture -q DEB_HOST_MULTIARCH)" && \
    CONFIGURE_ARGS_MODULES="--prefix=/usr \
      --modules=/lib \
      --statedir=/var/lib/unit \
      --control=unix:/var/run/control.unit.sock \
      --runstatedir=/var/run \
      --pid=/var/run/unit.pid \
      --logdir=/var/log \
      --log=/dev/stdout \
      --tmpdir=/var/tmp \
      --user=unit \
      --group=unit \
      --openssl \
      --libdir=/usr/lib/$DEB_HOST_MULTIARCH" && \
    CONFIGURE_ARGS="$CONFIGURE_ARGS_MODULES \
      --njs" && \
    make -j $NCPU -C pkg/contrib .njs && \
    export PKG_CONFIG_PATH=$(pwd)/pkg/contrib/njs/build && \
#    ./configure $CONFIGURE_ARGS --modulesdir=/usr/lib/unit/debug-modules --debug && \
#    make -j $NCPU unitd && \
#    install -pm755 build/sbin/unitd /usr/sbin/unitd-debug && \
#    make clean && \
    ./configure $CONFIGURE_ARGS --modulesdir=/usr/lib/unit/modules && \
    make -j $NCPU unitd && \
    install -pm755 build/sbin/unitd /usr/sbin/unitd && \
    make clean && \
    /bin/true && \
#    ./configure $CONFIGURE_ARGS_MODULES --modulesdir=/usr/lib/unit/debug-modules --debug && \
    ./configure $CONFIGURE_ARGS_MODULES --modulesdir=/usr/lib/unit/modules && \
    ./configure php && \
    make -j $NCPU php && \
    make -j $NCPU php-install && \
    rm -rf /usr/src/unit && \
    ldconfig && \
    mkdir -p /var/lib/unit/ && \
    ./configure python \
      --lib-path=/lib \
      --config="python${PYTHON_VER}-config --embed" && \
    make && \
    make install && \
    make -j $NCPU python${PYTHON_VER} && \
    make -j $NCPU python${PYTHON_VER}-install && \
    apt clean && \
    rm -rf /tmp/unit*

COPY --from=wp-src ["/usr/src/wordpress/", "/var/www/html/"]
COPY --from=wp-cli ["/usr/local/bin/wp", "/usr/local/bin/wp"]

RUN groupadd --gid 9999 unit && \
    useradd \
      --uid 9999 \
      --gid unit \
      --no-create-home \
      --home /nonexistent \
      --comment "unit user" \
      --shell /bin/false \
      unit && \
    mkdir -p /var/www/html/wp-content/languages && \
    mkdir -p /var/www/html/wp-content/themes && \
    mkdir -p /var/www/html/wp-content/plugins && \
    mkdir -p /var/www/html/wp-content/uploads && \
    mkdir -p /etc/crontabs && \
    chown -R www-data:www-data /var/www/html/wp-content && \
    echo "* * * * * /usr/local/bin/wp cron event run --due-now" >> /etc/crontabs/www-data

STOPSIGNAL SIGTERM
COPY ./unit.json /docker-entrypoint.d/
COPY ./docker-entrypoint.sh /usr/local/bin/
COPY ["./welcome/welcome.json", "./welcome/welcome.html", "./welcome/welcome.md", "/usr/share/unit/welcome/"]
CMD ["/usr/local/bin/docker-entrypoint.sh", "unitd", "--no-daemon", "--control", "unix:/var/run/control.unit.sock"]

# ==============================================

FROM unit

COPY ./requirements.txt /tmp/requirements.txt
RUN mkdir -p /usr/tmp && \
    chmod 777 /usr/tmp && \
    chmod 777 /usr/local/bin/docker-entrypoint.sh && \
    python3 -m venv /opt/venv

ENV PATH=/opt/venv/bin:${PATH}
RUN . /opt/venv/bin/activate && \
    pip install -U pip setuptools wheel && \
    pip install -Ur /tmp/requirements.txt

COPY ./aurauto /app/aurauto
ENV PYTHONPATH=/app/aurauto

ARG CI_COMMIT_SHORT_SHA
ARG CI_COMMIT_MESSAGE
ENV COMMIT_HASH=${CI_COMMIT_SHORT_SHA}
ENV COMMIT_MESSAGE=${CI_COMMIT_MESSAGE}

WORKDIR /app/aurauto
