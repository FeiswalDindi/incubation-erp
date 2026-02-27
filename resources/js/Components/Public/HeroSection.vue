<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="relative bg-kca-navy min-h-screen flex items-center pt-20 overflow-hidden">
        <div class="absolute inset-0 opacity-20 pointer-events-none">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-kca-gold blur-[120px] rounded-full"></div>
            <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-blue-400 blur-[100px] rounded-full"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full grid grid-cols-1 lg:grid-cols-2 gap-12 items-center relative z-10">
            
            <div class="reveal-on-scroll">
                <span class="inline-block px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-kca-gold text-sm font-black uppercase tracking-widest mb-6 backdrop-blur-md">
                    Ignite Your Potential
                </span>
                <h1 class="text-5xl md:text-7xl font-black text-white leading-[1.1] mb-6">
                    Launch Your <span class="text-transparent bg-clip-text bg-gradient-to-r from-kca-gold to-yellow-300">Empire</span> At KCA.
                </h1>
                <p class="text-xl text-blue-100 mb-10 max-w-lg leading-relaxed font-medium">
                    The bridge between university brilliance and market dominance. Build, network, and scale with the best incubation ecosystem in the region.
                </p>
                <div class="flex flex-col sm:flex-row gap-5">
                    <Link :href="route('login')" class="px-10 py-5 bg-kca-gold text-kca-navy font-black rounded-2xl shadow-2xl hover:scale-105 transition-all flex items-center justify-center text-lg">
                        Get Started <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </Link>
                    <a href="#events" class="px-10 py-5 bg-white/5 hover:bg-white/10 text-white font-bold rounded-2xl backdrop-blur-md border border-white/10 transition-all text-center">
                        Explore Events
                    </a>
                </div>
            </div>

            <div class="hidden lg:block relative reveal-on-scroll" style="transition-delay: 300ms;">
                <div class="animate-float">
                    <svg viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto drop-shadow-2xl">
                        <defs>
                            <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:#aa9b13;stop-opacity:1" />
                                <stop offset="100%" style="stop-color:#05347e;stop-opacity:1" />
                            </linearGradient>
                        </defs>
                        <rect x="150" y="100" width="200" height="300" rx="20" fill="white" opacity="0.1" />
                        <circle cx="250" cy="180" r="60" fill="url(#grad1)" />
                        <path d="M150 400 C150 320, 350 320, 350 400" fill="url(#grad1)" />
                        <rect x="220" y="260" width="60" height="10" rx="5" fill="#aa9b13" />
                        <circle cx="100" cy="200" r="15" fill="#aa9b13" class="animate-pulse" />
                        <circle cx="400" cy="150" r="20" fill="#05347e" class="animate-bounce" style="animation-duration: 3s" />
                        <circle cx="420" cy="350" r="12" fill="#aa9b13" />
                    </svg>
                </div>
                <div class="absolute -z-10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full border-2 border-dashed border-white/10 rounded-full animate-spin-slow"></div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-30px); }
}
.animate-float { animation: float 6s ease-in-out infinite; }
.animate-spin-slow { animation: spin 12s linear infinite; }
</style>