<?php 
include __DIR__ . '/includes/db.php'; 

// ✅ GI-FIX: Gi-kuha ang tibuok URL path aron ma-detect maski ang mga sub-folders (e.g., 'customers/index.php')
$current_uri = $_SERVER['SCRIPT_NAME']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electronics Inventory System | Midterm Project</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Unique Matcha-Lemon Color Palette */
            --bg-main: #f7f9f4;         /* Soft Matcha Cream Powder Background */
            --bg-sidebar: #e2ebd5;      /* Aesthetic Sage Tea Green Sidebar */
            --accent-yellow: #fde047;   /* Warm Honey Butter Yellow */
            --accent-green: #606c38;    /* Deep Forest Matcha for sharp headers */
            --text-dark: #2c3516;       /* Deep Organic Green-Brown for high contrast text */
            --text-muted: #6b7a54;      /* Earthy Sage for descriptions */
            --border-clean: #d5e0c5;    /* Clean Matcha Line Separators */
            
            /* Visibility Status Badges */
            --success-bg: #dcfce7;
            --success-text: #166534;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-main);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Fun & Curvy Title Styling for a unique Girly Look */
        h1, h2, h3, .brand-title, .value {
            font-family: 'Fredoka', sans-serif;
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        /* ================= AESTHETIC SAGE SIDEBAR ================= */
        .sidebar {
            width: 280px;
            height: calc(100vh - 40px);
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: var(--bg-sidebar);
            border: 2px solid var(--border-clean);
            border-radius: 28px;
            padding: 2.2rem 1.3rem;
            display: flex;
            flex-direction: column;
            z-index: 1000;
            box-shadow: 0 12px 30px rgba(107, 122, 84, 0.12);
            overflow-y: auto;
        }

        .sidebar .brand-title {
            color: var(--accent-green);
            font-size: 1.5rem;
            margin-bottom: 2.2rem;
            display: flex;
            align-items: center;
            gap: 12px;
            padding-left: 0.5rem;
        }

        .sidebar .brand-title i {
            color: var(--text-dark);
            background: var(--accent-yellow);
            padding: 8px 12px;
            border-radius: 16px;
            box-shadow: 0 4px 10px rgba(253, 224, 71, 0.3);
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            flex-grow: 1;
        }

        .sidebar a {
            color: var(--text-dark);
            text-decoration: none;
            padding: 0.9rem 1.2rem;
            border-radius: 16px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
            border-left: 4px solid transparent;
        }

        .sidebar a i {
            font-size: 1.2rem;
            color: var(--text-muted);
            transition: transform 0.2s ease, color 0.2s ease;
        }

        /* 🌿 GI-FIX: Mo-epekto lang ang yellow gradient kung DILI active ang link */
        .sidebar a:not(.active):hover {
            background: linear-gradient(135deg, #f3e7a1, #e6d8a2, #d8c98a) !important;
            color: var(--accent-green) !important;
            transform: translateX(5px);
            border-left: 4px solid #c2a95c;
            box-shadow: 0 6px 14px rgba(96, 108, 56, 0.12);
        }

        /* 🌿 GI-FIX: Ang icon bounce para lang sa mga dili active */
        .sidebar a:not(.active):hover i {
            transform: scale(1.15) rotate(-5deg);
            color: var(--accent-green);
        }

        /* DYNAMIC ACTIVE STATE STYLING (Pugngan ang hover animations) */
        .sidebar a.active {
            background: var(--accent-yellow) !important;
            color: var(--text-dark) !important;
            font-weight: 600;
            box-shadow: 0 6px 15px rgba(253, 224, 71, 0.45);
            border: 1px solid rgba(0,0,0,0.05);
            transform: none !important; 
            border-left: 4px solid transparent !important;
            cursor: default; /* I-set as plain cursor kay naa naman ka sa mismong page */
        }

        .sidebar a.active i {
            color: var(--text-dark) !important;
            transform: none !important;
        }

        /* Bottom Student Info Tag */
        .student-credit {
            background-color: rgba(255, 255, 255, 0.6);
            padding: 1.2rem;
            border-radius: 20px;
            margin-top: auto;
            border: 2px dashed var(--border-clean);
        }

        /* ================= MAIN CONTENT SPAWN ================= */
        .main {
            margin-left: 330px;
            padding: 2.5rem 2.5rem 2.5rem 1rem;
            min-height: 100vh;
        }

        .topbar-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
        }

        /* Unique Lemon Leaf Banner Curve */
        .aesthetic-banner {
            background: linear-gradient(135deg, #fef08a 0%, #d9f99d 100%);
            border-radius: 32px;
            padding: 2.8rem;
            margin-bottom: 2.5rem;
            border: 2px solid #eab308;
            box-shadow: 0 10px 25px rgba(217, 249, 157, 0.4);
        }

        .aesthetic-banner h1 {
            color: var(--text-dark);
            font-size: 2.2rem;
        }

        .aesthetic-banner p {
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Minimalist Rounded Cards */
        .cute-card {
            background-color: #ffffff;
            border: 2px solid var(--border-clean);
            border-radius: 24px;
            padding: 1.6rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 8px 20px rgba(107, 122, 84, 0.03);
            transition: all 0.25s ease;
        }

        .cute-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(107, 122, 84, 0.1);
            border-color: var(--accent-yellow);
        }

        .cute-card .value {
            font-size: 1.9rem;
            color: var(--text-dark);
            display: block;
        }

        .cute-card .label {
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .cute-card .icon-bubble {
            width: 52px;
            height: 52px;
            border-radius: 18px;
            background-color: var(--bg-sidebar);
            color: var(--accent-green);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }

        /* Panels */
        .content-panel {
            background-color: #ffffff;
            border: 2px solid var(--border-clean);
            border-radius: 28px;
            padding: 2.2rem;
            box-shadow: 0 8px 20px rgba(107, 122, 84, 0.03);
        }

        /* Clean Table Visibility Structure */
        .table {
            color: var(--text-dark) !important;
        }

        .table thead th {
            background-color: var(--bg-sidebar) !important;
            color: var(--accent-green) !important;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: none !important;
            padding: 1.1rem;
        }

        .table thead th:first-child { border-top-left-radius: 16px; border-bottom-left-radius: 16px; }
        .table thead th:last-child { border-top-right-radius: 16px; border-bottom-right-radius: 16px; }

        .table tbody td {
            padding: 1.2rem 1rem;
            border-bottom: 2px solid var(--bg-main) !important;
            font-size: 0.98rem;
        }

        /* Custom Soft Status Badges */
        .badge-soft-success {
            background-color: var(--success-bg);
            color: var(--success-text);
            padding: 0.5rem 1rem;
            border-radius: 14px;
            font-weight: 700;
            font-size: 0.8rem;
            border: 1px solid rgba(22, 101, 52, 0.15);
        }

        /* Responsive Breakpoints */
        @media (max-width: 992px) {
            .sidebar { width: 80px; padding: 2rem 0.5rem; align-items: center; left: 10px; top: 10px; height: calc(100vh - 20px); border-radius: 20px;}
            .sidebar h4 span, .sidebar a span, .student-credit { display: none; }
            .main { margin-left: 100px; padding: 1.5rem; }
            .sidebar .brand-title { justify-content: center; margin-bottom: 1.5rem; padding-left: 0; }
            .sidebar a { justify-content: center; padding: 1rem; border-radius: 16px; }
            .sidebar a:not(.active):hover i { transform: none; }
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="brand-title">
        <i class="bi bi-laptop"></i> <span>GadgetHub</span>
    </div>

    <div class="sidebar-menu">
        <a href="index.php" class="<?php echo (strpos($current_uri, 'index.php') !== false && strpos($current_uri, 'customers/') === false && strpos($current_uri, 'categories/') === false && strpos($current_uri, 'products/') === false && strpos($current_uri, 'suppliers/') === false && strpos($current_uri, 'shippers/') === false && strpos($current_uri, 'orders/') === false && strpos($current_uri, 'orderdetails/') === false && strpos($current_uri, 'employees/') === false) ? 'active' : ''; ?>">
            <i class="bi bi-grid-1x2-fill"></i> <span>Dashboard</span>
        </a>
        <a href="customers/index.php" class="<?php echo (strpos($current_uri, 'customers/') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-hearts"></i> <span>Customers</span>
        </a>
        <a href="categories/index.php" class="<?php echo (strpos($current_uri, 'categories/') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-tags-fill"></i> <span>Categories</span>
        </a>
        <a href="products/index.php" class="<?php echo (strpos($current_uri, 'products/') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-phone-flip"></i> <span>Products</span>
        </a>
        <a href="suppliers/index.php" class="<?php echo (strpos($current_uri, 'suppliers/') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-building-up"></i> <span>Suppliers</span>
        </a>
        <a href="shippers/index.php" class="<?php echo (strpos($current_uri, 'shippers/') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-cursor-fill"></i> <span>Shippers</span>
        </a>
        <a href="orders/index.php" class="<?php echo (strpos($current_uri, 'orders/') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-bag-heart-fill"></i> <span>Orders</span>
        </a>
        <a href="orderdetails/index.php" class="<?php echo (strpos($current_uri, 'orderdetails/') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-receipt-cutoff"></i> <span>Order Details</span>
        </a>
        <a href="employees/index.php" class="<?php echo (strpos($current_uri, 'employees/') !== false) ? 'active' : ''; ?>">
            <i class="bi bi-person-lines-fill"></i> <span>Employees</span>
        </a>
    </div>

    <div class="student-credit mt-4">
        <span class="d-block small fw-bold text-uppercase mb-1" style="font-size: 0.7rem; color: var(--text-muted);">Submitted By:</span>
        <p class="mb-1 fw-bold" style="font-size: 0.95rem; color: var(--text-dark);">Baay, Niza Flor D.</p>
        <span class="badge bg-white fw-bold" style="font-size:0.75rem; color: var(--accent-green); border: 1px solid var(--border-clean);">BSICT 2B1</span>
    </div>
</div>

<div class="main">
    <div class="topbar-wrapper">
        <div>
            <span class="text-uppercase small fw-bold" style="letter-spacing: 0.5px; color: var(--text-muted);">ITE 221 - Information Management</span>
            <h2 class="m-0 mt-1" style="color: var(--accent-green);">Inventory Management</h2>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="text-end d-none d-sm-block">
                <span class="fw-bold d-block" style="font-size: 0.95rem;">Niza Flor Baay</span>
                <small style="color: var(--text-muted);">System Manager</small>
            </div>
            <div style="width: 44px; height: 44px; border-radius: 16px; background: var(--accent-yellow); display:grid; place-items:center; font-weight:700; color: var(--text-dark); box-shadow: 0 4px 12px rgba(253, 224, 71, 0.4);">N</div>
        </div>
    </div>

    <div class="aesthetic-banner">
        <h1>Electronics Inventory Dashboard ✨</h1>
        <p class="mb-0 opacity-90" style="max-width: 600px;">
            Welcome to your interactive dashboard layer. Easily organize items, verify product stock counts, look up supplier attachments, and cross-reference store orders cleanly.
        </p>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="cute-card">
                <div>
                    <span class="label">Total Products</span>
                    <span class="value mt-1">1,240</span>
                </div>
                <div class="icon-bubble"><i class="bi bi-phone"></i></div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="cute-card">
                <div>
                    <span class="label">Active Buyers</span>
                    <span class="value mt-1">450</span>
                </div>
                <div class="icon-bubble"><i class="bi bi-hearts"></i></div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="cute-card">
                <div>
                    <span class="label">Total Orders</span>
                    <span class="value mt-1">892</span>
                </div>
                <div class="icon-bubble"><i class="bi bi-bag-heart-fill"></i></div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="cute-card">
                <div>
                    <span class="label">Main Categories</span>
                    <span class="value mt-1">12 Slots</span>
                </div>
                <div class="icon-bubble"><i class="bi bi-bookmark-star-fill"></i></div>
            </div>
        </div>
    </div>

    <div class="content-panel">
        <h3 class="mb-4" style="font-size: 1.3rem; color: var(--text-dark);"><i class="bi bi-stars" style="color: #eab308;"></i> Recent Gadget Transactions</h3>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Electronic Item</th>
                        <th>Status Group</th>
                        <th class="text-end">Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fw-bold" style="color: var(--text-muted);">#ORD-9021</td>
                        <td class="fw-bold">Alexa Smith</td>
                        <td>MacBook Pro M3 (512GB)</td>
                        <td><span class="badge-soft-success">Dispatched</span></td>
                        <td class="text-end fw-bold">₱89,990.00</td>
                    </tr>
                    <tr>
                        <td class="fw-bold" style="color: var(--text-muted);">#ORD-9022</td>
                        <td class="fw-bold">Jordan Placer</td>
                        <td>iPhone 15 Pro Max</td>
                        <td><span class="badge-soft-success">Dispatched</span></td>
                        <td class="text-end fw-bold">₱72,400.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>