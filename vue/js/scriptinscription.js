const container = document.querySelector('.container');
const boutoni = document.querySelector('.btn-register');
const boutonc = document.querySelector('.btn-login');

boutoni.addEventListener('click', () => {
    container.classList.add('active');
})

boutonc.addEventListener('click', () => {
    container.classList.remove('active');
})