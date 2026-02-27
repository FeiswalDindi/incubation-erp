<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({ events: Array });

const form = useForm({
    title: '', description: '', start_datetime: '', end_datetime: '', location: '', google_form_link: '',
});

const isSubmitting = ref(false);
const copiedEventId = ref(null);

const submit = () => {
    isSubmitting.value = true;
    form.post(route('events.store'), {
        preserveScroll: true,
        onSuccess: () => { form.reset(); isSubmitting.value = false; },
        onError: () => { isSubmitting.value = false; }
    });
};

const formatDateTime = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
};

const copyToClipboard = async (slug, eventId) => {
    const url = `${route('events.index')}/apply/${slug}`;
    try {
        await navigator.clipboard.writeText(url);
        copiedEventId.value = eventId;
        setTimeout(() => { copiedEventId.value = null; }, 2000);
    } catch (err) {}
};
</script>

<template>
    <Head title="Manage Events" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link :href="route('dashboard')" class="text-gray-400 hover:text-kca-navy transition-colors bg-white p-2 rounded-full shadow-sm border border-gray-100 hover:shadow-md tooltip" title="Back to Dashboard">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </Link>
                <h2 class="text-2xl font-bold leading-tight text-kca-navy tracking-tight">
                    Manage Events & Workshops
                </h2>
            </div>
        </template>

        <div class="py-12 bg-gray-50 min-h-screen">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    
                    <div class="w-full lg:w-1/3">
                        <div class="bg-white p-6 shadow-lg rounded-2xl border-t-4 border-kca-navy">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">Create Event</h3>
                            <form @submit.prevent="submit" class="space-y-4">
                                <div>
                                    <InputLabel for="title" value="Event Title" />
                                    <TextInput id="title" type="text" class="mt-1 block w-full rounded-xl border-gray-300" v-model="form.title" required />
                                    <InputError class="mt-2" :message="form.errors.title" />
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <InputLabel for="start_datetime" value="Starts At" />
                                        <TextInput id="start_datetime" type="datetime-local" class="mt-1 block w-full rounded-xl text-sm" v-model="form.start_datetime" required />
                                        <InputError class="mt-2" :message="form.errors.start_datetime" />
                                    </div>
                                    <div>
                                        <InputLabel for="end_datetime" value="Ends At" />
                                        <TextInput id="end_datetime" type="datetime-local" class="mt-1 block w-full rounded-xl text-sm" v-model="form.end_datetime" required />
                                        <InputError class="mt-2" :message="form.errors.end_datetime" />
                                    </div>
                                </div>
                                <div>
                                    <InputLabel for="location" value="Location / Room" />
                                    <TextInput id="location" type="text" class="mt-1 block w-full rounded-xl" v-model="form.location" />
                                </div>
                                <div>
                                    <InputLabel for="google_form_link" value="Google Form Link (Optional)" />
                                    <TextInput id="google_form_link" type="url" class="mt-1 block w-full rounded-xl border-gray-300" v-model="form.google_form_link" placeholder="https://forms.gle/..." />
                                    <p class="text-xs text-gray-500 mt-1">Paste your Google Form link here for registrations.</p>
                                    <InputError class="mt-2" :message="form.errors.google_form_link" />
                                </div>
                                <div>
                                    <InputLabel for="description" value="Details" />
                                    <textarea id="description" class="mt-1 block w-full border-gray-300 rounded-xl" rows="3" v-model="form.description"></textarea>
                                </div>
                                <PrimaryButton class="w-full justify-center bg-kca-navy hover:bg-blue-900 rounded-xl py-3 mt-4" :disabled="form.processing">
                                    Publish & Generate Link
                                </PrimaryButton>
                            </form>
                        </div>
                    </div>

                    <div class="w-full lg:w-2/3">
                        <div class="bg-white p-6 shadow-sm rounded-2xl">
                            <h3 class="text-xl font-bold text-gray-900 mb-6">Active Office Events</h3>
                            
                            <div v-if="events.length === 0" class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                                <p class="text-lg text-gray-500">No events found.</p>
                            </div>

                            <div class="space-y-4">
                                <div v-for="event in events" :key="event.id" class="p-5 border border-gray-100 bg-white rounded-xl shadow-sm flex flex-col md:flex-row justify-between gap-4">
                                    <div class="flex-1">
                                        <h4 class="text-lg font-bold text-kca-navy flex items-center gap-2">
                                            {{ event.title }}
                                            <span v-if="event.google_form_link" class="text-xs bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full border border-purple-200">Google Form Attached</span>
                                        </h4>
                                        <p class="text-sm text-gray-600 mt-2">{{ formatDateTime(event.start_datetime) }} → {{ formatDateTime(event.end_datetime) }}</p>
                                        <p v-if="event.location" class="text-sm text-gray-500 mt-1">{{ event.location }}</p>
                                    </div>
                                    <div class="w-full md:w-auto">
                                        <p class="text-xs text-gray-400 font-semibold mb-1">Share Link <span v-if="copiedEventId === event.id" class="text-green-600 ml-2">Copied!</span></p>
                                        <button @click="copyToClipboard(event.slug, event.id)" class="w-full flex justify-between gap-3 bg-blue-50 border border-blue-100 px-3 py-2 rounded-lg text-sm hover:bg-blue-100">
                                            <span class="text-blue-700 font-medium truncate max-w-[200px]">{{ route('events.index') }}/apply/{{ event.slug }}</span>
                                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>