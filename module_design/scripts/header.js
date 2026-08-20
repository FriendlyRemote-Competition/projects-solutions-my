const header = document.querySelector('header');
const hero = document.querySelector('.hero');

window.addEventListener('scroll', (e) => {
    let scrollY = window.scrollY
    let threshold = hero.clientHeight * 0.2

    if(scrollY > threshold) {
        header.classList.add('scroll');
    }else{
        header.classList.remove('scroll');
    }
})

const navLinks = document.querySelectorAll('nav a');
const sections = document.querySelectorAll('section[id]');
const headerHeight = header.clientHeight;
const observerOptions = {
    root: null,
    rootMargin: "-40% 0px -60% 0px",
    threshold:0
}

const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if(entry.isIntersecting) {
            const id = entry.target.id
            navLinks.forEach(link => link.classList.remove('active'))
            const activeLink = document.querySelector(`nav a[href="#${id}"]`)
            if(activeLink) activeLink.classList.add('active')
        }
    })
}, observerOptions);

sections.forEach(section => observer.observe(section));

const mobileMenuBtn = document.querySelector('.mobile-icon')
const mobileMenu = document.querySelector('#mobile-menu');
const closeBtn = document.querySelector('#close-btn');
const mobileLinks = document.querySelectorAll('.mobile-link');

mobileMenuBtn.addEventListener('click', () => {
    openMobile()

})
closeBtn.addEventListener('click', () => {
    closeMobile()

})
mobileLinks.forEach(link => {
    link.addEventListener('click', () => {
       closeMobile()

    })
});

document.addEventListener('keydown', (e)=> {
    if(e.key === 'Escape') return closeMobile()
})

const closeMobile = () => {
    mobileMenu.classList.remove('active');
    mobileMenu.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = 'auto';
}
const openMobile = () => {
    mobileMenu.classList.add('active');
    mobileMenu.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
}