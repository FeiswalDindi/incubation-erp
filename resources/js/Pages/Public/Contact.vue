<script setup>
import { Head } from '@inertiajs/vue3';
import PublicLayout from '@/Layouts/PublicLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({ canLogin: Boolean });
</script>

<template>
    <Head title="Contact - KCA Incubation" />

    <PublicLayout :canLogin="canLogin">
        <div class="pt-32 pb-24 bg-gray-50 min-h-screen">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 reveal-on-scroll">
                <h1 class="text-4xl font-extrabold text-kca-navy mb-6 text-center">Get in Touch</h1>
                
                <div class="bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100">
                    <form class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <InputLabel for="name" value="Full Name" />
                                <TextInput id="name" type="text" class="mt-1 block w-full rounded-xl" placeholder="John Doe" />
                            </div>
                            <div>
                                <InputLabel for="email" value="Email Address" />
                                <TextInput id="email" type="email" class="mt-1 block w-full rounded-xl" placeholder="john@student.kcau.ac.ke" />
                            </div>
                        </div>
                        
                        <div>
                            <InputLabel for="message" value="Message" />
                            <textarea id="message" rows="5" class="mt-1 block w-full border-gray-300 focus:border-kca-navy focus:ring-kca-navy rounded-xl shadow-sm" placeholder="How can we help you?"></textarea>
                        </div>
                        
                        <PrimaryButton class="w-full justify-center bg-kca-navy hover:bg-blue-900 rounded-xl py-4 text-lg mt-2">
                            Send Message
                        </PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </PublicLayout>
</template>