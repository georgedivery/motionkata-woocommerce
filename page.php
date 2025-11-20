<?php get_header(); ?>

<?php
// Check if Theme Template is selected
$is_theme_template = is_page_template('theme-template.php');

// If Theme Template is selected, show sections
if ($is_theme_template) : ?>
	<div class="main">
		<?php include 'sections.php';?>
	</div><!-- /.main -->
<?php else : ?>
	<!-- Default page content when Theme Template is not selected -->
	<div class="main">
		<?php get_template_part('content', 'page'); ?>
	</div>
<?php endif; ?>

<?php get_footer(); ?>