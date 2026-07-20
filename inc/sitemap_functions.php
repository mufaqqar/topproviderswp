<?php

// Serve sitemap XML files from theme folder via WordPress
add_action('init', function () {
    $request_uri = $_SERVER['REQUEST_URI'] ?? '';
    $path = parse_url($request_uri, PHP_URL_PATH);
    $home = parse_url(home_url('/'), PHP_URL_PATH);

    if ($home && strpos($path, $home) === 0) {
        $path = substr($path, strlen($home) - 1);
    }

    if (preg_match('#^/sitemaps/.+\.xml$#i', $path)) {
        $file = basename($path);
        $file_path = _sitemap_path() . '/' . $file;

        if (file_exists($file_path) && filesize($file_path) > 0) {
            header('Content-Type: application/xml; charset=UTF-8');
            header('X-Robots-Tag: noindex, follow');
            readfile($file_path);
            exit;
        }
    }
});

add_filter('wpseo_sitemap_index', function ($sitemap_index) {
    $current_date = gmdate('Y-m-d H:i +0 0:00');
    $sitemap_dir = _sitemap_path();

    $sitemap_index .= '<sitemap><loc>' . esc_url(home_url('/sitemaps/states.xml')) . '</loc><lastmod>' . esc_html($current_date) . '</lastmod></sitemap>';

    if (is_dir($sitemap_dir)) {
        $files = scandir($sitemap_dir);
        $xml_files = preg_grep('/\.xml$/i', $files);
        sort($xml_files);
        foreach ($xml_files as $file) {
            if ($file === 'states.xml') continue;
            if (filesize($sitemap_dir . '/' . $file) === 0) continue;
            $sitemap_index .= '<sitemap><loc>' . esc_url(home_url('/sitemaps/' . $file)) . '</loc><lastmod>' . esc_html($current_date) . '</lastmod></sitemap>';
        }
    }

    return $sitemap_index;
});


//SiteMapByState(); Sitemap for States
function _sitemap_path() {
    $dir = get_template_directory() . '/sitemaps';
    if (!file_exists($dir)) {
        mkdir($dir, 0755, true);
    }
    return $dir;
}

function SiteMapByState() {
    $sitemap_folder = _sitemap_path();
    $sitemap_file = $sitemap_folder . '/states.xml';
    if (!file_exists($sitemap_folder)) {
        mkdir($sitemap_folder, 0755, true);
    }
    $file = fopen($sitemap_file, 'w');
    fwrite($file, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
    fwrite($file, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL);
    
    $types =  ['internet', 'tv', 'internet-tv', 'moving', 'solar', 'insurance', 'health-insurance', 'home-security'];  
    foreach ($types as $type) {
        $terms = get_terms(array(
            'taxonomy'   => 'zone_state',
            'hide_empty' => false,
            'posts_per_page' => -1,
        ));
        if (!empty($terms) && !is_wp_error($terms)) {
            foreach ($terms as $term) {
                $url = home_url($type . '/' . $term->slug);
                if (strpos($url, 'www.') === false) {
                    $url = str_replace('://', '://www.', $url);
                }
                fwrite($file, '<url>' . PHP_EOL);
                fwrite($file, '<loc>' . esc_url($url) . '</loc>' . PHP_EOL);
                fwrite($file, '</url>' . PHP_EOL);
            }
        }
    }
    fwrite($file, '</urlset>' . PHP_EOL);
    fclose($file);
    echo 'State sitemap generated.' . PHP_EOL;
}


// SiteMapByZipCode(); Sitemap for ZipCode
function SiteMapByZipCode() {
    set_time_limit(0);
    $services =  ['internet', 'tv', 'internet-tv', 'moving', 'solar', 'insurance', 'health-insurance', 'home-security'];
    $sitemap_folder = _sitemap_path();
    $posts_per_file = 20000;

    foreach ($services as $service) {
        $file_index = 1;
        $offset = 0;
        
        while (true) {
            $sitemap_file = "{$sitemap_folder}/zipcode_{$service}-{$file_index}.xml";
            $file = fopen($sitemap_file, 'w');
            fwrite($file, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
            fwrite($file, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL);

            $args = array(
                'post_type'      => 'area_zone',
                'posts_per_page' => $posts_per_file,
                'offset'         => $offset,
                'order'          => 'DESC',
                'fields'         => 'ids',
            );

            $providers_query = new WP_Query($args);

            if (!$providers_query->have_posts()) {
                fclose($file);
                break;
            }

            while ($providers_query->have_posts()) {
                $providers_query->the_post();
                $post_id = get_the_ID();
                $post_slug = get_post_field('post_name', $post_id);
                $zone_city_terms = get_the_terms($post_id, 'zone_city');
                $zone_state_terms = get_the_terms($post_id, 'zone_state');
                $zone_city = $zone_city_terms && !is_wp_error($zone_city_terms) ? $zone_city_terms[0]->slug : '';
                $zone_state = $zone_state_terms && !is_wp_error($zone_state_terms) ? $zone_state_terms[0]->slug : '';

                $link = home_url("/{$service}/{$zone_state}/{$zone_city}/{$post_slug}");
                if (strpos($link, 'www.') === false) {
                    $link = str_replace('://', '://www.', $link);
                }

                fwrite($file, "<url>" . PHP_EOL);
                fwrite($file, "<loc>" . esc_url($link) . "</loc>" . PHP_EOL);
                fwrite($file, "</url>" . PHP_EOL);
            }

            wp_reset_postdata();
            fwrite($file, '</urlset>' . PHP_EOL);
            fclose($file);
            echo 'Sitemap for ' . esc_html($service) . " generated and saved as " . esc_html($sitemap_file) . PHP_EOL;

            $offset += $posts_per_file;
            $file_index++;
        }
    }
}


function SiteMapByCity() {
    set_time_limit(0);
    $services =  ['internet', 'tv', 'internet-tv', 'moving', 'solar', 'insurance', 'health-insurance', 'home-security'];
    $sitemap_folder = _sitemap_path();
    $posts_per_file = 20000;
    $total_records = 0;

    foreach ($services as $service) {
        $file_index = 1;
        $offset = 0;
        
        while (true) {
            $sitemap_file = "{$sitemap_folder}/cities_{$service}-{$file_index}.xml";
            $file = fopen($sitemap_file, 'w');
            fwrite($file, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
            fwrite($file, '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL);

            $args = array(
                'post_type'      => 'area_zone',
                'posts_per_page' => $posts_per_file,
                'offset'         => $offset,
                'order'          => 'DESC',
                'fields'         => 'ids',
            );

            $providers_query = new WP_Query($args);
            $displayed_cities = array();

            if (!$providers_query->have_posts()) {
                fclose($file);
                break;
            }

            while ($providers_query->have_posts()) {
                $providers_query->the_post();
                $post_id = get_the_ID();
                $zone_city_terms = get_the_terms($post_id, 'zone_city');
                $zone_state_terms = get_the_terms($post_id, 'zone_state');
                $zone_city = $zone_city_terms && !is_wp_error($zone_city_terms) ? $zone_city_terms[0]->slug : '';
                $zone_state = $zone_state_terms && !is_wp_error($zone_state_terms) ? $zone_state_terms[0]->slug : '';

                $city_state_key = $zone_city . '|' . $zone_state;

                if (!in_array($city_state_key, $displayed_cities) && $zone_city && $zone_state) {
                    $displayed_cities[] = $city_state_key;

                    $link = home_url("/{$service}/{$zone_state}/{$zone_city}/");
                    if (strpos($link, 'www.') === false) {
                        $link = str_replace('://', '://www.', $link);
                    }

                    fwrite($file, "<url>" . PHP_EOL);
                    fwrite($file, "<loc>" . esc_url($link) . "</loc>" . PHP_EOL);
                    fwrite($file, "</url>" . PHP_EOL);

                    $total_records++;
                }
            }

            wp_reset_postdata();
            fwrite($file, '</urlset>' . PHP_EOL);
            fclose($file);
            echo 'Sitemap for ' . esc_html($service) . " generated and saved as " . esc_html($sitemap_file) . PHP_EOL;

            $offset += $posts_per_file;
            $file_index++;
        }
    }

    echo "Total records added: " . $total_records . PHP_EOL;
}


