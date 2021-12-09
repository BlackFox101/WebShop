const findBtn = document.querySelector('.find-button')
const select = document.querySelector('.header__search-select')
const logoutBtn = document.querySelector('.header__container-logout-btn')
const authMenuBtn = document.querySelector('.auth-menu')
const authMenuList = authMenuBtn.querySelector('ul')

let selectedCategory = select.value

select.addEventListener('change', () => {
    selectedCategory = select.value
})

logoutBtn.addEventListener('click', async () => {
    const response = await fetch('/logout')
})

findBtn.addEventListener('click', () => {
    // TODO
    console.log('clicked', selectedCategory)
})

authMenuBtn.addEventListener('click', (e) => {
    if (authMenuList.style.display === 'none') {
        authMenuBtn.style.right = '-132px'
        authMenuList.style.display = 'block'
    }
    else if (e.target.parentNode.className !== 'auth-menu__list') {
        authMenuBtn.style.right = '-75px'
        authMenuList.style.display = 'none'
    }
})

window.addEventListener('click', (e) => {
    console.log(e.target.parentNode)
    if (!['auth-menu__list', 'user-name', 'auth-menu'].includes(e.target.parentNode.className)) {
        authMenuBtn.style.right = '-75px'
        authMenuList.style.display = 'none'
    }
})