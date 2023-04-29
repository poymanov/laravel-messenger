<script setup>
import MessengerLayout from '@/Layouts/MessengerLayout.vue';
import NewMessage from '@/Components/Chat/NewMessage.vue';
import {usePage, Head, Link} from "@inertiajs/vue3";
import MessagesList from '@/Components/Chat/MessagesList.vue';
import {onMounted, ref, watch, computed} from "vue";
import {debounce} from "lodash";
import Modal from '@/Components/UI/Modal.vue';
import DangerButton from '@/Components/UI/DangerButton.vue';

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    messages: {
        type: Object,
        required: true
    }
});

const chatBody = ref(null);
const showModal = ref(false);
const currentChatId = usePage().props.currentChatId;

const userProfileAvatarUrl = computed(() => {
    const avatarUrl = new URL(props.user.avatar_url);
    avatarUrl.search = 's=200';
    return avatarUrl;
});

const userStatus = computed(() => {
    if (props.user.is_online) {
        return 'Online';
    }

    if (props.user.last_activity_at) {
        return 'Active ' + props.user.last_activity_at;
    }

    return 'Not active yet';
});

onMounted(() => {
    chatBody.value.scrollTop = chatBody.value.scrollHeight;
});

watch(props.messages, debounce(() => {
    let items = document.getElementsByClassName('chat-message');
    let lastItem = items[items.length - 1];
    lastItem.scrollIntoView({behavior: "smooth", block: "end", inline: "nearest"});
}), 300);

function addSentMessage(newMessage) {
    if (newMessage.date in props.messages) {
        props.messages[newMessage.date].messages.push(newMessage.message);
    } else {
        props.messages[newMessage.date] = {
            title: newMessage.title,
            messages: [newMessage.message]
        }
    }

    const currentChat = usePage().props.chats.find(chat => chat.chat_id === usePage().props.currentChatId);
    currentChat.last_message_text = newMessage.message.text;
    currentChat.last_message_created_at = newMessage.created_at;
}

function closeModal() {
    showModal.value = false;
}

function openModal() {
    showModal.value = true;
}

</script>

<template>
    <Head :title="`Chat with ` + user.name"/>

    <MessengerLayout>
        <div class="chat-header text-black px-6 py-4 flex flex-row flex-none justify-between items-center shadow">
            <div class="flex">
                <div class="w-12 h-12 mr-4 relative flex flex-shrink-0">
                    <img class="shadow-md rounded-full w-full h-full object-cover" :src="user.avatar_url" alt="">
                </div>
                <div class="text-sm">
                    <p class="font-bold cursor-pointer" @click="openModal">{{ user.name }}</p>
                    <p>{{ userStatus }}</p>
                </div>
            </div>
        </div>
        <div ref="chatBody" class="chat-body p-4 flex-1 overflow-y-scroll">
            <MessagesList :messages="messages"/>
        </div>
        <div class="chat-footer flex-none">
            <div class="flex flex-row items-center p-4">
                <div class="relative flex-grow">
                    <NewMessage @messageAdded="addSentMessage" :current-chat-id="usePage().props.currentChatId"/>
                </div>
            </div>
        </div>

        <Modal :show="showModal" maxWidth="md" @close="closeModal">
            <div class="p-6">
                <div class="flex mb-2">
                    <div class="w-20 h-20 mr-4 relative flex flex-shrink-0">
                        <img class="shadow-md rounded-full w-full h-full object-cover" :src="userProfileAvatarUrl" alt="">
                    </div>
                    <div class="text-lg">
                        <p class="font-bold cursor-pointer" @click="openModal">{{ user.name }}</p>
                        <p>{{ userStatus }}</p>
                    </div>
                </div>
                <div class="py-2">
                    <hr>
                </div>
                <div>
                    <b>Email:</b> {{ user.email }}
                </div>
                <div class="py-2">
                    <hr>
                </div>
                <div class="py-2">
                    <DangerButton>
                        <Link
                            :href="route('chats.destroy', currentChatId)"
                            method="delete"
                            as="button">
                            Delete Chat
                        </Link>
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </MessengerLayout>
</template>
