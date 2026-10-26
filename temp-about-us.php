<?php
/** Template Name: About Us */
get_header();
set_query_var('hero_title', 'About Us');
set_query_var('hero_style', 'image');
set_query_var('hero_image', 'family.webp');
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
                src="<?php echo esc_url(get_template_directory_uri()); ?>/images/businesspeople.webp" style="color: transparent;" />
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
            <h2 id="methodology" class="section-title-lg">Our Provider Ranking <span class="text-brand-blue">Methodology</span></h2>
            <p class="section-subtitle">We strive to present a comprehensive array of choices, which is why we include all major TV and internet providers on our website. Our reviews consider availability, reliability, customer support, user feedback, and overall value for money.</p>
            <h3 class="text-xl font-bold text-[#071F37] mt-6 mb-2">What we evaluate</h3>
            <p class="section-subtitle">Availability, maximum speed, starting price, price after promotion, contract length, early termination fees, equipment fees, data caps, bundle value, and customer feedback.</p>
            <h3 class="text-xl font-bold text-[#071F37] mt-6 mb-2">Where our data comes from</h3>
            <p class="section-subtitle">We use provider plan pages, coverage tools, publicly available pricing, and customer reviews. Affiliate relationships do not change the price you pay, and they do not determine placement.</p>
            <h3 class="text-xl font-bold text-[#071F37] mt-6 mb-2">How we update and correct information</h3>
            <p class="section-subtitle">We review provider pages on a regular schedule and update them when plans, prices, or availability change. If you spot an error, <a class="text-brand-blue underline" href="<?php echo esc_url(home_url('/contact-us/')); ?>">contact us</a> and we will review it.</p>
            <p class="text-sm text-[#4E4E4E] mt-6">Reviewed by the Top Providers Editorial Team &middot; Last updated <?php echo esc_html(get_the_modified_date('F j, Y')); ?></p>
        </div>
    </div>
</section>

<section class="container-section mb-20" id="editorial-standards">
    <h2 class="section-title-lg text-center">Our Editorial <span class="text-brand-blue">Standards</span></h2>
    <div class="grid md:grid-cols-3 gap-7 mt-10">
        <div class="bg-white rounded-2xl p-6 border border-blue-100">
            <h3 class="text-xl font-bold text-[#071F37] mb-3">Independence</h3>
            <p class="text-base text-[#464646]">Provider rankings are based on availability, speed, price, contract terms, and customer feedback. Affiliate relationships do not determine placement.</p>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-blue-100">
            <h3 class="text-xl font-bold text-[#071F37] mb-3">Accuracy</h3>
            <p class="text-base text-[#464646]">We check provider plan pages, coverage tools, and public pricing before publishing. Plans and prices can change, so confirm details with the provider before signing up.</p>
        </div>
        <div class="bg-white rounded-2xl p-6 border border-blue-100">
            <h3 class="text-xl font-bold text-[#071F37] mb-3">Corrections</h3>
            <p class="text-base text-[#464646]">If a plan, price, or availability detail is wrong, <a class="text-brand-blue underline" href="<?php echo esc_url(home_url('/contact-us/')); ?>">tell us</a>. We review reports and update the page when needed.</p>
        </div>
    </div>
</section>

<section class="container-section mb-20">
    <h2 class="section-title-lg text-center">What Our <span class="text-brand-blue">Clients Say</span></h2>
    <?php get_template_part('template-parts/client', 'reviews'); ?>
</section>

<?php get_footer(); ?>
