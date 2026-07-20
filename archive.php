<?php get_header(); ?>

<section class="py-16">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-5xl font-bold mb-8">
            <?php
            if (is_category()) {
                single_cat_title();
            } elseif (is_tag()) {
                single_tag_title();
            } elseif (is_author()) {
                the_post();
                echo 'Author: ' . get_the_author();
                rewind_posts();
            } elseif (is_day()) {
                echo 'Day: ' . get_the_date();
            } elseif (is_month()) {
                echo 'Month: ' . get_the_date('F Y');
            } elseif (is_year()) {
                echo 'Year: ' . get_the_date('Y');
            } else {
                the_archive_title();
            }
            ?>
        </h1>
        <?php if (have_posts()) : ?>
            <div class="grid md:grid-cols-3 gap-8">
                <?php while (have_posts()) : the_post(); ?>
                    <article class="border rounded-lg overflow-hidden shadow">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-48 object-cover" />
                        <?php endif; ?>
                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <p class="text-gray-600"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                            <a href="<?php the_permalink(); ?>" class="text-blue-600 hover:underline mt-2 inline-block">Read More</a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            <div class="mt-8">
                <?php the_posts_pagination(); ?>
            </div>
        <?php else : ?>
            <p>No posts found.</p>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
