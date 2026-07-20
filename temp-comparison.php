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
            <p id="more_1" class="p-3 px-4 flex items-center"><a href="#">Details Plans</a></p>
        </div>
        <div class="border">
            <p id="more_2" class="p-3 px-4 flex items-center"><a href="#">Details Plans</a></p>
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
                moreLink.href = '#';
                moreLink.textContent = '-';
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

<?php get_footer(); ?>
