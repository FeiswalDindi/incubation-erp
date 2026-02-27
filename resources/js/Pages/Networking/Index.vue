<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({ students: Array });
</script>

<template>
    <Head title="Student Network" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <Link :href="route('dashboard')" class="text-gray-400 hover:text-kca-navy transition-colors bg-white p-2 rounded-full shadow-sm border border-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </Link>
                    <h2 class="text-2xl font-bold leading-tight text-kca-navy tracking-tight">
                        Incubation Center Network
                    </h2>
                </div>
                <Link :href="route('networking.edit')" class="bg-kca-gold hover:bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition-colors">
                    Edit My Profile
                </Link>
            </div>
        </template>

        <div class="py-12 bg-gray-50 min-h-screen">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                
                <div v-if="students.length === 0" class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <p class="text-xl text-gray-500 font-medium">No students have joined the network yet.</p>
                </div>

                <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="student in students" :key="student.id" class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden group flex flex-col">
                        <div class="h-24 bg-gradient-to-r from-kca-navy to-blue-800 relative">
                            <div class="absolute -bottom-10 left-6">
                                <div class="h-20 w-20 bg-white rounded-full p-1 shadow-md">
                                    <div class="h-full w-full bg-blue-100 rounded-full flex items-center justify-center text-blue-800 font-extrabold text-2xl border-2 border-dashed border-blue-200">
                                        {{ student.name.charAt(0) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-12 pb-6 px-6 flex-1 flex flex-col">
                            <h3 class="text-xl font-bold text-gray-900">{{ student.name }}</h3>
                            <p class="text-kca-gold font-semibold text-sm mb-3">
                                {{ student.profile?.headline || 'Incubation Student' }}
                            </p>
                            
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-1">
                                {{ student.profile?.bio || 'This student hasn\'t added a bio yet. They are probably busy coding!' }}
                            </p>

                            <div v-if="student.profile?.skills" class="mb-5 flex flex-wrap gap-2">
                                <span v-for="skill in student.profile.skills.split(',')" :key="skill" class="bg-gray-100 text-gray-700 text-xs px-2.5 py-1 rounded-md font-medium border border-gray-200">
                                    {{ skill.trim() }}
                                </span>
                            </div>

                            <div class="flex gap-3 pt-4 border-t border-gray-100 mt-auto">
                                <a v-if="student.profile?.github_url" :href="student.profile.github_url" target="_blank" class="text-gray-400 hover:text-gray-900 transition-colors tooltip" title="GitHub">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"></path></svg>
                                </a>
                                <a v-if="student.profile?.linkedin_url" :href="student.profile.linkedin_url" target="_blank" class="text-gray-400 hover:text-blue-700 transition-colors tooltip" title="LinkedIn">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                </a>
                                <a v-if="student.profile?.portfolio_url" :href="student.profile.portfolio_url" target="_blank" class="text-gray-400 hover:text-kca-gold transition-colors tooltip" title="Portfolio Website">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                                </a>
                                <a :href="'mailto:' + student.email" class="ml-auto text-xs font-bold text-kca-navy bg-blue-50 px-3 py-1.5 rounded-lg hover:bg-blue-100 transition-colors">
                                    Email
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>