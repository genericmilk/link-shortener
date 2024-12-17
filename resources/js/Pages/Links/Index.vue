<script setup>
import { defineProps, ref } from 'vue';

import AppLayout from '@/Layouts/AppLayout.vue';
import LinksList from '@/Pages/Links/Components/List.vue';
import NewLinkModal from '@/Pages/Links/Components/NewLinkModal.vue';


defineProps({
    links: Object,
});

const showingNewLinkModal = ref(false);

const openModal = () => {
    showingNewLinkModal.value = true;
};

const closeModal = () => {
    showingNewLinkModal.value = false;
};

</script>

<template>
    <AppLayout title="My Links">
        <template #header>

            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    My Links
                </h2>
                <div>
                    <button type="button" @click="openModal" class="rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add New Link</button>
                </div>

            </div>



        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                    <LinksList :links="links" v-if="links.length>0" />
                    <div v-else class="p-6 text-center text-gray-500 dark:text-gray-200">
                        <h2 class="font-semibold text-xl">Welcome to the Link Shortener App 🎉</h2>
                        <p class="mt-2">
                            Click on the button above to add a new link or why not try out the API 👀
                        </p>
                    </div>  
                </div>
            </div>
        </div>

        <NewLinkModal :show="showingNewLinkModal" @close="closeModal" />
    </AppLayout>
</template>
