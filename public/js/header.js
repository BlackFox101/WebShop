const searchBtn = document.querySelector('#search-button');
const select = document.querySelector('#header__search-select');
const inputName = document.querySelector('#header__search-input');
const authMenuBtn = document.querySelector('#auth-menu');
const authMenuList = document.querySelector('#auth-menu__list');
const authMenuArrow = document.getElementById('menu_arrow');
const categorySelector = document.getElementById('category-selector');
const IS_HIDDEN = 'is_hidden';

headerHandler();

function headerHandler() {
    initHeaderSearchValue();
    headerSearchHandler();
    categorySelectorHandler()

    if (authMenuBtn) {
        addMenuOpening();
        addMenuClosure();
    }
}

function categorySelectorHandler() {
    if  (categorySelector) {
        const paramsString = document.location.search;
        const searchParams = new URLSearchParams(paramsString);
        const category = searchParams.get('category');
        const options = categorySelector.querySelectorAll('option');
        const values = [];
        options.forEach((option) => {
            values.push(option.getAttribute('value'));
        })
        if (values.includes(category))
        {
            categorySelector.value = category;
        }
    }
}

function initHeaderSearchValue() {
    const paramsString = document.location.search;
    const searchParams = new URLSearchParams(paramsString);
    inputName.value = searchParams.get('name');
    const selectName = document.location.pathname.slice(1)

    if (['shops', 'products'].includes(selectName))
    {
        select.value = selectName;
    }
}

function headerSearchHandler() {
    searchBtn.addEventListener('click', async() => {
        const selectedCategory = select.value;
        const name = inputName.value;
        const category = inputName.value;
        let newUrl = `/${selectedCategory}?`;
        if (name) {
            newUrl += `name=${name}&`;
        }
        if  (categorySelector && categorySelector.value) {
            newUrl += `category=${categorySelector.value}&`;
        }
        document.location.href = newUrl;
    })
}

function addMenuOpening() {
    authMenuBtn.addEventListener('click', (e) => {
        authMenuList.classList.toggle(IS_HIDDEN);
        authMenuArrow.classList.toggle('fa-arrow-up');
    })
}

function addMenuClosure() {
    window.addEventListener('click', (e) => {
        if (!['auth-menu__list', 'user-name', 'auth-menu'].includes(e.target.parentNode.className)
            && !authMenuList.classList.contains(IS_HIDDEN)) {
            authMenuList.classList.add(IS_HIDDEN);
            authMenuArrow.classList.add('fa-arrow-up');
        }
    })
}