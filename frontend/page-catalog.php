<?php
/**
 * The template for displaying all pages
 * Template name: Каталог
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
$url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; 
// $page = $_GET['pages'] ?: '1';
// if (str_contains( $url, '?pages=' )) {
//   $ourData = file_get_contents("http://localhost/api/car_ad_filter/?page=".$page."");
//   $object = json_decode($ourData);
// } elseif (str_contains( $url, '?search=' )) {
//   $search = myUrlEncode($_GET['search']);
  $country = 'Армения';
  if ($_COOKIE[ 'selectedCountry']) {
    $country = $_COOKIE[ 'selectedCountry'];
  }
//   $ourData = file_get_contents("http://localhost/api/car_ad_filter/?search=". $search ."&country=".$country."");
//   $object = json_decode($ourData);
// } else {
//   $condition = $_GET['condition']  ?: '';
//   $country = $_GET['country'] ?: '';
  $brand = $_GET['brand'] ?: '';
//   $price_min = $_GET['price_min'] ?: '';
//   $price_max = $_GET['price_max'] ?: '';
//   $color = $_GET['color'] ?: '';
//   $model = $_GET['model'] ?: '';
//   $production_date_min = $_GET['production_date_min'] ?: '';
//   $production_date_max = $_GET['production_date_max'] ?: '';
//   $engine_capacity_min = $_GET['engine_capacity_min'] ?: '';
//   $engine_capacity_max = $_GET['engine_capacity_max'] ?: '';
//   $mileage_min = $_GET['mileage_min'] ?: '';
//   $mileage_max = $_GET['mileage_max'] ?: '';
//   $gearbox = $_GET['cars_gearbox'] ?: '';
//   $cars_drive = $_GET['cars_drive'] ?: '';
//   $engine = $_GET['cars_engine'] ?: '';
//   $cars_type = $_GET['cars_type'] ?: '';
//   $page = $_GET['pages'] ?: '1';
//   $ordering = $_GET['ordering'] ?: 'create_date';
//   $ourData = file_get_contents("http://localhost/api/car_ad_filter/?condition=".$condition."&country=".$country."&brand=".$brand."&model=".$model."&production_date_min=".$production_date_min."&production_date_max=".$production_date_max."&cars_gearbox=".$gearbox."&cars_drive=".$cars_drive."&cars_engine=".$engine."&cars_type=".$cars_type."&price_min=".$price_min."&price_max=".$price_max."&color=".$color."&mileage_min=".$mileage_min."&mileage_max=".$mileage_max."&engine_capacity_min=".$engine_capacity_min."&engine_capacity_max=".$engine_capacity_max."&page=".$page."&ordering=".$ordering."");
//   $object = json_decode($ourData);
// }
// $brandsData = file_get_contents("http://localhost/api/brand/");
// $brandsObject = json_decode($brandsData);

?>
<div class="content_catalog">
  <div class="content-bread-wrap">
    <ul class="bread-crumbs-list">
      <!-- <li class="bread-crumbs-li">· Ейск</li> -->
      <li class="bread-crumbs-li">· Транспорт</li>
      <li class="bread-crumbs-li">· Автомобили</li>
    </ul>
  </div>

  <div class="auto-belarus__wrap">
    <p class="auto-belarus"><?php 
      if ($brand) {
        echo $brand;
      } else {
        the_title();
      }
      ?></p>
    <number class="auto-belarus__total"><?php echo number_format( $object->count, 0, '', ' ' );?></number>
  </div>


  <div class="block-models-auto-wrap">

    <?php get_sidebar();?>

    <div class="models-block-describe">
      <div class="models-block-wrap">
        <?php brandCounter('Audi');?>
        <?php brandCounter('BMW');?>
        <?php brandCounter('Changan');?>
        <?php brandCounter('Chery');?>
        <?php brandCounter('Chevrolet');?>
        <?php brandCounter('Ford');?>
        <?php brandCounter('Geely');?>
        <?php brandCounter('Haval');?>
        <?php brandCounter('Honda');?>
        <?php brandCounter('Hyundai');?>
        <?php brandCounter('Kia');?>
        <?php brandCounter('Land Rover');?>
        <?php brandCounter('Lexus');?>
        <?php brandCounter('Mazda');?>
        <?php brandCounter('Mercedes-Benz');?>
        <?php brandCounter('Mitsubishi');?>
        <?php brandCounter('Nissan');?>
        <?php brandCounter('Opel');?>
        <?php brandCounter('Peugeot');?>
        <?php brandCounter('Renault');?>
        <?php brandCounter('Skoda');?>
        <?php brandCounter('Suzuki');?>
        <?php brandCounter('Toyota');?>
        <?php brandCounter('Volkswagen');?>
        <?php brandCounter('ВАЗ (ЛАДА)');?>
        <?php brandCounter('ГАЗ');?>
        <?php brandCounter('УАЗ');?>
      </div>


      <?php echo do_shortcode( '[echo_viewed_cars]' );?>


      <div class="filters-block">
        <!-- <div class="map-block">
          <a class="map-link" href="#">
            <img src="<?php echo get_template_directory_uri();?>/assets/images/catalog_page/filters-block/map.png"
              alt="map">
          </a>
          <p class="map-block__text">На карте</p>

        </div> -->

        <div class="save-block">
          <a class="save-link" href="#">
            <img src="<?php echo get_template_directory_uri();?>/assets/images/catalog_page/filters-block/heart.png"
              alt="like">
          </a>
          <p class="save-block__text">Сохранить подборку</p>
        </div>

        <div class="sorting-block">
          <div class="sorting-link">
            <img src="<?php echo get_template_directory_uri();?>/assets/images/catalog_page/filters-block/sorting.png"
              alt="sorting">
          </div>
          <p class="sorting-block__text">Сортировка</p>
          <ul>
            <li><a href="<?php echo $url;?>&ordering=-price">Цена: по убыванию </a></li>
            <li><a href="<?php echo $url;?>&ordering=price">Цена: по возрастанию </a></li>
            <li><a href="<?php echo $url;?>&ordering=create_date">Сначала новые </a></li>
            <li><a href="<?php echo $url;?>&ordering=-create_date">Сначала старые </a></li>
          </ul>
        </div>
        <?php if( !empty( $_COOKIE[ 'selectedCountry' ] ) ) {?>
        <div class="checkbox-filter-block">
          <label class="checkbox-filter-link" href="#">
            <input type="checkbox" name="" value="<?php echo $_COOKIE[ 'selectedCountry' ]?>"
              id="checkbox-filter-input">
            <p class="checkbox-filter__text">Сначала в выбранной стране</p>
          </label>
        </div>
        <?php }?>
      </div>


      <div class="cars-offers-block catalog">
        <!-- <div class="mobile-block-advertisement-1">

        </div>
        <div class="mobile-block-advertisements">

        </div>
        <div class="mobile-block-advertisements-2">

        </div>

        <div class="block-advertisement">

        </div> -->
        <div class="pagination">
        </div>
      </div>
    </div>
  </div>
</div>
<?php
get_footer();