const findBtn = document.querySelector('.find-button');
const select = document.querySelector('#header__search-select');
const authMenuBtn = document.querySelector('#auth-menu');
const authMenuList = authMenuBtn.querySelector('#auth-menu__list');
const authMenuArrow = document.getElementById('menu_arrow');
const IS_HIDDEN = 'is_hidden';

findBtn.addEventListener('click', () => {
    let selectedCategory = select.value;
    // TODO
    console.log('clicked', selectedCategory)
})

authMenuBtn.addEventListener('click', (e) => {
    authMenuList.classList.toggle(IS_HIDDEN);
    authMenuArrow.classList.toggle('fa-arrow-up');
})

window.addEventListener('click', (e) => {
    if (!['auth-menu__list', 'user-name', 'auth-menu'].includes(e.target.parentNode.className)
        && !authMenuList.classList.contains(IS_HIDDEN)) {
        authMenuList.classList.add(IS_HIDDEN);
        authMenuArrow.classList.add('fa-arrow-up');
    }
})