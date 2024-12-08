<?php
/**
 * Aurauto functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Aurauto
 */

 require_once('api.php');

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.21' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function aurauto_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Aurauto, use a find and replace
		* to change 'aurauto' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'aurauto', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'aurauto' ),
			'menu-footer' => esc_html__( 'Footer', 'aurauto' )
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'aurauto_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'aurauto_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function aurauto_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'aurauto_content_width', 640 );
}
add_action( 'after_setup_theme', 'aurauto_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function aurauto_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'aurauto' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'aurauto' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'aurauto_widgets_init' );
add_action( 'init', 'true_jquery_register' );
 
function true_jquery_register() {
	if ( !is_admin() ) {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', ( 'https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js' ), false, null, true );
		wp_enqueue_script( 'jquery' );
	}
}
/**
 * Enqueue scripts and styles.
 */
function aurauto_scripts() {
  wp_enqueue_style( 'aurauto-slick', get_template_directory_uri() . '/assets/css/slick.css', array(), _S_VERSION );
	wp_enqueue_style( 'aurauto-style', get_stylesheet_uri(), array(), _S_VERSION );
  wp_enqueue_style( 'aurauto-css', get_template_directory_uri() . '/assets/css/main.css', array(), _S_VERSION );
    // if( is_page_template('page-catalog.php')) {
      wp_enqueue_style( 'aurauto-catalog', get_template_directory_uri() . '/assets/css/catalog.css', array(), _S_VERSION );
      // }
        if( is_page_template('page-card.php')) {
    wp_enqueue_style( 'aurauto-card', get_template_directory_uri() . '/assets/css/card.css', array(), _S_VERSION );
  }
	wp_style_add_data( 'aurauto-style', 'rtl', 'replace' );
	wp_enqueue_script( 'aurauto-open', get_template_directory_uri() . '/assets/js/open.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'aurauto-slick-js', get_template_directory_uri() . '/assets/js/slick.min.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'aurauto-scripts', get_template_directory_uri() . '/assets/js/scripts.js', array(), _S_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'aurauto_scripts' );
add_action( 'wp_enqueue_scripts', 'jquery_scripts' );
 
function jquery_scripts() {
 
	wp_enqueue_script( 'jquery' );
	wp_register_script( 'ajax-script', get_template_directory_uri() . '/assets/js/ajax-script.js', array( 'jquery' ), time(), true );
  wp_localize_script( 'ajax-script', 'true_obj', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
	wp_enqueue_script( 'ajax-script' );
 
}
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
function transliterate($text) {
  $translit = array(
      'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
      'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
      'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
      'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
      'у' => 'u', 'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch',
      'ш' => 'sh', 'щ' => 'shch', 'ъ' => '', 'ы' => 'y', 'ь' => '',
      'э' => 'e', 'ю' => 'yu', 'я' => 'ya'
  );
    // Преобразование текста в нижний регистр и транслитерация
    $transliterated = strtr(mb_strtolower($text), $translit);

    // Замена пробелов на нижнее подчеркивание
    $transliterated = str_replace(' ', '_', $transliterated);

    return $transliterated;
}

function fetch_api_data($url, $transient_key, $expiration = 3600) {
    // Проверить, есть ли данные в кэше
    if (false === ($data = get_transient($transient_key))) {
        // Данных в кэше нет, загружаем их с API
        $response = file_get_contents($url);
        $data = json_decode($response);
        // Сохранить данные в кэше
        set_transient($transient_key, $data, $expiration);
    }
    return $data;
}
add_action( 'wp_ajax_currencychange', 'change_currence_price' ); 
add_action( 'wp_ajax_nopriv_currencychange', 'change_currence_price' );
function change_currence_price() {
  $price = $_POST['price'];
  $currency = $_POST['currency'];
  $currencylayer = file_get_contents("http://localhost/api/currencies/");
  $currencylayerArray = json_decode($currencylayer, true);
  echo number_format($price * $currencylayerArray[$currency], 0, '', ' ');
  die();
}

function load_template_part($template_name, $part_name=null, $args) {
    ob_start();
    get_template_part($template_name, $part_name, $args);
    $var = ob_get_contents();
    ob_end_clean();
    return $var;
}

// Установка лайка
add_action( 'wp_ajax_likeauto', 'true_likeauto_function' ); 
add_action( 'wp_ajax_nopriv_likeauto', 'true_likeauto_function' );
 
function true_likeauto_function(){
  $idAuto = $_POST['id'];
  $cur_user_id = get_current_user_id();
  $liked_cars = get_user_meta( $cur_user_id, 'like_auto', true );
  if( '' !== $liked_cars ){
    if (!str_contains($liked_cars, $idAuto)) {
      $new_liked_cars = $idAuto . ',' . $liked_cars;
      if( ! update_user_meta( $cur_user_id, 'like_auto', $new_liked_cars ) ) {
        echo "Поле не обновлено";
      } else {
        echo "Поле обновлено";
      }
    } else {
      echo "Поле не обновлено";
    }
  } else {
    if( ! update_user_meta( $cur_user_id, 'like_auto', $idAuto ) ) {
      echo "Поле не обновлено";
    } else {
      echo "Поле обновлено";
    }
  }
  die();
}

// Убрать лайк
add_action( 'wp_ajax_unlikeauto', 'true_unlikeauto_function' ); 
add_action( 'wp_ajax_nopriv_unlikeauto', 'true_unlikeauto_function' );
 
function true_unlikeauto_function(){
  $idAuto = $_POST['id'];
  $cur_user_id = get_current_user_id();
  $liked_cars = get_user_meta( $cur_user_id, 'like_auto', true );
  $liked_cars_array = explode(',', $liked_cars);
  unset($liked_cars_array[array_search($idAuto,$liked_cars_array)]);
  $liked_cars_new = implode(',', $liked_cars_array);
  if( update_user_meta( $cur_user_id, 'like_auto', $liked_cars_new ) ) {
    echo "Значение удалено";
  } else {
    echo "Значение не удалено";
  }
  die();
}

function echo_liked_cars_func( $atts ){
  $cur_user_id = get_current_user_id();
  $liked_cars = get_user_meta( $cur_user_id, 'like_auto', true );
  if ($liked_cars) {
    $liked_cars_array = explode(',', $liked_cars);
    $html = '<div class="cars-offers-block">';
        foreach ($liked_cars_array as $key => $value) {
          $ourData = file_get_contents("http://localhost/api/car_ad/".$value."/");
          $object = json_decode($ourData);
            $time = strtotime($object->create_date);
            $html .= load_template_part( 'template-parts/card', 'offer', $object );
          }
    return $html . '</div>';
  } else {
    return '<p>Ничего не найдено</p>';
  }

}
 
add_shortcode( 'echo_liked_cars', 'echo_liked_cars_func' );
// Фильтр кузовов авто
add_action( 'wp_ajax_carstypefilter', 'true_carstypefilter_function' ); 
add_action( 'wp_ajax_nopriv_carstypefilter', 'true_carstypefilter_function' );
 
function true_carstypefilter_function(){
  $marka = $_POST['marka'];
  $brandsObject = fetch_api_data("http://localhost/api/cars_type/", $marka);
  foreach ($brandsObject as $brand) {
    echo '<option value="'.$brand->name.'">'.$brand->name.'</option>';
  }
  die();
}
// Фильтр моделей авто
add_action( 'wp_ajax_modelfilter', 'true_modelfilter_function' ); 
add_action( 'wp_ajax_nopriv_modelfilter', 'true_modelfilter_function' );
 
function true_modelfilter_function(){
  $marka = $_POST['marka'];
  $url = "http://localhost/api/brand/".$marka."";
  $response = file_get_contents($url);
  $data = json_decode($response);
  echo '<option class="main__option">Модель</option>';
  foreach ($data as $brand) {
    echo '<option value="'.$brand->name.'">'.$brand->name.'</option>';
  }
  die();
}
function myUrlEncode($string) {
  $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
  $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
  return str_replace($entities, $replacements, urlencode($string));
}
add_action( 'wp_ajax_myfilter', 'true_filter_function' ); 
add_action( 'wp_ajax_nopriv_myfilter', 'true_filter_function' );
 
function true_filter_function(){
  if ($_POST['search'] ) {
	  $ourData = file_get_contents("http://localhost/api/car_ad_filter/?search=".myUrlEncode($_POST['search'])."");
	  $object = json_decode($ourData);
  } else {
      $condition = $_POST['condition']  ?: '';
      $country = $_POST['country'] ?: '';
      $brand = $_POST['brand'] ?: '';
      $price_min = $_POST['price_min'] ?: '';
      $price_max = $_POST['price_max'] ?: '';
      $color = $_POST['color'] ?: '';
      $model = $_POST['model'] ?: '';
      $production_date_min = $_POST['production_date_min'] ?: '';
      $production_date_max = $_POST['production_date_max'] ?: '';
      $engine_capacity_min = $_POST['engine_capacity_min'] ?: '';
      $engine_capacity_max = $_POST['engine_capacity_max'] ?: '';
      $mileage_min = $_POST['mileage_min'] ?: '';
      $mileage_max = $_POST['mileage_max'] ?: '';
      $gearbox = $_POST['cars_gearbox'] ?: '';
      $cars_drive = $_POST['cars_drive'] ?: '';
      $engine = $_POST['cars_engine'] ?: '';
      $cars_type = $_POST['cars_type'] ?: '';
      $ordering = $_POST['ordering'] ?: '';
      $page = $_POST['page'] ?: '1';
      $ourData = file_get_contents("http://localhost/api/car_ad_filter/?condition=".$condition."&country=".$country."&brand=".$brand."&model=".$model."&production_date_min=".$production_date_min."&production_date_max=".$production_date_max."&cars_gearbox=".$gearbox."&cars_drive=".$cars_drive."&cars_engine=".$engine."&cars_type=".$cars_type."&price_min=".$price_min."&price_max=".$price_max."&color=".$color."&mileage_min=".$mileage_min."&mileage_max=".$mileage_max."&engine_capacity_min=".$engine_capacity_min."&engine_capacity_max=".$engine_capacity_max."&ordering=".$ordering."&page=".$page."");
      $object = json_decode($ourData);
  }
  echo '<input type="hidden" name="new-brand" value="'.$brand.'">';
  echo '<input type="hidden" name="new-count" value="'.number_format( $object->count, 0, '', ' ' ).'">';
  foreach ($object->results as $key => $value) {
    get_template_part( 'template-parts/card', 'offer', $value );
  }
  echo '<div class="pagination" data-counter="'.$object->count.'">';
  // $url = get_permalink( 47 );
  foreach ($object->pages_data->page_links as $key => $value) {
    $pageNumber = $value[1];
      if ($pageNumber == $page) {
        echo '<span class="pagination-number current">'.$pageNumber.'</span>';
      } elseif (!$pageNumber) {
        echo '<span class="pagination-number more">...</span>';
      } else {
          echo '<span class="pagination-number">'.$pageNumber.'</span>';
      }
  }
  echo '</div>';
  die();
}

function brandCounter($brand) {
  $data = fetch_api_data("http://localhost/api/car_ad_filter/?brand=".myUrlEncode($brand)."", myUrlEncode($brand));
  if ($data) {
    echo '<a href="'.get_permalink( 47 ).'/?brand='.myUrlEncode($brand).'" class="models_name">
          <p class="brand-auto">'.$brand.'</p>
          <span class="brand-auto__link" data-brand="'.myUrlEncode($brand).'" >'.$data->count.'</span>
        </a>';
  }
}

add_action( 'template_redirect', 'truemisha_recently_viewed_product_cookie', 20 );
 
function truemisha_recently_viewed_product_cookie() {
 
	// если находимся не на странице товара, ничего не делаем
	if ( ! is_page(8) ) {
		return;
	}
 
 
	if ( empty( $_COOKIE[ 'recently_viewed_2' ] ) ) {
		$viewed_products = array();
	} else {
		$viewed_products = (array) explode( '|', $_COOKIE[ 'recently_viewed_2' ] );
	}
  $idAuto = $_GET["id"];
	// добавляем в массив текущий товар
	if ( ! in_array( $idAuto, $viewed_products ) ) {
		$viewed_products[] = $idAuto;
	}
 
	// нет смысла хранить там бесконечное количество товаров
	if ( sizeof( $viewed_products ) > 15 ) {
		array_shift( $viewed_products ); // выкидываем первый элемент
	}
 
 	// устанавливаем в куки
  setcookie( 'recently_viewed_2', join( '|', $viewed_products ), time()+3600, COOKIEPATH, COOKIE_DOMAIN );
}

function echo_viewed_cars_func( $atts ){
	if( empty( $_COOKIE[ 'recently_viewed_2' ] ) ) {
		$viewed_products = array();
	} else {
		$viewed_products = (array) explode( '|', $_COOKIE[ 'recently_viewed_2' ] );
	}
 
	if ( empty( $viewed_products ) ) {
		return;
	}
  $viewed_products = array_reverse( array_map( 'absint', $viewed_products ) );
  // return print_r($viewed_products);
  $html = '      <div class="block_inner-slider slider-looked" id="offers">
  <div class="offers__header">
    <p class="you-looked-block__headline">Вы смотрели</p>
    <div class="offers__arrows">
      <img class="slider__arrow_left"
        src="'. get_template_directory_uri() .'/assets/images/slider_arrow_left.png" id="offers_one"><img
        class="slider__arrow_right"
        src="'. get_template_directory_uri() .'/assets/images/slider_arrow_right.png" id="offers_one">
    </div>


  </div>
  <div class="slider slider-looked-wrap offers__slider" id="offers_one"><div class="slider__container">';
      foreach ($viewed_products as $key => $value) {
        $ourData = file_get_contents("http://localhost/api/car_ad/".$value."/");
        $object = json_decode($ourData);
          $time = strtotime($object->create_date);
          $html .= load_template_part( 'template-parts/card', 'slide', $object );
        }
	return $html . '</div></div></div>';
}
 
add_shortcode( 'echo_viewed_cars', 'echo_viewed_cars_func' );

// сохранение подборки
add_action( 'wp_ajax_saveSelection', 'true_saveSelection_function' ); 
add_action( 'wp_ajax_nopriv_saveSelection', 'true_saveSelection_function' );
 
function true_saveSelection_function(){
  $params = $_POST['params'];
  $cur_user_id = get_current_user_id();
  if(update_user_meta( $cur_user_id, 'car_selection', $params )) {
    echo 'Сохранено';
  } else {
    echo 'Ошибка';
  }
  die();
}

function echo_selection_cars_func( $atts ){
  $cur_user_id = get_current_user_id();
  $selection_cars = get_user_meta( $cur_user_id, 'car_selection', true );
  if ($selection_cars) {
    $queryString = http_build_query($selection_cars);
    $url = 'http://localhost/api/car_ad_filter/?' . $queryString;
    $ourData = file_get_contents($url);
    $object = json_decode($ourData);
    $html = '<div class="cars-offers-block">';
        foreach ($object->results as $key => $value) {
            $html .= load_template_part( 'template-parts/card', 'offer', $value );
          }
    return $html . '</div>';
  } else {
    return '<p>Ничего не найдено</p>';
  }

}
 
add_shortcode( 'echo_selection_cars', 'echo_selection_cars_func' );

add_filter( 'nav_menu_css_class', 'special_nav_class', 10, 2 );
function special_nav_class($classes, $item){
		$classes[] = "header__item";

	return $classes;
}

function echo_nominated_cars_func( ){
  $cur_user = wp_get_current_user();
  $selection_cars = get_field('mashiny', $cur_user );
  if ($selection_cars) {
    $html = '<div class="cars-offers-block">';
    foreach ($selection_cars as $key => $value) {
      $queryString = http_build_query($selection_cars);
      $url = 'http://localhost/api/car_ad/' . $value['id_obyavleniya'];
      $ourData = file_get_contents($url);
      $object = json_decode($ourData);
      $html .= load_template_part( 'template-parts/card', 'offer', $object );
    }
    return $html . '</div>';
  } else {
    return '<p>Ничего не найдено</p>';
  }

}
add_shortcode( 'echo_nominated_cars', 'echo_nominated_cars_func' );
function get_users_by_role($role) {
  $users = get_users(array('role' => $role));
  return $users;
}
function custom_rewrite_rule() {
  add_rewrite_rule(
    '^obyavlenie/([^/]+)/?$',
    'index.php?pagename=obyavlenie&slug=$matches[1]',
    'top'
  );
}
add_action('init', 'custom_rewrite_rule');

function custom_rewrite_tag() {
  add_rewrite_tag('%slug%', '([^&]+)');
}

function disable_yoast_seo_on_page_8() {
    if (is_page(8)) {
        global $wpseo_front;
        remove_action('wp_head', array($wpseo_front, 'head'), 1);
    }
}
add_action('template_redirect', 'disable_yoast_seo_on_page_8');

add_action('init', 'custom_rewrite_tag');

function generate_custom_meta_tags() {
  // Проверяем, находимся ли мы на странице объявления
  if (is_page('obyavlenie')) { // Замените 'obyavlenie' на имя вашей страницы

    // Получаем slug из URL
    $slug = $_SERVER['REQUEST_URI'];
    $slug = str_replace(get_permalink( 8 ), '', $slug);
    $slug = trim($slug, '/');

    // Разделяем slug на название и ID
    $parts = explode('-', $slug);
    $idAuto = end($parts);

    // Делаем запрос к API
    $object = fetch_api_data("http://localhost/api/car_ad/".$idAuto."/", $idAuto);

    // Проверяем, получили ли мы данные из API
    if ($object) {

      // Генерируем метатеги
      echo '<title>' . $object->brand . ' ' . $object->model . ' ' . $object->production_date . '</title>';
      echo '<meta name="description" content="' . $object->title . ' - ' . $object->price . ' ' . $object->cars_engine . ' ' . $object->cars_gearbox . ' ' . $object->mileage . ' км.">';
      echo '<meta name="keywords" content="' . $object->brand . ', ' . $object->model . ', ' . $object->production_date . ', ' . $object->cars_engine . ', ' . $object->cars_gearbox . '">';

      // Open Graph метатеги
      echo '<meta property="og:title" content="' . $object->brand . ' ' . $object->model . ' ' . $object->production_date . '">';
      echo '<meta property="og:description" content="' . $object->title . ' - ' . $object->price . ' ' . $object->cars_engine . ' ' . $object->cars_gearbox . ' ' . $object->mileage . ' км.">';
      echo '<meta property="og:image" content="' . $object->images[0] . '">';
      echo '<meta property="og:url" content="' . get_permalink() . '">';
      echo '<meta property="og:type" content="website">';

      // ... другие метатеги ...
    }
  }
}
add_action('wp_head', 'generate_custom_meta_tags');