<?php
$cheap_providers = get_query_var('providers_query');
if (!$cheap_providers || !$cheap_providers->have_posts()) return;
$type = get_query_var('type', 'internet');
?>

<section class="my-16">
    <div class="container mx-auto px-4">
        <div class="mb-10">
            <h2 class="text-2xl font-bold capitalize leading-10">Cheap <?php echo esc_html(str_replace(['-'], ' ', $type)); ?> Providers</h2>
        </div>
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <?php while ($cheap_providers->have_posts()) : $cheap_providers->the_post(); ?>
                <div class="w-full flex flex-col p-6 bg-white rounded-lg shadow-lg border border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <span class="text-4xl font-bold">$<?php echo esc_html(get_field('pro_price')); ?></span>
                            <span class="text-gray-400 ml-1 text-lg">/month</span>
                        </div>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium', ['class' => 'max-h-12 w-auto']); ?>
                        </a>
                    </div>
                    <h3 class="text-lg font-semibold mb-2"><?php the_title(); ?></h3>
                    <div class="mt-auto">
                        <a href="<?php the_permalink(); ?>" class="w-full block text-center py-3 text-white bg-[#96B93A] rounded-md font-semibold hover:bg-[#7a9a2e] transition">
                            View Plans
                        </a>
                    </div>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</section>