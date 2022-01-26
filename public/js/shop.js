const titleEditor = document.querySelector('.input-flex.title-editor')
const placeholderFotTitle = document.querySelector('.hidden_for_title_editor')

const descriptionEditor = document.querySelector('.input-flex.description_editor')
const placeholderForDescription = document.querySelector('.hidden_for_description_editor')

const itemsContainer = document.querySelector('.shop-items-container')

const items = Array.from(document.querySelectorAll('.shop-items-container .shop-item'))
    .map(i => i.querySelector('i'))

const shopId = document.getElementById('shop-id-input').value

function debounce(callback, timeout = 500) {
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
                const container = e.target.parentNode.parentNode;
                const id = container.id;
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
        i.addEventListener('click', async (e) => {
            const container = e.target.parentNode.parentNode;
            const id = container.id;
            const response = await fetch('/user/favourites/change/' + container.id, {
                method: "PUT"
            });

            if (response.status === 200) {
                if (e.target.className === 'fas fa-star') {
                    e.target.className = 'far fa-star'
                } else {
                    e.target.className = 'fas fa-star'
                }
            }
        })
    }
})

if (titleEditor) {
    titleEditor.value = placeholderFotTitle.innerHTML

    titleEditor.addEventListener('input', debounce((e) => {
        fetch('/shop/change_name', {
            method: "POST",
            body: JSON.stringify({
                name: e.target.value,
                shopId
            })
        })
    }))
}

if (descriptionEditor) {
    descriptionEditor.innerHTML = placeholderForDescription.innerHTML
    descriptionEditor.addEventListener('input', debounce((e) => {
        fetch('/shop/change_description', {
            method: "POST",
            body: JSON.stringify({
                description: e.target.value,
                shopId
            })
        })
    }))
}