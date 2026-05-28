<?php include '../includes/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories</title>
    
    <!-- Fonts & Icon CDNs -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
    <link href="../assets/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
</head>
<body>

<?php include '../includes/sidebar.php'; ?>

<!-- MAIN VIEW -->
<div class="main">
    <div class="content-panel">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="m-0">Categories Management</h2>
            <button class="btn btn-warning px-4 text-dark fw-bold" style="border-radius: 14px;" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-circle me-2"></i>Add Category
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 10%;">ID</th>
                        <th style="width: 25%;">Category Name</th>
                        <th style="width: 45%;">Description</th>
                        <th style="width: 20%;" class="text-center">Action</th>
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
        <div class="modal-content" style="border-radius: 24px; border: 2px solid var(--border-clean);">
            <div class="modal-header" style="background-color: var(--bg-sidebar); border-top-left-radius: 22px; border-top-right-radius: 22px;">
                <h5 class="modal-title fw-bold" style="color: var(--accent-green)">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addForm">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Category Name</label>
                        <input name="CategoryName" class="form-control" placeholder="e.g., Laptops" style="border-radius: 12px;" required>
                    </div>
                    <div>
                        <label class="form-label small fw-bold">Description</label>
                        <textarea name="Description" class="form-control" rows="3" placeholder="Provide basic description details..." style="border-radius: 12px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold" style="border-radius: 14px;">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 24px; border: 2px solid var(--border-clean);">
            <div class="modal-header" style="background-color: var(--bg-sidebar); border-top-left-radius: 22px; border-top-right-radius: 22px;">
                <h5 class="modal-title fw-bold" style="color: var(--accent-green)">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm">
                <div class="modal-body p-4">
                    <input type="hidden" name="CategoryID" id="edit_id">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Category Name</label>
                        <input name="CategoryName" id="edit_name" class="form-control" style="border-radius: 12px;" required>
                    </div>
                    <div>
                        <label class="form-label small fw-bold">Description</label>
                        <textarea name="Description" id="edit_description" class="form-control" rows="3" style="border-radius: 12px;"></textarea>
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

function showSuccess(msg){
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: msg,
        timer: 1800,
        showConfirmButton: false
    });
}

function escapeJS(str) {
    if (!str) return '';
    return str.replace(/'/g, "\\'").replace(/"/g, '&quot;');
}

// 1. READ
fetchData();
function fetchData(){
    fetch('fetch.php')
        .then(res => res.json())
        .then(data => {
            let html = "";
            data.forEach(r => {
                let safeDesc = r.Description ? r.Description : 'No description provided.';
                html += `
                <tr>
                    <td><strong>#${r.CategoryID}</strong></td>
                    <td>${r.CategoryName}</td>
                    <td><span class="badge-soft-success"><i class="bi bi-tags me-1"></i>${safeDesc}</span></td>
                    <td class="text-center" style="white-space: nowrap;">
                        <button class="btn btn-sm btn-outline-primary px-3 me-1" style="border-radius:10px" onclick="openEditModal(${r.CategoryID}, '${r.CategoryName.replace(/'/g, "\\'")}', '${safeDesc.replace(/'/g, "\\'")}')"><i class="bi bi-pencil-square"></i> Edit</button>
                        <button class="btn btn-sm btn-danger px-3" style="border-radius:10px" onclick="del(${r.CategoryID})"><i class="bi bi-trash3"></i> Delete</button>
                    </td>
                </tr>`;
            });
            dataTable.innerHTML = html;
        });
}
// 2. CREATE (Insert)
addForm.onsubmit = e => {
    e.preventDefault();
    fetch('insert.php', {
        method: 'POST',
        body: new FormData(addForm)
    })
    .then(r => r.text())
    .then(() => {
        showSuccess("Category Created Successfully");
        fetchData();
        addForm.reset();
        bootstrap.Modal.getInstance(document.getElementById('addModal')).hide();
    });
};

// 3. POPULATE & OPEN EDIT MODAL
function openEditModal(id, name, desc) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_description').value = desc;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}

// 4. UPDATE (Save Changes)
editForm.onsubmit = e => {
    e.preventDefault();
    fetch('update.php', {
        method: 'POST',
        body: new FormData(editForm)
    })
    .then(r => r.text())
    .then(() => {
        showSuccess("Category Updated Successfully");
        fetchData();
        bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
    });
};

// 5. DELETE
function del(id){
    Swal.fire({
        title: "Are you sure?",
        text: "This action cannot be undone.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#606c38",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then(res => {
        if(res.isConfirmed){
            fetch('delete.php?id=' + id)
                .then(r => r.text())
                .then(() => {
                    showSuccess("Category Deleted");
                    fetchData();
                });
        }
    });
}
</script>
</body>
</html>