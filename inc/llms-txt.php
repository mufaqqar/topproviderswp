<?php

/**
 * llms.txt — the LLM-friendly robots standard.
 *
 * Serves a machine-readable /llms.txt describing Top Providers for
 * Generative AI engines (ChatGPT, Claude, Perplexity, Gemini, Copilot).
 *
 * Learn more: https://llmstxt.org/
 */

/**
 * Serve /llms.txt from WordPress without a physical file.
 */
add_action('init', function () {
    $request_uri = $_SERVER['REQUEST_URI'] ?? '';
    $path = parse_url($request_uri, PHP_URL_PATH);

    if (rtrim($path, '/') === '/llms.txt') {
        nocache_headers();
        header('Content-Type: text/plain; charset=UTF-8');
        echo tp_theme_generate_llms_txt();
        exit;
    }
}, 5);

/**
 * Build the llms.txt content.
 *
 * @return string
 */
function tp_theme_generate_llms_txt() {
    $home = esc_url(home_url('/'));
    $site_name = get_bloginfo('name');
    $tagline = get_bloginfo('description');

    $lines = [];

    $lines[] = '# ' . $site_name;
    $lines[] = '';
    $lines[] = '> Compare and connect with top TV, Internet, Landline, Home Security, Moving, Solar, Insurance, and Health Insurance providers across the United States. Find the best plans, prices, and deals in your area.';

    $lines[] = '';
    $lines[] = '## Key Facts';
    $lines[] = '';
    $lines[] = '- ' . $site_name . ' is a provider comparison platform for the United States.';
    $lines[] = '- The site helps users find TV, Internet, Landline, Home Security, Moving, Solar, Insurance, and Health Insurance providers.';
    $lines[] = '- Users enter a ZIP code to see providers, plans, pricing, speeds, and availability near them.';
    $lines[] = '- Compare top providers side by side to find the best deal for your home.';

    $lines[] = '';
    $lines[] = '## Primary Pages';
    $lines[] = '';
    $lines[] = '- [' . $site_name . '](' . $home . '): Find the best TV, Internet, Landline and other providers in your area.';
    $lines[] = '- [Internet By Country](' . esc_url(home_url('/internet-by-country/')) . '): Top internet providers globally, organized by country.';
    $lines[] = '- [Providers](' . esc_url(home_url('/providers')) . '): Browse all top providers.';
    $lines[] = '- [Comparison](' . esc_url(home_url('/comparison')) . '): Compare providers side by side.';
    $lines[] = '- [Blog](' . esc_url(home_url('/blog')) . '): Guides, tips, and provider reviews.';
    $lines[] = '- [About Us](' . esc_url(home_url('/about-us')) . '): Our mission and how we rank providers.';
    $lines[] = '- [Contact](' . esc_url(home_url('/contact-us')) . '): Reach the Top Providers team.';

    $lines[] = '';
    $lines[] = '## Services';
    $lines[] = '';
    $lines[] = '- [Internet Providers](' . esc_url(home_url('/internet')) . '): Compare internet plans, speeds, and pricing.';
    $lines[] = '- [TV Providers](' . esc_url(home_url('/tv')) . '): Compare TV packages and channel lineups.';
    $lines[] = '- [Internet + TV Bundles](' . esc_url(home_url('/internet-tv')) . '): Bundle internet and TV for savings.';
    $lines[] = '- [Home Security](' . esc_url(home_url('/home-security')) . '): Home security systems and monitoring.';
    $lines[] = '- [Landline Providers](' . esc_url(home_url('/landline')) . '): Home phone service providers.';
    $lines[] = '- [Moving Companies](' . esc_url(home_url('/moving')) . '): Moving companies near you.';
    $lines[] = '- [Solar Installers](' . esc_url(home_url('/solar')) . '): Solar panel installers.';
    $lines[] = '- [Insurance](' . esc_url(home_url('/insurance')) . '): Compare insurance rates.';
    $lines[] = '- [Health Insurance](' . esc_url(home_url('/health-insurance')) . '): Compare health insurance plans.';

    $lines[] = '';
    $lines[] = '## State & ZIP Lookup';
    $lines[] = '';
    $lines[] = '- Providers are searchable by state, city, and ZIP code (e.g. /internet/texas/dallas, /internet/tx/75001).';
    $lines[] = '- [Find Providers by ZIP](' . esc_url(home_url('/#search')) . '): Enter a ZIP code to see providers in your area.';

    $lines[] = '';
    $lines[] = '## Contact';
    $lines[] = '';
    $lines[] = '- Email: contact@topproviders.net';
    $lines[] = '- Contact: ' . esc_url(home_url('/contact-us/'));
    $lines[] = '- Service area: United States';

    $lines[] = '';
    $lines[] = '### llms-full.txt';
    $lines[] = '';
    $lines[] = '- [Full llms.txt](' . esc_url(home_url('/llms-full.txt')) . ')';

    return implode("\n", $lines);
}


/**
 * Also serve an optional /llms-full.txt with more detail for LLM crawlers.
 */
add_action('init', function () {
    $request_uri = $_SERVER['REQUEST_URI'] ?? '';
    $path = parse_url($request_uri, PHP_URL_PATH);

    if (rtrim($path, '/') === '/llms-full.txt') {
        nocache_headers();
        header('Content-Type: text/plain; charset=UTF-8');
        echo tp_theme_generate_llms_full_txt();
        exit;
    }
}, 5);

/**
 * Build the llms-full.txt content.
 *
 * @return string
 */
function tp_theme_generate_llms_full_txt() {
    $home = esc_url(home_url('/'));
    $site_name = get_bloginfo('name');

    $out = tp_theme_generate_llms_txt();

    $out .= "\n\n## Full Site Content Overview\n";
    $out .= "\nThis file provides the complete text of the llms.txt file plus additional detail for AI engines.\n";

    // Service landing pages with descriptions
    $services = [
        'internet'        => 'Compare internet providers, plans, speeds, and pricing across the US. Find the best internet deals in your ZIP code.',
        'tv'              => 'Compare TV providers, packages, channel lineups, and pricing. Find the best TV plans in your area.',
        'internet-tv'     => 'Bundle internet and TV services for potential cost savings. Compare bundled plans from top providers.',
        'home-security'   => 'Home security system providers with monitoring, mobile apps, and automation features.',
        'landline'        => 'Landline / home phone service providers with pricing and contract terms.',
        'moving'          => 'Moving companies and relocation services with quotes and rates.',
        'solar'           => 'Solar panel installers with costs, savings, and financing options.',
        'insurance'       => 'Auto and home insurance rates from top insurance providers.',
        'health-insurance'=> 'Health insurance plans with coverage options.',
    ];

    foreach ($services as $slug => $desc) {
        $out .= "\n\n### " . ucwords(str_replace('-', ' ', $slug)) . "\n";
        $out .= $desc . "\n";
        $out .= 'URL: ' . esc_url(home_url('/' . $slug . '/')) . "\n";
    }

    // Top providers (recent posts of type providers)
    $providers = get_posts(array(
        'post_type'      => 'providers',
        'posts_per_page' => 20,
        'post_status'    => 'publish',
    ));

    if ($providers) {
        $out .= "\n\n## Top Providers\n";
        foreach ($providers as $provider) {
            $out .= '- ' . $provider->post_title . ': ' . esc_url(get_permalink($provider->ID)) . "\n";
        }
    }

    return $out;
}