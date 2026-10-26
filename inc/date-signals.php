<?php

/**
 * Freshness & date signals for AEO / GEO / SEO.
 *
 * - Emits <meta> tags for published/modified times
 * - Appends visible "Last updated" lines where relevant
 * - Exposes datePublished / dateModified helpers for JSON-LD schema
 */

/**
 * Emit date meta tags in the document head.
 */
if (!defined('WPSEO_VERSION')) {
    add_action('wp_head', 'tp_theme_date_meta_tags', 2);
}

function tp_theme_date_meta_tags() {
    if (!is_singular()) {
        return;
    }

    global $post;

    $published = get_the_date('c', $post->ID);
    $modified  = get_the_modified_date('c', $post->ID);

    echo "\n<!-- Generated date signals -->\n";
    echo '<meta property="article:published_time" content="' . esc_attr($published) . '" />' . "\n";
    echo '<meta property="article:modified_time" content="' . esc_attr($modified) . '" />' . "\n";
    echo '<meta property="og:updated_time" content="' . esc_attr($modified) . '" />' . "\n";
}

/**
 * Helper: last updated markup used by templates.
 *
 * @param int|null $post_id
 * @return string
 */
function tp_theme_last_updated_text($post_id = null) {
    if (is_null($post_id)) {
        $post_id = get_the_ID();
    }
    if (!$post_id) {
        return '';
    }

    $published = get_the_date('F j, Y', $post_id);
    $modified  = get_the_modified_date('F j, Y', $post_id);

    if ($modified && $modified !== $published) {
        return 'Last updated on ' . esc_html($modified) . ' (first published ' . esc_html($published) . ')';
    }

    return 'Published on ' . esc_html($published);
}

/**
 * Helper: published + modified timestamps for JSON-LD.
 *
 * @param int|null $post_id
 * @return array
 */
function tp_theme_date_schema_values($post_id = null) {
    if (is_null($post_id)) {
        $post_id = get_the_ID();
    }
    if (!$post_id) {
        return array();
    }

    return array(
        'datePublished' => get_the_date('c', $post_id),
        'dateModified'  => get_the_modified_date('c', $post_id),
    );
}