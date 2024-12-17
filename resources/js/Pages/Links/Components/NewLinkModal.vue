<script setup>
import {reactive,computed} from 'vue';
import {router} from '@inertiajs/vue3';

import DialogModal from '@/Components/DialogModal.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import axios from 'axios';

const emit = defineEmits(['close']);

const props = defineProps({
    showNewTopicModal: Boolean,
});

const form = reactive({
    values: {
        url: '',    
    },
    errorText: '',
    processing: false,
});


// methods
const closeAndClear = () => {
    console.log('closeAndClear');
    form.errorText = '';
    form.processing = false;
    form.values.url = '';
    emit('close');
};

const createNewLink = () => {
    if(form.processing) return;
    
    form.processing = true;
    let values = form.values;
    // are any values null? if so, set error

    if (!values.url) {
        form.errorText = 'Please complete all fields';
        form.processing = false;        
        return;
    }

    axios.post(route('links.store', {
        url: values.url
    })).then((response) => {
        closeAndClear();
        router.reload();
    }).catch((error) => {
        console.log(error);
        let message = error.response.data.message || 'An error occurred (Probably not a good look on a technical test!!). Please try again.';
        form.errorText = message;
        form.processing = false;
    });


};



</script>
<template>
    <!-- Add new client Modal -->
    <DialogModal :show="showNewTopicModal">
        <template #title>
            Add New Link
        </template>

        <template #content>
            Please enter the URL of the new link you would like to add to your My Links page.

            <div class="mt-4">
                <InputLabel for="topic" value="Link URL" />                    
                <TextInput
                    label="Search topic"
                    class="mt-1 block w-full"
                    placeholder="Link URL"
                    id="name"
                    v-model="form.values.url"
                    v-on:keyup.enter="createNewLink"
                    :disabled="form.processing"
                    :error="form.errorText"
                />          
            </div>


            <InputError :message="form.errorText" class="mt-4" />



        </template>

        <template #footer>
            <SecondaryButton @click="closeAndClear" :disabled="form.processing">
                Cancel
            </SecondaryButton>

            <PrimaryButton
                class="ms-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="createNewLink"
            >
                Add New Link
            </PrimaryButton>
        </template>
    </DialogModal>
</template>
