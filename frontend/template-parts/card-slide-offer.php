<?php
$value = $args;
$time = strtotime($value->create_date);
$cur_user_id = get_current_user_id();
$liked_cars = get_user_meta( $cur_user_id, 'like_auto', false );
$idAuto =  $value->ad_id;
$name = $value->brand . ' ' . $value->model . '-' . $value->production_date;
$slug = transliterate($name) . '-' . $value->ad_id;
?>
<div class="car-offer">
  <div class="car-picture__block-img">
    <a href="<?php echo get_permalink(8) . $slug; ?>">
      <img class="car-picture" src="<?php echo  $value->images[0]  ?>" alt="car" onerror="this.src = '<?php echo get_template_directory_uri()?>/assets/images/logo.svg'">
    </a>
    <div class="block-contacts-call">
      <a href="#" class="telephone-icon">
        <img src="<?php echo  get_template_directory_uri() ?>/assets/images/catalog_page/mobile/telephone-icon.png" alt="phone">
      </a>
      <a href="#" class="chat-icon">
        <img src="<?php echo get_template_directory_uri() ?>/assets/images/catalog_page/mobile/chat-icon.svg" alt="chat">
      </a>
      <a href="#" class="like-icon">
        <img src="<?php echo get_template_directory_uri() ?>/assets/images/catalog_page/mobile/heart-icone.png" alt="heart-icone">
      </a>
    </div>
  </div>

  <?php  
    if ( is_user_logged_in() ) { 
      if (in_array($idAuto, $liked_cars)) {
        echo '  <div class="like-block added" data-id="'. $value->ad_id.'">
        <svg class="icon" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 391.837 391.837" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M285.257 35.528c58.743.286 106.294 47.836 106.58 106.58 0 107.624-195.918 214.204-195.918 214.204S0 248.165 0 142.108c0-58.862 47.717-106.58 106.58-106.58a105.534 105.534 0 0 1 89.339 48.065 106.578 106.578 0 0 1 89.338-48.065z" style="" fill="#d7443e" data-original="#d7443e" class=""></path></g></svg>
        <svg class="icon" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 412.735 412.735" style="enable-background:new 0 0 512 512" xml:space="preserve"><g><path d="M295.706 35.522a115.985 115.985 0 0 0-89.339 41.273 114.413 114.413 0 0 0-89.339-41.273C52.395 35.522 0 87.917 0 152.55c0 110.76 193.306 218.906 201.143 223.086a9.404 9.404 0 0 0 10.449 0c7.837-4.18 201.143-110.759 201.143-223.086 0-64.633-52.396-117.028-117.029-117.028zm-89.339 319.216C176.065 336.975 20.898 242.412 20.898 152.55c0-53.091 43.039-96.131 96.131-96.131a94.041 94.041 0 0 1 80.457 43.363c3.557 4.905 10.418 5.998 15.323 2.44a10.968 10.968 0 0 0 2.44-2.44c29.055-44.435 88.631-56.903 133.066-27.848a96.129 96.129 0 0 1 43.521 80.615c.001 90.907-155.167 184.948-185.469 202.189z" fill="#ffffff" opacity="1" data-original="#000000"></path></g></svg>
      </div>';
      } else {
        echo '  <div class="like-block" data-id="'. $value->ad_id.'">
        <svg class="icon" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 391.837 391.837" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M285.257 35.528c58.743.286 106.294 47.836 106.58 106.58 0 107.624-195.918 214.204-195.918 214.204S0 248.165 0 142.108c0-58.862 47.717-106.58 106.58-106.58a105.534 105.534 0 0 1 89.339 48.065 106.578 106.578 0 0 1 89.338-48.065z" style="" fill="#d7443e" data-original="#d7443e" class=""></path></g></svg>
        <svg class="icon" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 412.735 412.735" style="enable-background:new 0 0 512 512" xml:space="preserve"><g><path d="M295.706 35.522a115.985 115.985 0 0 0-89.339 41.273 114.413 114.413 0 0 0-89.339-41.273C52.395 35.522 0 87.917 0 152.55c0 110.76 193.306 218.906 201.143 223.086a9.404 9.404 0 0 0 10.449 0c7.837-4.18 201.143-110.759 201.143-223.086 0-64.633-52.396-117.028-117.029-117.028zm-89.339 319.216C176.065 336.975 20.898 242.412 20.898 152.55c0-53.091 43.039-96.131 96.131-96.131a94.041 94.041 0 0 1 80.457 43.363c3.557 4.905 10.418 5.998 15.323 2.44a10.968 10.968 0 0 0 2.44-2.44c29.055-44.435 88.631-56.903 133.066-27.848a96.129 96.129 0 0 1 43.521 80.615c.001 90.907-155.167 184.948-185.469 202.189z" fill="#ffffff" opacity="1" data-original="#000000"></path></g></svg>
      </div>';
      }
    }?>
  <div class="you-looked-car__block-describe">
    <a href="<?php echo get_permalink(8) . $slug; ?>" class="car-offer-brand"><?php echo $value->brand ?>
      <?php echo $value->model ?>, <?php echo $value->production_date ?></a>
    <div class="price"><?php echo number_format($value->price, 0, '', ' ')  ?> $</div>
    <div class="desribe-car"><?php echo $value->mileage ?> км, <?php echo $value->cars_type ?>, <?php echo $value->cars_drive ?>,
      <?php echo $value->cars_engine ?></div>
    <div class="car-offer__city"><?php echo $value->area ?>, <?php echo $value->country ?></div>
    <div class="last-visit catalog-last-visit"><?php echo date('d.m.y',$time) ?></div>

    <div class="block-message">
      <a class="send-message" href="#">Сообщение</a>
      <a class="call" href="#">Позвонить</a>
    </div>
  </div>
</div>