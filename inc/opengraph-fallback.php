<?php

/**
 * Open Graph / Twitter Card fallbacks.
 *
 * Yoast SEO normally outputs social meta. These fallbacks fire only when
 * a tag is missing so the theme is resilient when Yoast is disabled.
 */

add_action('wp_head', 'tp_theme_og_fallback', 8);

function tp_theme_og_fallback() {
    if (defined('WPSEO_VERSION') || class_exists('WPSEO_Frontend')) {
        return;
    }

    $site_name = get_bloginfo('name');
    $url       = is_singular() ? get_permalink() : home_url(add_query_arg(array()));
    $title     = wp_get_document_title();
    $desc      = has_excerpt() ? get_the_excerpt() : get_bloginfo('description');
    $image     = '';

    if (is_singular() && has_post_thumbnail()) {
        $image = (string) get_the_post_thumbnail_url(null, 'large');
    } else {
        $image = get_template_directory_uri() . '/images/og-home.jpg';
    }

    echo "\n<!-- Open Graph / Twitter fallback -->\n";
    echo '<meta property="og:type" content="' . (is_singular() ? 'article' : 'website') . '" />' . "\n";
    echo '<meta property="og:site_name" content="' . esc_attr($site_name) . '" />' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($title) . '" />' . "\n";
    echo '<meta property="og:description" content="' . esc_attr(wp_strip_all_tags($desc)) . '" />' . "\n";
    echo '<meta property="og:url" content="' . esc_url($url) . '" />' . "\n";
    echo '<meta property="og:image" content="' . esc_url($image) . '" />' . "\n";
    if (strpos($image, 'og-home.jpg') !== false) {
        echo '<meta property="og:image:width" content="1200" />' . "\n";
        echo '<meta property="og:image:height" content="630" />' . "\n";
        echo '<meta property="og:image:alt" content="Compare internet and TV providers by ZIP code" />' . "\n";
    }
    echo '<meta property="og:locale" content="' . esc_attr(get_locale()) . '" />' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
    echo '<meta name="twitter:title" content="' . esc_attr($title) . '" />' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr(wp_strip_all_tags($desc)) . '" />' . "\n";
    echo '<meta name="twitter:image" content="' . esc_url($image) . '" />' . "\n";
}