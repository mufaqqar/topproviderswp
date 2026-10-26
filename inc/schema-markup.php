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
 * Add the homepage entity graph.
 */
function tp_theme_homepage_schema() {
    if (!is_front_page()) {
        return;
    }

    $home       = esc_url(home_url('/'));
    $org_id     = $home . '#organization';
    $website_id = $home . '#website';
    $page_id    = $home . '#webpage';
    $logo       = esc_url(get_template_directory_uri() . '/images/logo-512.png');
    $og_image   = esc_url(get_template_directory_uri() . '/images/og-home.jpg');
    $modified   = get_the_modified_date('c');
    $published  = get_the_date('c');

    if (!$modified) {
        $modified = gmdate('c');
    }

    $providers = get_posts(array(
        'post_type'      => 'providers',
        'posts_per_page' => 6,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ));

    $provider_items = array();
    $position       = 1;

    foreach ($providers as $provider) {
        $provider_items[] = array(
            '@type'    => 'ListItem',
            'position' => $position,
            'item'     => array(
                '@type' => 'Service',
                'name'  => $provider->post_title,
                'url'   => get_permalink($provider->ID),
            ),
        );
        $position++;
    }

    $organization = array(
        '@type'               => 'Organization',
        '@id'                 => $org_id,
        'name'                => 'Top Providers',
        'alternateName'       => 'TopProviders',
        'url'                 => $home,
        'logo'                => array(
            '@type'  => 'ImageObject',
            'url'    => $logo,
            'width'  => 512,
            'height' => 512,
        ),
        'image'               => $og_image,
        'description'         => 'Top Providers helps people compare internet, TV, bundle, and home service providers by ZIP code.',
        'email'               => 'contact@topproviders.net',
        'knowsAbout'          => array(
            'Internet service providers',
            'TV service providers',
            'Internet and TV bundles',
            'Home phone and landline service',
            'Home security systems',
            'Moving companies',
            'Solar panel installers',
            'Insurance providers',
            'Health insurance plans',
        ),
        'knowsLanguage'       => 'en-US',
        'areaServed'          => array(
            '@type' => 'Country',
            'name'  => 'United States',
        ),
        'contactPoint'        => array(
            '@type'             => 'ContactPoint',
            'contactType'       => 'customer support',
            'email'             => 'contact@topproviders.net',
            'url'               => esc_url(home_url('/contact-us/')),
            'availableLanguage' => 'English',
            'areaServed'        => 'US',
        ),
        'publishingPrinciples' => esc_url(home_url('/about-us/')),
        'correctionsPolicy'    => esc_url(home_url('/about-us/#methodology')),
        'sameAs'              => array(
            'https://x.com/topproviders',
            'https://www.instagram.com/top.providers/',
            'https://www.facebook.com/topproviders',
            'https://www.youtube.com/@top-providers',
        ),
    );

    $website = array(
        '@type'       => 'WebSite',
        '@id'         => $website_id,
        'name'        => 'Top Providers',
        'url'         => $home,
        'publisher'   => array('@id' => $org_id),
        'inLanguage'  => 'en-US',
        'potentialAction' => array(
            '@type'         => 'SearchAction',
            'target'        => array(
                '@type'       => 'EntryPoint',
                'urlTemplate' => esc_url(home_url('/?s={search_term_string}')),
            ),
            'query-input'   => 'required name=search_term_string',
        ),
    );

    $webpage = array(
        '@type'            => 'WebPage',
        '@id'              => $page_id,
        'url'              => $home,
        'name'             => 'Compare Internet & TV Providers by ZIP Code | Top Providers',
        'description'      => 'Compare internet, TV, and bundle providers in your ZIP code. See speeds, prices, and deals from top providers, then choose the best plan for your home.',
        'abstract'         => 'Enter your ZIP code to compare internet, TV, and bundle providers, check availability, and review speeds, prices, and contract terms.',
        'isPartOf'         => array('@id' => $website_id),
        'about'            => array('@id' => $org_id),
        'primaryImageOfPage' => array(
            '@type'  => 'ImageObject',
            'url'    => $og_image,
            'width'  => 1200,
            'height' => 630,
        ),
        'datePublished'    => $published,
        'dateModified'     => $modified,
        'inLanguage'       => 'en-US',
        'breadcrumb'       => array('@id' => $home . '#breadcrumb'),
        'potentialAction'  => array(
            '@type'  => 'ReadAction',
            'target' => $home,
        ),
    );

    $service = array(
        '@type'            => 'Service',
        '@id'              => $home . '#service',
        'name'             => 'Internet and TV Provider Comparison',
        'serviceType'      => 'Internet and television provider comparison',
        'description'      => 'Compare internet, TV, and bundle plans by ZIP code, including speeds, prices, availability, and contract terms.',
        'provider'         => array('@id' => $org_id),
        'areaServed'       => array(
            '@type' => 'Country',
            'name'  => 'United States',
        ),
        'mainEntityOfPage' => array('@id' => $page_id),
        'hasOfferCatalog'  => array(
            '@type'           => 'OfferCatalog',
            'name'            => 'Internet, TV, and bundle plans',
            'itemListElement' => array(
                array(
                    '@type'       => 'Offer',
                    'itemOffered' => array(
                        '@type'       => 'Service',
                        'name'        => 'Internet service',
                        'serviceType' => 'Internet',
                    ),
                ),
                array(
                    '@type'       => 'Offer',
                    'itemOffered' => array(
                        '@type'       => 'Service',
                        'name'        => 'TV service',
                        'serviceType' => 'Television',
                    ),
                ),
                array(
                    '@type'       => 'Offer',
                    'itemOffered' => array(
                        '@type'       => 'Service',
                        'name'        => 'Internet and TV bundle',
                        'serviceType' => 'Internet and television bundle',
                    ),
                ),
            ),
        ),
    );

    $item_list = array(
        '@type'           => 'ItemList',
        '@id'             => $home . '#providers',
        'name'            => 'Popular internet and TV providers',
        'numberOfItems'   => count($provider_items),
        'itemListElement' => $provider_items,
    );

    $faq = array(
        '@type'      => 'FAQPage',
        '@id'        => $home . '#faq',
        'mainEntity' => array(
            array(
                '@type'          => 'Question',
                'name'           => 'How do I find internet providers in my area?',
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text'  => 'Enter your ZIP code in the availability checker on this page. You will see internet providers that serve your address, along with available speeds, starting prices, and plan details.',
                ),
            ),
            array(
                '@type'          => 'Question',
                'name'           => 'What is the difference between internet and TV bundles?',
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text'  => 'An internet and TV bundle combines two services on one bill, usually at a lower combined price than buying them separately. Bundles may also include a DVR, streaming app access, or a home phone line.',
                ),
            ),
            array(
                '@type'          => 'Question',
                'name'           => 'How much does internet service cost per month?',
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text'  => 'Internet prices vary by provider, speed, and location. Entry-level plans often start around $30 to $50 per month, while faster or unlimited plans can cost more. Promotional prices may increase after the introductory period.',
                ),
            ),
            array(
                '@type'          => 'Question',
                'name'           => 'Do I need a contract for internet or TV service?',
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text'  => 'Some providers require a one- or two-year contract, while others offer month-to-month service. Check the contract term, early termination fee, equipment fee, and price-after-promotion details before you sign up.',
                ),
            ),
            array(
                '@type'          => 'Question',
                'name'           => 'How does Top Providers make money?',
                'acceptedAnswer' => array(
                    '@type' => 'Answer',
                    'text'  => 'Top Providers may earn a commission when you sign up for a service through our links. This does not change the price you pay. Our rankings are based on availability, speed, price, contract terms, and customer feedback.',
                ),
            ),
        ),
    );

    $breadcrumb = array(
        '@type'           => 'BreadcrumbList',
        '@id'             => $home . '#breadcrumb',
        'itemListElement' => array(
            array(
                '@type'    => 'ListItem',
                'position' => 1,
                'name'     => 'Home',
                'item'     => $home,
            ),
        ),
    );

    tp_theme_echo_jsonld(array(
        '@context' => 'https://schema.org',
        '@graph'   => array(
            $organization,
            $website,
            $webpage,
            $service,
            $item_list,
            $faq,
            $breadcrumb,
        ),
    ));
}
add_action('wp_head', 'tp_theme_homepage_schema', 1);

/**
 * Add the Organization and WebSite entities to every non-home page.
 */
function tp_theme_site_entity_schema() {
    if (is_front_page()) {
        return;
    }

    $home   = esc_url(home_url('/'));
    $org_id = $home . '#organization';

    tp_theme_echo_jsonld(array(
        '@context' => 'https://schema.org',
        '@graph'   => array(
            array(
                '@type'   => 'Organization',
                '@id'     => $org_id,
                'name'    => 'Top Providers',
                'url'     => $home,
                'logo'    => array(
                    '@type'  => 'ImageObject',
                    'url'    => esc_url(get_template_directory_uri() . '/images/logo-512.png'),
                    'width'  => 512,
                    'height' => 512,
                ),
                'description' => 'Top Providers helps people compare internet, TV, bundle, and home service providers by ZIP code.',
                'email'       => 'contact@topproviders.net',
                'sameAs'      => array(
                    'https://x.com/topproviders',
                    'https://www.instagram.com/top.providers/',
                    'https://www.facebook.com/topproviders',
                    'https://www.youtube.com/@top-providers',
                ),
            ),
            array(
                '@type'     => 'WebSite',
                '@id'       => $home . '#website',
                'name'      => 'Top Providers',
                'url'       => $home,
                'publisher' => array('@id' => $org_id),
                'inLanguage' => 'en-US',
            ),
        ),
    ));
}
add_action('wp_head', 'tp_theme_site_entity_schema', 1);

add_filter('wpseo_json_ld_output', '__return_false');

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
    $dates    = tp_theme_date_schema_values(get_the_ID());

    tp_theme_echo_jsonld(array(
        "@context" => "https://schema.org",
        "@type"    => $type,
        "name"     => $is_about ? 'About Top Providers' : 'Contact Top Providers',
        "url"      => get_permalink(),
        "description" => $desc,
        "inLanguage"  => "en-US",
        "isPartOf"    => array(
            "@id" => esc_url(home_url('/')) . "#website"
        ),
        "about"       => array(
            "@id" => esc_url(home_url('/')) . "#organization"
        ),
        "dateModified" => isset($dates['dateModified']) ? $dates['dateModified'] : null
    ));
}
add_action('wp_head', 'tp_theme_about_contact_schema', 11);