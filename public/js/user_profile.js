const shops = document.querySelectorAll('.profile-container-bottom a')

shops.forEach(shop => {
    if (!shop.id) {
        return
    }
    const eye = shop.querySelector('i')
    eye.addEventListener('click', (e) => {
        e.preventDefault()
        if (eye.className === 'fa fa-eye') {
            eye.className = 'fa fa-eye-slash'
        } else {
            eye.className = 'fa fa-eye'
        }
        const promise = fetch('/shop/change_visibility', {
            method: 'POST',
            body: JSON.stringify({
                id: shop.id,
            })
        })
    })
})