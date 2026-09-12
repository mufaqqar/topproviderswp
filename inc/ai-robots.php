<?php

/**
 * AI Crawler Allow Rules (robots.txt)
 *
 * Explicitly invites Generative AI / Answer engine crawlers so they can
 * index Top Providers content for AEO / GEO.
 *
 * Yoast SEO hijacks the core `robots_txt` filter at priority 99999, so we
 * hook even later (999999) to append after Yoast's output.
 */

/**
 * Append AI bot allowances to the delivered robots.txt.
 *
 * @param string $robots_txt Current robots.txt content.
 * @return string
 */
function tp_theme_ai_robots_append($robots_txt) {
    if (strpos($robots_txt, 'GPTBot') !== false) {
        return $robots_txt;
    }

    $block = PHP_EOL . "
# START TOP PROVIDERS AI CRAWLERS
# Allow Generative AI / Answer engines to index Top Providers content.

User-agent: GPTBot
Allow: /

User-agent: ChatGPT-User
Allow: /

User-agent: OAI-SearchBot
Allow: /

User-agent: ClaudeBot
Allow: /

User-agent: Claude-Web
Allow: /

User-agent: PerplexityBot
Allow: /

User-agent: Perplexity-User
Allow: /

User-agent: Google-Extended
Allow: /

User-agent: Applebot-Extended
Allow: /

User-agent: CCBot
Allow: /

User-agent: Amazonbot
Allow: /

User-agent: Bytespider
Allow: /

User-agent: cohere-ai
Allow: /

User-agent: DuckAssistBot
Allow: /

User-agent: FacebookBot
Allow: /

User-agent: google-data
Allow: /

User-agent: Grokbot
Allow: /

User-agent: KakaoBot
Allow: /

User-agent: Meta-ExternalAgent
Allow: /

User-agent: MojeekBot
Allow: /

User-agent: OtterAi
Allow: /

User-agent: SemrushBot-OCOB
Allow: /

User-agent: Webgpt
Allow: /

User-agent: Yandex
Allow: /
# END TOP PROVIDERS AI CRAWLERS
";

    return str_replace("\n\nSitemap:", "\n" . $block . "\nSitemap:", $robots_txt) . $block;
}
add_filter('robots_txt', 'tp_theme_ai_robots_append', 999999, 2);

/**
 * Fallback robots.txt: if Yoast is not active, serve a minimal robots.txt
 * that allows all AI crawlers and points at the sitemap index.
 */
add_action('init', function () {
    if (class_exists('WPSEO_Frontend') || defined('WPSEO_VERSION')) {
        return;
    }

    $request_uri = $_SERVER['REQUEST_URI'] ?? '';
    $path = parse_url($request_uri, PHP_URL_PATH);

    if ($path === '/robots.txt') {
        header('Content-Type: text/plain; charset=UTF-8');
        echo "User-agent: *\nAllow: /\n\n";
        echo "Sitemap: " . esc_url(home_url('/sitemap_index.xml')) . "\n";
        echo "Sitemap: " . esc_url(home_url('/sitemaps/states.xml')) . "\n";
        exit;
    }
}, 5);