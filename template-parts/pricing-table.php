<?php
/**
 * Pricing Table Component
 *
 * Usage:
 *   set_query_var('table_title', 'Internet Plans');
 *   set_query_var('table_columns', ['Provider', 'Speed', 'Price', 'Order']);
 *   set_query_var('table_data', $array_of_rows);
 *   set_query_var('table_bg', '#6041BB'); // optional, defaults to brand-purple
 *   get_template_part('template-parts/pricing-table');
 *
 * Each row in table_data is an array of cell values.
 * For a "Join Us" button cell, set value to array('type' => 'button', 'url' => '/path', 'text' => 'Join Us')
 */

$table_title = get_query_var('table_title', '');
$table_columns = get_query_var('table_columns', array());
$table_data = get_query_var('table_data', array());
$table_bg = get_query_var('table_bg', '#6041BB');

if (empty($table_columns) || empty($table_data)) return;

$col_count = count($table_columns);
$grid_cols = 'md:grid-cols-' . $col_count;
?>

<section class="my-16">
    <div class="container-section">
        <?php if ($table_title) : ?>
        <div class="mb-10">
            <h2 class="text-2xl font-bold"><?php echo esc_html($table_title); ?></h2>
        </div>
        <?php endif; ?>
        <div class="table-wrapper">
            <div class="w-full h-auto shadow-xl border rounded-t-md rounded-b-md">
                <div class="md:w-full min-w-fit grid <?php echo $grid_cols; ?> grid-cols-1"
                    style="background-color: <?php echo esc_attr($table_bg); ?>">
                    <?php foreach ($table_columns as $col) : ?>
                    <div class="table-header-cell">
                        <h4 class="table-header-text font-bold"><?php echo esc_html($col); ?></h4>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php foreach ($table_data as $row) : ?>
                <div class="w-full flex md:flex-row flex-col dtable">
                    <div class="w-full grid <?php echo $grid_cols; ?>">
                        <?php foreach ($row as $cell) : ?>
                        <div class="table-cell">
                            <?php if (is_array($cell) && isset($cell['type']) && $cell['type'] === 'button') : ?>
                            <a href="<?php echo esc_url($cell['url']); ?>"
                               class="text-white bg-brand-green hover:bg-brand-purple text-center text-sm px-4 py-2 rounded-lg block"><?php echo esc_html($cell['text']); ?></a>
                            <?php else : ?>
                            <p class="table-cell-text"><?php echo esc_html(is_array($cell) ? '' : $cell); ?></p>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
