<script setup>
import MessengerLayout from '@/Layouts/MessengerLayout.vue';

import {Head} from '@inertiajs/vue3';
</script>

<template>
    <Head title="Chat"/>

    <MessengerLayout>
        <div class="chat-header text-black px-6 py-4 flex flex-row flex-none justify-between items-center shadow">
            <div class="flex">
                <div class="text-sm">
                    <p class="font-bold">User</p>
                </div>
            </div>
        </div>
        <div class="chat-body p-4 flex-1 overflow-y-scroll">

        </div>
        <div class="chat-footer flex-none">
            <div class="flex flex-row items-center p-4">
                <div class="relative flex-grow">
                    <label>
                        <input class="rounded-full py-2 pl-3 pr-10 w-full border border-gray-200 focus:border-gray-200 bg-gray-200 focus:bg-gray-200 focus:outline-none text-gray-200 focus:shadow-md transition duration-300 ease-in"
                               type="text" value="" placeholder="Aa"/>
                    </label>
                </div>
            </div>
        </div>
    </MessengerLayout>
</template>
