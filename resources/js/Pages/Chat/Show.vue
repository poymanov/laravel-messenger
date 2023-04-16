<script setup>
import MessengerLayout from '@/Layouts/MessengerLayout.vue';
import {Head} from '@inertiajs/vue3';
import NewMessage from '@/Components/Chat/NewMessage.vue';
import {usePage} from "@inertiajs/vue3";
import MessagesList from '@/Components/Chat/MessagesList.vue';

const props = defineProps({
    username: {
        type: String,
        required: true
    },
    avatar_url: {
        type: String,
        required: true
    },
    messages: {
        type: Object,
        required: true
    }
});

function addSentMessage(newMessage) {
    if (newMessage.date in props.messages) {
        props.messages[newMessage.date].messages.push(newMessage.message);
    } else {
        props.messages[newMessage.date] = {
            title: newMessage.title,
            messages: [newMessage.message]
        }
    }
}

</script>

<template>
    <Head title="Chat"/>

    <MessengerLayout>
        <div class="chat-header text-black px-6 py-4 flex flex-row flex-none justify-between items-center shadow">
            <div class="flex">
                <div class="w-12 h-12 mr-4 relative flex flex-shrink-0">
                    <img class="shadow-md rounded-full w-full h-full object-cover" :src="avatar_url" alt="">
                </div>
                <div class="text-sm">
                    <p class="font-bold">{{ username }}</p>
                </div>
            </div>
        </div>
        <div class="chat-body p-4 flex-1 overflow-y-scroll">
            <MessagesList :messages="messages"/>
        </div>
        <div class="chat-footer flex-none">
            <div class="flex flex-row items-center p-4">
                <div class="relative flex-grow">
                    <NewMessage @messageAdded="addSentMessage" :current-chat-id="usePage().props.currentChatId"/>
                </div>
            </div>
        </div>
    </MessengerLayout>
</template>
