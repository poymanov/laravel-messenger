<script setup>

import {ref, watch} from "vue";
import {usePage} from "@inertiajs/vue3";
import Modal from '@/Components/Modal.vue';
import {debounce} from "lodash";
import PrimaryButton from '@/Components/PrimaryButton.vue';

const showModal = ref(false);
const users = ref([]);
const searchEmail = ref('');

watch(searchEmail, debounce(function (value) {
    if (value.length === 0) {
        users.value = [];
        return;
    }

    const url = route('user.find-all-by-simular-email', {'email': value});

    axios.get(url).then(response => {
        users.value = response.data.filter(user => user.id !== usePage().props.auth.user.id);
    });
}, 300));

function closeModal() {
    showModal.value = false;
    users.value = [];
    searchEmail.value = '';
}

function openModal() {
    showModal.value = true;
}

</script>

<template>
    <div class="header p-4 flex flex-row justify-between items-center flex-none border-right border-gray-200 border-r-2">
        <a href="#" @click="openModal" class="ml-auto text-white block rounded-full hover:bg-gray-700 bg-gray-800 w-10 h-10 p-2 hidden md:block group-hover:block">
            <svg viewBox="0 0 24 24" class="w-full h-full fill-current">
                <path
                    d="M6.3 12.3l10-10a1 1 0 0 1 1.4 0l4 4a1 1 0 0 1 0 1.4l-10 10a1 1 0 0 1-.7.3H7a1 1 0 0 1-1-1v-4a1 1 0 0 1 .3-.7zM8 16h2.59l9-9L17 4.41l-9 9V16zm10-2a1 1 0 0 1 2 0v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2h6a1 1 0 0 1 0 2H4v14h14v-6z"/>
            </svg>
        </a>
    </div>

    <Modal :show="showModal" maxWidth="md" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-2">
                Add chat
            </h2>

            <form @submit.prevent="" class="mb-5">
                <div class="relative">
                    <label>
                        <input v-model="searchEmail" class="rounded-full py-2 pr-6 pl-10 w-full border border-gray-800 focus:border-gray-200 focus:bg-gray-100 focus:outline-none text-black focus:shadow-md transition duration-300 ease-in"
                               type="text" placeholder="Search user"/>
                        <span class="absolute top-0 left-0 mt-2 ml-3 inline-block">
                                    <svg viewBox="0 0 24 24" class="w-6 h-6">
                                        <path fill="#bbb"
                                              d="M16.32 14.9l5.39 5.4a1 1 0 0 1-1.42 1.4l-5.38-5.38a8 8 0 1 1 1.41-1.41zM10 16a6 6 0 1 0 0-12 6 6 0 0 0 0 12z"/>
                                    </svg>
                                </span>
                    </label>
                </div>
            </form>

            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                <li v-for="user in users" class="py-3 sm:py-4 px-2 hover:bg-gray-100 rounded-lg">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                {{ user.name }}
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                {{ user.email }}
                            </p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">

                        </div>
                    </div>
                </li>
            </ul>

            <div class="flex justify-end">
                <PrimaryButton @click="closeModal">Cancel</PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
