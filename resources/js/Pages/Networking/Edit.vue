<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({ profile: Object });

const form = useForm({
    headline: props.profile?.headline || '',
    bio: props.profile?.bio || '',
    skills: props.profile?.skills || '',
    github_url: props.profile?.github_url || '',
    linkedin_url: props.profile?.linkedin_url || '',
    portfolio_url: props.profile?.portfolio_url || '',
});

const submit = () => {
    form.post(route('networking.update'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Edit Profile" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link :href="route('dashboard')" class="text-gray-400 hover:text-kca-navy transition-colors bg-white p-2 rounded-full shadow-sm border border-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </Link>
                <h2 class="text-2xl font-bold leading-tight text-kca-navy tracking-tight">
                    Professional Profile
                </h2>
            </div>
        </template>

        <div class="py-12 bg-gray-50 min-h-screen">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8">
                
                <div class="bg-white p-8 shadow-xl rounded-2xl border-t-4 border-kca-gold">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Build Your Identity</h3>
                    <p class="text-sm text-gray-500 mb-8">This information will be displayed publicly in the Incubation Center directory to help you find teammates and collaborate.</p>

                    <form @submit.prevent="submit" class="space-y-6">
                        
                        <div>
                            <InputLabel for="headline" value="Professional Headline" />
                            <TextInput id="headline" type="text" class="mt-1 block w-full rounded-xl" v-model="form.headline" placeholder="e.g. Frontend Dev | Vue.js Enthusiast" />
                            <InputError class="mt-2" :message="form.errors.headline" />
                        </div>

                        <div>
                            <InputLabel for="bio" value="About Me" />
                            <textarea id="bio" class="mt-1 block w-full border-gray-300 focus:border-kca-navy focus:ring-kca-navy rounded-xl shadow-sm" rows="4" v-model="form.bio" placeholder="Tell the community about what you are building or learning..."></textarea>
                            <InputError class="mt-2" :message="form.errors.bio" />
                        </div>

                        <div>
                            <InputLabel for="skills" value="Top Skills (Comma Separated)" />
                            <TextInput id="skills" type="text" class="mt-1 block w-full rounded-xl" v-model="form.skills" placeholder="e.g. UI/UX, Laravel, Marketing, Python" />
                            <InputError class="mt-2" :message="form.errors.skills" />
                        </div>

                        <hr class="border-gray-100 my-6">
                        <h4 class="text-md font-bold text-gray-700 mb-4">External Links</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <InputLabel for="github_url" value="GitHub URL" />
                                <TextInput id="github_url" type="url" class="mt-1 block w-full rounded-xl" v-model="form.github_url" placeholder="https://github.com/..." />
                                <InputError class="mt-2" :message="form.errors.github_url" />
                            </div>

                            <div>
                                <InputLabel for="linkedin_url" value="LinkedIn URL" />
                                <TextInput id="linkedin_url" type="url" class="mt-1 block w-full rounded-xl" v-model="form.linkedin_url" placeholder="https://linkedin.com/in/..." />
                                <InputError class="mt-2" :message="form.errors.linkedin_url" />
                            </div>
                        </div>

                        <div>
                            <InputLabel for="portfolio_url" value="Personal Portfolio URL" />
                            <TextInput id="portfolio_url" type="url" class="mt-1 block w-full rounded-xl" v-model="form.portfolio_url" placeholder="https://yourwebsite.com" />
                            <InputError class="mt-2" :message="form.errors.portfolio_url" />
                        </div>

                        <div class="pt-6 flex justify-end">
                            <PrimaryButton class="px-8 py-3 bg-kca-navy hover:bg-blue-900 rounded-xl shadow-md" :disabled="form.processing">
                                Save Profile
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </AuthenticatedLayout>
</template>