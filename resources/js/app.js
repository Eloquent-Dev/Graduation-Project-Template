import './bootstrap';

const hamMenu = document.querySelector('.ham-menu');
const sideMenu = document.getElementById('side-menu');
const backdrop = document.getElementById('menu-backdrop');

function toggleMenu() {
    hamMenu.classList.toggle('active');
    sideMenu.classList.toggle('-translate-x-full');
    backdrop.classList.toggle('opacity-0');
    backdrop.classList.toggle('pointer-events-none');
}

hamMenu.addEventListener('click', toggleMenu);
backdrop.addEventListener('click', toggleMenu);

