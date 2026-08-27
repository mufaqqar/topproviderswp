<?php

/**
 * Schema Markup for SEO
 * Adds Organization, LocalBusiness, Product, and FAQ schema
 */

/**
 * Add Organization Schema to the head
 */
function tp_theme_organization_schema() {
    if (is_front_page()) :
    ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Top Providers",
        "url": "<?php echo esc_url(home_url('/')); ?>",
        "logo": "<?php echo esc_url(get_template_directory_uri() . '/images/logo.webp'); ?>",
        "description": "Your go-to source for the best internet, TV, and home bundles. Compare plans, find deals, and connect with top providers effortlessly.",
        "sameAs": [
            "https://x.com/topproviders",
            "https://www.instagram.com/top.providers/",
            "https://www.facebook.com/topproviders",
            "https://www.youtube.com/@top-providers"
        ],
        "contactPoint": {
            "@type": "ContactPoint",
            "contactType": "customer service",
            "availableLanguage": "English"
        },
        "address": {
            "@type": "PostalAddress",
            "addressCountry": "US"
        }
    }
    </script>
    <?php
    endif;
}
add_action('wp_head', 'tp_theme_organization_schema', 1);

/**
 * Add Website Schema with SearchAction
 */
function tp_theme_website_schema() {
    if (is_front_page()) :
    ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "Top Providers",
        "url": "<?php echo esc_url(home_url('/')); ?>",
        "potentialAction": {
            "@type": "SearchAction",
            "target": {
                "@type": "EntryPoint",
                "urlTemplate": "<?php echo esc_url(home_url('/?s={search_term_string}')); ?>"
            },
            "query-input": "required name=search_term_string"
        }
    }
    </script>
    <?php
    endif;
}
add_action('wp_head', 'tp_theme_website_schema', 2);

/**
 * Add BreadcrumbList Schema
 */
function tp_theme_breadcrumb_schema() {
    if (is_single() && !is_front_page()) :
        global $post;
        $breadcrumbs = array();
        
        // Home
        $breadcrumbs[] = array(
            "@type" => "ListItem",
            "position" => 1,
            "name" => "Home",
            "item" => esc_url(home_url('/'))
        );
        
        $position = 2;
        
        // Add provider type if applicable
        if (get_post_type() === 'providers') {
            $service_types = get_the_terms($post->ID, 'providers_service_types');
            if ($service_types && !is_wp_error($service_types)) {
                foreach ($service_types as $type) {
                    $term_link = get_term_link($type);
                    if (!is_wp_error($term_link)) {
                        $breadcrumbs[] = array(
                            "@type" => "ListItem",
                            "position" => $position,
                            "name" => $type->name,
                            "item" => esc_url($term_link)
                        );
                        $position++;
                    }
                }
            }
            
            // Provider type
            $provider_types = get_the_terms($post->ID, 'providers_types');
            if ($provider_types && !is_wp_error($provider_types)) {
                foreach ($provider_types as $type) {
                    $term_link = get_term_link($type);
                    if (!is_wp_error($term_link)) {
                        $breadcrumbs[] = array(
                            "@type" => "ListItem",
                            "position" => $position,
                            "name" => $type->name,
                            "item" => esc_url($term_link)
                        );
                        $position++;
                    }
                }
            }
        }
        
        // Current page
        $breadcrumbs[] = array(
            "@type" => "ListItem",
            "position" => $position,
            "name" => get_the_title()
        );
    ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": <?php echo json_encode($breadcrumbs); ?>
    }
    </script>
    <?php
    endif;
}
add_action('wp_head', 'tp_theme_breadcrumb_schema', 3);

/**
 * Add Product/Service Schema for Provider Pages
 */
function tp_theme_provider_product_schema() {
    if (is_single() && get_post_type() === 'providers') :
        global $post;
        $price = get_field('pro_price');
        $pro_link = get_field('pro_link');
        $pro_speed = get_field('pro_speed');
        $title = get_the_title();
        $excerpt = get_the_excerpt();
        $thumbnail = get_the_post_thumbnail_url($post->ID, 'full');
        
        $schema = array(
            "@context" => "https://schema.org",
            "@type" => "Product",
            "name" => $title . " Internet Plans",
            "description" => !empty($excerpt) ? wp_strip_all_tags($excerpt) : "Compare " . $title . " internet plans, pricing, and features. Find the best deal for your home.",
            "brand" => array(
                "@type" => "Brand",
                "name" => $title
            ),
            "url" => get_permalink(),
        );
        
        if ($thumbnail) {
            $schema['image'] = $thumbnail;
        }
        
        if ($price) {
            $schema['offers'] = array(
                "@type" => "Offer",
                "price" => $price,
                "priceCurrency" => "USD",
                "priceValidUntil" => date('Y-m-d', strtotime('+1 month')),
                "availability" => "https://schema.org/InStock",
                "url" => !empty($pro_link) ? $pro_link : get_permalink()
            );
        }
        
        // Add aggregate rating if reviews exist
        $comments = get_comments(array(
            'post_id' => $post->ID,
            'count' => true,
            'status' => 'approve'
        ));
        
        if ($comments > 0) {
            $rating_sum = 0;
            $rating_count = 0;
            
            foreach (get_comments(array('post_id' => $post->ID, 'status' => 'approve')) as $comment) {
                $rating = get_comment_meta($comment->comment_ID, 'star', true);
                if ($rating) {
                    $rating_sum += intval($rating);
                    $rating_count++;
                }
            }
            
            if ($rating_count > 0) {
                $schema['aggregateRating'] = array(
                    "@type" => "AggregateRating",
                    "ratingValue" => round($rating_sum / $rating_count, 1),
                    "reviewCount" => $rating_count,
                    "bestRating" => 5,
                    "worstRating" => 1
                );
            }
        }
        
        // Add review schema
        $review_comments = get_comments(array(
            'post_id' => $post->ID,
            'status' => 'approve',
            'number' => 5,
            'meta_query' => array(
                array(
                    'key' => 'star',
                    'value' => '',
                    'compare' => '!='
                )
            )
        ));
        
        if (!empty($review_comments)) {
            $reviews = array();
            foreach ($review_comments as $comment) {
                $rating = get_comment_meta($comment->comment_ID, 'star', true);
                if ($rating) {
                    $reviews[] = array(
                        "@type" => "Review",
                        "author" => array(
                            "@type" => "Person",
                            "name" => $comment->comment_author
                        ),
                        "reviewRating" => array(
                            "@type" => "Rating",
                            "ratingValue" => $rating,
                            "bestRating" => 5
                        ),
                        "reviewBody" => wp_strip_all_tags($comment->comment_content)
                    );
                }
            }
            
            if (!empty($reviews)) {
                $schema['review'] = $reviews;
            }
        }
    ?>
    <script type="application/ld+json">
    <?php echo json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
    </script>
    <?php
    endif;
}
add_action('wp_head', 'tp_theme_provider_product_schema', 4);

/**
 * Add FAQ Schema for Provider Pages
 */
function tp_theme_faq_schema() {
    if (is_single() && get_post_type() === 'providers') :
        if (have_rows('faq\'s')) :
            $faq_items = array();
            while (have_rows('faq\'s')) : the_row();
                $question = get_sub_field('question');
                $answer = get_sub_field('answer');
                if ($question && $answer) {
                    $faq_items[] = array(
                        "@type" => "Question",
                        "name" => wp_strip_all_tags($question),
                        "acceptedAnswer" => array(
                            "@type" => "Answer",
                            "text" => wp_strip_all_tags($answer)
                        )
                    );
                }
            endwhile;
            
            if (!empty($faq_items)) :
    ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": <?php echo json_encode($faq_items, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
    }
    </script>
    <?php
            endif;
        endif;
    endif;
}
add_action('wp_head', 'tp_theme_faq_schema', 5);

/**
 * Add LocalBusiness Schema for Country Zone pages
 */
function tp_theme_local_business_schema() {
    if (get_post_type() === 'country_zone' && is_single()) :
    ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "Top Providers - <?php echo esc_html(get_the_title()); ?>",
        "description": "Find the best internet, TV, and home service providers in <?php echo esc_html(get_the_title()); ?>.",
        "url": "<?php echo esc_url(get_permalink()); ?>",
        "areaServed": {
            "@type": "State",
            "name": "<?php echo esc_html(get_the_title()); ?>"
        },
        "hasOfferCatalog": {
            "@type": "OfferCatalog",
            "name": "Internet Service Plans",
            "itemListElement": [
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "Service",
                        "name": "Internet Service",
                        "serviceType": "Internet"
                    }
                },
                {
                    "@type": "Offer",
                    "itemOffered": {
                        "@type": "Service",
                        "name": "TV Service",
                        "serviceType": "Television"
                    }
                }
            ]
        }
    }
    </script>
    <?php
    endif;
}
add_action('wp_head', 'tp_theme_local_business_schema', 6);

/**
 * Add ComparisonPage Schema for Comparison pages
 */
function tp_theme_comparison_schema() {
    if (is_page_template('temp-comparison.php')) :
    ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "<?php echo esc_html(get_the_title()); ?>",
        "description": "Compare internet, TV, and bundle plans from top providers side by side. Find the best deal for your home.",
        "url": "<?php echo esc_url(get_permalink()); ?>",
        "mainEntity": {
            "@type": "ItemList",
            "name": "Internet Service Providers Comparison",
            "description": "List of internet service providers available for comparison",
            "numberOfItems": <?php echo $providers_query->found_posts; ?>
        }
    }
    </script>
    <?php
    endif;
}
add_action('wp_head', 'tp_theme_comparison_schema', 7);
