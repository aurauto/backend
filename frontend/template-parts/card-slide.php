<?php
  $value = $args;
  $time = strtotime($value->create_date);
$name = $value->brand . ' ' . $value->model . '-' . $value->production_date;
$slug = transliterate($name) . '-' . $value->ad_id;
?>
<div class="slider__item">
  <a href="<?php echo get_permalink(8) . $slug; ?>" class="you-looked-car">
    <div сlass="you-looked-car__picture-block">
      <img class="slider-looked__slider-car"
        src="<?php echo  $value->images[0]  ?>" onerror="this.src = '<?php echo get_template_directory_uri()?>/assets/images/logo.svg'">

      <p class="name_car"><?php echo $value->brand ?>
      <?php echo $value->model ?>, <?php echo $value->production_date ?></p>
      <span class="cost"><?php echo number_format($value->price, 0, '', ' ')  ?> $</span>
      <div class="location"><?php echo $value->area ?>, <?php echo $value->country ?></div>
      <div class="last-visit"><?php echo date('d.m.y',$time) ?></div>
    </div>
  </a>
</div>