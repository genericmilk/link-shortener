
<script setup>
    import { router } from '@inertiajs/vue3';

    defineProps(['links']);

    const deleteLink = (link) => {
        if(confirm('Are you sure you want to delete this link?')) {

            router.delete(route('links.destroy', link),{
                preserveScroll: true,
                preserveState: true,
                preserveQuery: true,
                onSuccess: () => {
                    alert('Link deleted successfully.');
                },
                onError: (error) => {
                    console.log(error);
                    alert('An error occurred (Probably not a good look on a technical test!!). Please try again.');
                }
            })

        }
    };


</script>
<template>
    <div class="px-4 sm:px-6 lg:px-8">

        <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full divide-y divide-gray-900">
                    <thead>
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-100 sm:pl-0">URL</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-100">Website URL</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-100">Created</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                            <span class="sr-only">Manage</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-900">
                        <tr v-for="link in links" :key="link.email">
                            <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                            <div class="flex items-center">
                                <div class="size-11 shrink-0">
                                    <img class="size-11 rounded-full" :src="link.thumbnail" alt="" />
                                </div>
                                <div class="ml-4">
                                <div class="font-medium text-gray-100"><a :href="link.url" target="_blank">{{ link.url }}</a></div>
                                </div>
                            </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-300"><a :href="link.short_url" target="_blank">{{ link.short_url }}</a></td>
                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-300">{{ link.created_ago }}</td>
        

                            <td class="relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <a @click="deleteLink(link)" class="text-indigo-600 hover:text-indigo-900 cursor-pointer">Delete<span class="sr-only">, {{ link.name }}</span></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </div>

    </div>
</template>