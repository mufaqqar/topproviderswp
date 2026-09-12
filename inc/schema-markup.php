<?php

/**
 * Schema Markup for SEO / AEO / GEO
 * Organization, WebSite, BreadcrumbList, Product, FAQ, Article, Person,
 * Service, ItemList, and LocalBusiness JSON-LD structured data.
 */

/**
 * Helper: output a JSON-LD script tag safely.
 *
 * @param array $data
 * @return void
 */
function tp_theme_echo_jsonld($data) {
    if (empty($data)) {
        return;
    }
    echo '<script type="application/ld+json">' . wp_json_encode($data, JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
}

/**
 * Add Organization Schema to the head (enhanced for GEO entity signals).
 */
function tp_theme_organization_schema() {
    if (!is_front_page()) {
        return;
    }

    $schema = array(
        "@context"        => "https://schema.org",
        "@type"           => "Organization",
        "@id"             => esc_url(home_url('/')) . "#organization",
        "name"            => "Top Providers",
        "alternateName"   => "TopProviders",
        "url"             => esc_url(home_url('/')),
        "logo"            => esc_url(get_template_directory_uri() . '/images/logo.webp'),
        "image"           => esc_url(get_template_directory_uri() . '/images/logo.webp'),
        "description"     => "Compare and connect with the best TV, Internet, Landline, Home Security, Moving, Solar, Insurance, and Health Insurance providers in your area. Find deals, compare plans, and choose the perfect provider for your home.",
        "email"           => "contact@topproviders.net",
        "knowsAbout"      => array(
            "Internet service providers",
            "TV service providers",
            "Internet and TV bundles",
            "Home phone and landline service",
            "Home security systems",
            "Moving companies",
            "Solar panel installers",
            "Insurance providers",
            "Health insurance plans"
        ),
        "knowsLanguage"   => "en-US",
        "areaServed"      => array(
            "@type" => "Country",
            "name"  => "United States"
        ),
        "contactPoint"    => array(
            "@type"          => "ContactPoint",
            "contactType"    => "customer service",
            "contactOption"  => "TollFree",
            "telephone"      => "+1-800-555-0144",
            "availableLanguage" => "English",
            "areaServed"     => "US"
        ),
        "address"         => array(
            "@type"          => "PostalAddress",
            "addressCountry" => "US"
        ),
        "sameAs"          => array(
            "https://x.com/topproviders",
            "https://www.instagram.com/top.providers/",
            "https://www.facebook.com/topproviders",
            "https://www.youtube.com/@top-providers"
        ),
        "potentialAction" => array(
            "@type" => "SearchAction",
            "target" => array(
                "@type"       => "EntryPoint",
                "urlTemplate" => esc_url(home_url('/?s={search_term_string}'))
            ),
            "query-input" => "required name=search_term_string"
        )
    );

    tp_theme_echo_jsonld($schema);
}
add_action('wp_head', 'tp_theme_organization_schema', 1);

/**
 * Add WebSite Schema with SearchAction.
 */
function tp_theme_website_schema() {
    if (!is_front_page()) {
        return;
    }

    $schema = array(
        "@context"        => "https://schema.org",
        "@type"           => "WebSite",
        "@id"             => esc_url(home_url('/')) . "#website",
        "name"            => "Top Providers",
        "url"             => esc_url(home_url('/')),
        "publisher"       => array(
            "@id" => esc_url(home_url('/')) . "#organization"
        ),
        "potentialAction" => array(
            "@type"         => "SearchAction",
            "target"        => array(
                "@type"       => "EntryPoint",
                "urlTemplate" => esc_url(home_url('/?s={search_term_string}'))
            ),
            "query-input"   => "required name=search_term_string"
        )
    );

    tp_theme_echo_jsonld($schema);
}
add_action('wp_head', 'tp_theme_website_schema', 2);

/**
 * Add BreadcrumbList Schema — now applies to pages, taxonomy, and archives.
 */
function tp_theme_breadcrumb_schema() {
    if (is_front_page()) {
        return;
    }

    global $post;
    $breadcrumbs = array();

    $breadcrumbs[] = array(
        "@type"    => "ListItem",
        "position" => 1,
        "name"     => "Home",
        "item"     => esc_url(home_url('/'))
    );

    $position = 2;

    // Service / area-zone rewrites (internet/state/city/zip)
    $service    = get_query_var('service');
    $zone_state = get_query_var('zone_state');
    $zone_city  = get_query_var('zone_city');
    $post_slug  = get_query_var('post_slug');

    if ($service && get_post_type() === 'area_zone') {
        $service_name = ucwords(str_replace('-', ' ', $service));

        $breadcrumbs[] = array(
            "@type"    => "ListItem",
            "position" => $position,
            "name"     => $service_name,
            "item"     => esc_url(home_url('/' . $service . '/'))
        );
        $position++;

        if ($zone_state) {
            $breadcrumbs[] = array(
                "@type"    => "ListItem",
                "position" => $position,
                "name"     => ucwords(str_replace('-', ' ', $zone_state)),
                "item"     => esc_url(home_url('/' . $service . '/' . $zone_state . '/'))
            );
            $position++;
        }

        if ($zone_city) {
            $breadcrumbs[] = array(
                "@type"    => "ListItem",
                "position" => $position,
                "name"     => ucwords(str_replace('-', ' ', $zone_city)),
                "item"     => esc_url(home_url('/' . $service . '/' . $zone_state . '/' . $zone_city . '/'))
            );
            $position++;
        }

        if ($post_slug) {
            $breadcrumbs[] = array(
                "@type"    => "ListItem",
                "position" => $position,
                "name"     => get_the_title()
            );
            $position++;
        }
    } elseif (get_post_type() === 'providers' && is_single()) {
        // Provider type terms
        $service_types = get_the_terms($post->ID, 'providers_service_types');
        if ($service_types && !is_wp_error($service_types)) {
            foreach ($service_types as $type) {
                $term_link = get_term_link($type);
                if (!is_wp_error($term_link)) {
                    $breadcrumbs[] = array(
                        "@type"    => "ListItem",
                        "position" => $position,
                        "name"     => $type->name,
                        "item"     => esc_url($term_link)
                    );
                    $position++;
                }
            }
        }

        $provider_types = get_the_terms($post->ID, 'providers_types');
        if ($provider_types && !is_wp_error($provider_types)) {
            foreach ($provider_types as $ptype) {
                $term_link = get_term_link($ptype);
                if (!is_wp_error($term_link)) {
                    $breadcrumbs[] = array(
                        "@type"    => "ListItem",
                        "position" => $position,
                        "name"     => $ptype->name,
                        "item"     => esc_url($term_link)
                    );
                    $position++;
                }
            }
        }

        $breadcrumbs[] = array(
            "@type"    => "ListItem",
            "position" => $position,
            "name"     => get_the_title()
        );
        $position++;
    } elseif (is_single() && get_post_type() === 'post') {
        $categories = get_the_category($post->ID);
        if (!empty($categories)) {
            $breadcrumbs[] = array(
                "@type"    => "ListItem",
                "position" => $position,
                "name"     => $categories[0]->name,
                "item"     => esc_url(get_category_link($categories[0]->term_id))
            );
            $position++;
        }

        $breadcrumbs[] = array(
            "@type"    => "ListItem",
            "position" => $position,
            "name"     => get_the_title()
        );
        $position++;
    } elseif (is_page()) {
        $breadcrumbs[] = array(
            "@type"    => "ListItem",
            "position" => $position,
            "name"     => get_the_title()
        );
        $position++;
    } elseif (is_tax() || is_category() || is_tag()) {
        $breadcrumbs[] = array(
            "@type"    => "ListItem",
            "position" => $position,
            "name"     => single_term_title('', false)
        );
        $position++;
    } elseif (is_archive()) {
        $breadcrumbs[] = array(
            "@type"    => "ListItem",
            "position" => $position,
            "name"     => wp_strip_all_tags(get_the_archive_title())
        );
        $position++;
    } elseif (is_search()) {
        $breadcrumbs[] = array(
            "@type"    => "ListItem",
            "position" => $position,
            "name"     => 'Search Results for "' . get_search_query() . '"'
        );
        $position++;
    }

    if (count($breadcrumbs) <= 1) {
        return;
    }

    $schema = array(
        "@context"        => "https://schema.org",
        "@type"           => "BreadcrumbList",
        "itemListElement" => $breadcrumbs
    );

    tp_theme_echo_jsonld($schema);
}
add_action('wp_head', 'tp_theme_breadcrumb_schema', 3);

/**
 * Add Product/Service Schema for Provider Pages (with date signals).
 */
function tp_theme_provider_product_schema() {
    if (!(is_single() && get_post_type() === 'providers')) {
        return;
    }

    global $post;
    $price = function_exists('get_field') ? get_field('pro_price') : get_post_meta($post->ID, 'pro_price', true);
    $pro_link = function_exists('get_field') ? get_field('pro_link') : '';
    $title = get_the_title();
    $excerpt = get_the_excerpt();
    $thumbnail = get_the_post_thumbnail_url($post->ID, 'full');

    $dates = tp_theme_date_schema_values($post->ID);

    $schema = array(
        "@context"      => "https://schema.org",
        "@type"         => "Product",
        "name"          => $title . " Plans",
        "description"   => !empty($excerpt) ? wp_strip_all_tags($excerpt) : "Compare " . $title . " plans, pricing, and features. Find the best deal for your home.",
        "brand"         => array(
            "@type" => "Brand",
            "name"  => $title
        ),
        "url"           => get_permalink(),
        "datePublished" => isset($dates['datePublished']) ? $dates['datePublished'] : null,
        "dateModified"  => isset($dates['dateModified']) ? $dates['dateModified'] : null,
    );

    if ($thumbnail) {
        $schema['image'] = $thumbnail;
    }

    if ($price) {
        $schema['offers'] = array(
            "@type"          => "Offer",
            "price"          => $price,
            "priceCurrency"  => "USD",
            "priceValidUntil" => gmdate('Y-m-d', strtotime('+1 year')),
            "availability"   => "https://schema.org/InStock",
            "url"            => !empty($pro_link) ? $pro_link : get_permalink()
        );
    }

    // Aggregate rating from approved review comments
    $comments = get_comments(array(
        'post_id' => $post->ID,
        'status'  => 'approve',
        'meta_query' => array(
            array(
                'key'   => 'star',
                'value' => '',
                'compare' => '!='
            )
        )
    ));

    if (!empty($comments)) {
        $rating_sum   = 0;
        $rating_count = 0;
        $reviews      = array();

        foreach ($comments as $comment) {
            $rating = get_comment_meta($comment->comment_ID, 'star', true);
            if ($rating) {
                $rating_sum += intval($rating);
                $rating_count++;
                $reviews[] = array(
                    "@type"       => "Review",
                    "author"      => array(
                        "@type" => "Person",
                        "name"  => $comment->comment_author
                    ),
                    "reviewRating" => array(
                        "@type"       => "Rating",
                        "ratingValue" => $rating,
                        "bestRating"  => 5
                    ),
                    "reviewBody"   => wp_strip_all_tags($comment->comment_content),
                    "datePublished" => get_comment_date('c', $comment->comment_ID)
                );
            }
        }

        if ($rating_count > 0) {
            $schema['aggregateRating'] = array(
                "@type"       => "AggregateRating",
                "ratingValue" => round($rating_sum / $rating_count, 1),
                "reviewCount" => $rating_count,
                "bestRating"  => 5,
                "worstRating" => 1
            );
        }

        if (!empty($reviews)) {
            $schema['review'] = array_slice($reviews, 0, 5);
        }
    }

    tp_theme_echo_jsonld($schema);
}
add_action('wp_head', 'tp_theme_provider_product_schema', 4);

/**
 * Add FAQ Schema for Provider Pages (ACF repeater).
 */
function tp_theme_faq_schema() {
    if (!(is_single() && get_post_type() === 'providers')) {
        return;
    }

    if (!function_exists('have_rows')) {
        return;
    }

    // Field name may use a straight or curly apostrophe depending on ACF.
    $faq_rows = false;
    if (have_rows('faq\'s')) {
        $faq_rows = 'faq\'s';
    } elseif (have_rows('faq’s')) {
        $faq_rows = 'faq’s';
    }

    if (!$faq_rows) {
        return;
    }

    $faq_items = array();
    while (have_rows($faq_rows)) : the_row();
        $question = get_sub_field('question');
        $answer   = get_sub_field('answer');
        if ($question && $answer) {
            $faq_items[] = array(
                "@type"          => "Question",
                "name"           => wp_strip_all_tags($question),
                "acceptedAnswer" => array(
                    "@type" => "Answer",
                    "text"  => wp_strip_all_tags($answer)
                )
            );
        }
    endwhile;

    if (empty($faq_items)) {
        return;
    }

    tp_theme_echo_jsonld(array(
        "@context"   => "https://schema.org",
        "@type"      => "FAQPage",
        "mainEntity" => $faq_items
    ));
}
add_action('wp_head', 'tp_theme_faq_schema', 5);

/**
 * Add LocalBusiness Schema for Country Zone pages.
 */
function tp_theme_local_business_schema() {
    if (!(get_post_type() === 'country_zone' && is_single())) {
        return;
    }

    tp_theme_echo_jsonld(array(
        "@context"       => "https://schema.org",
        "@type"          => "LocalBusiness",
        "name"           => "Top Providers - " . esc_html(get_the_title()),
        "description"    => "Find the best internet, TV, and home service providers in " . esc_html(get_the_title()) . ".",
        "url"            => esc_url(get_permalink()),
        "areaServed"     => array(
            "@type" => "State",
            "name"  => esc_html(get_the_title())
        ),
        "hasOfferCatalog" => array(
            "@type"           => "OfferCatalog",
            "name"            => "Internet and TV Service Plans",
            "itemListElement" => array(
                array(
                    "@type"        => "Offer",
                    "itemOffered"  => array(
                        "@type"       => "Service",
                        "name"        => "Internet Service",
                        "serviceType" => "Internet"
                    )
                ),
                array(
                    "@type"        => "Offer",
                    "itemOffered"  => array(
                        "@type"       => "Service",
                        "name"        => "TV Service",
                        "serviceType" => "Television"
                    )
                )
            )
        )
    ));
}
add_action('wp_head', 'tp_theme_local_business_schema', 6);

/**
 * Add Article + Author Person Schema for blog posts.
 */
function tp_theme_article_schema() {
    if (!(is_single() && get_post_type() === 'post')) {
        return;
    }

    global $post;
    $author_id = get_post_field('post_author', $post->ID);
    $author_name = get_the_author_meta('display_name', $author_id);
    $author_url  = get_the_author_meta('user_url', $author_id);
    $author_desc = get_the_author_meta('description', $author_id);

    $dates = tp_theme_date_schema_values($post->ID);
    $thumbnail = get_the_post_thumbnail_url($post->ID, 'full');
    $excerpt = has_excerpt() ? get_the_excerpt() : wp_trim_words(wp_strip_all_tags($post->post_content), 40);

    $schema = array(
        "@context"        => "https://schema.org",
        "@type"           => "Article",
        "@id"             => get_permalink() . "#article",
        "mainEntityOfPage" => get_permalink(),
        "headline"        => get_the_title(),
        "description"     => wp_strip_all_tags($excerpt),
        "image"           => $thumbnail,
        "author"          => array(
            "@type" => "Person",
            "name"  => $author_name,
            "url"   => $author_url ? $author_url : get_author_posts_url($author_id)
        ),
        "publisher"       => array(
            "@id" => esc_url(home_url('/')) . "#organization"
        ),
        "datePublished"   => isset($dates['datePublished']) ? $dates['datePublished'] : null,
        "dateModified"    => isset($dates['dateModified']) ? $dates['dateModified'] : null,
    );

    if ($thumbnail) {
        $schema['image'] = $thumbnail;
    }

    if (get_the_category($post->ID)) {
        $schema['articleSection'] = get_the_category($post->ID)[0]->name;
    }

    tp_theme_echo_jsonld($schema);
}
add_action('wp_head', 'tp_theme_article_schema', 7);

/**
 * Add Person (author) schema on author-linked blog posts.
 */
function tp_theme_author_person_schema() {
    if (!(is_single() && get_post_type() === 'post')) {
        return;
    }

    global $post;
    $author_id   = get_post_field('post_author', $post->ID);
    $author_name = get_the_author_meta('display_name', $author_id);
    $author_url  = get_author_posts_url($author_id);
    $author_desc = get_the_author_meta('description', $author_id);

    $schema = array(
        "@context" => "https://schema.org",
        "@type"    => "Person",
        "@id"      => $author_url . "#person",
        "name"     => $author_name,
        "url"      => $author_url,
        "worksFor" => array(
            "@id" => esc_url(home_url('/')) . "#organization"
        )
    );

    if ($author_desc) {
        $schema['description'] = $author_desc;
    }

    tp_theme_echo_jsonld($schema);
}
add_action('wp_head', 'tp_theme_author_person_schema', 8);

/**
 * Add ComparisonPage + ItemList schema for the comparison template.
 * (Rebuilds the provider list instead of relying on template-scope vars.)
 */
function tp_theme_comparison_schema() {
    if (!is_page_template('temp-comparison.php')) {
        return;
    }

    $items     = array();
    $position  = 1;

    $providers = get_posts(array(
        'post_type'      => 'providers',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'order'          => 'DESC',
        'orderby'        => 'date'
    ));

    foreach ($providers as $provider) {
        $price = function_exists('get_field') ? get_field('pro_price', $provider->ID) : get_post_meta($provider->ID, 'pro_price', true);
        $items[] = array(
            "@type"    => "ListItem",
            "position" => $position,
            "item"     => array(
                "@type" => "Product",
                "name"  => $provider->post_title,
                "url"   => get_permalink($provider->ID),
                "image" => get_the_post_thumbnail_url($provider->ID, 'full'),
            )
        );
        if ($price) {
            $items[($position - 1)]['item']['offers'] = array(
                "@type"        => "Offer",
                "price"        => $price,
                "priceCurrency" => "USD",
                "availability" => "https://schema.org/InStock"
            );
        }
        $position++;
    }

    tp_theme_echo_jsonld(array(
        "@context"   => "https://schema.org",
        "@type"      => "ItemList",
        "name"       => "Internet Service Providers Comparison",
        "description" => "Internet, TV, and bundle plans from top providers compared side by side.",
        "numberOfItems" => count($items),
        "itemListElement" => array_slice($items, 0, 30)
    ));
}
add_action('wp_head', 'tp_theme_comparison_schema', 9);

/**
 * Service schema for service landing pages (internet, tv, moving, solar...).
 */
function tp_theme_service_schemas() {
    $service = get_query_var('service');

    if (empty($service) || get_post_type() !== 'area_zone') {
        return;
    }

    $labels = array(
        'internet'        => 'Internet Provider',
        'tv'              => 'TV Provider',
        'internet-tv'     => 'Internet and TV Bundle Provider',
        'home-security'   => 'Home Security Provider',
        'landline'        => 'Landline Service Provider',
        'moving'          => 'Moving Company',
        'solar'           => 'Solar Installer',
        'insurance'       => 'Insurance Provider',
        'health-insurance'=> 'Health Insurance Provider'
    );

    $zone_state = get_query_var('zone_state');
    $zone_city  = get_query_var('zone_city');

    $name = isset($labels[$service]) ? $labels[$service] : ucwords(str_replace('-', ' ', $service)) . ' Provider';

    // Build "Top X providers in {city/state}" entity
    $entity_name = 'Top ' . $name . 's in ' . ($zone_city ? ucwords(str_replace('-', ' ', $zone_city)) : ($zone_state ? ucwords(str_replace('-', ' ', $zone_state)) : 'the United States'));

    $schema = array(
        "@context" => "https://schema.org",
        "@type"    => "Service",
        "name"     => $entity_name,
        "serviceType" => $name,
        "url"      => home_url(add_query_arg(array())),
        "provider" => array(
            "@id" => esc_url(home_url('/')) . "#organization"
        ),
        "areaServed" => array()
    );

    if ($zone_state) {
        $schema['areaServed'][] = array(
            "@type" => "State",
            "name"  => ucwords(str_replace('-', ' ', $zone_state))
        );
    }
    if ($zone_city) {
        $schema['areaServed'][] = array(
            "@type" => "City",
            "name"  => ucwords(str_replace('-', ' ', $zone_city))
        );
    }
    if (!$zone_state && !$zone_city) {
        $schema['areaServed'][] = array(
            "@type" => "Country",
            "name"  => "United States"
        );
    }
    if (count($schema['areaServed']) === 1) {
        $schema['areaServed'] = $schema['areaServed'][0];
    }

    tp_theme_echo_jsonld($schema);
}
add_action('wp_head', 'tp_theme_service_schemas', 10);

/**
 * AboutPage / ContactPage schema for those page templates.
 */
function tp_theme_about_contact_schema() {
    if (!is_page_template('temp-about-us.php') && !is_page_template('temp-contact-us.php')) {
        return;
    }

    $is_about = is_page_template('temp-about-us.php');
    $type     = $is_about ? 'AboutPage' : 'ContactPage';
    $desc     = $is_about
        ? 'Learn how Top Providers ranks and reviews the best TV, Internet, and home service providers.'
        : 'Contact the Top Providers team for help comparing internet, TV, and home service providers.';

    tp_theme_echo_jsonld(array(
        "@context" => "https://schema.org",
        "@type"    => $type,
        "name"     => $is_about ? 'About Top Providers' : 'Contact Top Providers',
        "url"      => get_permalink(),
        "description" => $desc,
        "inLanguage"  => "en-US",
        "isPartOf"    => array(
            "@id" => esc_url(home_url('/')) . "#website"
        )
    ));
}
add_action('wp_head', 'tp_theme_about_contact_schema', 11);