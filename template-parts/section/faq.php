<?php
/**
 * FAQ Accordion Component
 *
 * Usage:
 *   set_query_var('faq_title', 'FAQs');
 *   set_query_var('faq_items', $faq_array);
 *   get_template_part('template-parts/section/faq');
 *
 * $faq_array format:
 *   [
 *     ['question' => '...', 'answer' => '...'],
 *     ...
 *   ]
 */

$faq_title = get_query_var('faq_title', 'FAQs');
$faq_items = get_query_var('faq_items', array());

if (empty($faq_items)) return;
?>

<section class="my-16">
    <div class="container-section">
        <div class="mb-10">
            <h2 class="text-2xl font-bold"><?php echo esc_html($faq_title); ?></h2>
        </div>
        <div class="grid gap-10">
            <?php foreach ($faq_items as $faq) : ?>
            <div class="faq-item">
                <div class="faq-question">
                    <p class="text-lg font-semibold"><?php echo esc_html($faq['question']); ?></p>
                    <span class="faq-icon text-brand-purple">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024"
                            class="faq-arrow-svg" height="24" width="24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M474 152m8 0l60 0q8 0 8 8l0 704q0 8-8 8l-60 0q-8 0-8-8l0-704q0-8 8-8Z"></path>
                            <path d="M168 474m8 0l672 0q8 0 8 8l0 60q0 8-8 8l-672 0q-8 0-8-8l0-60q0-8 8-8Z"></path>
                        </svg>
                    </span>
                </div>
                <div class="faq-answer hidden mt-5">
                    <p class="text-base font-medium"><?php echo esc_html($faq['answer']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.faq-item').forEach(function(item) {
        var question = item.querySelector('.faq-question');
        var answer = item.querySelector('.faq-answer');
        var arrow = item.querySelector('.faq-arrow-svg');
        if (!question) return;
        question.addEventListener('click', function() {
            document.querySelectorAll('.faq-item').forEach(function(other) {
                var otherAnswer = other.querySelector('.faq-answer');
                var otherArrow = other.querySelector('.faq-arrow-svg');
                if (other !== item) {
                    if (otherAnswer) otherAnswer.classList.add('hidden');
                    if (otherArrow) otherArrow.classList.remove('rotate-45');
                }
            });
            if (answer) answer.classList.toggle('hidden');
            if (arrow) arrow.classList.toggle('rotate-45');
        });
    });
});
</script>
