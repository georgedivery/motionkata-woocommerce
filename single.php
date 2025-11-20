<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 */
get_header(); ?>

<div class="main">
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

    <?php endwhile; endif;  ?>
</div>

<?php
get_footer();