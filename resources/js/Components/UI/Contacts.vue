<script setup>
import {usePage, Link } from "@inertiajs/vue3";
import {onMounted, onUnmounted, watch} from "vue";
import {debounce} from "lodash";

const currentChatId = usePage().props.currentChatId;
const currentAuthUserId = usePage().props.auth.user.id;
const websocketChatChannel = `user.${currentAuthUserId}`;

watch(usePage().props.chats, debounce(() => {
    usePage().props.chats.sort((itemFirst, itemSecond) =>  itemSecond.last_message_created_at - itemFirst.last_message_created_at);
}), 300);

onMounted(() => {
    Echo
        .private(websocketChatChannel)
        .listen('.new-message', (newMessage) => {
            const newMessageChatId = newMessage.message.chat_id;
            if (currentChatId === newMessageChatId) {
                return;
            }

            const newMessageChats = usePage().props.chats.filter(chat => chat.chat_id === newMessageChatId);

            if (newMessageChats.length === 0) {
                return;
            }

            newMessageChats[0].not_read++;
            newMessageChats[0].last_message_text = newMessage.message.text;
        });
});

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
                <div v-if="chat.is_online" class="absolute p-1 rounded-full bottom-0 right-0">
                    <div class="bg-green-500 rounded-full w-3 h-3"></div>
                </div>
            </div>
            <div class="flex-auto min-w-0 ml-4 mr-6 hidden md:block group-hover:block">
                <Link :href="route('chats.show', {'id': chat.chat_id})">
                    <p>{{ chat.username }}</p>
                </Link>
                <div class="flex items-center text-sm text-gray-600">
                    <div class="min-w-0 mr-auto">
                        <p class="truncate">{{ chat.last_message_text }}</p>
                    </div>
                </div>
            </div>
            <div v-if="chat.not_read">
                <div class="bg-blue-700 py-1 px-3 text-sm text-white rounded-full md:block group-hover:block">
                    {{ chat.not_read }}
                </div>
            </div>
        </div>
    </div>
</template>
