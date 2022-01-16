const categories = document.getElementById('catgetories_list')
const addCategory = document.getElementById('add-category')
const newCategory = document.getElementById('new-category-input')

async function onDeleteCategory(e) {
    categories.removeChild(e.target.parentNode)

    const response = await fetch('', {
        method: "DELETE",
        body: {
            id: e.target.id
        }
    })
}

Array.from(categories.children).forEach(c => {
    const deleteIcon = c.querySelector('i')
    deleteIcon.addEventListener('click', onDeleteCategory)
})

async function createCategory(title) {
    newCategory.value = ''

    const li = document.createElement('li')
    li.className = 'category_list-item'

    const categoryTitle = document.createElement('div')
    categoryTitle.className = 'categoryName'
    categoryTitle.innerText = title

    const deleteIcon = document.createElement('i')
    deleteIcon.addEventListener('click', onDeleteCategory)
    deleteIcon.title = "Удалить"
    deleteIcon.className = 'far fa-trash-alt'

    li.appendChild(categoryTitle)
    li.appendChild(deleteIcon)
    categories.appendChild(li)

    const response = await fetch('', {
        method: "POST",
        body: {
            title
        }
    })

    // TODO response ID
    // deleteIcon.id = response.body.id
}

addCategory.addEventListener('click', (e) => {
    createCategory(newCategory.value)
})

console.log(addCategory)