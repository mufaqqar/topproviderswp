<?php
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['SERVER_NAME'] = 'localhost';

require_once 'D:/wamp64/www/topproviders/wp-load.php';

echo "Starting sitemap generation...\n\n";

echo "--- State sitemap ---\n";
SiteMapByState();
echo "Done.\n\n";

echo "--- City sitemaps ---\n";
SiteMapByCity();
echo "Done.\n\n";

echo "--- Zipcode sitemaps ---\n";
SiteMapByZipCode();
echo "Done.\n\n";

echo "--- Zone sitemap ---\n";
if (function_exists('generate_custom_sitemap')) {
    generate_custom_sitemap();
    echo "Done.\n";
}

echo "\nAll sitemaps generated successfully!\n";
