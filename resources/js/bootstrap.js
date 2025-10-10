// Load the project's JavaScript dependencies which includes Vue and other libraries
// import axios from 'axios';
// window.axios = axios;

// window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';*/

// If you would like to use the Vue 3 framework, please uncomment the following lines and run `npm install`
// import { createApp } from 'vue';
// window.Vue = createApp({});

import { gsap } from 'gsap'
import { ScrollTrigger } from 'gsap/ScrollTrigger'
import { ScrollSmoother } from 'gsap/ScrollSmoother'
import { ScrollToPlugin } from 'gsap/ScrollToPlugin'

gsap.registerPlugin(ScrollTrigger, ScrollSmoother, ScrollToPlugin)
gsap.defaults({ ease: 'expo' })