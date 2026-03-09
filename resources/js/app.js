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

const notificationBtn = document.getElementById('notification-btn');
const notificationDropdown = document.getElementById('notification-dropdown');

if(notificationBtn && notificationDropdown){
    notificationBtn.addEventListener('click',(e)=>{
        e.stopPropagation()
    
        notificationDropdown.classList.toggle('hidden')
    });

    document.addEventListener('click', (e)=>{
        if(!notificationBtn.contains(e.target) && !notificationDropdown.contains(e.target)){
            notificationDropdown.classList.add('hidden')
        }
    })

}