// fungsi sidebar
const toggle = document.querySelector('.toggle');
    const navigation = document.querySelector('.navigation');
    const main = document.querySelector('.main');

    toggle.onclick = function (e) {
        navigation.classList.toggle('active');
        main.classList.toggle('active');
    };