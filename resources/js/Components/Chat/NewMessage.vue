<script setup>

import {ref} from "vue";

const text = ref('');

const props = defineProps({
    currentChatId: {
        type: String,
        required: true
    },
});

function sendMessage() {
    const url = route('chat-messages.store', {'chat_id': props.currentChatId, 'text': text.value});

    axios.post(url).then(() => text.value = '').catch(error => console.log(error.message));
}

</script>

<template>
    <form @submit.prevent="sendMessage">
        <label>
            <input v-model="text" class="rounded-full py-2 pl-3 pr-10 w-full border text-black border-gray-200 focus:border-gray-200 bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-md transition duration-300 ease-in"
                   type="text" placeholder="Aa"/>
        </label>
    </form>
</template>
