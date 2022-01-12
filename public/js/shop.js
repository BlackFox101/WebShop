const titleEditor = document.querySelector('.input-flex.title-editor')
const placeholderFotTitle = document.querySelector('.hidden_for_title_editor')

const descriptionEditor = document.querySelector('.input-flex.description_editor')
const placeholderFotDescription = document.querySelector('.hidden_for_description_editor')

const items = document.querySelectorAll('.shop-items-container .shop-item')

function debounce(callback, timeout = 300) {
    let timer
    return (...args) => {
        clearTimeout(timer)
        timer = setTimeout(() => {
            callback(...args)
        }, timeout)
    }
}

items.forEach(i => {
    if (i.getAttribute('type') === 'delete') {
        const deleteBtn = i.querySelector('i')
        if (deleteBtn) {
            deleteBtn.addEventListener('click', () => {
                console.log('delete', i.id)
            })
        }
    } else {
        const favoriteBtn = i.querySelector('i')
        if (favoriteBtn) {
            favoriteBtn.addEventListener('click', (e) => {
                if (e.target.className === 'fas fa-star') {
                    // request
                    e.target.className = 'far fa-star'
                } else {
                    // request
                    e.target.className = 'fas fa-star'
                }
            })
        }
    }
})

if (titleEditor) {
    titleEditor.innerHTML = placeholderFotTitle.innerHTML
    const startWidth = placeholderFotTitle.getBoundingClientRect().width
    const startHeight = placeholderFotTitle.getBoundingClientRect().height

    titleEditor.style.width = startWidth + 30 + 'px'
    titleEditor.style.height = startHeight + 'px'

    titleEditor.addEventListener('input', debounce((e) => {
        console.log('request has been sent', e.target.value)
    }))
    titleEditor.addEventListener('input', (e) => {
        placeholderFotTitle.innerHTML = e.target.value || 'Введите название магазина...'
        const {width} = placeholderFotTitle.getBoundingClientRect()
        titleEditor.style.width = width + 20 + 'px'
    })
}

if (descriptionEditor) {
    descriptionEditor.innerHTML = placeholderFotDescription.innerHTML
    const startWidth = placeholderFotDescription.getBoundingClientRect().width

    descriptionEditor.style.width = startWidth + 30 + 'px'

    descriptionEditor.addEventListener('input', debounce((e) => {
        console.log('request has been sent', e.target.value)
    }))
    descriptionEditor.addEventListener('input', (e) => {
        placeholderFotDescription.innerHTML = e.target.value || 'Введите описание магазина...'
        const {width} = placeholderFotDescription.getBoundingClientRect()
        descriptionEditor.style.width = width + 20 + 'px'
    })
}