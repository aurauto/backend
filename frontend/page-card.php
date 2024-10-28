<?php
/**
 * The template for displaying all pages
 * Template name: Карточка
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Aurauto
 */

 require_once('api.php');

get_header();
$slug = $_SERVER['REQUEST_URI'];
$slug = str_replace(get_permalink( 8 ), '', $slug);
$slug = trim($slug, '/');

// Разделяем слаг на название и ID
$parts = explode('-', $slug);
$idAuto = end($parts);
$object = fetch_api_data("http://localhost/api/car_ad/".$idAuto."/", $idAuto);
$id = $object->ad_id;
$companyAnnouncementsObject = fetch_api_data(myUrlEncode("http://localhost/api/car_ad_filter/?aggregator=".$object->aggregator."&page_size=100"), $object->aggregator . $idAuto);
$results = $companyAnnouncementsObject->results;
$rand_keys = array_rand($results, 5);
$maxPrice = ($object->price * 0.25) + $object->price;
$minPrice = $object->price;
$area = $object->area;
$relatedProducts = file_get_contents(myUrlEncode('http://localhost/api/car_ad_filter/?price_max='.$maxPrice.'&price_min='.$minPrice.'&area='.$area.'&page_size=3'));
$relatedProductsObject = json_decode($relatedProducts);
$cur_user_id = get_current_user_id();
$liked_cars = get_user_meta( $cur_user_id, 'like_auto', true );
?>
<script>
  document.title = '<?php echo $object->title?>';
</script>
<div class="content">

  <div class="content-bread-wrap">
    <ul class="bread-crumbs-list">
      <li class="bread-crumbs-li"> <a href="<?php echo home_url()?>">Главная</a></li>
      <li class="bread-crumbs-li"><a href="<?php echo get_permalink( 47 )?>">· Каталог</a></li>
      <li class="bread-crumbs-li"><a href="<?php echo get_permalink( 47 )?>?brand=<?php echo $object->brand?>">· Модели
          <?php echo $object->brand?></a></li>
      <li class="bread-crumbs-li">· <?php echo $object->model?></li>
    </ul>
  </div>

  <div class="auto-belarus__wrap">
    <p class="auto-belarus"><?php echo $object->title?>
    </p>
    <number class="auto-belarus__total"><?php echo number_format($object->price, 0, '', ' ')?></number>
    <!-- <number class="auto-belarus__total">
      <?php 
      // echo changeCurrencePrice($object->price, 'USDRUB')
      ?>
      </number> -->



    <div class="money-choose">
      <svg id="money" xmlns="http://www.w3.org/2000/svg" width="15" height="8" viewBox="0 0 15 8" fill="none">
        <path d="M13.728 0.364014L7.36407 6.72797L1.00011 0.364013" stroke="black" />
      </svg>
      <p class="currency-name">Валюта</p>
      <div class="rub">
        <select name="money-choose" id="money-choose" data-price="<?php echo $object->price?>">
          <option value="USD">$.</option>
          <option value="RUB">₽.</option>
          <option value="BYN">B.r</option>
          <option value="AMD">֏.</option>
          <option value="KGS">с.</option>
        </select>
      </div>
    </div>
  </div>


  <div class="main-block-auto">

    <div class="block-auto-car-information">
      <div class="block-car">
        <div class="car-img">
          <?php
            $images = $object->images;
            foreach ($images as $img) {
              echo '<img class="car-img__main-pic" src="'.$img.'" alt="car">';
            }
          ?>

        </div>

        <div class="car-gallery">
          <?php 
            foreach ($images as $key => $img) {
              echo '<div class="car-block">
                      <img class="car-'.$key.'" src="'.$img.'" alt="">
                    </div>';
            }
          ?>
        </div>
        <div class="block-firm-name-mobile">
          <p class="firm-name"><?php echo  $object->aggregator?></p>
          <!-- <img class="logo-firm-icon" src="<?php echo get_template_directory_uri();?>/assets/images/card-page/block-car-contol/label.png" alt="logo-firm"> -->
        </div>

        <div class="block-location-mobile">
          <p class="block-location__headline">Расположение</p>

          <ul class="block-location__metro-list">
            <?php if ($object->country) {
            echo '<li class="block-location__metro-item">'.$object->country.'</li>';
          }?>
            <?php if ($object->region) {
            echo '<li class="block-location__metro-item">'.$object->region.'</li>';
          }?>
            <?php if ($object->area) {
            echo '<li class="block-location__metro-item">'.$object->area.'</li>';
          }?>
          </ul>
        </div>

        <a class="all-ad-company-mobile">Все объявления компании</a>
      </div>

      <div class="block-car__technical-describes">
        <p class="block-car__technical-describes_headline">Характеристики</p>

        <div class="technical-describes-block-list">
          <ul class="technical-describes__list">
            <li class="technical-describes__item">Год выпуска: <?php echo $object->production_date;?> </li>
            <?php if ($object->mileage) {
              echo '<li class="technical-describes__item">Пробег: '.$object->mileage.' км</li>';
            }?>
            <!-- <li class="technical-describes__item">ПТС: Оригинал</li>
            <li class="technical-describes__item">Владельцев по ПТС: 1</li> -->
            <?php if ($object->condition) {
              echo '<li class="technical-describes__item">Состояние: '.$object->condition.'</li>';
            }?>
            <?php if ($object->engine_capacity) {
              echo '<li class="technical-describes__item">Объём двигателя: '.$object->engine_capacity.' л</li>';
            }?>
          </ul>


          <ul class="technical-describes__list">
            <?php if ($object->cars_gearbox) {
              echo '<li class="technical-describes__item">Коробка передач: '.$object->cars_gearbox.'</li>';
            }?>
            <?php if ($object->cars_engine) {
              echo '<li class="technical-describes__item">Тип двигателя: '.$object->cars_engine.'</li>';
            }?>
            <?php if ($object->cars_drive) {
              echo '<li class="technical-describes__item">Привод: '.$object->cars_drive.'</li>';
            }?>
            <?php if ($object->cars_type) {
              echo '<li class="technical-describes__item">Тип кузова: '.$object->cars_type.'</li>';
            }?>
            <?php if ($object->color) {
              echo '<li class="technical-describes__item">Цвет: '.$object->color.'</li>';
            }?>
          </ul>

        </div>
        <!-- <a class="All-options top-modify" href="#">Все опции</a> -->
      </div>


      <div class="you-looked-block-mobile">
        <p class="you-looked-block__headline">Объявления компании</p>
        <div class="you-looked-block__cars">
          <?php 
              foreach ($results as $key => $value) {
                if (in_array($key, $rand_keys)) {
                  get_template_part( 'template-parts/card', 'content-mini', $value );
                }
              }
            ?>
        </div>
      </div>

      <div class="mobile-block-advertisements-2 card-modify ">

      </div>



      <div class="block-contacts-mobile">
        <a class="contact-seller write" data-link="<?php echo $object->link ?>">Связаться с продавцом</a>
        <!-- <a class="contact-seller call-to-seller">Позвонить продавцу</a>
        <a class="contact-seller offer-call">Заказать звонок</a> -->
        <?php 
          if ( is_user_logged_in() ) { 
            if (str_contains($liked_cars, $idAuto)) {
              echo '<a class="contact-seller favorit-add added" data-id="'. $idAuto.'">Удалить из избранного</a>';
            } else {
              echo '<a class="contact-seller favorit-add" data-id="'. $idAuto.'">Добавить в избранное</a>';
            }
          }?>
      </div>

      <div class="mobile-card-ad">

      </div>
      <?php if ($object->description) {
        echo '<p class="describe-text">Описание</p><div class="credit-conditions-block">';
        echo $object->description . '</div>';
      }?>
      <?php       
      // Указание роли, которую мы хотим получить
      $role = 'um_custom_role_2';
      
      // Вызов функции и получение списка пользователей
      $users = get_users_by_role($role);
      
      foreach ($users as $user) {
        $selection_cars = get_field('mashiny', $user );
        if (!empty($selection_cars)) {
        $value = array_column($selection_cars, 'id_obyavleniya');
        if (in_array($idAuto, $value)) {
          echo '<div class="credit-conditions-block">';
          if (get_field('usloviya', $user )) {
            echo '<ul class="credit-conditions-block__list">';
            foreach (get_field('usloviya', $user ) as $key => $value) {
              echo '<li class="credit-conditions-block__item">'.$value['punkt'].'</li>';
            } 
            echo '</ul>';
          }
          if (get_field('o_dilere', $user )) {
            echo '<div class="credit-conditions-block__adertisements">';
            $content = apply_filters( 'acf_the_content', get_field('o_dilere', $user ) );
            echo $content;
            echo '</div>';
          }
          echo '</div>';
        }
        }
      }
      ?>

      <div class="similar-ads-block">
        <p class="similar-ads">Похожие объявления</p>

        <div class="cars-offers-block">
          <?php 
              foreach ($relatedProductsObject->results as $key => $value) {
                get_template_part( 'template-parts/card', 'content', $value );
                }
            ?>
        </div>
      </div>
    </div>



    <div class="block-car-contol">
      <div class="block-contacts">
        <a class="contact-seller write" data-link="<?php echo $object->link ?>">Связаться с продавцом</a>
        <!-- <a class="contact-seller call-to-seller">Позвонить продавцу</a>
          <a class="contact-seller offer-call">Заказать звонок</a> -->
        <?php 
          if ( is_user_logged_in() ) { 
            if (str_contains($liked_cars, $idAuto)) {
              echo '<a class="contact-seller favorit-add added" data-id="'. $idAuto.'">Удалить из избранного</a>';
            } else {
              echo '<a class="contact-seller favorit-add" data-id="'. $idAuto.'">Добавить в избранное</a>';
            }
          }?>
      </div>

      <div class="block-firm-name">
        <p class="firm-name"><?php echo $object->aggregator?></p>
        <!-- <img class="logo-firm-icon" src="<?php echo get_template_directory_uri();?>/assets/images/card-page/block-car-contol/label.png" alt="logo-firm"> -->
      </div>

      <div class="block-location">
        <p class="block-location__headline">Расположение</p>

        <ul class="block-location__metro-list">
          <?php if ($object->country) {
            echo '<li class="block-location__metro-item">'.$object->country.'</li>';
          }?>
          <?php if ($object->region) {
            echo '<li class="block-location__metro-item">'.$object->region.'</li>';
          }?>
          <?php if ($object->area) {
            echo '<li class="block-location__metro-item">'.$object->area.'</li>';
          }?>
        </ul>
      </div>

      <div class="you-looked-block">
        <p class="you-looked-block__headline">Объявления компании</p>
        <div class="you-looked-block__cars">
          <?php 
              foreach ($results as $key => $value) {
                if (in_array($key, $rand_keys)) {
                  get_template_part( 'template-parts/card', 'content-mini', $value );

                }
              }
            ?>
        </div>
      </div>

      <div class="block-advertisements-2 card-modify ">

      </div>
    </div>
  </div>
</div>
<?php
get_footer();