<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const page = usePage();

const roles = computed(() => page.props.auth.roles || []);
const upcomingEvents = computed(() => page.props.upcomingEvents || []);
const user = computed(() => page.props.auth.user);

const isOfficeStaff = computed(() => {
    return roles.value.some(role => ['Assistant', 'Intern', 'Incubation Officer'].includes(role));
});

const formatDateTime = (dateString) => {
    const options = { weekday: 'short', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' };
    return new Date(dateString).toLocaleDateString('en-US', options);
};

// --- CUSTOM CALENDAR ENGINE ---
const today = new Date();
const currentMonth = today.getMonth();
const currentYear = today.getFullYear();
const monthName = today.toLocaleString('default', { month: 'long' });

const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
const firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay(); 

const blankDays = Array.from({ length: firstDayOfMonth }, (_, i) => i);
const monthDays = Array.from({ length: daysInMonth }, (_, i) => i + 1);

const hasEventOnDay = (day) => {
    return upcomingEvents.value.some(event => {
        const eventDate = new Date(event.start_datetime);
        return eventDate.getDate() === day && 
               eventDate.getMonth() === currentMonth && 
               eventDate.getFullYear() === currentYear;
    });
};

const isToday = (day) => {
    return day === today.getDate() && currentMonth === today.getMonth() && currentYear === today.getFullYear();
};

// --- INTERACTIVE EVENT MODAL LOGIC ---
const isEventModalOpen = ref(false);
const selectedDateEvents = ref([]);
const clickedDateStr = ref('');

const openDayDetails = (day) => {
    if (!hasEventOnDay(day)) return; // Do nothing if there are no events on this day

    // Filter events to only show the ones for the clicked day
    selectedDateEvents.value = upcomingEvents.value.filter(event => {
        const eventDate = new Date(event.start_datetime);
        return eventDate.getDate() === day && 
               eventDate.getMonth() === currentMonth && 
               eventDate.getFullYear() === currentYear;
    });

    // Format the date beautifully for the modal header (e.g., "Friday, February 27")
    const dateObj = new Date(currentYear, currentMonth, day);
    clickedDateStr.value = dateObj.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric' });
    
    isEventModalOpen.value = true;
};

const closeEventModal = () => {
    isEventModalOpen.value = false;
    setTimeout(() => { selectedDateEvents.value = []; }, 300); // Clear array after animation
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold leading-tight text-kca-navy tracking-tight">
                Incubation Center Portal
            </h2>
        </template>

        <div class="py-12 bg-gray-50 min-h-screen">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-8">
                
                <div v-if="isOfficeStaff" class="bg-white shadow-lg sm:rounded-2xl border-t-4 border-kca-gold p-6 sm:p-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-2 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-kca-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Office Management Panel
                    </h3>
                    <p class="mb-6 text-gray-600">Welcome back, Admin. Use the tools below to manage cohorts and events.</p>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6">
                        <Link :href="route('events.index')" class="bg-kca-navy text-white px-4 py-4 rounded-xl hover:bg-blue-900 transition-all duration-300 transform hover:-translate-y-1 shadow-md flex justify-center items-center font-bold text-center">
                            Manage Events
                        </Link>
                        <Link :href="route('resources.index')" class="border-2 border-kca-navy text-kca-navy px-4 py-4 rounded-xl hover:bg-blue-50 transition-all duration-300 transform hover:-translate-y-1 flex justify-center items-center font-bold text-center">
                            File Directory
                        </Link>
                        <Link :href="route('communication.index')" class="bg-kca-gold text-white px-4 py-4 rounded-xl hover:bg-yellow-600 transition-all duration-300 transform hover:-translate-y-1 shadow-md flex justify-center items-center font-bold text-center">
                            Mass Announce
                        </Link>
                    </div>
                </div>

                <div v-else class="space-y-6">
                    <div class="bg-gradient-to-r from-kca-navy to-blue-900 rounded-2xl p-8 text-white shadow-lg relative overflow-hidden border-b-4 border-kca-gold">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-5 rounded-full blur-2xl"></div>
                        <h2 class="text-3xl font-extrabold mb-2 relative z-10">Welcome back, {{ user.name.split(' ')[0] }}!</h2>
                        <p class="text-blue-200 relative z-10">Stay updated with the latest incubation activities and network with your peers.</p>
                        
                        <div class="mt-6 flex flex-wrap gap-4 relative z-10">
                            <Link :href="route('networking.index')" class="bg-kca-gold hover:bg-yellow-600 text-white px-6 py-2.5 rounded-lg font-bold transition-colors shadow-md flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Find Teammates
                            </Link>
                            <Link :href="route('networking.edit')" class="bg-white/10 hover:bg-white/20 text-white border border-white/20 px-6 py-2.5 rounded-lg font-bold transition-colors backdrop-blur-sm">
                                Update My Profile
                            </Link>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        
                        <div class="lg:col-span-2 bg-white shadow-sm sm:rounded-2xl border border-gray-100 p-6 sm:p-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center border-b pb-4">
                                <svg class="w-5 h-5 mr-2 text-kca-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                                Timeline & Upcoming Activities
                            </h3>
                            
                            <div v-if="upcomingEvents.length === 0" class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                                <div class="w-16 h-16 bg-blue-50 text-blue-200 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <p class="text-gray-500 font-medium">Your timeline is clear.</p>
                                <p class="text-xs text-gray-400">No events are scheduled for the near future.</p>
                            </div>

                            <div v-else class="space-y-4">
                                <div v-for="(event, index) in upcomingEvents" :key="event.id" class="flex gap-4 relative">
                                    <div class="flex flex-col items-center">
                                        <div class="w-4 h-4 rounded-full bg-kca-gold border-4 border-yellow-50 z-10"></div>
                                        <div v-if="index !== upcomingEvents.length - 1" class="w-0.5 h-full bg-gray-100 mt-1"></div>
                                    </div>

                                    <div class="flex-1 pb-6">
                                        <div class="bg-gray-50 hover:bg-blue-50 transition-colors border border-gray-100 rounded-xl p-5 group">
                                            <div class="flex justify-between items-start flex-wrap gap-2 mb-2">
                                                <h4 class="font-bold text-lg text-kca-navy group-hover:text-blue-800 transition-colors">{{ event.title }}</h4>
                                                <span class="text-xs font-bold text-kca-gold bg-yellow-50 px-2.5 py-1 rounded border border-yellow-100">
                                                    {{ formatDateTime(event.start_datetime) }}
                                                </span>
                                            </div>
                                            <p v-if="event.location" class="text-sm text-gray-500 flex items-center mb-3">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                                {{ event.location }}
                                            </p>
                                            <Link :href="route('events.apply', event.slug)" class="inline-flex items-center text-sm font-bold text-blue-600 hover:text-blue-800">
                                                View Details & Register 
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm sm:rounded-2xl border border-gray-100 p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center justify-between">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-kca-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ monthName }} {{ currentYear }}
                                </span>
                                <span class="text-xs font-medium text-gray-400">Click highlighted days</span>
                            </h3>

                            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                <div class="grid grid-cols-7 gap-1 text-center mb-2">
                                    <div class="text-xs font-bold text-gray-400 py-1">Su</div>
                                    <div class="text-xs font-bold text-gray-400 py-1">Mo</div>
                                    <div class="text-xs font-bold text-gray-400 py-1">Tu</div>
                                    <div class="text-xs font-bold text-gray-400 py-1">We</div>
                                    <div class="text-xs font-bold text-gray-400 py-1">Th</div>
                                    <div class="text-xs font-bold text-gray-400 py-1">Fr</div>
                                    <div class="text-xs font-bold text-gray-400 py-1">Sa</div>
                                </div>

                                <div class="grid grid-cols-7 gap-1 text-center">
                                    <div v-for="blank in blankDays" :key="'blank-' + blank" class="p-2"></div>
                                    
                                    <div v-for="day in monthDays" :key="day" class="relative py-2 px-1" @click="openDayDetails(day)">
                                        <div :class="[
                                            'w-8 h-8 mx-auto flex items-center justify-center rounded-full text-sm font-medium transition-all duration-200',
                                            isToday(day) && !hasEventOnDay(day) ? 'bg-gray-300 text-white' : '',
                                            isToday(day) && hasEventOnDay(day) ? 'bg-kca-navy text-white shadow-md cursor-pointer hover:scale-110 ring-2 ring-offset-2 ring-kca-gold' : '',
                                            !isToday(day) && hasEventOnDay(day) ? 'bg-blue-50 text-blue-800 cursor-pointer hover:bg-blue-100 hover:scale-110 font-bold border border-blue-200' : '',
                                            !isToday(day) && !hasEventOnDay(day) ? 'text-gray-600' : ''
                                        ]">
                                            {{ day }}
                                        </div>

                                        <div v-if="hasEventOnDay(day)" class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-1.5 h-1.5 bg-kca-gold rounded-full shadow-sm"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <Transition name="fade">
            <div v-if="isEventModalOpen" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-blur-sm" @click="closeEventModal" aria-hidden="true"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border-t-8 border-kca-gold">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            
                            <div class="flex justify-between items-start mb-5 border-b border-gray-100 pb-4">
                                <div class="flex items-center">
                                    <div class="bg-yellow-50 p-2 rounded-lg text-kca-gold mr-4">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <h3 class="text-xl leading-6 font-bold text-kca-navy" id="modal-title">
                                        {{ clickedDateStr }}
                                    </h3>
                                </div>
                                <button @click="closeEventModal" class="text-gray-400 hover:text-gray-500 bg-gray-50 hover:bg-gray-200 rounded-full p-2 transition-colors focus:outline-none">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>

                            <div class="mt-2 space-y-4 max-h-96 overflow-y-auto pr-2">
                                <div v-for="event in selectedDateEvents" :key="event.id" class="bg-gray-50 border border-gray-200 p-5 rounded-xl hover:border-blue-300 transition-colors group">
                                    <h4 class="font-bold text-lg text-gray-900 group-hover:text-blue-800 transition-colors mb-1">{{ event.title }}</h4>
                                    
                                    <div class="flex items-center text-sm text-gray-600 mb-3 font-medium">
                                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ new Date(event.start_datetime).toLocaleTimeString('en-US', {hour: '2-digit', minute:'2-digit'}) }}
                                        <span class="mx-2 text-gray-300">|</span>
                                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                        {{ event.location || 'Location TBD' }}
                                    </div>
                                    
                                    <p v-if="event.description" class="text-sm text-gray-600 mb-4 line-clamp-3">{{ event.description }}</p>
                                    
                                    <Link :href="route('events.apply', event.slug)" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-bold rounded-lg shadow-sm text-white bg-kca-navy hover:bg-blue-900 focus:outline-none transition-colors">
                                        View Full Details
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Transition>

    </AuthenticatedLayout>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active { transition: opacity 0.3s ease; }
.fade-enter-from,
.fade-leave-to { opacity: 0; }
</style>