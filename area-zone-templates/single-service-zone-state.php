<?php

global $wp_query;

$zone_state = isset($wp_query->query_vars['zone_state']) ? $wp_query->query_vars['zone_state'] : '';
$zone_city = isset($wp_query->query_vars['zone_city']) ? $wp_query->query_vars['zone_city'] : '';
$post_slug = isset($wp_query->query_vars['post_slug']) ? $wp_query->query_vars['post_slug'] : '';
$type = isset($wp_query->query_vars['service']) ? $wp_query->query_vars['service'] : '';

add_filter('wpseo_title', 'Generate_Title_For_State');
add_filter('wpseo_metadesc', 'Generate_Description_For_State');
add_filter('wpseo_canonical', 'Generate_Canonical_Tag');

get_header();

$zip_codes_to_search = get_zipcodes_by_state($zone_state);
$provider_ids = create_meta_query_for_zipcodes($zip_codes_to_search, $type);
if (!empty($provider_ids)) {
    $query_args = array(
        'post_type'      => 'providers',
        'posts_per_page' => -1,
        'post__in'       => $provider_ids,
        'orderby'        => 'post__in',
    );
    $query = new WP_Query($query_args);
} else {
    echo 'No providers match the criteria.';
}

$i = 0;
$state = strtoupper($zone_state);


set_query_var('hero_title', esc_html($type) . ' Providers in <br /><span class="text-brand-green">' . esc_html($state) . '</span>');
set_query_var('hero_subtitle', 'Compare ' . esc_html($type) . ' providers in ' . esc_html($state) . ' — enter your ZIP to see available plans and pricing:');
set_query_var('hero_style', 'gray');
set_query_var('hero_deco', true);
set_query_var('hero_search', true);
get_template_part('template-parts/section/hero-banner');
?>

<section class="my-16">
    <div class="container-section">
        <div class="mb-10">
            <h2 class="section-title text-center md:text-left"><?php echo esc_html($type) ?> Providers in <span class="text-brand-green"><?php echo esc_html($state) ?> </span></h2>
        </div>

        <div class="filter-bar">
            <?php get_template_part('template-parts/types', 'routing'); ?>
            <div class="sort-wrapper">
                <p class="font-medium">Sort By:</p>
                <div class="sort-select">
                    <select>
                        <option value="">Recommended</option>
                        <option value="">Speed</option>
                        <option value="">Avg. User Rating</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="grid-providers">
            <?php
                if ($query->have_posts()) {
                    while ($query->have_posts()) { $query->the_post(); $i++; set_query_var('provider_index', $i);
                        get_template_part('template-parts/provider', 'card');
                    }
                } else {
                    echo 'No providers found with the specified zip code.';
                }
                wp_reset_postdata();
            ?>
        </div>
        <div><p class="disclaimer">*DISCLAIMER: Availability vary by service address. not all offers available in all areas, pricing subject to change at any time. Additional taxes, fees, and terms may apply.</p></div>
    </div>
</section>

<?php get_footer(); ?>
