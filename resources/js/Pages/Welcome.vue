<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import HeroSection from '@/Components/Public/HeroSection.vue';
import PillarsSection from '@/Components/Public/PillarsSection.vue';
import EventsSection from '@/Components/Public/EventsSection.vue';

defineProps({
    canLogin: Boolean,
    upcomingEvents: Array,
});
</script>

<template>
    <Head title="KCA Incubation Center" />

    <PublicLayout :canLogin="canLogin">
        
        <HeroSection />
        
        <PillarsSection />
        
        <EventsSection :events="upcomingEvents" />

    </PublicLayout>
</template>