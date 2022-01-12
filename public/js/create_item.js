const fileInput = document.getElementById('upload_photo')
const createBtn = document.getElementById('create_item_btn')

const description = document.getElementById('item_description')
const title = document.getElementById('item_title')
const price = document.getElementById('item_price')
const category = document.getElementById('item-category')

createBtn.addEventListener('click', async () => {
    const allowedFileExtensions =
        /(\.jpg|\.jpeg|\.png|\.gif)$/i
    const filePath = fileInput.value

    if (filePath && !allowedFileExtensions.exec(filePath)) {
        alert('Invalid file type');
        fileInput.value = '';
        return false;
    }

    const files = fileInput.files
    const formData = new FormData()

    if (filePath) {
        formData.append('shop_image', files[0])
    }

    await fetch('', {
        method: 'POST',
        body: {
            title: title.value,
            description: description.value,
            price: price.value,
            category: category.value,
            itemImage: filePath ? formData : null
        }
    })

    console.log({
        title: title.value,
        description: description.value,
        price: price.value,
        itemImage: filePath ? formData : null,
        category: category.value,
    })
})