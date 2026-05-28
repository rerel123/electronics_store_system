<?php include '../includes/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees Management</title>
    
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

<!-- SIDEBAR -->
<?php include '../includes/sidebar.php'; ?>

<!-- MAIN VIEW -->
<div class="main" style="margin-left: 330px; padding: 2.5rem 2.5rem 2.5rem 1rem;">
    <div class="content-panel" style="background: #fff; border: 2px solid #d5e0c5; border-radius: 28px; padding: 2.2rem;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="m-0" style="font-family: 'Fredoka';">Employees Management</h2>
            <button class="btn btn-warning px-4 text-dark fw-bold" style="border-radius: 14px;" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-circle me-2"></i>Add Employee
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Birth Date</th>
                        <th>Role / Position</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="data">
                    <!-- Dynamic Fetch Content -->
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
                <h5 class="modal-title fw-bold" style="color: #606c38">Add New Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addForm">
                <div class="modal-body p-4">
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label small fw-bold">First Name</label>
                            <input name="FirstName" class="form-control" style="border-radius: 12px;" required>
                        </div>
                        <div class="col">
                            <label class="form-label small fw-bold">Last Name</label>
                            <input name="LastName" class="form-control" style="border-radius: 12px;" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Birth Date</label>
                        <input type="date" name="BirthDate" class="form-control" style="border-radius: 12px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Role / Position</label>
                        <input name="Roles" class="form-control" placeholder="e.g., Manager, Cashier" style="border-radius: 12px;" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold" style="border-radius: 14px;">Save Employee</button>
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
                <h5 class="modal-title fw-bold" style="color: #606c38">Edit Employee Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <div class="modal-body p-4">
                    <input type="hidden" name="EmployeeID" id="edit_id">
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label small fw-bold">First Name</label>
                            <input name="FirstName" id="edit_first_name" class="form-control" style="border-radius: 12px;" required>
                        </div>
                        <div class="col">
                            <label class="form-label small fw-bold">Last Name</label>
                            <input name="LastName" id="edit_last_name" class="form-control" style="border-radius: 12px;" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Birth Date</label>
                        <input type="date" name="BirthDate" id="edit_birth_date" class="form-control" style="border-radius: 12px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Role / Position</label>
                        <input name="Roles" id="edit_roles" class="form-control" style="border-radius: 12px;" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" style="border-radius: 14px;">Update Details</button>
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
                let formattedBirthDate = r.BirthDate ? new Date(r.BirthDate).toLocaleDateString([], {dateStyle: 'medium'}) : 'N/A';
                
                html += `
                <tr>
                    <td><strong>#${r.EmployeeID}</strong></td>
                    <td class="fw-bold">${r.FirstName} ${r.LastName}</td>
                    <td><i class="bi bi-cake2 me-2 text-muted"></i>${formattedBirthDate}</td>
                    <td><span class="badge-soft-success"><i class="bi bi-briefcase me-1"></i>${r.Roles}</span></td>
                    <td class="text-center" style="white-space: nowrap;">
                        <button class="btn btn-sm btn-outline-primary px-3 me-1" style="border-radius:10px" 
                            onclick="openEditModal(${r.EmployeeID}, '${r.FirstName.replace(/'/g, "\\'")}', '${r.LastName.replace(/'/g, "\\'")}', '${r.BirthDate}', '${r.Roles.replace(/'/g, "\\'")}')">
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger px-3" style="border-radius:10px" onclick="del(${r.EmployeeID})">
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
        showSuccess("Employee Registered Successfully");
        fetchData();
        addForm.reset();
        bootstrap.Modal.getInstance(document.getElementById('addModal')).hide();
    });
};

// 3. OPEN EDIT MODAL
function openEditModal(id, firstName, lastName, birthDate, roles) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_first_name').value = firstName;
    document.getElementById('edit_last_name').value = lastName;
    document.getElementById('edit_birth_date').value = birthDate;
    document.getElementById('edit_roles').value = roles;

    new bootstrap.Modal(document.getElementById('editModal')).show();
}

// 4. UPDATE
editForm.onsubmit = e => {
    e.preventDefault();
    fetch('update.php', { method: 'POST', body: new FormData(editForm) })
    .then(() => {
        showSuccess("Employee Record Updated");
        fetchData();
        bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
    });
};

// 5. DELETE
function del(id){
    Swal.fire({
        title: "Are you sure?",
        text: "Removing this profile will delete their record permanently.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#606c38",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then(res => {
        if(res.isConfirmed){
            fetch('delete.php?id=' + id).then(() => {
                showSuccess("Employee Deleted");
                fetchData();
            });
        }
    });
}
</script>
</body>
</html>