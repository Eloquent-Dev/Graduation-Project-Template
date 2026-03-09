import './bootstrap';

//Elements
const hamMenu = document.querySelector('.ham-menu');
const sideMenu = document.getElementById('side-menu');
const backdrop = document.getElementById('menu-backdrop');
const authModal = document.getElementById('auth-modal');
const loginView = document.getElementById('login-view');
const registerView = document.getElementById('register-view');
const oauthCompleteView = document.getElementById('oauth-complete-view');

//Buttons
const openAuthBtn = document.getElementById('open-auth-btn');
const closeAuthBtn = document.getElementById('close-auth-btn');
const showRegisterBtn = document.getElementById('show-register-btn');
const showLoginBtn = document.getElementById('show-login-btn');


function toggleMenu() {
    hamMenu.classList.toggle('active');
    sideMenu.classList.toggle('-translate-x-full');
    backdrop.classList.toggle('opacity-0');
    backdrop.classList.toggle('pointer-events-none');
}

hamMenu.addEventListener('click', toggleMenu);
backdrop.addEventListener('click', toggleMenu);

authModal.addEventListener('click', (e) =>{
    if(e.target === authModal){
        authModal.classList.add('hidden')
    }
})
if(openAuthBtn){
    openAuthBtn.addEventListener('click',(e)=> {
    e.preventDefault();

    loginView.classList.remove('hidden')
    registerView.classList.add('hidden')
    authModal.classList.remove('hidden')
})
}

if(closeAuthBtn){
    closeAuthBtn.addEventListener('click',() =>{
    authModal.classList.add('hidden')
})
}

if(showRegisterBtn){
    showRegisterBtn.addEventListener('click',()=>{
    loginView.classList.add('hidden')
    registerView.classList.remove('hidden')
})
}

if(showLoginBtn){
    showLoginBtn.addEventListener('click',()=>{
    registerView.classList.add('hidden')
    loginView.classList.remove('hidden')
})
}

const autoOpen = authModal.getAttribute('data-auto-open')

if(autoOpen){
    loginView.classList.add('hidden')
    registerView.classList.add('hidden')
    if(oauthCompleteView) oauthCompleteView.classList.add('hidden')

    authModal.classList.remove('hidden')

    if(autoOpen === 'oauth' && oauthCompleteView){
        oauthCompleteView.classList.remove('hidden')
    }else if(autoOpen === 'register'){
        registerView.classList.remove('hidden')
    }else if(autoOpen === 'login'){
        loginView.classList.remove('hidden')
    }
}

const phoneInput1 = document.querySelector("#phone-1");

const iti1 = window.intlTelInput(phoneInput1, {

    initialCountry: "auto",

    geoIpLookup: callback => {

        fetch("https://ipapi.co/json")

            .then(res => res.json())

            .then(data => callback(data.country_code))

            .catch(() => callback("jo")); // Default to Jordan

    },

    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"

});

const phoneInput2 = document.querySelector("#phone-2");

const iti2 = window.intlTelInput(phoneInput2, {

    initialCountry: "auto",

    geoIpLookup: callback => {

        fetch("https://ipapi.co/json")

            .then(res => res.json())

            .then(data => callback(data.country_code))

            .catch(() => callback("jo")); // Default to Jordan

    },

    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"

});
