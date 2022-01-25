const fileInput = document.getElementById('upload_photo')
const createBtn = document.getElementById('create_item_btn')

const description = document.getElementById('item_description')
const title = document.getElementById('item_title')
const price = document.getElementById('item_price')
const category = document.getElementById('item-category')

const shopId = document.getElementById('shop-id-input').value

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

    await fetch('/products/create', {
        method: 'POST',
        body: JSON.stringify({
            title: title.value,
            description: description.value,
            price: price.value,
            categoryId: category.value,
            itemImage: filePath ? formData : null,
            shopId,
        })
    })
})