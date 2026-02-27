<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({ events: Array });

const formatDateTime = (dateString) => {
    return new Date(dateString).toLocaleDateString('en-US', { month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' });
};
</script>

<template>
    <section class="py-24 bg-gray-50 border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6 reveal-on-scroll">
                <div class="max-w-2xl">
                    <h2 class="text-3xl md:text-5xl font-extrabold text-kca-navy mb-4">Upcoming Activities</h2>
                    <p class="text-lg text-gray-600">Join our masterclasses, hackathons, and networking sessions.</p>
                </div>
                <Link :href="route('login')" class="text-blue-600 font-bold hover:text-blue-800 flex items-center group">
                    Enter Portal to Register <svg class="w-5 h-5 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </Link>
            </div>

            <div v-if="events.length === 0" class="bg-white rounded-3xl p-12 text-center border border-gray-200 shadow-sm reveal-on-scroll">
                <p class="text-xl font-bold text-gray-900">We are planning the next cohort!</p>
                <p class="text-gray-500">Check back soon for upcoming hackathons.</p>
            </div>

            <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div v-for="(event, index) in events" :key="event.id" class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 group flex flex-col reveal-on-scroll" :style="`transition-delay: ${index * 100}ms;`">
                    <div class="h-32 bg-kca-navy relative overflow-hidden">
                        <div class="absolute bottom-4 left-6 bg-white/20 backdrop-blur-md px-3 py-1 rounded-md text-white text-sm font-bold border border-white/30">
                            {{ formatDateTime(event.start_datetime) }}
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-blue-700 transition-colors">{{ event.title }}</h3>
                        <p class="text-gray-600 text-sm line-clamp-3 mb-6 flex-1">{{ event.description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
