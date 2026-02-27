<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = defineProps({ 
    canLogin: { type: Boolean, default: true } 
});

const isScrolled = ref(false);
const mobileMenuOpen = ref(false);

const handleScroll = () => {
    isScrolled.value = window.scrollY > 20;
};

const setupAnimations = () => {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('opacity-100', 'translate-y-0');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal-on-scroll').forEach((el) => {
        el.classList.add('transition-all', 'duration-1000', 'opacity-0', 'translate-y-12');
        observer.observe(el);
    });
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
    nextTick(() => setupAnimations());
});

onUnmounted(() => window.removeEventListener('scroll', handleScroll));
</script>

<template>
    <div class="min-h-screen bg-white flex flex-col overflow-x-hidden">
        
        <nav :class="[
            'fixed w-full z-50 transition-all duration-500 py-4',
            isScrolled ? 'bg-white/80 backdrop-blur-lg shadow-lg border-b border-gray-100' : 'bg-transparent'
        ]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <Link :href="route('home')" class="flex items-center gap-2 group z-[60]">
                    <div :class="['w-10 h-10 rounded-xl flex items-center justify-center shadow-lg transition-all duration-500', isScrolled ? 'bg-kca-navy text-white' : 'bg-kca-gold text-kca-navy']">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <span :class="['font-black text-xl tracking-tighter transition-colors duration-500', isScrolled ? 'text-kca-navy' : 'text-white']">
                        KCA INCUBATION
                    </span>
                </Link>

                <div class="hidden md:flex items-center gap-8 font-bold">
                    <Link :href="route('home')" :class="[isScrolled ? 'text-gray-600' : 'text-gray-100', 'hover:text-kca-gold transition-colors']">Home</Link>
                    <Link :href="route('about')" :class="[isScrolled ? 'text-gray-600' : 'text-gray-100', 'hover:text-kca-gold transition-colors']">About</Link>
                    <Link :href="route('contact')" :class="[isScrolled ? 'text-gray-600' : 'text-gray-100', 'hover:text-kca-gold transition-colors']">Contact</Link>
                    <Link :href="route('login')" class="bg-kca-gold text-kca-navy px-6 py-2.5 rounded-full hover:scale-105 transition-transform shadow-lg">Portal Login</Link>
                </div>

                <button @click="mobileMenuOpen = !mobileMenuOpen" :class="['md:hidden z-[60] p-2 rounded-lg transition-colors', isScrolled || mobileMenuOpen ? 'text-kca-navy' : 'text-white']">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path v-if="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </nav>

        <div class="md:hidden">
            <transition name="fade">
                <div v-if="mobileMenuOpen" @click="mobileMenuOpen = false" class="fixed inset-0 bg-kca-navy/60 backdrop-blur-sm z-40 transition-opacity"></div>
            </transition>

            <transition name="slide-right">
                <div v-if="mobileMenuOpen" class="fixed top-4 right-4 bottom-4 w-[280px] bg-white rounded-3xl shadow-2xl z-50 flex flex-col overflow-hidden border border-gray-100">
                    <div class="p-8 flex flex-col h-full overflow-y-auto">
                        <div class="mb-10">
                            <p class="text-xs font-black text-kca-gold uppercase tracking-[0.2em] mb-2">Main Menu</p>
                            <div class="h-1 w-10 bg-kca-navy rounded-full"></div>
                        </div>

                        <div class="flex flex-col gap-6">
                            <Link :href="route('home')" @click="mobileMenuOpen = false" class="text-2xl font-black text-kca-navy hover:text-kca-gold transition-colors">Home</Link>
                            <Link :href="route('about')" @click="mobileMenuOpen = false" class="text-2xl font-black text-kca-navy hover:text-kca-gold transition-colors">About</Link>
                            <Link :href="route('contact')" @click="mobileMenuOpen = false" class="text-2xl font-black text-kca-navy hover:text-kca-gold transition-colors">Contact</Link>
                        </div>

                        <div class="mt-auto pt-10">
                            <Link :href="route('login')" class="block w-full bg-kca-navy text-white text-center py-4 rounded-2xl font-black shadow-lg shadow-blue-900/20">
                                Portal Login
                            </Link>
                            <p class="text-center text-[10px] text-gray-400 mt-6 font-bold uppercase tracking-widest">KCA Incubation Center © 2026</p>
                        </div>
                    </div>
                </div>
            </transition>
        </div>

        <main class="flex-grow">
            <slot />
        </main>
    </div>
</template>

<style scoped>
/* Smooth Sidebar Transitions */
.slide-right-enter-active, .slide-right-leave-active {
    transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
}
.slide-right-enter-from, .slide-right-leave-to {
    transform: translateX(110%);
    opacity: 0;
}

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.4s ease;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}

/* Custom Scrollbar for the Sidebar */
div::-webkit-scrollbar {
    width: 4px;
}
div::-webkit-scrollbar-thumb {
    background: #e5e7eb;
    border-radius: 10px;
}
</style>