<?php


function generate_custom_sitemap() {
    $services = ['internet', 'tv', 'internet-tv', 'home-security', 'landline', 'moving', 'solar', 'insurance', 'health-insurance'];
    
    $zone_states = get_terms(['taxonomy' => 'zone_state', 'hide_empty' => true]);
    $zone_cities = get_terms(['taxonomy' => 'zone_city', 'hide_empty' => true]);
    $area_zone_posts = get_posts(['post_type' => 'area_zone', 'posts_per_page' => -1, 'fields' => 'ids']);

    $file = fopen(ABSPATH . 'zone_sitemap.xml', 'w');
    fwrite($file, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
    fwrite($file, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL);

    foreach ($services as $service) {
        fwrite($file, '<url><loc>' . esc_url(home_url("/$service/")) . '</loc></url>' . PHP_EOL);

        foreach ($zone_states as $zone_state) {
            fwrite($file, '<url><loc>' . esc_url(home_url("/$service/{$zone_state->slug}/")) . '</loc></url>' . PHP_EOL);

            foreach ($zone_cities as $zone_city) {
                $city_url = home_url("/$service/{$zone_state->slug}/{$zone_city->slug}/");
                fwrite($file, '<url><loc>' . esc_url($city_url) . '</loc></url>' . PHP_EOL);

                foreach ($area_zone_posts as $post_id) {
                    $post_zone_states = wp_get_post_terms($post_id, 'zone_state', ['fields' => 'slugs']);
                    $post_zone_cities = wp_get_post_terms($post_id, 'zone_city', ['fields' => 'slugs']);
                    
                    if (in_array($zone_state->slug, $post_zone_states) && in_array($zone_city->slug, $post_zone_cities)) {
                        $post_slug = get_post_field('post_name', $post_id);
                        fwrite($file, '<url><loc>' . esc_url(home_url("/$service/{$zone_state->slug}/{$zone_city->slug}/{$post_slug}/")) . '</loc></url>' . PHP_EOL);
                    }
                }
            }
        }
    }

    fwrite($file, '</urlset>' . PHP_EOL);
    fclose($file);
}
// Remove from init - too heavy. Run manually via sitemap generator page.
// add_action('init', 'generate_custom_sitemap');
