<?php
/*
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Aurauto
 */

require_once('api.php');

get_header();
$brandsObject = fetch_api_data("http://localhost/api/brand/", "cached_brands");
$cars_gearbox_object = fetch_api_data("http://localhost/api/cars_gearbox/", "cached_gearboxes");
$cars_type_object = fetch_api_data("http://localhost/api/cars_type/", "cached_car_types");
$cars_color_object = fetch_api_data("http://localhost/api/color/", "cached_car_colors");
$country = '';
  if ($_COOKIE[ 'selectedCountry']) {
    $country = $_COOKIE[ 'selectedCountry'];
  }
  $cars_key = "cached_cars_" . ($country ?: "default");
  if ($country == 'Армения') {
    $objectElectro = fetch_api_data(myUrlEncode('http://localhost/api/car_ad_filter/?country=Армения&cars_engine=Электро&condition=Не битое&production_date_min=2019'),'Electro' . $cars_key);
    $objectDecode = fetch_api_data(myUrlEncode('http://localhost/api/car_ad_filter/?country=Армения&brand=BMW,Mercedes-Benz,Audi,Volkswagen,Toyota,Kia,Hyundai&condition=Не битое&production_date_min=2014&page_size=100'),'object'.$cars_key);
    $filterLink = get_permalink( 47 ) . '?country=Армения&brand=BMW,Mercedes-Benz,Audi,Volkswagen,Toyota,Kia,Hyundai&condition=Не битое&production_date_min=2014';
    $objectChinaDecode = fetch_api_data(myUrlEncode('http://localhost/api/car_ad_filter/?country=Армения&brand=Geely,Chery,Changan,Haval,FAW&condition=Не битое&production_date_min=2021&cars_type=Внедорожник / Кроссовер&page_size=100'),'objectChina'.$cars_key);
    $filterLinkChina = get_permalink( 47 ) . '?country=Армения&brand=Geely,Chery,Changan,Haval,FAW&condition=Не битое&production_date_min=2021&cars_type=Внедорожник';
  } elseif ($country == 'Киргизстан') {
    $objectElectro = fetch_api_data(myUrlEncode('http://localhost/api/car_ad_filter/?country=Киргизстан&cars_engine=Электромобиль&condition=Новый&production_date_min=2019'),'Electro' . $cars_key);
    $objectDecode = fetch_api_data(myUrlEncode('http://localhost/api/car_ad_filter/?country=Киргизстан&brand=BMW,Mercedes-Benz,Audi,Volkswagen,Toyota,Kia,Hyundai&condition=Новый&production_date_min=2014&page_size=100'),'object'.$cars_key);
    $filterLink = get_permalink( 47 ) . '?country=Киргизстан&brand=BMW,Mercedes-Benz,Audi,Volkswagen,Toyota,Kia,Hyundai&condition=Новый&production_date_min=2014';
    $objectChinaDecode = fetch_api_data(myUrlEncode('http://localhost/api/car_ad_filter/?country=Киргизстан&brand=Geely,Chery,Changan,Haval,FAW&production_date_min=2021&condition=Новый&cars_type=Внедорожник&page_size=100'),'objectChina'.$cars_key);
    $filterLinkChina = get_permalink( 47 ) . '?country=Киргизстан&brand=Geely,Chery,Changan,Haval,FAW&production_date_min=2021&condition=Новый&cars_type=Внедорожник';
  } elseif ($country == 'Беларусь') {
    $objectElectro = fetch_api_data(myUrlEncode('http://localhost/api/car_ad_filter/?country=Беларусь&cars_engine=Электричество&condition=С пробегом&production_date_min=2019'),'Electro' . $cars_key);
    $objectDecode = fetch_api_data(myUrlEncode('http://localhost/api/car_ad_filter/?country=Беларусь&brand=BMW,Mercedes-Benz,Audi,Volkswagen,Toyota,Kia,Hyundai&condition=С пробегом&production_date_min=2014&page_size=100'),'object'.$cars_key);
    $filterLink = get_permalink( 47 ) . '?country=Беларусь&brand=BMW,Mercedes-Benz,Audi,Volkswagen,Toyota,Kia,Hyundai&condition=С пробегом&production_date_min=2014';
    $objectChinaDecode = fetch_api_data(myUrlEncode('http://localhost/api/car_ad_filter/?country=Беларусь&brand=Geely,Chery,Changan,Haval,FAW&condition=С пробегом&production_date_min=2021&cars_type=Внедорожник&page_size=100'),'objectChina'.$cars_key);
    $filterLinkChina = get_permalink( 47 ) . '?country=Беларусь&brand=Geely,Chery,Changan,Haval,FAW&condition=С пробегом&production_date_min=2021&cars_type=Внедорожник';
  } else {
    $objectElectro = fetch_api_data(myUrlEncode('http://localhost/api/car_ad_filter/?cars_engine=Электричество&condition=С пробегом&production_date_min=2019'),'Electro' . $cars_key);
    $objectDecode = fetch_api_data(myUrlEncode('http://localhost/api/car_ad_filter/?brand=BMW,Mercedes-Benz,Audi,Volkswagen,Toyota,Kia,Hyundai&condition=С пробегом&production_date_min=2014&page_size=100'),'object'.$cars_key);
    $filterLink = get_permalink( 47 ) . '?brand=BMW,Mercedes-Benz,Audi,Volkswagen,Toyota,Kia,Hyundai&condition=С пробегом&production_date_min=2014';
    $objectChinaDecode = fetch_api_data(myUrlEncode('http://localhost/api/car_ad_filter/?brand=Geely,Chery,Changan,Haval,FAW&condition=С пробегом&production_date_min=2021&cars_type=Внедорожник&page_size=100'),'objectChina'.$cars_key);
    $filterLinkChina = get_permalink( 47 ) . '?brand=Geely,Chery,Changan,Haval,FAW&condition=С пробегом&production_date_min=2021&cars_type=Внедорожник';
  }
?>
<div class="content">
  <form action="<?php echo get_permalink( 50 )?>" class="block_inner" method="get" id="main">
    <h1>Быстро выбрать и выгодно купить авто от официального дилера</h1>
    <div class="main__p">Найдите самые выгодные цены на покупку, обслуживание и ремонт авто</div>
    <div class="main__list">
      <div class="main__checkboxes">
        <div class="main__checkbox_container">
          <input class="main__radio" type="radio" name="condition" value="" id="all_auto" checked>
          <label class="main__checkbox_label" for="all_auto"><span>Все авто</span></label>
        </div>
        <div class="main__checkbox_container">
          <input class="main__radio" type="radio" name="condition" value="Новый" id="new">
          <label class="main__checkbox_label" for="new"><span>Новые авто</span></label>
        </div>
        <div class="main__checkbox_container">
          <input class="main__radio" type="radio" name="condition" value="Не битое" id="probeg">
          <label class="main__checkbox_label" for="probeg"><span>Не битое</span></label>
        </div>
        <div class="main__checkbox_container">
          <input class="main__checkbox" type="checkbox" name="country" value="" id="all_country" checked>
          <label class="hidden_1000 main__checkbox_label" for="all_country"><span>Все страны</span></label>
        </div>
      </div>
      <div class="main__countries">
        <span>Страны ЕАЭС для поиска авто: <small>(по умолчанию поиск во всех странах)</small></span>
        <label class="main__country_img"><input type="checkbox" name="country" value="Армения"><img
            src="<?php echo get_template_directory_uri();?>/assets/images/country1.png"></label>
        <label class="main__country_img"><input type="checkbox" name="country" value="Беларусь"><img
            src="<?php echo get_template_directory_uri();?>/assets/images/country2.png"></label>
        <label class="main__country_img"><input type="checkbox" name="country" value="Казахстан"><img
            src="<?php echo get_template_directory_uri();?>/assets/images/country3.png"></label>
        <label class="main__country_img"><input type="checkbox" name="country" value="Киргизстан"><img
            src="<?php echo get_template_directory_uri();?>/assets/images/country4.png"></label>
      </div>
    </div>
    <div class="main__input_group">
      <div class="main__square">
        <select class="main__input_item select" name="brand">
          <option class="main__option">Марка</option>
          <?php 
            if ($brandsObject) {
              foreach ($brandsObject as $key => $brand) {
                echo '<option value="'.$brand->name.'">'.$brand->name.'</option>';
              }
            }?>
        </select>
        <select class="main__input_item select" name="model" id="models">
          <option class="main__option">Модель</option>
        </select>
        <div class="main__input_item">
          <input class="main__input" placeholder="300 000" name="price_min"><span>Цена от, р.</span>
        </div>
        <div class="main__input_item">
          <input class="main__input" placeholder="2 300 000" name="price_max"><span>До</span>
        </div>
      </div>
      <div class="main__square">
        <select class="main__input_item select" name="cars_gearbox">
          <option class="main__option" value="">Коробка</option>
          <?php foreach ($cars_gearbox_object as $key => $value) {
        echo '<option value="'.$value->name.'">'.$value->name.'</option>';
      }?>
        </select>
        <select class="main__input_item select" name="cars_drive">
          <option class="main__option" value="">Привод</option>
          <option class="main__option" value="Передний">Передний</option>
          <option class="main__option" value="Задний">Задний</option>
          <option class="main__option" value="Полный">Полный</option>
        </select>
        <select class="main__input_item select" name="cars_type">
          <option class="main__option" value="">Кузов</option>
          <?php 
      if ($cars_type_object) {
        foreach ($cars_type_object as $key => $type) {
          echo '<option value="'.$type->name.'">'.$type->name.'</option>';
        }
      }?>
        </select>
        <select class="main__input_item select" name="color">
          <option class="main__option" value="">Цвет</option>
          <?php 
            if ($cars_color_object) {
              foreach ($cars_color_object as $key => $color) {
                echo '<option value="'.$color->name.'">'.$color->name.'</option>';
              }
            }?>
        </select>
      </div>
      <div class="main__square">
        <select class="main__input_item select" name="cars_engine">
          <option class="main__option" value="">Двигатель</option>
          <option class="main__option" value="Бензин">Бензин</option>
          <option class="main__option" value="Электро">Электро</option>
          <option class="main__option" value="Дизель">Дизель</option>
          <option class="main__option" value="Гибрид">Гибрид</option>
        </select>
        <div class="main__input_item">
          <input class="main__input" name="engine_capacity_max" placeholder="1.4 - 4.6"><span>Объем, л..</span>
        </div>
        <div class="main__input_item">
          <input class="main__input" name="mileage_min" placeholder="От"><span>Пробег от</span>
        </div>
        <div class="main__input_item">
          <input class="main__input" name="mileage_max" placeholder="До"><span>Пробег до</span>
        </div>
      </div>
    </div>
    <button class="main__button">Показать</button>
  </form>
  <div class="block_inner" id="marks">
    <h2>Марки новых авто</h2>
    <div class="marks__list">
        <a class="marks__mark_img" href="<?php echo get_permalink( 47 )?>/?brand=BMW"><img src="<?php echo get_template_directory_uri();?>/assets/images/mark_1.png"></a>
        <a class="marks__mark_img" href="<?php echo get_permalink( 47 )?>/?brand=Chevrolet"><img src="<?php echo get_template_directory_uri();?>/assets/images/mark_2.png"></a>
        <a class="marks__mark_img" href="<?php echo get_permalink( 47 )?>/?brand=Citroen"><img src="<?php echo get_template_directory_uri();?>/assets/images/mark_3.png"></a>
        <a class="marks__mark_img" href="<?php echo get_permalink( 47 )?>/?brand=Ford"><img src="<?php echo get_template_directory_uri();?>/assets/images/mark_4.png"></a>
        <a class="marks__mark_img" href="<?php echo get_permalink( 47 )?>/?brand=Mitsubishi"><img src="<?php echo get_template_directory_uri();?>/assets/images/mark_5.png"></a>
        <a class="marks__mark_img" href="<?php echo get_permalink( 47 )?>/?brand=Mazda"><img src="<?php echo get_template_directory_uri();?>/assets/images/mark_6.png"></a>
        <a class="marks__mark_img" href="<?php echo get_permalink( 47 )?>/?brand=Honda"><img src="<?php echo get_template_directory_uri();?>/assets/images/mark_7.png"></a>
        <a class="marks__mark_img" href="<?php echo get_permalink( 47 )?>/?brand=Hyundai"><img src="<?php echo get_template_directory_uri();?>/assets/images/mark_8.png"></a>
        <a class="marks__mark_img" href="<?php echo get_permalink( 47 )?>/?brand=Skoda"><img src="<?php echo get_template_directory_uri();?>/assets/images/mark_9.png"></a>
        <a class="marks__mark_img" href="<?php echo get_permalink( 47 )?>/?brand=Peugeot"><img src="<?php echo get_template_directory_uri();?>/assets/images/mark_10.png"></a>
        <a class="marks__mark_img" href="<?php echo get_permalink( 47 )?>/?brand=Nissan"><img src="<?php echo get_template_directory_uri();?>/assets/images/mark_11.png"></a>
        <a class="marks__mark_img" href="<?php echo get_permalink( 47 )?>/?brand=Opel"><img src="<?php echo get_template_directory_uri();?>/assets/images/mark_12.png"></a>
        <a class="marks__mark_img" href="<?php echo get_permalink( 47 )?>/?brand=Renault"><img src="<?php echo get_template_directory_uri();?>/assets/images/mark_13.png"></a>
        <a class="marks__mark_img" href="<?php echo get_permalink( 47 )?>/?brand=Toyota"><img src="<?php echo get_template_directory_uri();?>/assets/images/mark_14.png"></a>
        <a class="marks__mark_img" href="<?php echo get_permalink( 47 )?>/?brand=Volkswagen"><img src="<?php echo get_template_directory_uri();?>/assets/images/mark_15.png"></a>
        <a class="marks__mark_img" href="<?php echo get_permalink( 47 )?>/?brand=Volvo"><img src="<?php echo get_template_directory_uri();?>/assets/images/mark_16.png"></a>
    </div>
    <!-- <div class="marks__items">
      <div class="marks__item"><img class="marks__item_img"
          src="<?php echo get_template_directory_uri();?>/assets/images/mark_icon1.png">
        <p class="marks__item_p">Легковые авто</p>
      </div>
      <div class="marks__item"><img class="marks__item_img"
          src="<?php echo get_template_directory_uri();?>/assets/images/mark_icon2.png">
        <p class="marks__item_p">Грузовые авто</p>
      </div>
      <div class="marks__item"><img class="marks__item_img"
          src="<?php echo get_template_directory_uri();?>/assets/images/mark_icon3.png">
        <p class="marks__item_p">Мототехника</p>
      </div>
      <div class="marks__item"><img class="marks__item_img"
          src="<?php echo get_template_directory_uri();?>/assets/images/mark_icon4.png">
        <p class="marks__item_p">Сельхозтехника</p>
      </div>
      <div class="marks__item"><img class="marks__item_img"
          src="<?php echo get_template_directory_uri();?>/assets/images/mark_icon5.png">
        <p class="marks__item_p">Спец.техника</p>
      </div>
      <div class="marks__item"><img class="marks__item_img"
          src="<?php echo get_template_directory_uri();?>/assets/images/mark_icon6.png">
        <p class="marks__item_p">Прицепы</p>
      </div>
      <div class="marks__item"><img class="marks__item_img"
          src="<?php echo get_template_directory_uri();?>/assets/images/mark_icon7.png">
        <p class="marks__item_p">Водный транспорт</p>
      </div>
      <div class="marks__item"><img class="marks__item_img"
          src="<?php echo get_template_directory_uri();?>/assets/images/mark_icon8.png">
        <p class="marks__item_p">Шины, диски</p>
      </div>
      <div class="marks__item"><img class="marks__item_img"
          src="<?php echo get_template_directory_uri();?>/assets/images/mark_icon9.png">
        <p class="marks__item_p">Аксессуары</p>
      </div>
      <div class="marks__item"><img class="marks__item_img"
          src="<?php echo get_template_directory_uri();?>/assets/images/mark_icon10.png">
        <p class="marks__item_p">Запчасти, расходники</p>
      </div>
      <div class="marks__item"><img class="marks__item_img"
          src="<?php echo get_template_directory_uri();?>/assets/images/mark_icon11.png">
        <p class="marks__item_p">Инструмент</p>
      </div>
      <div class="marks__item"><img class="marks__item_img"
          src="<?php echo get_template_directory_uri();?>/assets/images/mark_icon12.png">
        <p class="marks__item_p">Услуги для авто</p>
      </div>
    </div> -->
  </div>
  <div class="block_inner" id="offers">
    <div class="offers__header">
      <p class="offers__title show_1000">Лучшие предложения<span class="hidden_1000"></span></p>
      <div class="offers__arrows"><img class="slider__arrow_left"
          src="<?php echo get_template_directory_uri();?>/assets/images/slider_arrow_left.png" id="offers_one"><img
          class="slider__arrow_right"
          src="<?php echo get_template_directory_uri();?>/assets/images/slider_arrow_right.png" id="offers_one">
      </div>
      <p class="offers__title hidden_1000">Лучшие предложения<span></span></p><a class="offers__button"
        href="<?php echo $filterLink;?>">Смотреть все</a>
    </div>
    <div class="slider offers__slider" id="offers_one">
      <div class="slider__container">
      <?php  
              foreach ($objectDecode->results as $key => $value) {
                get_template_part( 'template-parts/card', 'slide-offer', $value );
              }?>
      </div>
    </div>
  </div>
  <div class="block_inner" id="offers">
    <div class="offers__header">
      <p class="offers__title show_1000">Электромобили<span class="hidden_1000"></span></p>
      <div class="offers__arrows"><img class="slider__arrow_left"
          src="<?php echo get_template_directory_uri();?>/assets/images/slider_arrow_left.png" id="offers_two"><img
          class="slider__arrow_right"
          src="<?php echo get_template_directory_uri();?>/assets/images/slider_arrow_right.png" id="offers_two">
      </div>
      <p class="offers__title hidden_1000">Электромобили<span></span></p><a class="offers__button" href="<?php 
          if ($country == 'Армения') {
            echo get_permalink( 47 ) . '?country=Армения&cars_engine=Электро&production_date_min=2019';    
          } elseif ($country == 'Киргизстан') {
            echo get_permalink( 47 ) . '?country=Киргизстан&cars_engine=Электромобиль&production_date_min=2019';
          } else {
            echo get_permalink( 47 ) . '?country=Беларусь&cars_engine=Электричество&production_date_min=2019'; 
          }
      
      ?>">Смотреть все</a>
    </div>
    <div class="slider offers__slider" id="offers_two">
      <div class="slider__container">
            <?php  
              foreach ($objectElectro->results as $key => $value) {
                get_template_part( 'template-parts/card', 'slide-offer', $value );
              }?>
      </div>
    </div>
  </div>
  <div class="block_inner" id="offers">
    <div class="offers__header">
      <p class="offers__title show_1000">Топ 10<span class="hidden_1000"></span></p>
      <div class="offers__arrows"><img class="slider__arrow_left"
          src="<?php echo get_template_directory_uri();?>/assets/images/slider_arrow_left.png" id="offers_three"><img
          class="slider__arrow_right"
          src="<?php echo get_template_directory_uri();?>/assets/images/slider_arrow_right.png" id="offers_three">
      </div>
      <p class="offers__title hidden_1000">Топ 10<span></span></p><a class="offers__button" href="#">Смотреть
        все</a>
    </div>
    <div class="slider offers__slider" id="offers_three">
      <div class="slider__container">
      <?php 
          $top10 = get_field('top_10', 2);
          $top10array = [];
          foreach ($top10 as $key => $value) {
            if ($country == 'Армения') {
              $object = file_get_contents(myUrlEncode('http://localhost/api/car_ad_filter/?country=Армения&brand='.$value['marka'].'&model='.$value['model'].'&production_date_min=2010&condition=Не битое&price_min=2000'));
              $objectArray = json_decode($object);    
            } elseif ($country == 'Киргизстан') {
              $object = file_get_contents(myUrlEncode('http://localhost/api/car_ad_filter/?country=Киргизстан&brand='.$value['marka'].'&model='.$value['model'].'&production_date_min=2010&condition=Новый&price_min=2000&page_size=1'));
              $objectArray = json_decode($object);  
            } elseif ($country == 'Беларусь') {
              $object = file_get_contents(myUrlEncode('http://localhost/api/car_ad_filter/?country=Беларусь&brand='.$value['marka'].'&model='.$value['model'].'&production_date_min=2010&condition=С пробегом&price_min=2000&page_size=1'));
              $objectArray = json_decode($object); 
            } else {
              $object = file_get_contents(myUrlEncode('http://localhost/api/car_ad_filter/?brand='.$value['marka'].'&model='.$value['model'].'&production_date_min=2010&condition=С пробегом&price_min=2000&page_size=1'));
              $objectArray = json_decode($object); 
            }
            // $object = file_get_contents(myUrlEncode('http://localhost/api/car_ad_filter/?brand='.$value['marka'].'&model='.$value['model'].'&production_date_min=2010&price_min=2000&page_size=1'));
            //   $objectArray = json_decode($object); 
            $top10array[] = $objectArray->results;
          }
          // var_dump($top10array);
          foreach ($top10array as $key => $value) {
            if($value[0]) {
            get_template_part( 'template-parts/card', 'slide-offer', $value[0] );
              
            }
          }
      ?>

      </div>
    </div>
  </div>
  <div class="block_inner" id="offers">
    <div class="offers__header">
      <p class="offers__title show_1000">Авто из Китая</p>
      <div class="offers__arrows"><img class="slider__arrow_left"
          src="<?php echo get_template_directory_uri();?>/assets/images/slider_arrow_left.png" id="offers_four"><img
          class="slider__arrow_right"
          src="<?php echo get_template_directory_uri();?>/assets/images/slider_arrow_right.png" id="offers_four">
      </div>
      <p class="offers__title hidden_1000">Авто из Китая</p><a class="offers__button"
        href="<?php echo $filterLinkChina;?>">Смотреть все</a>
    </div>
    <div class="slider offers__slider" id="offers_four">
      <div class="slider__container">
      <?php  
              foreach ($objectChinaDecode->results as $key => $value) {
                get_template_part( 'template-parts/card', 'slide-offer', $value );
              }?>
      </div>
    </div>
  </div>
  <div class="block_inner" id="advantages">
    <h2>Преимущества <span class="advantages__span">AUR</span><span>AUTO</span></h2>
    <div class="advantages__items">
      <div class="advantages__item"><img class="advantages__img"
          src="<?php echo get_template_directory_uri();?>/assets/images/advantages_car.png">
        <p class="advantages__p auto-oficial-diler">36 923 авто в наличии от официальных дилеров</p>
      </div>
      <div class="advantages__item"><img class="advantages__img"
          src="<?php echo get_template_directory_uri();?>/assets/images/advantages_search.png">
        <p class="advantages__p">Персональный подбор предложений на авто с дополнительной скидкой</p>
      </div>
      <div class="advantages__item"><img class="advantages__img"
          src="<?php echo get_template_directory_uri();?>/assets/images/advantages_price.png">
        <p class="advantages__p">Реальные цены и скидки мы получаем напрямую от дилеров</p>
      </div>
      <div class="advantages__item"><img class="advantages__img"
          src="<?php echo get_template_directory_uri();?>/assets/images/advantages_info.png">
        <p class="advantages__p">Вся информация есть у нас — вам не надо ехать к дилерам</p>
      </div>
    </div>
  </div>
  <div class="block_inner" id="partners">
    <h2>Наши партнеры <span class="hidden_1000">—официальные дилеры</span></h2>
    <p><img class="slider__arrow_left show_1000" id="slider__partners"
        src="<?php echo get_template_directory_uri();?>/assets/images/slider_arrow_left.png"><span>Более 1175
        дилеров...</span><img class="slider__arrow_right show_1000" id="slider__partners"
        src="<?php echo get_template_directory_uri();?>/assets/images/slider_arrow_right.png"></p>
    <div class="slider partners__slider" id="slider__partners"><img class="slider__arrow_left hidden_1000"
        id="slider__partners" src="<?php echo get_template_directory_uri();?>/assets/images/slider_arrow_left.png">
      <div class="slider__container">
        <div class="slider__item"><img class="partners__img"
            src="<?php echo get_template_directory_uri();?>/assets/images/partners_brand1.png"></div>
        <div class="slider__item"><img class="partners__img"
            src="<?php echo get_template_directory_uri();?>/assets/images/partners_brand1.png"></div>
        <div class="slider__item"><img class="partners__img"
            src="<?php echo get_template_directory_uri();?>/assets/images/partners_brand2.png"></div>
        <div class="slider__item"><img class="partners__img"
            src="<?php echo get_template_directory_uri();?>/assets/images/partners_brand3.png"></div>
        <div class="slider__item"><img class="partners__img"
            src="<?php echo get_template_directory_uri();?>/assets/images/partners_brand4.png"></div>
        <div class="slider__item"><img class="partners__img"
            src="<?php echo get_template_directory_uri();?>/assets/images/partners_brand5.png"></div>
        <div class="slider__item"><img class="partners__img"
            src="<?php echo get_template_directory_uri();?>/assets/images/partners_brand6.png"></div>
        <div class="slider__item"><img class="partners__img"
            src="<?php echo get_template_directory_uri();?>/assets/images/partners_brand2.png"></div>
        <div class="slider__item"><img class="partners__img"
            src="<?php echo get_template_directory_uri();?>/assets/images/partners_brand3.png"></div>
        <div class="slider__item"><img class="partners__img"
            src="<?php echo get_template_directory_uri();?>/assets/images/partners_brand4.png"></div>
        <div class="slider__item"><img class="partners__img"
            src="<?php echo get_template_directory_uri();?>/assets/images/partners_brand5.png"></div>
        <div class="slider__item"><img class="partners__img"
            src="<?php echo get_template_directory_uri();?>/assets/images/partners_brand6.png"></div>
      </div><img class="slider__arrow_right hidden_1000" id="slider__partners"
        src="<?php echo get_template_directory_uri();?>/assets/images/slider_arrow_right.png">
    </div>
  </div>
</div>
<?php
get_footer();