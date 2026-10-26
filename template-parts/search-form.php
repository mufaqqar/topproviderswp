<?php
$form_id = wp_unique_id('tp-search-form-');
?>
<div>
    <form id="<?php echo esc_attr($form_id); ?>" class="tp-search-form" method="post" action="<?php echo esc_url(home_url('/')); ?>" role="search">
        <div class="rounded-2xl shadow-xl w-full sm:w-auto">
            <div class="relative gap-2 flex sm:pl-3 items-center sm:rounded-2xl w-full m-auto border sm:border-none border-gray-300 bg-gray-100 serch_form">
                <div class="flex items-center flex-1 w-full">
                    <svg
                        stroke="currentColor"
                        fill="none"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="absolute text-2xl sm:text-3xl ml-2 sm:ml-1 text-[#6041BB]"
                        height="1em"
                        width="1em"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true"
                    >
                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                        <circle cx="12" cy="10" r="3"></circle>
                    </svg>
                    <label for="<?php echo esc_attr($form_id); ?>-zip" class="sr-only">ZIP code</label>
                    <input type="text" placeholder="Enter ZIP code" maxlength="5" id="<?php echo esc_attr($form_id); ?>-zip" name="zip_code" class="w-full py-3 sm:py-5 pl-10 pr-8 outline-none md:w-80 bg-transparent rounded-l-md" value="" inputmode="numeric" pattern="[0-9]{5}" autocomplete="postal-code" required />
                </div>
                <input type="hidden" name="customSelect" value="internet" />
                <button class="px-3 md:px-8 py-3 sm:py-[20px] font-semibold text-white bg-[#6041BB] border-[#6041BB] sm:rounded-br-2xl sm:rounded-r-2xl" type="submit">Check Availability</button>
            </div>
        </div>
        <fieldset class="flex justify-center border-0 p-0 m-0 min-w-0">
            <legend class="sr-only">Choose a service type</legend>
            <div class="flex flex-wrap items-center gap-3 my-4 justify-center">
                <label for="<?php echo esc_attr($form_id); ?>-internet" class="flex items-center rounded-md transition gap-2 cursor-pointer">
                    <input type="radio" name="provider-types" value="internet" id="<?php echo esc_attr($form_id); ?>-internet" class="w-5 h-5 text-blue-500" checked />
                    <span class="text-base font-medium truncate">Internet</span>
                </label>
                <label for="<?php echo esc_attr($form_id); ?>-tv" class="flex items-center rounded-md transition gap-2 cursor-pointer">
                    <input type="radio" name="provider-types" value="tv" id="<?php echo esc_attr($form_id); ?>-tv" class="w-5 h-5 text-blue-500" />
                    <span class="text-base font-medium truncate">TV</span>
                </label>
                <label for="<?php echo esc_attr($form_id); ?>-internet-tv" class="flex items-center rounded-md transition gap-2 cursor-pointer">
                    <input type="radio" name="provider-types" value="internet-tv" id="<?php echo esc_attr($form_id); ?>-internet-tv" class="w-5 h-5 text-blue-500" />
                    <span class="text-base font-medium truncate">Internet & TV</span>
                </label>
                <label for="<?php echo esc_attr($form_id); ?>-moving" class="flex items-center rounded-md transition gap-2 cursor-pointer">
                    <input type="radio" name="provider-types" value="moving" id="<?php echo esc_attr($form_id); ?>-moving" class="w-5 h-5 text-blue-500" />
                    <span class="text-base font-medium truncate">Moving</span>
                </label>
                <label for="<?php echo esc_attr($form_id); ?>-solar" class="flex items-center rounded-md transition gap-2 cursor-pointer">
                    <input type="radio" name="provider-types" value="solar" id="<?php echo esc_attr($form_id); ?>-solar" class="w-5 h-5 text-blue-500" />
                    <span class="text-base font-medium truncate">Solar</span>
                </label>
                <label for="<?php echo esc_attr($form_id); ?>-insurance" class="flex items-center rounded-md transition gap-2 cursor-pointer">
                    <input type="radio" name="provider-types" value="insurance" id="<?php echo esc_attr($form_id); ?>-insurance" class="w-5 h-5 text-blue-500" />
                    <span class="text-base font-medium truncate">Insurance</span>
                </label>
                <label for="<?php echo esc_attr($form_id); ?>-health-insurance" class="flex items-center rounded-md transition gap-2 cursor-pointer">
                    <input type="radio" name="provider-types" value="health-insurance" id="<?php echo esc_attr($form_id); ?>-health-insurance" class="w-5 h-5 text-blue-500" />
                    <span class="text-base font-medium truncate">Health</span>
                </label>
            </div>
        </fieldset>
        <p class="text-center text-xs opacity-80">Free to use. No obligation. Compare providers available in your ZIP code.</p>
    </form>
</div>
