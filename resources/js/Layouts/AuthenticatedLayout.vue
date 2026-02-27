<script setup>
import { ref, computed } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);

const page = usePage();
const user = computed(() => page.props.auth.user);
const roles = computed(() => page.props.auth.roles || []);

// Check if the user is staff to conditionally render the admin links
const isOfficeStaff = computed(() => {
    return roles.value.some(role => ['Assistant', 'Intern', 'Incubation Officer'].includes(role));
});
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-50">
            <nav class="bg-kca-navy border-b border-blue-900 sticky top-0 z-50 shadow-md">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')" class="text-white font-extrabold text-xl tracking-wider flex items-center gap-2">
                                    <div class="w-8 h-8 bg-kca-gold rounded-lg flex items-center justify-center text-kca-navy shadow-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    </div>
                                    KCA INCUBATION
                                </Link>
                            </div>

                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')" class="text-gray-300 hover:text-white focus:text-white transition-colors">
                                    Dashboard
                                </NavLink>
                                
                                <template v-if="isOfficeStaff">
                                    <NavLink :href="route('events.index')" :active="route().current('events.*')" class="text-gray-300 hover:text-white focus:text-white transition-colors">
                                        Events
                                    </NavLink>
                                    <NavLink :href="route('communication.index')" :active="route().current('communication.*')" class="text-gray-300 hover:text-white focus:text-white transition-colors">
                                        Announcements
                                    </NavLink>
                                </template>

                                <template v-else>
                                    <NavLink :href="route('networking.index')" :active="route().current('networking.index')" class="text-gray-300 hover:text-white focus:text-white transition-colors">
                                        Student Network
                                    </NavLink>
                                </template>

                                <NavLink :href="route('resources.index')" :active="route().current('resources.*')" class="text-gray-300 hover:text-white focus:text-white transition-colors">
                                    Directory
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-bold rounded-md text-kca-navy bg-kca-gold hover:bg-yellow-500 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                                                {{ user.name.split(' ')[0] }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <div class="block px-4 py-2 text-xs text-gray-400 font-bold uppercase tracking-wider">
                                            Manage Account
                                        </div>
                                        <DropdownLink v-if="!isOfficeStaff" :href="route('networking.edit')">
                                            My Profile
                                        </DropdownLink>
                                        <DropdownLink :href="route('profile.edit')">
                                            Account Settings
                                        </DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button" class="text-red-600 hover:text-red-800 hover:bg-red-50">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="showingNavigationDropdown = !showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-blue-800 focus:outline-none focus:bg-blue-800 focus:text-white transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div :class="{'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown}" class="sm:hidden bg-blue-900 border-t border-blue-800">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')" :active="route().current('dashboard')" class="text-gray-300">
                            Dashboard
                        </ResponsiveNavLink>
                        
                        <template v-if="isOfficeStaff">
                            <ResponsiveNavLink :href="route('events.index')" :active="route().current('events.*')" class="text-gray-300">
                                Manage Events
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('communication.index')" :active="route().current('communication.*')" class="text-gray-300">
                                Announcements
                            </ResponsiveNavLink>
                        </template>

                        <template v-else>
                            <ResponsiveNavLink :href="route('networking.index')" :active="route().current('networking.index')" class="text-gray-300">
                                Student Network
                            </ResponsiveNavLink>
                        </template>

                        <ResponsiveNavLink :href="route('resources.index')" :active="route().current('resources.*')" class="text-gray-300">
                            File Directory
                        </ResponsiveNavLink>
                    </div>

                    <div class="pt-4 pb-1 border-t border-blue-800">
                        <div class="px-4">
                            <div class="font-medium text-base text-white">{{ user.name }}</div>
                            <div class="font-medium text-sm text-blue-300">{{ user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink v-if="!isOfficeStaff" :href="route('networking.edit')" class="text-gray-300">
                                My Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('profile.edit')" class="text-gray-300">
                                Account Settings
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button" class="text-red-400">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <div v-if="$page.props.flash?.message" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <p class="text-sm text-green-700 font-bold">{{ $page.props.flash.message }}</p>
                    </div>
                </div>
            </div>

            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <main>
                <slot />
            </main>
        </div>
    </div>
</template>