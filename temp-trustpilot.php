<?php
/** Template Name: Trust Reviews */
get_header();
set_query_var('hero_title', get_the_title());
set_query_var('hero_style', 'solid');
get_template_part('template-parts/section/hero-banner');
?>
<section class="section-page">
    <div class="container-section">
        <?php if (have_posts()) : while (have_posts()) : the_post(); the_content(); endwhile; endif; ?>
        <?php get_template_part('template-parts/review', 'provider'); ?>
    </div>
</section>
<?php get_footer(); ?>
