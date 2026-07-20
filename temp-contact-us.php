<?php
/** Template Name: Contact Us */
get_header();
set_query_var('hero_title', 'Contact Us');
set_query_var('hero_style', 'image');
set_query_var('hero_image', 'family.png');
get_template_part('template-parts/section/hero-banner');
?>

<section class="pb-16 mt-10 md:mt-20">
    <div class="container-section grid grid-cols-1 md:grid-cols-2 my-10 gap-10">
        <div>
            <span class="font-semibold text-brand-blue">SECURE CONNECTIONS</span>
            <h2 class="section-title-lg">We Offer The <span class="text-brand-blue">Highest-Quality Network Connections</span></h2>
            <p class="section-subtitle">We're here to help! Leave us a message, and our team will get back to you as soon as possible.</p>

            <div class="flex mt-8 items-center gap-4">
                <div class="bg-brand-blue p-4">
                    <svg width="30px" height="30px" viewBox="-3 0 20 20" version="1.1">
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g id="Dribbble-Light-Preview" transform="translate(-423.000000, -5439.000000)" fill="#fff">
                                <g id="icons" transform="translate(56.000000, 160.000000)">
                                    <path d="M376,5286.219 C376,5287.324 375.105,5288.219 374,5288.219 C372.895,5288.219 372,5287.324 372,5286.219 C372,5285.114 372.895,5284.219 374,5284.219 C375.105,5284.219 376,5285.114 376,5286.219 M374,5297 C372.178,5297 369,5290.01 369,5286 C369,5283.243 371.243,5281 374,5281 C376.757,5281 379,5283.243 379,5286 C379,5290.01 375.822,5297 374,5297 M374,5279 C370.134,5279 367,5282.134 367,5286 C367,5289.866 370.134,5299 374,5299 C377.866,5299 381,5289.866 381,5286 C381,5282.134 377.866,5279 374,5279" id="pin_rounded_circle-[#619]"></path>
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
            </div>
        </div>

        <div>
            <div class="bg-white p-8 rounded-lg shadow-card">
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();
                        the_content();
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
