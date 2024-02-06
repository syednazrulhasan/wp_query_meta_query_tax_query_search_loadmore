<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Fresh_Theme
 */

?>

	<footer id="colophon" class="site-footer">
		<div class="site-info">
			&copy;<?php echo bloginfo('blogname'); ?>  | <?php echo date('Y');    ?> <span><?php //echo do_shortcode('[weather_data]'); ?></span>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
