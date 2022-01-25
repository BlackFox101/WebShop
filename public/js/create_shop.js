const fileInput = document.getElementById('upload_photo')
const createBtn = document.getElementById('creat_shop_btn')

const description = document.getElementById('shop_description')
const title = document.getElementById('shop_title')

const userId = document.getElementById('user-id-input').value

createBtn.addEventListener('click', async () => {
    const allowedFileExtensions =
        /(\.jpg|\.jpeg|\.png|\.gif)$/i
    const filePath = fileInput.value

    if (filePath && !allowedFileExtensions.exec(filePath)) {
        alert('Invalid file type')
        fileInput.value = ''
        return false
    }

    const files = fileInput.files
    const formData = new FormData()

    if (filePath) {
        formData.append('image', files[0])
    }

    await fetch('', {
        method: 'POST',
        body: JSON.stringify({
            title: title.value,
            description: description.value,
            shopImage: filePath ? formData : null,
            userId
        })
    })
})