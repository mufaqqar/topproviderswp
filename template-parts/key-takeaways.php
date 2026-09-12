<?php
/**
 * Key Takeaways / Quick Facts block — AEO optimization.
 *
 * A concise "answer box" placed near the top of a page. Search engines and
 * answer engines (Google AI Overviews, ChatGPT, Perplexity, Gemini) use this
 * direct-answer structure for featured snippets and citations.
 *
 * Usage:
 *   set_query_var('key_takeaways_title', 'Key Takeaways');
 *   set_query_var('key_takeaways', array('...', '...', '...'));
 *   get_template_part('template-parts/key-takeaways');
 */

$kt_title = get_query_var('key_takeaways_title', 'Key Takeaways');
$kt_items = get_query_var('key_takeaways', array());

if (empty($kt_items)) {
    return;
}
?>

<section class="my-8" aria-label="<?php echo esc_attr($kt_title); ?>">
    <div class="container-section">
        <div class="rounded-lg border border-[#96B93A] bg-[#F7FAF2] p-6 shadow-soft">
            <h2 class="text-xl font-bold text-[#215690] mb-4"><?php echo esc_html($kt_title); ?></h2>
            <ul class="space-y-3">
                <?php foreach ($kt_items as $kt_item) : ?>
                <li class="flex gap-3 text-base text-gray-800">
                    <span class="mt-0.5 text-brand-green font-bold">&#10003;</span>
                    <span><?php echo esc_html($kt_item); ?></span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>