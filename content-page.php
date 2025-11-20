<?php
/**
 * Template part for displaying page content
 *
 * @package WordPress
 * @subpackage Webbeb
 */
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<section class="section-post">
    <div class="shell">
        <div class="section-head">
            <h2 class="section-title">
                <?php the_title(); ?>
            </h2>
        </div>

        <div class="section-body">
            <?php the_content(); ?>
        </div>
    </div>
</section>
<?php endwhile; endif; ?>

