<?php include '../includes/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management</title>
    
    <!-- Fonts & CDNs -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Plus+Jakarta+Sans:wght@200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="../assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php include '../includes/sidebar.php'; ?>

<!-- MAIN VIEW -->
<div class="main" style="margin-left: 330px; padding: 2.5rem 2.5rem 2.5rem 1rem;">
    <div class="content-panel" style="background: #fff; border: 2px solid #d5e0c5; border-radius: 28px; padding: 2.2rem;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="m-0" style="font-family: 'Fredoka';">Products Management</h2>
            <button class="btn btn-warning px-4 text-dark fw-bold" style="border-radius: 14px;" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-circle me-2"></i>Add Product
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Supplier ID</th>
                        <th>Category ID</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="data">
                    <!-- Dynamic Rows Loaded Here -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ADD MODAL -->
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 24px;">
            <div class="modal-header" style="background-color: #e2ebd5;">
                <h5 class="modal-title fw-bold" style="color: #606c38">Add New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addForm">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Product Name</label>
                        <input name="ProductName" class="form-control" style="border-radius: 12px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Supplier ID (Manual Input)</label>
                        <input type="number" name="SupplierID" class="form-control" placeholder="Enter Supplier ID Number" style="border-radius: 12px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Category ID (Manual Input)</label>
                        <input type="number" name="CategoryID" class="form-control" placeholder="Enter Category ID Number" style="border-radius: 12px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Unit</label>
                        <input name="Unit" class="form-control" placeholder="e.g., 10 boxes, 1 pc" style="border-radius: 12px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Price</label>
                        <input type="number" step="0.01" name="Price" class="form-control" style="border-radius: 12px;" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold" style="border-radius: 14px;">Save Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 24px;">
            <div class="modal-header" style="background-color: #e2ebd5;">
                <h5 class="modal-title fw-bold" style="color: #606c38">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <div class="modal-body p-4">
                    <input type="hidden" name="ProductID" id="edit_id">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Product Name</label>
                        <input name="ProductName" id="edit_name" class="form-control" style="border-radius: 12px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Supplier ID</label>
                        <input type="number" name="SupplierID" id="edit_supplier" class="form-control" style="border-radius: 12px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Category ID</label>
                        <input type="number" name="CategoryID" id="edit_category" class="form-control" style="border-radius: 12px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Unit</label>
                        <input name="Unit" id="edit_unit" class="form-control" style="border-radius: 12px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Price</label>
                        <input type="number" step="0.01" name="Price" id="edit_price" class="form-control" style="border-radius: 12px;" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" style="border-radius: 14px;">Update Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const dataTable = document.getElementById('data');
const addForm = document.getElementById('addForm');
const editForm = document.getElementById('editForm');

function showSuccess(msg) {
    Swal.fire({ icon: 'success', title: 'Success', text: msg, timer: 1800, showConfirmButton: false });
}

// 1. READ
fetchData();
function fetchData(){
    fetch('fetch.php')
        .then(res => res.json())
        .then(data => {
            let html = "";
            data.forEach(r => {
                html += `
                <tr>
                    <td><strong>#${r.ProductID}</strong></td>
                    <td>${r.ProductName}</td>
                    <td><span class="badge bg-light text-dark border">${r.SupplierID || 'N/A'}</span></td>
                    <td><span class="badge bg-light text-dark border">${r.CategoryID || 'N/A'}</span></td>
                    <td>${r.Unit}</td>
                    <td class="fw-bold text-success">$${parseFloat(r.Price).toFixed(2)}</td>
                    <td class="text-center" style="white-space: nowrap;">
                        <button class="btn btn-sm btn-outline-primary px-3 me-1" style="border-radius:10px" 
                            onclick="openEditModal(${r.ProductID}, '${r.ProductName.replace(/'/g, "\\'")}', ${r.SupplierID}, ${r.CategoryID}, '${r.Unit.replace(/'/g, "\\'")}', ${r.Price})">
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger px-3" style="border-radius:10px" onclick="del(${r.ProductID})">
                            <i class="bi bi-trash3"></i> Delete
                        </button>
                    </td>
                </tr>`;
            });
            dataTable.innerHTML = html;
        });
}

// 2. CREATE
addForm.onsubmit = e => {
    e.preventDefault();
    fetch('insert.php', { method: 'POST', body: new FormData(addForm) })
    .then(() => {
        showSuccess("Product Added Successfully");
        fetchData();
        addForm.reset();
        bootstrap.Modal.getInstance(document.getElementById('addModal')).hide();
    });
};

// 3. OPEN EDIT MODAL
function openEditModal(id, name, supplierId, categoryId, unit, price) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_unit').value = unit;
    document.getElementById('edit_price').value = price;
    
    // Direkta na i-assign ang mga ID values sa input fields
    document.getElementById('edit_supplier').value = supplierId;
    document.getElementById('edit_category').value = categoryId;

    new bootstrap.Modal(document.getElementById('editModal')).show();
}

// 4. UPDATE
editForm.onsubmit = e => {
    e.preventDefault();
    fetch('update.php', { method: 'POST', body: new FormData(editForm) })
    .then(() => {
        showSuccess("Product Updated Successfully");
        fetchData();
        bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
    });
};

// 5. DELETE
function del(id){
    Swal.fire({
        title: "Are you sure?",
        text: "This product will be permanently removed.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#606c38",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then(res => {
        if(res.isConfirmed){
            fetch('delete.php?id=' + id).then(() => {
                showSuccess("Product Deleted");
                fetchData();
            });
        }
    });
}
</script>
</body>
</html>