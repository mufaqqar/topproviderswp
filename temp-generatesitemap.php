<?php
/** Template Name: Sitemap Generator */
get_header();
?>

<div class="container mx-auto px-4 py-10">
    <h1 class="text-2xl font-bold mb-6">Regenerating Sitemaps...</h1>
    <pre class="bg-gray-100 p-4 rounded text-sm">
<?php
echo "Generating state sitemaps...\n";
SiteMapByState();
echo "State sitemap done.\n\n";

echo "Generating city sitemaps...\n";
SiteMapByCity();
echo "City sitemaps done.\n\n";

echo "Generating zipcode sitemaps...\n";
SiteMapByZipCode();
echo "Zipcode sitemaps done.\n\n";

echo "Generating zone sitemap...\n";
generate_custom_sitemap();
echo "Zone sitemap done.\n\n";

echo '<strong class="text-green-600">All sitemaps regenerated successfully!</strong>';
?>
    </pre>
    <p class="mt-4"><a href="<?php echo home_url('/zone_sitemap.xml'); ?>" class="text-brand-purple underline">View zone_sitemap.xml</a></p>
</div>

<?php get_footer(); ?>