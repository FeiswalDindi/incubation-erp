<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({ studentCount: Number });

const form = useForm({
    subject: '',
    message: '',
});

const submit = () => {
    if (confirm(`Are you sure you want to email ${props.studentCount} students?`)) {
        form.post(route('communication.send'), {
            preserveScroll: true,
            onSuccess: () => form.reset(),
        });
    }
};
</script>

<template>
    <Head title="Mass Communication" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link :href="route('dashboard')" class="text-gray-400 hover:text-kca-navy transition-colors bg-white p-2 rounded-full shadow-sm border border-gray-100 hover:shadow-md tooltip" title="Back to Dashboard">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </Link>
                <h2 class="text-2xl font-bold leading-tight text-kca-navy tracking-tight">
                    Student Communication Hub
                </h2>
            </div>
        </template>

        <div class="py-12 bg-gray-50 min-h-screen">
            <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">
                
                <div class="bg-white p-6 md:p-10 shadow-xl rounded-2xl border-t-4 border-kca-gold">
                    <div class="flex items-center gap-4 mb-8 p-4 bg-blue-50 border border-blue-100 rounded-xl">
                        <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Broadcast Announcement</h3>
                            <p class="text-sm text-gray-600">This message will be emailed directly to <strong class="text-kca-navy">{{ studentCount }} registered students</strong>.</p>
                        </div>
                    </div>

                    <form @submit.prevent="submit" class="space-y-6">
                        <div>
                            <InputLabel for="subject" value="Subject Line" />
                            <TextInput id="subject" type="text" class="mt-1 block w-full rounded-xl text-lg font-medium border-gray-300" v-model="form.subject" required placeholder="e.g. Mandatory Briefing for Cohort 4" />
                            <InputError class="mt-2" :message="form.errors.subject" />
                        </div>

                        <div>
                            <InputLabel for="message" value="Message Content" />
                            <textarea id="message" class="mt-1 block w-full border-gray-300 focus:border-kca-navy focus:ring-kca-navy rounded-xl shadow-sm" rows="10" v-model="form.message" required placeholder="Write your announcement here..."></textarea>
                            <p class="text-xs text-gray-500 mt-2">Emails will automatically include the KCA Incubation Center branding and letterhead.</p>
                            <InputError class="mt-2" :message="form.errors.message" />
                        </div>

                        <div class="pt-4 border-t border-gray-100 flex justify-end">
                            <PrimaryButton class="px-8 py-3 bg-kca-navy hover:bg-blue-900 text-white rounded-xl shadow-md transition-all transform hover:-translate-y-1" :class="{ 'opacity-50 cursor-not-allowed': form.processing || studentCount === 0 }" :disabled="form.processing || studentCount === 0">
                                <span v-if="form.processing" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Dispatching Emails...
                                </span>
                                <span v-else>Send Broadcast Now</span>
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </AuthenticatedLayout>
</template>