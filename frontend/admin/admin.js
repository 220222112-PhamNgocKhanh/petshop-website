function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('collapsed');
}

function openModal() {
    document.getElementById("productModal").style.display = "block";
}

function closeModal() {
    document.getElementById("productModal").style.display = "none";
}

function saveProduct() {
    let name = document.getElementById("productName").value;
    let price = document.getElementById("productPrice").value;
    
    if (name === "" || price === "") {
        alert("Vui lòng nhập đủ thông tin!");
        return;
    }

    let table = document.getElementById("productTable");
    let row = table.insertRow();
    row.innerHTML = `<td>${table.rows.length}</td>
                     <td>${name}</td>
                     <td>${price}đ</td>
                     <td><img src="default.jpg" class="product-img"></td>
                     <td>
                         <button class="edit-btn" onclick="editProduct(this)">✏️</button>
                         <button class="delete-btn" onclick="deleteProduct(this)">🗑️</button>
                     </td>`;
    
    closeModal();
}

function deleteProduct(button) {
    let row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

function editProduct(button) {
    let row = button.parentNode.parentNode;
    document.getElementById("productName").value = row.cells[1].innerText;
    document.getElementById("productPrice").value = row.cells[2].innerText.replace("đ", "");
    openModal();
}
