let str=window.location.href;
var url= new URL(str);
var action= url.searchParams.get("action");
console.log(action);

const container = document.querySelector('.container');
const boutoni = document.querySelector('.btn-register');
const boutonc = document.querySelector('.btn-login');

if(action == "inscription"){
    container.classList.add('active');
}

boutoni.addEventListener('click', () => {
    container.classList.add('active');
})

boutonc.addEventListener('click', () => {
    container.classList.remove('active');
})

