<?php
// Check if Theme Template is selected
$is_theme_template = is_page_template('theme-template.php');

// Only show ACF sections if Theme Template is selected
if (!$is_theme_template) {
	return;
}

if (!function_exists('have_rows') || !function_exists('get_field')) :
	?>
<section>
    <div class="shell">
        <h2>
            Advanced Custom Fields plugin is not active.
        </h2>
    </div>
</section>
<?php
	return;
endif;

$sections_field = get_field('sections');

if (!$sections_field) :
	?>
<section>
    <div class="shell">
        <h2>
            No sections created yet
        </h2>
    </div>
</section>
<?php
	return;
endif;
?>

<?php while (have_rows('sections')) : the_row(); ?>
<?php if (get_row_layout() === 'hero_section') : ?>
<?php include 'sections/hero/index.php'; ?>
<?php endif; ?>
<?php endwhile; // end "while" flex content?>