<?php
$query_compair = get_query_var('providers_query');
if (!$query_compair || !$query_compair->have_posts()) return;
$type = get_query_var('type', 'internet');
$city = get_query_var('zone_city', '');
?>
<section class="my-16">
    <div class="container mx-auto px-4">
        <div class="mb-10">
            <h2 class="text-2xl font-bold">Compare <?php echo esc_html($type); ?> Providers in <span class="text-[#96B93A]"><?php echo esc_html(FormatData($city)); ?></span></h2>
            <p>Still can't decide? Use our side-by-side comparison chart to make an informed decision.</p>
        </div>
        <div>
            <div class="w-full mx-auto h-auto mb-6">
                <div class="w-full h-auto shadow-xl border rounded-t-md rounded-b-md flex md:flex-row flex-row items-stretch">
                    <div class="md:w-96 min-w-[50px] bg-[#6041BB]">
                        <div class="md:border-r border-r-0 border-b grid justify-center md:p-5 p-2 md:h-auto h-[120px] items-center">
                            <div><h4 class="md:text-base text-xs text-center text-white">Provider</h4></div>
                        </div>
                        <div class="md:border-r border-r-0 border-b grid justify-center md:p-5 p-2 md:h-auto h-[120px] items-center">
                            <div><h4 class="md:text-base text-xs text-center text-white">Connection Type</h4></div>
                        </div>
                        <div class="md:border-r border-r-0 border-b grid justify-center md:p-5 p-2 md:h-auto h-[120px] items-center">
                            <div><h4 class="md:text-base text-xs text-center text-white">Max Download Speed</h4></div>
                        </div>
                        <div class="md:border-r border-r-0 border-b grid justify-center md:p-5 p-2 md:h-auto h-[120px] items-center">
                            <div><h4 class="md:text-base text-xs text-center text-white">Data Caps</h4></div>
                        </div>
                        <div class="md:border-r border-r-0 border-b grid justify-center md:p-5 p-2 md:h-auto h-[120px] items-center">
                            <div><h4 class="md:text-base text-xs text-center text-white">Contract Term</h4></div>
                        </div>
                        <div class="md:border-r border-r-0 border-b grid justify-center md:p-5 p-2 md:h-auto h-[120px] items-center">
                            <div><h4 class="md:text-base text-xs text-center text-white">Setup Fee</h4></div>
                        </div>
                        <div class="md:border-r border-r-0 border-b grid justify-center md:p-5 p-2 md:h-auto h-[120px] items-center">
                            <div><h4 class="md:text-base text-xs text-center text-white">Early Termination Fee</h4></div>
                        </div>
                        <div class="md:border-r border-r-0 border-b grid justify-center md:p-5 p-2 md:h-auto h-[120px] items-center">
                            <div><h4 class="md:text-base text-xs text-center text-white">Equipment Rental Fee</h4></div>
                        </div>
                        <div class="md:border-r border-r-0 border-b grid justify-center md:p-5 p-2 md:h-auto h-[120px] items-center">
                            <div><h4 class="md:text-base text-xs text-center text-white">Monthly Price</h4></div>
                        </div>
                        <div class="md:border-r border-r-0 border-b grid justify-center md:p-5 p-2 md:h-auto h-[120px] items-center">
                            <div><h4 class="md:text-base text-xs text-center text-white">Order Now</h4></div>
                        </div>
                    </div>
                    <div class="flex flex-row w-full md:overflow-hidden overflow-x-scroll">
                        <?php
                            $i = 0;
                            while ($query_compair->have_posts()) {
                                $query_compair->the_post();
                                $i++;
                                set_query_var('provider_index', $i);
                                $servicesInfo = get_field('services_info');
                                $type = get_query_var('type');

                                if ($type === 'tv') {
                                    $services = isset($servicesInfo['tv_services']) ? $servicesInfo['tv_services'] : array();
                                } elseif ($type === 'landline') {
                                    $services = isset($servicesInfo['landline_services']) ? $servicesInfo['landline_services'] : array();
                                } elseif ($type === 'home-security') {
                                    $services = isset($servicesInfo['home_security_services']) ? $servicesInfo['home_security_services'] : array();
                                } else {
                                    $services = isset($servicesInfo['internet_services']) ? $servicesInfo['internet_services'] : array();
                                }

                                $speed = isset($services['summary_speed']) ? $services['summary_speed'] : '';
                                $price = isset($services['price']) ? $services['price'] : '';
                                $setup_fee = isset($services['setup_fee']) ? $services['setup_fee'] : '';
                                $connection_type = isset($services['connection_type']) ? $services['connection_type'] : '';
                                $early_termination_fee = isset($services['early_termination_fee']) ? $services['early_termination_fee'] : '';
                                $equipment_rental_fee = isset($services['equipment_rental_fee']) ? $services['equipment_rental_fee'] : '';
                                $contract = isset($services['contract']) ? $services['contract'] : '';
                                $data_caps = isset($services['data_caps']) ? $services['data_caps'] : '';
                        ?>
                        <div class="min-w-[120px] md:w-full dtable">
                            <div class="w-full md:border-r border-r-0 border-b grid justify-center md:p-5 p-2 md:h-auto h-[120px] items-center">
                                <div><p class="text-center md:text-base text-xs"><?php the_title(); ?></p></div>
                            </div>
                            <div class="w-full md:border-r border-r-0 border-b grid justify-center md:p-5 p-2 md:h-auto h-[120px] items-center">
                                <div><p class="text-center md:text-base text-xs"><?php echo esc_html($connection_type); ?></p></div>
                            </div>
                            <div class="w-full md:border-r border-r-0 border-b grid justify-center md:p-5 p-2 md:h-auto h-[120px] items-center">
                                <div><p class="text-center md:text-base text-xs"><?php echo esc_html($speed); ?><?php if ($type === 'internet') echo ' Mbps'; ?></p></div>
                            </div>
                            <div class="w-full md:border-r border-r-0 border-b grid justify-center md:p-5 p-2 min-h-[64.8px] items-center md:col-span-3">
                                <div><p class="text-center md:text-base text-xs"><?php echo esc_html($connection_type); ?></p></div>
                            </div>
                            <div class="w-full grid justify-center md:p-5 p-2 min-h-[64.8px] items-center">
                                <div><p class="text-center md:text-base text-xs"><?php echo esc_html($data_caps); ?></p></div>
                            </div>
                            <div class="w-full grid justify-center md:p-5 p-2 min-h-[64.8px] items-center">
                                <div><p class="text-center md:text-base text-xs"><?php echo esc_html($contract); ?></p></div>
                            </div>
                            <div class="w-full grid justify-center md:p-5 p-2 min-h-[64.8px] items-center">
                                <div><p class="text-center md:text-base text-xs"><?php echo esc_html($setup_fee); ?></p></div>
                            </div>
                            <div class="w-full grid justify-center md:p-5 p-2 min-h-[64.8px] items-center">
                                <div><p class="text-center md:text-base text-xs"><?php echo esc_html($early_termination_fee); ?></p></div>
                            </div>
                            <div class="w-full grid justify-center md:p-5 p-2 min-h-[64.8px] items-center">
                                <div><p class="text-center md:text-base text-xs"><?php echo esc_html($equipment_rental_fee); ?></p></div>
                            </div>
                            <div class="w-full grid justify-center md:p-5 p-2 min-h-[64.8px] items-center">
                                <div><p class="text-center md:text-base text-xs">$<?php echo esc_html($price); ?></p></div>
                            </div>
                            <div class="w-full grid justify-center md:p-5 p-2 min-h-[64.8px] items-center">
                                <div><p class="text-center md:text-base text-xs"><a href="<?php the_permalink(); ?>">View Plans</a></p></div>
                            </div>
                        </div>
                        <?php
                            }
                            wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
