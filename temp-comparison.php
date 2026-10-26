<?php
/** Template Name: Comparison Page */

get_header();

$args = array(
    'post_type'      => 'providers',
    'posts_per_page' => -1,
    'order'          => 'DESC',
    'orderby'        => 'date'
);
$providers_query = new WP_Query($args);
$providers_options = '';
if ($providers_query->have_posts()) :
    while ($providers_query->have_posts()) : $providers_query->the_post();
        $providers_options .= '<option value="' . esc_attr(get_the_ID()) . '">' . esc_html(get_the_title()) . '</option>';
    endwhile;
endif;
wp_reset_postdata();
?>

<section class="py-24 bg-cover bg-no-repeat bg-center"
    style="background-image: linear-gradient(45deg, rgba(103,71,192, 1), rgba(103,71,192, 0.6)), url('<?php echo esc_url(get_template_directory_uri()); ?>/images/contact-us-bg.webp')">
    <div class="container mx-auto px-4">
        <h1 class="sm:text-5xl text-4xl leading-normal font-semibold text-white text-center"><?php the_title(); ?></h1>
        <p class="text-white text-center mt-4 text-lg">Compare internet, TV, and bundle plans from top providers side by side</p>
    </div>
</section>

<section class="py-24">
    <div class="container mx-auto px-4">
    <?php
        while (have_posts()) :
            the_post();
            the_content();
        endwhile;
    ?>
    </div>
</section>

<!-- Provider Comparison Tool -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-8">Compare Providers Side by Side</h2>
        <p class="text-center text-gray-600 mb-12 max-w-2xl mx-auto">Select two providers below to compare their plans, features, pricing, and more. Make an informed decision for your home internet needs.</p>

<div class="!overflow-x-auto scroll-bar my-20">
    <section class="mb-2 container mx-auto grid grid-cols-3 px-2 md:px-0 min-w-[540px]">
        <div class="border font-semibold md:text-xl flex items-center">
            <p class="p-3 px-4 flex items-center">Select Providers</p>
        </div>
        <div class="border bg-[#FECE2F] flex items-center pr-2 !border-b-[0px]">
            <select id="provider_1" class="comparison-select bg-transparent text-gray-900 block w-full p-2.5 border-none focus:outline-none">
                <option value="">Choose a Provider</option>
                <?php echo $providers_options; ?>
            </select>
        </div>
        <div class="border bg-[#FECE2F] flex items-center pr-2 !border-b-[0px]">
            <select id="provider_2" class="comparison-select bg-transparent text-gray-900 block w-full p-2.5 border-none focus:outline-none">
                <option value="">Choose a Provider</option>
                <?php echo $providers_options; ?>
            </select>
        </div>

        <div class="border font-semibold md:text-xl flex items-center">
            <p class="p-3 px-4 flex items-center">Features</p>
        </div>
        <div class="border">
            <ul id="features_1" class="grid p-3 justify-start"></ul>
        </div>
        <div class="border">
            <ul id="features_2" class="grid p-3 justify-start"></ul>
        </div>

        <div class="border font-semibold md:text-xl">
            <p class="p-3 px-4 flex items-center">Speed</p>
        </div>
        <div class="border">
            <p id="speed_1" class="p-3 px-4 flex items-center">-</p>
        </div>
        <div class="border">
            <p id="speed_2" class="p-3 px-4 flex items-center">-</p>
        </div>

        <div class="border font-semibold md:text-xl">
            <p class="p-3 px-4 flex items-center">Channels</p>
        </div>
        <div class="border">
            <p id="channels_1" class="p-3 px-4 flex items-center">-</p>
        </div>
        <div class="border">
            <p id="channels_2" class="p-3 px-4 flex items-center">-</p>
        </div>

        <div class="border font-semibold md:text-xl">
            <p class="p-3 px-4 flex items-center">Price</p>
        </div>
        <div class="border">
            <p id="price_1" class="p-3 px-4 flex items-center">-</p>
        </div>
        <div class="border">
            <p id="price_2" class="p-3 px-4 flex items-center">-</p>
        </div>

        <div class="border font-semibold md:text-xl">
            <p class="p-3 px-4 flex items-center">More About</p>
        </div>
        <div class="border">
            <p id="more_1" class="p-3 px-4 flex items-center"><a href="<?php echo esc_url(home_url('/internet/')); ?>">Browse Plans</a></p>
        </div>
        <div class="border">
            <p id="more_2" class="p-3 px-4 flex items-center"><a href="<?php echo esc_url(home_url('/internet/')); ?>">Browse Plans</a></p>
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var providers = <?php
        $all_providers = array();
        $pq = new WP_Query(array(
            'post_type' => 'providers',
            'posts_per_page' => -1,
            'order' => 'DESC',
            'orderby' => 'date'
        ));
        if ($pq->have_posts()) :
            while ($pq->have_posts()) : $pq->the_post();
                $services_info = get_field('services_info');
                $internet = isset($services_info['internet_services']) ? $services_info['internet_services'] : array();
                $tv = isset($services_info['tv_services']) ? $services_info['tv_services'] : array();
                $all_providers[] = array(
                    'id' => get_the_ID(),
                    'title' => get_the_title(),
                    'permalink' => get_permalink(),
                    'features' => isset($internet['summary_features']) ? $internet['summary_features'] : (isset($tv['summary_features']) ? $tv['summary_features'] : ''),
                    'speed' => isset($internet['summary_speed']) ? $internet['summary_speed'] : (isset($tv['summary_speed']) ? $tv['summary_speed'] : ''),
                    'channels' => isset($tv['summary_channel']) ? $tv['summary_channel'] : '',
                    'price' => isset($internet['price']) ? $internet['price'] : (isset($tv['price']) ? $tv['price'] : ''),
                );
            endwhile;
        endif;
        wp_reset_postdata();
        echo json_encode($all_providers);
    ?>;

    function updateComparison() {
        var id1 = document.getElementById('provider_1').value;
        var id2 = document.getElementById('provider_2').value;
        var p1 = id1 ? providers.find(function(p) { return p.id == id1; }) : null;
        var p2 = id2 ? providers.find(function(p) { return p.id == id2; }) : null;

        function setCell(suffix, provider) {
            document.getElementById('features_' + suffix).innerHTML = provider ? '<li class="text-sm p-1">' + (provider.features || 'N/A') + '</li>' : '';
            document.getElementById('speed_' + suffix).innerHTML = '<p class="p-3 px-4 flex items-center">' + (provider ? (provider.speed || '-') : '-') + '</p>';
            document.getElementById('channels_' + suffix).innerHTML = '<p class="p-3 px-4 flex items-center">' + (provider ? (provider.channels || '-') : '-') + '</p>';
            document.getElementById('price_' + suffix).innerHTML = '<p class="p-3 px-4 flex items-center">' + (provider ? '$' + provider.price : '-') + '</p>';
            var moreLink = document.getElementById('more_' + suffix).querySelector('a');
            if (provider && provider.permalink) {
                moreLink.href = provider.permalink;
                moreLink.textContent = 'Details Plans';
            } else {
                moreLink.href = '<?php echo esc_url(home_url('/internet/')); ?>';
                moreLink.textContent = 'Browse Plans';
            }
        }

        setCell('1', p1);
        setCell('2', p2);
    }

    document.querySelectorAll('.comparison-select').forEach(function(sel) {
        sel.addEventListener('change', updateComparison);
    });
});
</script>

<!-- SEO Content Section for Comparison Page -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8">How to Choose the Right Internet Provider</h2>
        
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                <h3 class="text-xl font-semibold mb-3 text-[#6041BB]">1. Check Availability</h3>
                <p class="text-gray-600">Not all providers are available in every area. Start by checking which providers service your zip code. Use our search tool to see what's available at your address.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                <h3 class="text-xl font-semibold mb-3 text-[#6041BB]">2. Compare Speeds</h3>
                <p class="text-gray-600">Consider your internet usage needs. For basic browsing and email, 25-50 Mbps may suffice. For streaming 4K video or gaming, look for plans with 100+ Mbps.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                <h3 class="text-xl font-semibold mb-3 text-[#6041BB]">3. Evaluate Pricing</h3>
                <p class="text-gray-600">Compare both introductory and regular rates. Some providers offer low promotional prices that increase after 12 months. Consider the total cost over 2-3 years.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-100">
                <h3 class="text-xl font-semibold mb-3 text-[#6041BB]">4. Read Customer Reviews</h3>
                <p class="text-gray-600">Look at what other customers in your area are saying. Reliability, customer service, and actual speeds can vary significantly between providers.</p>
            </div>
        </div>

        <div class="bg-gray-50 p-8 rounded-lg">
            <h2 class="text-2xl font-bold mb-6">Common Questions About Internet Providers</h2>
            
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold mb-2">What is the fastest internet provider?</h3>
                    <p class="text-gray-600">Fiber providers like Verizon Fios and AT&T Fiber typically offer the fastest speeds, with plans reaching up to 1 Gbps or more. Cable providers like Xfinity and Spectrum also offer high-speed plans in many areas.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-2">Which provider has the cheapest plans?</h3>
                    <p class="text-gray-600">Prices vary by location, but providers like Spectrum and Cox often have competitive introductory rates. Be sure to check for promotional offers and bundle deals that can lower your monthly cost.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-2">Do I need a contract?</h3>
                    <p class="text-gray-600">Many providers now offer no-contract options, though they may have slightly higher monthly rates. Providers like Spectrum and T-Mobile Home Internet are known for not requiring long-term contracts.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-2">What speed do I need for streaming?</h3>
                    <p class="text-gray-600">For HD streaming, 25 Mbps is generally sufficient. For 4K streaming, look for plans with at least 50 Mbps. If multiple people will be streaming simultaneously, consider plans with 100+ Mbps.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Provider Quick Links -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-8">Compare Specific Providers</h2>
        <div class="grid md:grid-cols-3 gap-4">
            <?php
            $quick_providers = array(
                array('name' => 'Xfinity vs Spectrum', 'slug' => 'xfinity'),
                array('name' => 'AT&T vs Verizon', 'slug' => 'att'),
                array('name' => 'Cox vs Spectrum', 'slug' => 'cox'),
                array('name' => 'Frontier vs CenturyLink', 'slug' => 'frontier'),
                array('name' => 'HughesNet vs Viasat', 'slug' => 'hughesnet'),
                array('name' => 'T-Mobile vs Verizon', 'slug' => 't-mobile'),
            );
            foreach ($quick_providers as $qp) :
            ?>
            <a href="<?php echo esc_url(home_url('/providers/' . $qp['slug'])); ?>" 
               class="block bg-white p-4 rounded-lg shadow-md border border-gray-100 hover:border-[#6041BB] transition-all duration-300 text-center">
                <span class="font-semibold text-[#6041BB]"><?php echo $qp['name']; ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
