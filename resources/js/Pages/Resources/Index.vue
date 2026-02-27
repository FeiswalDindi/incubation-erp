<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({ resources: Array });
const page = usePage();
const roles = computed(() => page.props.auth.roles);
const isOfficeStaff = computed(() => roles.value.includes('Assistant') || roles.value.includes('Intern') || roles.value.includes('Incubation Officer'));

const form = useForm({
    title: '',
    url: '',
    category: 'Google Drive Folder',
});

const submit = () => {
    form.post(route('resources.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};

const deleteResource = (id) => {
    if (confirm('Are you sure you want to remove this link from the directory?')) {
        form.delete(route('resources.destroy', id), { preserveScroll: true });
    }
};

const getIconForCategory = (category) => {
    if (category === 'Google Drive Folder') return 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z';
    if (category === 'Template / Document') return 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z';
    return 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1'; // Link icon
};
</script>

<template>
    <Head title="File Directory" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link :href="route('dashboard')" class="text-gray-400 hover:text-kca-navy transition-colors bg-white p-2 rounded-full shadow-sm border border-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </Link>
                <h2 class="text-2xl font-bold leading-tight text-kca-navy tracking-tight">
                    Incubation File Directory
                </h2>
            </div>
        </template>

        <div class="py-12 bg-gray-50 min-h-screen">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-8">
                
                <div class="flex flex-col lg:flex-row gap-8">
                    
                    <div v-if="isOfficeStaff" class="w-full lg:w-1/3">
                        <div class="bg-white p-6 shadow-lg rounded-2xl border-t-4 border-kca-gold sticky top-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">Add to Directory</h3>
                            
                            <form @submit.prevent="submit" class="space-y-4">
                                <div>
                                    <InputLabel for="title" value="Display Title" />
                                    <TextInput id="title" type="text" class="mt-1 block w-full rounded-xl" v-model="form.title" required placeholder="e.g. Cohort 1 Photos" />
                                    <InputError class="mt-2" :message="form.errors.title" />
                                </div>
                                
                                <div>
                                    <InputLabel for="category" value="Resource Type" />
                                    <select id="category" v-model="form.category" class="mt-1 block w-full rounded-xl border-gray-300 focus:border-kca-navy focus:ring-kca-navy shadow-sm">
                                        <option>Google Drive Folder</option>
                                        <option>Template / Document</option>
                                        <option>External Link</option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.category" />
                                </div>

                                <div>
                                    <InputLabel for="url" value="Shareable Link (URL)" />
                                    <TextInput id="url" type="url" class="mt-1 block w-full rounded-xl" v-model="form.url" required placeholder="https://drive.google.com/..." />
                                    <InputError class="mt-2" :message="form.errors.url" />
                                </div>

                                <PrimaryButton class="w-full justify-center bg-kca-navy hover:bg-blue-900 rounded-xl py-3 mt-4" :disabled="form.processing">
                                    Publish Link
                                </PrimaryButton>
                            </form>
                        </div>
                    </div>

                    <div class="w-full" :class="isOfficeStaff ? 'lg:w-2/3' : ''">
                        <div class="bg-white p-6 shadow-sm rounded-2xl">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 border-b pb-4">Shared Resources</h3>
                            
                            <div v-if="resources.length === 0" class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                                <p class="text-lg text-gray-500 font-medium">The directory is currently empty.</p>
                                <p v-if="isOfficeStaff" class="text-sm text-gray-400 mt-1">Use the form to add your first Google Drive link!</p>
                            </div>

                            <div v-else class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div v-for="resource in resources" :key="resource.id" class="p-4 border border-gray-200 rounded-xl hover:border-blue-300 hover:shadow-md transition-all duration-200 bg-white group relative">
                                    
                                    <a :href="resource.url" target="_blank" rel="noopener noreferrer" class="flex items-start gap-4">
                                        <div class="p-3 bg-blue-50 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="getIconForCategory(resource.category)"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-lg font-bold text-gray-900 truncate group-hover:text-kca-navy transition-colors">{{ resource.title }}</h4>
                                            <p class="text-xs text-gray-500 font-medium uppercase tracking-wider mt-1">{{ resource.category }}</p>
                                        </div>
                                    </a>

                                    <button v-if="isOfficeStaff" @click="deleteResource(resource.id)" class="absolute top-4 right-4 text-gray-300 hover:text-red-500 opacity-0 group-hover:opacity-100 transition-opacity p-1 bg-white rounded-full hover:bg-red-50" title="Delete Link">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>