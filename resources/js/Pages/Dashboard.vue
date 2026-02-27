<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

// Access the shared data from our Inertia Middleware
const page = usePage();
const roles = computed(() => page.props.auth.roles);

// Helper function to check roles
const hasRole = (role) => roles.value.includes(role);
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-kca-navy">
                Incubation Center Portal
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                
                <div v-if="hasRole('Assistant') || hasRole('Intern') || hasRole('Incubation Officer')" class="mb-8 overflow-hidden bg-white shadow-sm sm:rounded-lg border-l-4 border-kca-gold">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-bold text-kca-navy mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-kca-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Office Management Panel
                        </h3>
                        <p class="mb-4">Welcome back to the office interface. Here you can manage events, generate forms, and oversee cohorts.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                            <button class="bg-kca-navy text-white px-4 py-3 rounded hover:bg-blue-900 transition flex justify-center items-center font-medium">
                                Manage Upcoming Events
                            </button>
                            <button class="bg-kca-gold text-white px-4 py-3 rounded hover:bg-yellow-600 transition flex justify-center items-center font-medium">
                                Generate Workshop Link
                            </button>
                            <button class="border border-kca-navy text-kca-navy px-4 py-3 rounded hover:bg-gray-50 transition flex justify-center items-center font-medium">
                                View File Directory
                            </button>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-bold text-gray-800 mb-2">Student Portal</h3>
                        <p>You are logged in! Watch this space for upcoming incubation activities and announcements.</p>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>