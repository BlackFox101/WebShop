const shops = document.querySelectorAll('.shop')
const profileContainer = document.querySelector('.profile-container-bottom')

shops.forEach(shop => {
    if (!shop.id) {
        return
    }

    const hideShop = shop.querySelector('#hide-shop')
    const deleteShop = shop.querySelector('#delete-shop')

    hideShop.addEventListener('click', async (e) => {
        e.preventDefault()
        const response = await fetch('/shop/change_visibility', {
            method: 'POST',
            body: JSON.stringify({
                id: shop.id,
            })
        })

        if (response.status === 200) {
            if (hideShop.className === 'fa fa-eye') {
                hideShop.className = 'fa fa-eye-slash'
            } else {
                hideShop.className = 'fa fa-eye'
            }
        }
    })

    deleteShop.addEventListener('click', (e) => {
        e.preventDefault()
        const parent = e.target.parentNode.parentNode
        const promise = fetch('/shop/delete/' + shop.id, {
            method: 'DELETE'
        })
        profileContainer.removeChild(parent)
    })
})