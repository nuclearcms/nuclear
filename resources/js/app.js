import './bootstrap';

const body = document.body

const smoothWrapper = document.getElementById('smooth-wrapper')
// https://gsap.com/docs/v3/Plugins/ScrollSmoother/
// create the scrollSmoother before your scrollTriggers
if(smoothWrapper) {
    ScrollSmoother.create({
        smooth: 1, // how long (in seconds) it takes to "catch up" to the native scroll position
        effects: true, // looks for data-speed and data-lag attributes on elements
        //smoothTouch: 0.1, // much shorter smoothing time on touch devices (default is NO smoothing on touch devices)
    })
}

gsap.set('.reveal', { opacity: 0, rotateX: 90 })
gsap.set('.reveal-content', { y: 16, opacity: 0 })

ScrollTrigger.batch('.reveal', { onEnter: batch => gsap.to(batch, { opacity: 1, rotateX: 0, duration: 2, stagger: 0.2 }) })
ScrollTrigger.batch('.reveal-content', { onEnter: batch => gsap.to(batch, { opacity: 1, y: 0, duration: 1.5, stagger: 0.1 }) })

// SMOOTH TRIGGERS
const smoothTriggers = document.querySelectorAll('a.smooth-trigger')

smoothTriggers.forEach(item => {
    item.addEventListener('click', e => {
        e.preventDefault()
        gsap.to(window, { duration: 1, scrollTo: { y: item.dataset.target, offsetY: 64 } })
    })
})

const smoothScrollNext = document.querySelectorAll('a.smooth-scroll-next')
smoothScrollNext.forEach(item => {
    item.addEventListener('click', e => {
        e.preventDefault()
        const next = item.closest('.scroll-next').nextElementSibling
        if (next) {
            gsap.to(window, { duration: 1, scrollTo: { y: next, offsetY: 64 } })
        }
    })
})