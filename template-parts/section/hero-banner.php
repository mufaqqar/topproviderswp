<?php
/**
 * Hero Banner Component
 *
 * Usage:
 *   set_query_var('hero_title', 'Page Title');
 *   set_query_var('hero_style', 'gradient'); // gradient | solid | image | gray
 *   set_query_var('hero_image', 'contact-us-bg.webp'); // filename in /images/
 *   set_query_var('hero_search', false); // show search form
 *   set_query_var('hero_deco', false); // show decorative images
 *   get_template_part('template-parts/section/hero-banner');
 *
 * For gray style with deco (used in area-zone templates):
 *   set_query_var('hero_title', 'Title');
 *   set_query_var('hero_subtitle', 'Subtitle text');
 *   set_query_var('hero_style', 'gray');
 *   set_query_var('hero_deco', true);
 *   set_query_var('hero_search', true);
 *   get_template_part('template-parts/section/hero-banner');
 */

$hero_title = get_query_var('hero_title', '');
$hero_subtitle = get_query_var('hero_subtitle', '');
$hero_style = get_query_var('hero_style', 'gradient');
$hero_image = get_query_var('hero_image', 'contact-us-bg.webp');
$hero_search = get_query_var('hero_search', false);
$hero_deco = get_query_var('hero_deco', false);
$hero_search_form = get_query_var('hero_search_form', 'search');

if ($hero_style === 'gray') : ?>
<section class="section-hero-gray">
    <div class="container-section">
        <div class="flex justify-center flex-col items-center">
            <?php if ($hero_title) : ?>
            <h1 class="hero-title"><?php echo wp_kses_post($hero_title); ?></h1>
            <?php endif; ?>
            <?php if ($hero_subtitle) : ?>
            <p class="hero-subtitle"><?php echo wp_kses_post($hero_subtitle); ?></p>
            <?php endif; ?>
            <?php if ($hero_search) : ?>
            <div class="search-form-wrapper-white">
                <?php get_template_part('template-parts/' . $hero_search_form, 'form'); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php if ($hero_deco) : ?>
    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/business.webp" alt="" class="deco-business"/>
    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/wave1.png" alt="" class="deco-wave"/>
    <?php endif; ?>
</section>
<?php elseif ($hero_style === 'solid') : ?>
<section class="section-hero-solid">
    <div class="container-section">
        <h1 class="hero-title-alt"><?php echo wp_kses_post($hero_title); ?></h1>
        <?php if ($hero_search) : ?>
        <div class="search-form-wrapper mt-6">
            <?php get_template_part('template-parts/' . $hero_search_form, 'form'); ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php else : ?>
<section class="section-hero-gradient"
    style="background-image: linear-gradient(45deg, rgba(103,71,192,1), rgba(103,71,192,0.6)), url('<?php echo esc_url(get_template_directory_uri() . '/images/' . $hero_image); ?>')">
    <div class="container-section">
        <h1 class="hero-title-lg"><?php echo wp_kses_post($hero_title); ?></h1>
        <?php if ($hero_search) : ?>
        <div class="search-form-wrapper mt-6">
            <?php get_template_part('template-parts/' . $hero_search_form, 'form'); ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>
