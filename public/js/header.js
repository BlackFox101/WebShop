const findBtn = document.querySelector('.header__search-find-btn')
const select = document.querySelector('.header__search-select')
const logoutBtn = document.querySelector('.header__container-logout-btn')

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