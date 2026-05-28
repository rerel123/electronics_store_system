<?php include '../includes/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers Management</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<?php include '../includes/sidebar.php'; ?>

<div class="main">
    <div class="content-panel">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="m-0">Customers Management</h2>
            <button class="btn btn-warning fw-bold px-4" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-circle me-1"></i> Add Customer
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>City</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="data">
                    </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="addForm">
                <div class="modal-header">
                    <h5 class="modal-title">Add Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Customer Name</label>
                        <input name="CustomerName" class="form-control" placeholder="Customer Name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input name="City" class="form-control" placeholder="City" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success w-100">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editForm">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="CustomerID" id="edit_id">
                    <div class="mb-3">
                        <label class="form-label">Customer Name</label>
                        <input name="CustomerName" id="edit_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input name="City" id="edit_city" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const table = document.getElementById("data");
const addModalObj = new bootstrap.Modal(document.getElementById("addModal"));
const editModalObj = new bootstrap.Modal(document.getElementById("editModal"));

function showSuccess(msg){
    Swal.fire({
        icon: "success",
        title: "Success",
        text: msg,
        timer: 1500,
        showConfirmButton: false
    });
}

// ================= READ (FETCH) =================
function loadData(){
    // Gidiretso ra sa "fetch.php" kay pareha rani sila og folder (customers/)
    fetch("fetch.php")
    .then(res => res.json())
    .then(response => {
        let html = "";
        
        if(response.status === 'success' && Array.isArray(response.data)) {
            if (response.data.length === 0) {
                html = `<tr><td colspan="4" class="text-center text-muted">No customers found.</td></tr>`;
            } else {
                response.data.forEach(r => {
                    let safeName = r.CustomerName ? r.CustomerName.replace(/'/g, "\\'") : "";
                    let safeCity = r.City ? r.City.replace(/'/g, "\\'") : "";
                    
                    html += `
                    <tr>
                        <td><strong>#${r.CustomerID}</strong></td>
                        <td>${r.CustomerName || 'No Name'}</td>
                        <td>${r.City || 'No City'}</td>
                        <td class="text-center" style="white-space: nowrap;">
                            <button class="btn btn-sm btn-outline-primary px-3 me-1" style="border-radius:10px" 
                                onclick="openEditModal(${r.CustomerID}, '${safeName}', '${safeCity}')">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                            <button class="btn btn-sm btn-danger px-3" style="border-radius:10px" 
                                onclick="del(${r.CustomerID})">
                                <i class="bi bi-trash3"></i> Delete
                            </button>
                        </td>
                    </tr>`;
                });
            }
        } else {
            html = `<tr><td colspan="4" class="text-center text-muted">Failed structure payload format.</td></tr>`;
        }
        table.innerHTML = html;
    })
    .catch(err => {
        console.error("Fetch Error:", err);
        table.innerHTML = `<tr><td colspan="4" class="text-center text-danger">Failed to load data from server.</td></tr>`;
    });
}
loadData();

// ================= CREATE (INSERT) =================
document.getElementById("addForm").onsubmit = function(e){
    e.preventDefault();
    fetch("insert.php", {
        method: "POST",
        body: new FormData(this)
    })
    .then(res => res.json())
    .then(response => {
        if(response.status === 'success') {
            showSuccess(response.message);
            this.reset();
            addModalObj.hide();
            loadData();
        } else {
            Swal.fire("Error", response.message, "error");
        }
    })
    .catch(err => Swal.fire("Server Error", "Failed to add customer.", "error"));
};

// ================= OPEN EDIT MODAL =================
function openEditModal(id, name, city){
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_name").value = name;
    document.getElementById("edit_city").value = city;
    editModalObj.show();
}

// ================= UPDATE =================
document.getElementById("editForm").onsubmit = function(e){
    e.preventDefault();
    fetch("update.php", {
        method: "POST",
        body: new FormData(this)
    })
    .then(res => res.json())
    .then(response => {
        if(response.status === 'success') {
            showSuccess(response.message);
            editModalObj.hide();
            loadData();
        } else {
            Swal.fire("Error", response.message, "error");
        }
    })
    .catch(err => Swal.fire("Server Error", "Failed to update record.", "error"));
};

// ================= DELETE =================
function del(id){
    Swal.fire({
        title: "Delete this customer?",
        text: "This removal cannot be reversed inside the system records!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: "Yes, delete",
    }).then(result => {
        if(result.isConfirmed){
            let formData = new FormData();
            formData.append('id', id);

            fetch("delete.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(response => {
                if(response.status === 'success') {
                    showSuccess(response.message);
                    loadData();
                } else {
                    Swal.fire("Error", response.message, "error");
                }
            })
            .catch(err => Swal.fire("Server Error", "Could not complete drop procedure.", "error"));
        }
    });
}
</script>

</body>
</html>