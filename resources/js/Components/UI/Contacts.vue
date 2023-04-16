<script setup>
    import {usePage, Link } from "@inertiajs/vue3";
    const currentChatId = usePage().props.currentChatId;
</script>

<template>
    <div class="contacts p-2 flex-1 overflow-y-scroll text-black">
        <div
            v-for="chat in usePage().props.chats"
            class="flex justify-between items-center p-3 hover:bg-gray-100 rounded-lg relative"
            :class="{'bg-gray-100': chat.chat_id === currentChatId }"
        >
            <div class="w-16 h-16 relative flex flex-shrink-0">
                <img class="shadow-md rounded-full w-full h-full object-cover"
                     :src="chat.avatar_url"
                     alt=""
                />
            </div>
            <div class="flex-auto min-w-0 ml-4 mr-6 hidden md:block group-hover:block">
                <Link :href="route('chats.show', {'id': chat.chat_id})">
                    <p>{{ chat.username }}</p>
                </Link>
            </div>
        </div>
    </div>
</template>
