const SCROLL_TOP_SHOW_BUTTON = 300

function createScrollToTopButton() {
    const button = document.createElement('button')
    button.classList.add('button-scroll-to-top')

    button.innerHTML = '<i class="fas fa-angle-up"></i>'

    button.addEventListener('click', () => {
        window.scrollTo(0, 0)
    })

    window.addEventListener('scroll', () => {
        if (window.pageYOffset > SCROLL_TOP_SHOW_BUTTON) {
            button.classList.add('show')
        } else {
            button.classList.remove('show')
        }
    })

    document.body.appendChild(button)
}

createScrollToTopButton()