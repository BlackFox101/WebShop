const shops = document.querySelectorAll('.profile-container-bottom a')

shops.forEach(shop => {
    const eye = shop.querySelector('i')
    eye.addEventListener('click', (e) => {
        e.preventDefault()
        // make request to change visibility
        console.log('clicked', shop.id)
    })
})