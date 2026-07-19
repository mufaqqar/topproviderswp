<?php
/** Template Name: About Us */
get_header();
set_query_var('hero_title', 'About Us');
set_query_var('hero_style', 'image');
set_query_var('hero_image', 'family.png');
get_template_part('template-parts/section/hero-banner');
?>

<section class="my-16 mb-24">
    <div class="grid-2col container-section">
        <div class="relative">
            <img alt="diverse-team" loading="lazy" width="570" height="375" decoding="async" data-nimg="1"
                class="shadow-soft rounded-2xl z-10 relative"
                src="<?php echo esc_url(get_template_directory_uri()); ?>/images/diverse-team.jpg" style="color: transparent;" />
            <div class="bg-blue-100 absolute inset-0 rounded-2xl mt-20 !mb-[-2.5rem] ml-10 shadow-soft"></div>
        </div>
        <div class="py-10">
            <span class="font-semibold text-brand-blue">WHAT WE DO</span>
            <h2 class="section-title-lg">High-Quality Connections Wherever, <span class="text-brand-blue">Anytime</span></h2>
            <p class="section-subtitle">We're here to help! Leave us a message, and our team will get back to you as soon as possible. We strive to provide quick and helpful responses to all inquiries.</p>
        </div>
    </div>

    <div class="grid-2col container-section">
        <div class="py-10 order-2 md:order-1">
            <h2 class="section-title-lg">How We Sustain Our <span class="text-brand-blue">Platform</span></h2>
            <p class="section-subtitle">In order to maintain an ad-free experience for you, we support our platform through affiliate partnerships with Internet and TV providers, as well as other links featured on our website.</p>
        </div>
        <div class="relative order-1 md:order-2">
            <img alt="diverse-team" loading="lazy" width="570" height="375" decoding="async" data-nimg="1"
                class="shadow-soft rounded-2xl z-10 relative"
                src="<?php echo esc_url(get_template_directory_uri()); ?>/images/businesspeople.jpg" style="color: transparent;" />
            <div class="bg-blue-100 absolute inset-0 rounded-2xl mt-20 !mb-[-2.5rem] ml-10 shadow-soft"></div>
        </div>
    </div>

    <div class="grid-2col container-section">
        <div class="relative">
            <img alt="diverse-team" loading="lazy" width="570" height="375" decoding="async" data-nimg="1"
                class="shadow-soft rounded-2xl bg-white z-10 relative"
                src="<?php echo esc_url(get_template_directory_uri()); ?>/images/diverse-team.jpg" style="color: transparent;" />
            <div class="bg-blue-100 absolute inset-0 rounded-2xl mt-20 !mb-[-2.5rem] ml-10 shadow-soft"></div>
        </div>
        <div class="py-10">
            <h2 class="section-title-lg">Our Provider Ranking <span class="text-brand-blue">Criteria</span></h2>
            <p class="section-subtitle">We strive to present you with a comprehensive array of choices, which is why we include all major TV providers on our website. Our reviews take into account factors such as availability, reliability, customer support, user feedback, and overall value for your money.</p>
        </div>
    </div>
</section>

<section class="container-section mb-20">
    <h2 class="section-title-lg text-center">Whats Our Client <span class="text-brand-blue">Say's</span></h2>
    <?php get_template_part('template-parts/client', 'reviews'); ?>
</section>

<?php get_footer(); ?>
