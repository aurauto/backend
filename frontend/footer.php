<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Aurauto
 */

?>

<footer>
    <div class="footer__inner block_inner">
      <div class="footer__list">
        <div class="logo">
          <p class="logo__p">aur</p><span class="logo_theme_white logo__span">auto</span>
        </div>
        <p class="footer__p">Политика конфиденциальности<br><?php echo date('Y')?> ©Все права защищены</p>
      </div>
		<?php wp_nav_menu( [
	'theme_location' => 'menu-footer',
	'container' => '',
	'menu_class'      => 'footer__ul',
] ); ?>
      <div class="footer__list">
        <div class="footer__p"><span class="help"> Нужна помощь? </span> Закажите бесплатную консультацию наших
          специалистов.Перезвоним через 15
          минут.</div>
        <div class="footer__search">
			<?php echo do_shortcode('[contact-form-7 id="8b24936" title="Контактная форма 1"]');?>
        </div>
      </div>
    </div>
  </footer>
<div id="modal-container">
  <div class="modal-background">
    <div class="modal">
      <!-- <h2>I'm a Modal</h2> -->
      <div class="modal-close">&times;</div>
      <p>Нажмите перейти чтобы попасть на сайт с объявлением продавца и его данными</p>
      <a class="send-message" href="#" rel="noopener noreferrer" target="_blank">Перейти</a>
      <!-- <svg class="modal-svg" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" preserveAspectRatio="none">
								<rect x="0" y="0" fill="none" width="226" height="162" rx="3" ry="3"></rect>
							</svg> -->
    </div>
  </div>
</div>
<?php wp_footer(); ?>
</body>
</html>