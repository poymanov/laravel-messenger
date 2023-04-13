<script setup>

import AddChat from '@/Components/AddChat.vue';
import {Link} from "@inertiajs/vue3";
import Contacts from '@/Components/Contacts.vue';

</script>

<template>
    <!-- Messenger Clone -->
    <div class="h-screen w-full flex antialiased text-gray-200 bg-white overflow-hidden">
        <div class="flex-1 flex flex-col">
            <main class="flex-grow flex flex-row min-h-0">
                <section class="flex flex-col flex-none overflow-auto w-24 hover:w-64 group lg:max-w-sm md:w-2/5 transition-all duration-300 ease-in-out">
                    <div class="header p-2 flex flex-row justify-between items-center flex-none">
                        <div class="relative flex flex-shrink-0">
                            <Link :href="route('profile.edit')">
                                <img class="rounded-full" alt=""
                                     src="https://www.gravatar.com/avatar/00000000000000000000000000000000?s=50"/>
                            </Link>
                        </div>
                        <p class="text-md font-bold hidden text-black md:block group-hover:block">Messenger</p>
                        <AddChat/>
                    </div>
                    <Contacts />
                </section>
                <section class="flex flex-col flex-auto">
                    <slot/>
                </section>
            </main>
        </div>
    </div>
</template>

<style>
.group:hover .group-hover\:block {
    display: block;
}

.hover\:w-64:hover {
    width: 45%;
}
</style>
