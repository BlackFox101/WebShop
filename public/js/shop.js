const titleEditor = document.querySelector('.input-flex.title-editor')
const placeholderFotTitle = document.querySelector('.hidden_for_title_editor')

const descriptionEditor = document.querySelector('.input-flex.description_editor')
const placeholderFotDescription = document.querySelector('.hidden_for_description_editor')

const itemsContainer = document.querySelector('.shop-items-container')

const items = Array.from(document.querySelectorAll('.shop-items-container .shop-item'))
    .map(i => i.querySelector('i'))

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
    if (i.dataset.type === 'delete') {
        i.addEventListener('click', (e) => {
            if (confirm('Вы уверены?')) {
                const container = e.target.parentNode.parentNode
                const response = fetch('/products/delete', {
                    method: 'DELETE',
                    body: JSON.stringify({
                        id: container.id
                    })
                })
                itemsContainer.removeChild(container)
            }
        })
    } else {
        i.addEventListener('click', (e) => {
            const container = e.target.parentNode.parentNode
            const promise = fetch('/products/change_favorite', {
                method: "POST",
                body: JSON.stringify({
                    id: container.id,
                })
            })
            if (e.target.className === 'fas fa-star') {
                e.target.className = 'far fa-star'
            } else {
                e.target.className = 'fas fa-star'
            }
        })
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
    descriptionEditor.addEventListener('input', debounce((e) => {
        console.log('request has been sent', e.target.value)
    }))
}