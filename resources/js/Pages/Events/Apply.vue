<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({ event: Object });

const formatDateTime = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' });
};
</script>

<template>
    <Head :title="`Event: ${event.title}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link :href="route('dashboard')" class="text-gray-400 hover:text-kca-navy transition-colors bg-white p-2 rounded-full shadow-sm border border-gray-100 hover:shadow-md tooltip" title="Back to Dashboard">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </Link>
                <h2 class="text-2xl font-bold leading-tight text-kca-navy tracking-tight">
                    Event Details
                </h2>
            </div>
        </template>

        <div class="py-6 sm:py-12 bg-gray-50 min-h-screen px-4 sm:px-0">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                
                <div class="bg-white shadow-xl rounded-2xl overflow-hidden border-t-4 border-kca-gold">
                    <div class="bg-kca-navy p-6 sm:p-8 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-5 rounded-full blur-2xl"></div>
                        <h1 class="text-2xl sm:text-3xl font-extrabold mb-2 relative z-10 break-words">{{ event.title }}</h1>
                        <p class="text-blue-200 text-sm sm:text-base relative z-10">Hosted by KCA Incubation Center</p>
                    </div>

                    <div class="p-6 sm:p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 bg-blue-50/50 p-6 rounded-xl border border-blue-100">
                            <div>
                                <p class="text-xs text-blue-800 uppercase font-bold tracking-wider mb-1">When</p>
                                <p class="text-gray-800 font-medium text-sm">{{ formatDateTime(event.start_datetime) }}</p>
                                <p class="text-gray-500 text-sm">to {{ formatDateTime(event.end_datetime) }}</p>
                            </div>
                            <div v-if="event.location">
                                <p class="text-xs text-blue-800 uppercase font-bold tracking-wider mb-1">Where</p>
                                <p class="text-gray-800 font-medium text-sm flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    {{ event.location }}
                                </p>
                            </div>
                        </div>

                        <div v-if="event.description" class="mb-8 prose prose-blue max-w-none text-gray-600">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">About this event</h3>
                            <p class="whitespace-pre-wrap">{{ event.description }}</p>
                        </div>

                        <hr class="border-gray-100 mb-8" />

                        <div v-if="event.google_form_link" class="text-center">
                            <p class="text-gray-600 mb-4">Registration for this event is managed via Google Forms.</p>
                            <a :href="event.google_form_link" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center w-full sm:w-auto px-8 py-3 bg-kca-gold hover:bg-yellow-600 text-white font-bold rounded-xl shadow-md transition-transform transform hover:-translate-y-1">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                Proceed to Google Form
                            </a>
                        </div>

                        <div v-else class="text-center py-6 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                            <p class="text-gray-600 font-medium">This is an open event.</p>
                            <p class="text-sm text-gray-500 mt-1">No formal registration is required. Mark your calendar and we'll see you there!</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>