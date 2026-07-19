<?php



// Step 1: Define dynamic rewrite rules for all service types
function custom_dynamic_rewrite_rules() {
    // Define the static service types
    $services = ['internet', 'tv', 'internet-tv', 'moving', 'solar', 'insurance', 'health-insurance', 'home-security'];
    
    foreach ($services as $service) {
        // Pattern for full URL: /service/zone_state/zone_city/post_slug
        add_rewrite_rule(
            '^' . $service . '/([^/]+)/([^/]+)/([^/]+)/?$',
            'index.php?post_type=area_zone&service=' . $service . '&zone_state=$matches[1]&zone_city=$matches[2]&post_slug=$matches[3]',
            'top'
        );

        // Pattern for: /service/zone_state/zone_city
        add_rewrite_rule(
            '^' . $service . '/([^/]+)/([^/]+)/?$',
            'index.php?post_type=area_zone&service=' . $service . '&zone_state=$matches[1]&zone_city=$matches[2]',
            'top'
        );

        // Pattern for: /service/zone_state
        add_rewrite_rule(
            '^' . $service . '/([^/]+)/?$',
            'index.php?post_type=area_zone&service=' . $service . '&zone_state=$matches[1]',
            'top'
        );

        // Pattern for: /service
        add_rewrite_rule(
            '^' . $service . '/?$',
            'index.php?post_type=area_zone&service=' . $service,
            'top'
        );
    }
}
add_action('init', 'custom_dynamic_rewrite_rules');

// Step 2: Register custom query variables to ensure WordPress recognizes them
function add_custom_query_vars($vars) {
    $vars[] = 'service';
    $vars[] = 'zone_state';
    $vars[] = 'zone_city';
    $vars[] = 'post_slug';
    return $vars;
}
add_filter('query_vars', 'add_custom_query_vars');

// Step 3: Modify the permalink structure to include service, zone_state, and zone_city in the URL
function add_custom_prefix_to_area_zone_slug($post_link, $post) {
    if ($post->post_type == 'area_zone') {
        // Get the zone_city and zone_state terms associated with the post
        $zone_state_terms = wp_get_post_terms($post->ID, 'zone_state');
        $zone_city_terms = wp_get_post_terms($post->ID, 'zone_city');

        $zone_state_slug = !empty($zone_state_terms) ? $zone_state_terms[0]->slug : 'no-state';
        $zone_city_slug = !empty($zone_city_terms) ? $zone_city_terms[0]->slug : 'no-city';

        // Get the service type (static) from a meta field or assign it based on the URL
        $service_type = get_post_meta($post->ID, '_service_type', true);

        // Ensure the service type is valid
        $valid_service_types = ['internet', 'tv', 'tv-internet', 'landline', 'moving', 'solar', 'insurance', 'health-insurance', 'home-security'];
        if (!in_array($service_type, $valid_service_types)) {
            $service_type = 'internet'; // Default to internet if none is found
        }

        // Construct the custom URL: /service/zone_state/zone_city/post_slug
        return home_url('/' . $service_type . '/' . $zone_state_slug . '/' . $zone_city_slug . '/' . $post->post_name);
    }
    return $post_link;
}
add_filter('post_type_link', 'add_custom_prefix_to_area_zone_slug', 10, 2);

// Step 4: Modify the query to fetch the correct post based on the custom URL
function custom_query_vars($query) {
    if (!is_admin() && $query->is_main_query() && isset($query->query_vars['post_type']) && $query->query_vars['post_type'] === 'area_zone') {
        if (isset($query->query_vars['service'])) {
            $query->set('post_type', 'area_zone');

            if (isset($query->query_vars['zone_state'])) {
                // Handle query based on zone_state and further levels
                if (isset($query->query_vars['zone_city'])) {
                    if (isset($query->query_vars['post_slug'])) {
                        // Full URL: /service/zone_state/zone_city/post_slug
                        $query->set('name', $query->query_vars['post_slug']);
                        $query->set('post_type', 'area_zone'); // Set post type to area_zone
                    }
                }
            }
        }
    }
}
add_action('pre_get_posts', 'custom_query_vars');

// Step 5: Dynamic template routing based on the URL structure
function custom_template_include($template) {
    // Get the query variables
    $service = get_query_var('service');
    $zone_state = get_query_var('zone_state');
    $zone_city = get_query_var('zone_city');
    $post_slug = get_query_var('post_slug');

    // Define a dynamic template directory path
    $dynamic_template_dir = 'area-zone-templates/';

    $new_template = '';

    // Determine the appropriate template based on the query variables
    if ($service && $zone_state && $zone_city && $post_slug) {
        // Full URL: /service/zone_state/zone_city/post_slug
        $new_template = locate_template(array($dynamic_template_dir . 'single-service-zone-state-zone-city-post.php'));
    } elseif ($service && $zone_state && $zone_city) {
        // URL: /service/zone_state/zone_city
        $new_template = locate_template(array($dynamic_template_dir . 'single-service-zone-state-zone-city.php'));
    } elseif ($service && $zone_state) {
        // URL: /service/zone_state
        $new_template = locate_template(array($dynamic_template_dir . 'single-service-zone-state.php'));
    } elseif ($service) {
        // URL: /service
        $new_template = locate_template(array($dynamic_template_dir . 'single-service.php'));
    }

    // Return the new template if found, or default template
    return $new_template ? $new_template : $template;
}
add_filter('template_include', 'custom_template_include');

// Step 6: Flush rewrite rules (for development use only)
function custom_flush_rewrite_rules() {
    custom_dynamic_rewrite_rules();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'custom_flush_rewrite_rules');





function cbl_breadcrumb() {
    $service = get_query_var('service');
    $zone_state = get_query_var('zone_state');
    $zone_city = get_query_var('zone_city');
    $post_slug = get_query_var('post_slug');
    $post_type = get_post_type();

    $items = array();
    $items[] = array('url' => home_url(), 'label' => 'Home');

    if ($post_type === 'area_zone') {
        if ($service) {
            $items[] = array('url' => home_url('/' . $service), 'label' => ucfirst($service));
        }
        if ($zone_state) {
            $items[] = array('url' => home_url('/' . $service . '/' . $zone_state), 'label' => ucfirst(str_replace('-', ' ', $zone_state)));
        }
        if ($zone_city) {
            $items[] = array('url' => home_url('/' . $service . '/' . $zone_state . '/' . $zone_city), 'label' => ucfirst(str_replace('-', ' ', $zone_city)));
        }
        if ($post_slug) {
            $items[] = array('url' => '', 'label' => get_the_title());
        }
    } elseif ($post_type === 'providers') {
        $items[] = array('url' => home_url('/providers'), 'label' => 'Providers');
        $items[] = array('url' => '', 'label' => get_the_title());
    } else {
        if (is_single()) {
            $categories = get_the_category();
            if (!empty($categories)) {
                $items[] = array('url' => get_category_link($categories[0]->term_id), 'label' => $categories[0]->name);
            }
            $items[] = array('url' => '', 'label' => get_the_title());
        } elseif (is_page()) {
            $items[] = array('url' => '', 'label' => get_the_title());
        } elseif (is_search()) {
            $items[] = array('url' => '', 'label' => 'Search Results for "' . get_search_query() . '"');
        }
    }

    $num_items = count($items);
    echo '<div class="container mx-auto px-4 breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">';
    foreach ($items as $index => $item) {
        $position = $index + 1;
        if ($position < $num_items && !empty($item['url'])) {
            echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<a href="' . esc_url($item['url']) . '" itemprop="item"><span itemprop="name">' . esc_html($item['label']) . '</span></a>';
            echo '<meta itemprop="position" content="' . $position . '" />';
            echo '</span>';
            echo ' <span class="sep">&#187;</span> ';
        } else {
            echo '<span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
            echo '<span itemprop="name">' . esc_html($item['label']) . '</span>';
            echo '<meta itemprop="position" content="' . $position . '" />';
            echo '</span>';
        }
    }
    echo '</div>';
}



function Generate_Title_For_Zipcode() {
    global $wp_query;
    $state = $wp_query->query_vars['zone_state'];
    $city = $wp_query->query_vars['zone_city'];
    $zipcode = $wp_query->query_vars['post_slug'];
    $type =$wp_query->query_vars['service'];

    $f_state = strtoupper($state);
    $f_type = ucwords($type) ;
    

    
 

    $label = FormatData($type);
    return "Best $label in $zipcode, $f_state | Top Providers";
}

function Generate_Description_For_Zipcode() {
    $state = get_query_var('zone_state', '');
    $city = get_query_var('zone_city', '');
    $zipcode = get_query_var('post_slug', '');
    $type = get_query_var('service', '');

     $f_state = strtoupper($state);
    $f_type = ucwords($type) ;
   

    $label = FormatData($type);
    return "Explore $label providers in $zipcode, $state. Compare exclusive deals and find the best option for your needs with Top Providers.";
}

function Generate_Title_For_City() {
    global $wp_query;
    $state = $wp_query->query_vars['zone_state'];
    $city = $wp_query->query_vars['zone_city'];
    $zipcode = $wp_query->query_vars['post_slug'];
    $type =$wp_query->query_vars['service'];

    $label = FormatData($type);
    return "Top $label Providers in $city, $state | Trusted Solutions from Top Providers";
}

function Generate_Description_For_City() {
    $state = get_query_var('zone_state', '');
    $city = get_query_var('zone_city', '');
    $zipcode = get_query_var('post_slug', '');
    $type = get_query_var('service', '');

    $label = FormatData($type);
    $descriptions = [
        'internet' => "View all Internet service providers in $city, $state. Compare Internet plans, prices and new promotions and pick the best provider that fits within your budget.",
        'tv' => "Compare TV providers in $city, $state. View TV plans and deals and choose the best provider that fits within your budget.",
        'landline' => "Find the best home phone service providers in $city, $state. Compare providers, plans, prices and amenities to set your landline up.",
        'home-security' => "Find reliable, trustworthy, and affordable home security systems in $city, $state and protect your property like never before.",
        'moving' => "Compare top moving companies in $city, $state. Get quotes from trusted movers and find the best rates for your relocation.",
        'solar' => "Find top solar installers in $city, $state. Compare solar panel costs, savings, and financing options for your home.",
        'insurance' => "Compare auto and home insurance rates in $city, $state. Find affordable coverage from top insurance providers.",
        'health-insurance' => "Explore health insurance plans in $city, $state. Compare coverage options and find affordable health insurance today.",
    ];
    return isset($descriptions[$type]) ? $descriptions[$type] : "Find top $label providers in $city, $state. Compare options and choose the best fit for your needs.";
}

function Generate_Title_For_State() {
    global $wp_query;
   
    $state   = isset($wp_query->query_vars['zone_state']) ? $wp_query->query_vars['zone_state'] : '';
    $city    = isset($wp_query->query_vars['zone_city']) ? $wp_query->query_vars['zone_city'] : '';
    $zipcode = isset($wp_query->query_vars['post_slug']) ? $wp_query->query_vars['post_slug'] : '';
    $type    = isset($wp_query->query_vars['service']) ? $wp_query->query_vars['service'] : '';

    $label = FormatData($type);
    return "Top $label Providers in $state | Top Providers";
}

function Generate_Description_For_State() {
    $state = get_query_var('zone_state', '');
    $city = get_query_var('zone_city', '');
    $zipcode = get_query_var('post_slug', '');
    $type = get_query_var('service', '');

    $label = FormatData($type);
    $descriptions = [
        'internet' => "View all Internet service providers in $state. Compare Internet plans, prices and new promotions and pick the best provider that fits within your budget.",
        'tv' => "Compare TV providers in $state. View TV plans and deals and choose the best provider that fits within your budget.",
        'landline' => "Find the best home phone service providers in $state. Compare providers, plans, prices and amenities to set your landline up.",
        'home-security' => "Find reliable, trustworthy, and affordable home security systems in $state and protect your property like never before.",
        'moving' => "Compare top moving companies in $state. Get quotes from trusted movers and find the best rates for your relocation.",
        'solar' => "Find top solar installers in $state. Compare solar panel costs, savings, and financing options for your home.",
        'insurance' => "Compare auto and home insurance rates in $state. Find affordable coverage from top insurance providers.",
        'health-insurance' => "Explore health insurance plans in $state. Compare coverage options and find affordable health insurance today.",
    ];
    return isset($descriptions[$type]) ? $descriptions[$type] : "Find top $label providers in $state. Compare options and choose the best fit for your needs.";
}


function Generate_Title_For_Service() {
    global $wp_query;
    $type = isset($wp_query->query_vars['service']) ? $wp_query->query_vars['service'] : '';
    return 'Top ' . ucwords(str_replace('-', ' ', $type)) . ' Service Providers | Top Providers';
}

function Generate_Description_For_Service() {
    $type = get_query_var('service', '');
    return 'Compare top ' . str_replace('-', ' ', $type) . ' service providers. Find the best plans, prices, and deals in your area with Top Providers.';
}

function Generate_Canonical_Tag($canonical) {
    global $wp_query;
    $state   = isset($wp_query->query_vars['zone_state']) ? $wp_query->query_vars['zone_state'] : '';
    $city    = isset($wp_query->query_vars['zone_city']) ? $wp_query->query_vars['zone_city'] : '';
    $zipcode = isset($wp_query->query_vars['post_slug']) ? $wp_query->query_vars['post_slug'] : '';
    $type    = isset($wp_query->query_vars['service']) ? $wp_query->query_vars['service'] : '';

    if($zipcode){
        return home_url("/$type/$state/$city/$zipcode/");
    }
    elseif($city){
        return home_url("/$type/$state/$city/");
    }
    elseif($state){
        return home_url("/$type/$state/");
    }
    else {
        return home_url("/$type/");
    }

}





function custom_blog_permalink_structure($rules) {
    $new_rules = array(
        'blog/([^/]+)/?$' => 'index.php?name=$matches[1]', // Match blog/post_slug
    );
    return $new_rules + $rules;
}
add_filter('rewrite_rules_array', 'custom_blog_permalink_structure');

function custom_blog_post_permalink($permalink, $post) {
    if ($post->post_type === 'post') {
        $permalink = home_url('/blog/' . $post->post_name . '/');
    }
    return $permalink;
}
add_filter('post_link', 'custom_blog_post_permalink', 10, 2);


add_filter('wpseo_robots', 'yoast_no_home_noindex', 999);

function yoast_no_home_noindex($string) {
    $string = "index,follow";
    if (is_singular('area_zone')) {
        $string= "index,follow";
    }
    return $string;
}