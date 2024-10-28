<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Aurauto
 */

require_once('api.php');

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
$brandsData = file_get_contents("http://localhost/api/brand/");
$brandsObject = json_decode($brandsData);
$cars_gearbox_data = file_get_contents("http://localhost/api/cars_gearbox/");
$cars_gearbox_object = json_decode($cars_gearbox_data);
$cars_type_data = file_get_contents("http://localhost/api/cars_type/");
$cars_type_object = json_decode($cars_type_data);

$cars_color_data = file_get_contents("http://localhost/api/color/");
$cars_color = json_decode($cars_color_data);
?>

<form action="" method="POST" id="filter" class="block-models-auto__selection-mode">
  <div class="All-auto-button-block">
    <a class="All-auto-button" href="<?php echo get_permalink(47)?>">Все авто</a>
  </div>

  <div class="selector-mode-auto">
    <input type="checkbox" name="condition" value="Новый" class="label-condition" id="condition-new">
    <label for="condition-new" class="label new-auto">Новые авто</label>
    <input type="checkbox" name="condition" value="С пробегом" class="label-condition" id="condition-bu">
    <label for="condition-bu" class="label used-auto">С пробегом</label>
  </div>

  <div class="main__countries block-models-width">
    <label class="main__country_img"><input type="checkbox" name="country" value="Армения"><img src="<?php echo get_template_directory_uri();?>/assets/images/country1.png"></label>
    <label class="main__country_img"><input type="checkbox" name="country" value="Беларусь"><img src="<?php echo get_template_directory_uri();?>/assets/images/country2.png"></label>
    <label class="main__country_img"><input type="checkbox" name="country" value="Казахстан"><img src="<?php echo get_template_directory_uri();?>/assets/images/country3.png"></label>
    <label class="main__country_img"><input type="checkbox" name="country" value="Киргизстан"><img src="<?php echo get_template_directory_uri();?>/assets/images/country4.png"></label>
  </div>

  <div class="catalog-select-group__wrap">
    <label for="brand" class="label">Марка</label>
    <input type="search" name="brand" class="text-area-input" list="brands" placeholder="Любая">
    <?php 
      if ($brandsObject) {
        echo '<datalist id="brands">';
        foreach ($brandsObject as $key => $brand) {
          echo '<option value="'.$brand->name.'">'.$brand->name.'</option>';
        }
        echo '</datalist>';
      }?>
    <label for="model" class="label">Модель</label>
    <input type="search" name="model" class="text-area-input" list="models" placeholder="Любая">
    <datalist id="models">
      <option value=""></option>
    </datalist>
    <label for="color" class="label">Цвет</label>
    <input type="search" name="color" class="text-area-input" placeholder="Любой" list="colors">
    <?php 
      if ($cars_color) {
        echo '<datalist id="colors">';
        foreach ($cars_color as $key => $color) {
          echo '<option value="'.$color->name.'">'.$color->name.'</option>';
        }
        echo '</datalist>';
      }?>
    <label class="label">Цена</label>
    <div class="block-items">
      <input type="number" name="price_min" class="common-block-input-left" placeholder="Цена от">
      <input type="number" name="price_max" class="common-block-input-right" placeholder="До, руб.">
    </div>

    <div class="open-full-options">
      <a class="show-link" href="#">Показать</a>
      <a class="full-filter" href="">Полный фильтр</a>


    </div>

    <label class="label year-mobile">Год выпуска</label>
    <div class="block-items">
      <input type="text" name="production_date_min" class="common-block-input-left year-mobile" placeholder="1960">
      <input type="text" name="production_date_max" class="common-block-input-right year-mobile" placeholder="2023">
    </div>

    <label for="gearbox" class="label year-mobile">Коробка передач</label>
    <input type="text" name="cars_gearbox" class="text-area-input year-mobile-area" placeholder="Любая"
      list="cars_gearbox">
    <datalist id="cars_gearbox">
      <?php foreach ($cars_gearbox_object as $key => $value) {
        echo '<option value="'.$value->name.'">'.$value->name.'</option>';
      }?>
    </datalist>
    <div class="checkbox-block">
      <p class="checkbox-label-name">Привод</p>

      <div class="checkbox-transmission-wrap">

        <div class="checkbox-transmission">
          <label class="checkbox"> <input type="checkbox" value="Передний" name="cars_drive"> <span></span>
            Передний</label>
        </div>

        <div class="checkbox-transmission">
          <label class="checkbox"><input type="checkbox" value="Задний" name="cars_drive"> <span></span>
            Задний</label>
        </div>


        <div class="checkbox-transmission">
          <label class="checkbox"><input type="checkbox" value="Полный" name="cars_drive"> <span></span>
            Полный</label>
        </div>
      </div>

      <div class="checkbox-block">
        <p class="checkbox-label-name">Двигатель</p>
        <div class="checkbox-engine-wrap">

          <div class="checkbox-engine">

            <label class="checkbox"><input type="checkbox" value="Бензин" name="cars_engine"><span></span> Бензин </label>
          </div>

          <div class="checkbox-engine">

            <label class="checkbox"><input type="checkbox" value="Электро" name="cars_engine"><span></span> Электро
            </label>
          </div>


          <div class="checkbox-engine">
            <label class="checkbox"><input type="checkbox" value="Дизель" name="cars_engine"><span></span> Дизель
            </label>
          </div>

          <div class="checkbox-engine">

            <label class="checkbox"><input type="checkbox" value="Гибрид" name="cars_engine"><span></span> Гибрид
            </label>
          </div>
        </div>
      </div>


      <div class="catalog-engine-mode-select">
        <label for="engine_capacity " class="label">Объем двигателя</label>
        <div class="block-engine-force">
          <input type="text" name="engine_capacity_min" id="value-force-left" placeholder="От 0,0">
          <input type="text" name="engine_capacity_max" id="value-force-right" placeholder="До, 6+">
        </div>
        <label for="model" class="label">Пробег</label>
        <div class="block-engine-force">
          <input type="text" name="mileage_min" id="engine-force-left" placeholder="От">
          <input type="text" name="mileage_max" id="engine-force-right" placeholder="До">
        </div>
      </div>
    </div>
  </div>


  <div class="body-car-select">
    <label for="cars_type" class="label-body-car">Тип кузова</label>
    <input type="text" name="cars_type" id="body-car-select-item" placeholder="Любой" list="cars_type_list">
	      <?php 
      if ($cars_type_object) {
        echo '<datalist id="cars_type_list">';
        foreach ($cars_type_object as $key => $type) {
          echo '<option value="'.$type->name.'">'.$type->name.'</option>';
        }
        echo '</datalist>';
      }?>
  </div>

  <button class="call">Применить</button><input type="hidden" name="action" value="myfilter">
  <div class="block-models-auto__advertisements">

  </div>
</form>