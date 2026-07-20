<?php get_header();
set_query_var('hero_title', get_the_title());
set_query_var('hero_style', 'solid');
get_template_part('template-parts/section/hero-banner');
?>
<section class="section-page">
    <div class="container-section">
        <?php while (have_posts()) : the_post(); the_content(); endwhile; ?>
    </div>
</section>
<?php get_footer(); ?>
