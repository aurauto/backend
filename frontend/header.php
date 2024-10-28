<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Aurauto
 */

require_once('api.php');

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <header>
    <div class="ad"></div>
    <div class="header__bottom">
      <div class="header__items">
        <ol class="header__items_inner block_inner">
          <div class="header__empty"></div>
          <div class="header__empty"></div>
          <div class="header__empty"></div>
          <?php wp_nav_menu( [ 
            'menu' => 'primary',
            'container' => '',
            'items_wrap' => '%3$s' ] );?>
          <div class="country"><img class="country__icon"
              src="<?php echo get_template_directory_uri();?>/assets/images/country.png">
            <form id="countryForm">
				 <?php 
          if (isset($_COOKIE['selectedCountry'])) {
            $currentCountry = $_COOKIE['selectedCountry'];
          } else {
            $currentCountry = do_shortcode('[wt_geotargeting get="country"]');
          }
					$countries = file_get_contents('http://localhost/api/country/');
					$object = json_decode($countries);
					echo '<select name="country" id="country">
					<option value="" selected>'.$currentCountry.'</option>';
						foreach($object as $key => $value) {
							// if (!$currentCountry == $value->name) {
							echo '<option value="'.$value->name.'">'.$value->name.'</option>';
              // }
						}
					echo '</select>';
				?>
            </form>
          </div>
        </ol>
      </div>
      <div class="header__list">
        <div class="header__list_inner block_inner">
          <div class="block-logo-category">
            <a href="<?php echo get_home_url();?>" class="logo">
              <p class="logo__p">aur</p><span class="logo__span">auto</span>
            </a>

            <a href="<?php echo get_permalink(47)?>" class="category"><img class="category__img"
                src="<?php echo get_template_directory_uri();?>/assets/images/category.png">
              <p class="category__p">Все категории</p>
            </a>
          </div>
          <!-- <div class="search">
            <input class="search__input" placeholder="Поиск по объявлениям"><a class="search__button" href="#">Найти</a>
          </div> -->
          <form role="search" method="get" class="search" action="<?php echo esc_url( get_permalink( 50 ) ); ?>">
            <input type="search" class="search__input" placeholder="Поиск по объявлениям" name="search" />
            <button type="submit" value="Найти" class="search__button">Найти</button>
          </form>

          <?php if ( is_user_logged_in() ) { ?>
          <div class="auth hidden_1240"><a class="auth__button" href="<?php echo get_permalink( 23 );?>">Аккаунт</a>
          </div>
          <?php } else {?>
          <div class="auth hidden_1240"><a class="auth__button" href="<?php echo get_permalink( 25 );?>">Авторизация</a>
          </div>
          <?php }?>
        </div>
      </div>
    </div>
  </header>