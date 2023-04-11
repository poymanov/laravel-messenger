<script setup>

import HeaderNavigation from '@/Layouts/Common/HeaderNavigation.vue';
import AddChat from '@/Components/AddChat.vue';

</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <HeaderNavigation/>

            <div class="h-screen w-full flex antialiased bg-white overflow-hidden">
                <div class="flex-1 flex flex-col">
                    <main class="flex-grow flex flex-row min-h-0">
                        <section class="flex flex-col flex-none overflow-auto w-24 hover:w-64 group lg:max-w-sm md:w-2/5 transition-all duration-300 ease-in-out">
                            <AddChat />
                            <div class="contacts p-2 flex-1 overflow-y-scroll">
                            </div>
                        </section>
                        <section class="flex flex-col flex-auto">
                            <div class="chat-body p-4 flex-1 overflow-y-scroll">
                                <slot/>
                            </div>
                        </section>
                    </main>
                </div>
            </div>
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
