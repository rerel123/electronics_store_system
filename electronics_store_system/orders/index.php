<?php include '../includes/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Management</title>
    
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

<div class="main" style="margin-left: 330px; padding: 2.5rem 2.5rem 2.5rem 1rem;">
    <div class="content-panel" style="background: #fff; border: 2px solid #d5e0c5; border-radius: 28px; padding: 2.2rem;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="m-0" style="font-family: 'Fredoka';">Orders Management</h2>
            <button class="btn btn-warning px-4 text-dark fw-bold" style="border-radius: 14px;" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-circle me-2"></i>Add Order
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer ID</th>
                        <th>Employee ID</th>
                        <th>Order Date</th>
                        <th>Shipper ID</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="data">
                    </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 24px;">
            <div class="modal-header" style="background-color: #e2ebd5;">
                <h5 class="modal-title fw-bold" style="color: #606c38">Add New Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addForm">
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Customer ID</label>
                        <input type="number" name="CustomerID" class="form-control" placeholder="Enter Customer ID" style="border-radius: 12px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Employee ID</label>
                        <input type="number" name="EmployeeID" class="form-control" placeholder="Enter Employee ID" style="border-radius: 12px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Order Date & Time</label>
                        <input type="datetime-local" name="OrderDate" class="form-control" style="border-radius: 12px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Shipper ID</label>
                        <input type="number" name="ShipperID" class="form-control" placeholder="Enter Shipper ID" style="border-radius: 12px;" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold" style="border-radius: 14px;">Save Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 24px;">
            <div class="modal-header" style="background-color: #e2ebd5;">
                <h5 class="modal-title fw-bold" style="color: #606c38">Edit Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm">
                <div class="modal-body p-4">
                    <input type="hidden" name="OrderID" id="edit_id">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Customer ID</label>
                        <input type="number" name="CustomerID" id="edit_customer" class="form-control" style="border-radius: 12px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Employee ID</label>
                        <input type="number" name="EmployeeID" id="edit_employee" class="form-control" style="border-radius: 12px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Order Date & Time</label>
                        <input type="datetime-local" name="OrderDate" id="edit_date" class="form-control" style="border-radius: 12px;" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Shipper ID</label>
                        <input type="number" name="ShipperID" id="edit_shipper" class="form-control" style="border-radius: 12px;" required>
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

function showAlert(icon, title, text) {
    Swal.fire({ icon: icon, title: title, text: text, timer: 1800, showConfirmButton: false });
}

// 1. READ (FETCH)
fetchData();
function fetchData(){
    fetch('fetch.php')
        .then(res => res.json())
        .then(data => {
            let html = "";
            data.forEach(r => {
                let oID = r.OrderID;
                let cID = r.CustomerID;
                let eID = r.EmployeeID;
                let oDate = r.OrderDate;
                let sID = r.ShipperID;

                let formattedDate = oDate ? oDate.replace('T', ' ') : 'N/A';
                
                html += `
                <tr>
                    <td><strong>#${oID}</strong></td>
                    <td><span class="badge bg-light text-dark border">${cID}</span></td>
                    <td><span class="badge bg-light text-dark border">${eID}</span></td>
                    <td><i class="bi bi-calendar3 me-2 text-muted"></i>${formattedDate}</td>
                    <td><span class="badge bg-light text-dark border">${sID}</span></td>
                    <td class="text-center" style="white-space: nowrap;">
                        <button class="btn btn-sm btn-outline-primary px-3 me-1" style="border-radius:10px" 
                            onclick="openEditModal(${oID}, ${cID}, ${eID}, '${oDate}', ${sID})">
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger px-3" style="border-radius:10px" onclick="del(${oID})">
                            <i class="bi bi-trash3"></i> Delete
                        </button>
                    </td>
                </tr>`;
            });
            dataTable.innerHTML = html;
        });
}

// 2. CREATE (INSERT)
addForm.onsubmit = e => {
    e.preventDefault();
    fetch('insert.php', { method: 'POST', body: new FormData(addForm) })
    .then(res => res.text())
    .then(text => {
        if(text.trim() === "Success") {
            showAlert('success', 'Success', 'Order Logged Successfully');
            fetchData();
            addForm.reset();
            bootstrap.Modal.getInstance(document.getElementById('addModal')).hide();
        } else {
            showAlert('error', 'Error', text);
        }
    });
};

// 3. OPEN EDIT MODAL
function openEditModal(id, customerId, employeeId, orderDate, shipperId) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_customer').value = customerId;
    document.getElementById('edit_employee').value = employeeId;
    
    if(orderDate) {
        document.getElementById('edit_date').value = orderDate.replace(' ', 'T');
    }
    
    document.getElementById('edit_shipper').value = shipperId;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}

// 4. UPDATE
editForm.onsubmit = e => {
    e.preventDefault();
    fetch('update.php', { method: 'POST', body: new FormData(editForm) })
    .then(res => res.text())
    .then(text => {
        if(text.trim() === "Success") {
            showAlert('success', 'Success', 'Order Updated Successfully');
            fetchData();
            bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
        } else {
            showAlert('error', 'Error', text);
        }
    });
};

// 5. DELETE
function del(id){
    Swal.fire({
        title: "Are you sure?",
        text: "This order will be permanently removed.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#606c38",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then(res => {
        if(res.isConfirmed){
            fetch('delete.php?id=' + id)
            .then(res => res.text())
            .then(text => {
                if(text.trim() === "Success") {
                    showAlert('success', 'Deleted', 'Order Deleted Successfully');
                    fetchData();
                } else {
                    showAlert('error', 'Error', text);
                }
            });
        }
    });
}
</script>
</body>
</html>