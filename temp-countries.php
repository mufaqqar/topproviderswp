<?php
/** Template Name: Countries */
get_header();
set_query_var('hero_title', get_the_title());
set_query_var('hero_style', 'gradient');
get_template_part('template-parts/section/hero-banner');
?>
<section class="section-page">
    <div class="container-content">
        <div class="container-section py-8">
            <h2 class="section-title mb-6 text-center">Top Internet Providers by Country</h2>
        <?php
            $countries_by_continent = [
                'Europe' => [
                    'Albania', 'Andorra', 'Austria', 'Belarus', 'Belgium', 'Bosnia and Herzegovina',
                    'Bulgaria', 'Croatia', 'Czech Republic', 'Denmark', 'Estonia', 'Finland', 'France',
                    'Germany', 'Greece', 'Hungary', 'Iceland', 'Ireland', 'Italy', 'Kosovo', 'Latvia',
                    'Liechtenstein', 'Lithuania', 'Luxembourg', 'Malta', 'Moldova', 'Monaco',
                    'Montenegro', 'Netherlands', 'North Macedonia', 'Norway', 'Poland', 'Portugal',
                    'Romania', 'San Marino', 'Serbia', 'Slovakia', 'Slovenia', 'Spain', 'Sweden',
                    'Switzerland', 'Ukraine', 'United Kingdom', 'Vatican City'
                ],
                'North America' => [
                    'Antigua and Barbuda', 'Bahamas', 'Barbados', 'Belize', 'Canada', 'Costa Rica',
                    'Cuba', 'Dominica', 'Dominican Republic', 'El Salvador', 'Grenada', 'Guatemala',
                ],
            ];
            foreach ($countries_by_continent as $continent => $countries) {
                echo '<h3 class="text-xl font-bold mt-8 mb-4">' . esc_html($continent) . '</h3>';
                echo '<div class="grid grid-cols-2 md:grid-cols-4 gap-3">';
                foreach ($countries as $country) {
                    $slug = strtolower(str_replace([' ', '.'], '-', $country));
                    echo '<a href="' . esc_url(home_url('/internet-by-country/' . $slug)) . '" class="p-3 bg-gray-50 rounded-lg hover:bg-brand-green hover:text-white transition">' . esc_html($country) . '</a>';
                }
                echo '</div>';
            }
        ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>
