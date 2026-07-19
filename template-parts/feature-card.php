<?php
/**
 * Feature Card Component
 *
 * Usage:
 *   set_query_var('feature_icon', '<svg>...</svg>');
 *   set_query_var('feature_title', 'Card Title');
 *   set_query_var('feature_text', 'Description text');
 *   set_query_var('feature_bg', 'bg-brand-soft-bg'); // optional
 *   set_query_var('feature_link', '/url'); // optional
 *   get_template_part('template-parts/feature-card');
 */

$icon = get_query_var('feature_icon', '');
$title = get_query_var('feature_title', '');
$text = get_query_var('feature_text', '');
$bg = get_query_var('feature_bg', 'bg-white');
$link = get_query_var('feature_link', '');
$extra_class = get_query_var('feature_class', '');
?>

<div class="feature-card <?php echo esc_attr($bg . ' ' . $extra_class); ?>">
    <div class="mt-5">
        <?php if ($icon) : ?>
        <span class="feature-card-icon"><?php echo $icon; ?></span>
        <?php endif; ?>
        <?php if ($link) : ?>
        <h2 class="feature-card-title"><a href="<?php echo esc_url($link); ?>"><?php echo esc_html($title); ?></a></h2>
        <?php else : ?>
        <h2 class="feature-card-title"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>
        <?php if ($text) : ?>
        <div><p class="feature-card-text"><?php echo esc_html($text); ?></p></div>
        <?php endif; ?>
    </div>
</div>
