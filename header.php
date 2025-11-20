<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Webbeb
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- We will use fontawesome 7 -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css " type="text/css" media="all" />

	<?php wp_head(); ?>
  </head>

  <body <?php body_class(); ?>>
	<?php if (function_exists('wp_body_open')) { wp_body_open(); } ?>
	<div class="wrapper">

		<header class="header">
			<div class="shell">
				<div class="site-branding">
					<?php
					if (function_exists('the_custom_logo') && has_custom_logo()) {
						the_custom_logo();
					} else {
						?>
						<a class="logo logo--text" href="<?php echo esc_url(home_url('/')); ?>">
							<?php echo esc_html(get_bloginfo('name')); ?>
						</a>
						<?php
					}
					?>
				</div>

				<div class="navigation">
					<?php
					wp_nav_menu([
						'theme_location'  => 'primary',
						'container_class' => 'navbar-collapse collapse',
						'container_id'    => 'navbar',
						'menu_class'      => 'nav navbar-nav navbar-right',
						'fallback_cb'     => 'wp_page_menu',
					]);
					?>
				</div><!-- /.navigation -->
			</div><!-- /.shell -->
		</header>