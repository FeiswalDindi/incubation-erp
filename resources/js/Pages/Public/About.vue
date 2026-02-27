<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';

defineProps({ canLogin: Boolean });
</script>

<template>
    <Head title="About Us - KCA Incubation" />

    <PublicLayout :canLogin="canLogin">
        <div class="pt-32 pb-24 bg-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center reveal-on-scroll">
                <h1 class="text-4xl md:text-6xl font-extrabold text-kca-navy mb-6">Our Mission</h1>
                <p class="text-xl text-gray-600 leading-relaxed mb-12">
                    The KCA University Incubation Center was established to bridge the gap between academic theory and real-world enterprise. We believe every student has the potential to build the next big thing.
                </p>
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Students collaborating" class="rounded-3xl shadow-2xl mb-16 object-cover h-96 w-full" />
            </div>
        </div>
    </PublicLayout>
</template>