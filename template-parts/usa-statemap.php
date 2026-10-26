<section class="py-16 bg-[#6746C8]">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl md:text-5xl text-center md:leading-tight font-bold text-white mb-10">Find Top Internet Providers by State</h2>
        <div class="!max-w-[712px] w-full mx-auto">
            <?php get_template_part('template-parts/search', 'form'); ?>
        </div>
                <div class="mt-10">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/usa-provider-map.svg" alt="Map of internet providers by U.S. state" width="800" height="600" loading="lazy" decoding="async" class="w-full h-auto max-w-[800px] mx-auto" />
            <div class="mt-8 grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2 text-center">
                <?php
                $map_states = array(
        'AL' => 'Alabama',
        'AK' => 'Alaska',
        'AZ' => 'Arizona',
        'AR' => 'Arkansas',
        'CA' => 'California',
        'CO' => 'Colorado',
        'CT' => 'Connecticut',
        'DE' => 'Delaware',
        'DC' => 'District of Columbia',
        'FL' => 'Florida',
        'GA' => 'Georgia',
        'HI' => 'Hawaii',
        'ID' => 'Idaho',
        'IL' => 'Illinois',
        'IN' => 'Indiana',
        'IA' => 'Iowa',
        'KS' => 'Kansas',
        'KY' => 'Kentucky',
        'LA' => 'Louisiana',
        'ME' => 'Maine',
        'MD' => 'Maryland',
        'MA' => 'Massachusetts',
        'MI' => 'Michigan',
        'MN' => 'Minnesota',
        'MS' => 'Mississippi',
        'MO' => 'Missouri',
        'MT' => 'Montana',
        'NE' => 'Nebraska',
        'NV' => 'Nevada',
        'NH' => 'New Hampshire',
        'NJ' => 'New Jersey',
        'NM' => 'New Mexico',
        'NY' => 'New York',
        'NC' => 'North Carolina',
        'ND' => 'North Dakota',
        'OH' => 'Ohio',
        'OK' => 'Oklahoma',
        'OR' => 'Oregon',
        'PA' => 'Pennsylvania',
        'RI' => 'Rhode Island',
        'SC' => 'South Carolina',
        'SD' => 'South Dakota',
        'TN' => 'Tennessee',
        'TX' => 'Texas',
        'UT' => 'Utah',
        'VT' => 'Vermont',
        'VA' => 'Virginia',
        'WA' => 'Washington',
        'WV' => 'West Virginia',
        'WI' => 'Wisconsin',
        'WY' => 'Wyoming',
                );
                foreach ($map_states as $code => $name) {
                    echo '<a class="rounded-md bg-white/10 px-2 py-2 text-sm text-white hover:bg-[#96B93A]" href="' . esc_url(home_url('/internet/' . strtolower($code) . '/')) . '">' . esc_html($name) . '</a>';
                }
                ?>
            </div>
        </div>
    </div>
</section>