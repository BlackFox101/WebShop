const categories = document.getElementById('catgetories_list')
const addCategory = document.getElementById('add-category')
const newCategory = document.getElementById('new-category-input')

const statuses = document.getElementById('statuses_list')
const addStatus = document.getElementById('add-status')
const newStatus = document.getElementById('new-status-input')

async function onDeleteListItem(e, type) {
    let url = ''

    switch (type) {
        case 'category':
            categories.removeChild(e.target.parentNode)
            url = '/delete/category'
            break
        case 'status':
            statuses.removeChild(e.target.parentNode)
            url = '/delete/status'
            break
        default:
            alert(`type=${type} is not defined`)
            return
    }
    await fetch('', {
        method: "DELETE",
        body: {
            id: e.target.id
        }
    })
}

async function onCreateListItem(title, type) {
    const li = document.createElement('li')

    const categoryTitle = document.createElement('div')
    categoryTitle.innerText = title

    const deleteIcon = document.createElement('i')
    deleteIcon.title = "Удалить"
    deleteIcon.className = 'far fa-trash-alt'

    li.appendChild(categoryTitle)
    li.appendChild(deleteIcon)

    switch (type) {
        case 'category':
            newCategory.value = ''
            li.className = 'category_list-item'
            categoryTitle.className = 'categoryName'
            deleteIcon.addEventListener('click', (e) => onDeleteListItem(e, 'category'))
            categories.appendChild(li)
            await fetch('', {
                method: "POST",
                body: {
                    title
                }
            })
            // TODO response ID
            // deleteIcon.id = response.body.id
            break
        case 'status':
            newStatus.value = ''
            li.className = 'status_list-item'
            categoryTitle.className = 'statusName'
            deleteIcon.addEventListener('click', (e) => onDeleteListItem(e, 'status'))
            statuses.appendChild(li)
            await fetch('', {
                method: "POST",
                body: {
                    title
                }
            })
            // TODO response ID
            // deleteIcon.id = response.body.id
            break
        default:
            alert(`type=${type} is not defined`)
            return
    }
}

function initListeners() {
    function _initDeleteListener(item, type) {
        const deleteIcon = item.querySelector('i')
        deleteIcon.addEventListener('click', (e) => onDeleteListItem(e, type))
    }

    Array.from(categories.children).forEach(c => _initDeleteListener(c, 'category'))
    Array.from(statuses.children).forEach(s => _initDeleteListener(s, 'status'))
    addCategory.addEventListener('click', (e) => {
        onCreateListItem(newCategory.value, 'category')
    })
    addStatus.addEventListener('click', (e) => {
        onCreateListItem(newStatus.value, 'status')
    })
}

initListeners()