<form class="w-full flex items-center max-w-lg mx-auto" action="<?php echo esc_url(home_url('/result')); ?>" method="get">
    <label for="zipcode" class="sr-only">Enter ZIP code</label>
    <div class="relative w-full">
        <input type="text" id="zipcode" name="zipcode"
            class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-3"
            placeholder="Enter your ZIP code..." required pattern="[0-9]{5}" maxlength="5" />
    </div>
    <button type="submit"
        class="inline-flex items-center py-3 px-5 ml-2 text-sm font-medium text-white bg-[#96B93A] rounded-lg border border-[#96B93A] hover:bg-[#7a9a2e] focus:ring-4 focus:outline-none focus:ring-blue-300">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
        </svg>
        Search
    </button>
</form>
