<?php
session_start();
if (!(isset($_SESSION["uid"]) && isset($_SESSION["user_type"]) && isset($_SESSION["session_id"]))) {
    header("location:../../login.php");
    exit;
} else {
    if (in_array($_SESSION["user_type"], ['Faculty', 'Store', 'Vendor'])) {
        header("location:../index.php");
        exit;

    } else if (!($_SESSION["user_type"] == 'Factory')) {
        header("location:../../login.php");
        exit;
    }
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

include '../../_conn.php';
$user_name = $_SESSION['user_name'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factory Dashboard - Unnati Factory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../../public/css/styles.css">.
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0d6efd;
            --success-color: #198754;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #0dcaf0;
            --secondary-color: #6c757d;
            --dark-color: #212529;
            --light-bg: #f8f9fa;
            --card-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --card-shadow-hover: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            --border-radius: 0.5rem;
            --transition: all 0.3s ease;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .dashboard-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin: 20px;
            padding: 30px;
            min-height: calc(100vh - 40px);
        }

        .dashboard-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 30px;
            border-radius: var(--border-radius);
            margin-bottom: 30px;
            box-shadow: var(--card-shadow);
        }

        .dashboard-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .dashboard-header p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin: 0;
        }

        .metric-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            border: none;
            position: relative;
            overflow: hidden;
            height: 100%;
        }

        .metric-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary-color);
            transition: var(--transition);
        }

        .metric-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-shadow-hover);
        }

        .metric-card:hover::before {
            width: 6px;
        }

        .metric-card.production::before { background: var(--success-color); }
        .metric-card.orders::before { background: var(--warning-color); }
        .metric-card.inventory::before { background: var(--info-color); }
        .metric-card.workers::before { background: var(--secondary-color); }

        .metric-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: white;
        }

        .metric-card.production .metric-icon { background: var(--success-color); }
        .metric-card.orders .metric-icon { background: var(--warning-color); }
        .metric-card.inventory .metric-icon { background: var(--info-color); }
        .metric-card.workers .metric-icon { background: var(--secondary-color); }

        .metric-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--secondary-color);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }

        .metric-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 8px;
        }

        .quick-actions {
            background: white;
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            margin-top: 30px;
        }

        .quick-actions h4 {
            color: var(--dark-color);
            font-weight: 600;
            margin-bottom: 20px;
        }

        .action-buttons {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .action-btn {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            padding: 15px 20px;
            border-radius: var(--border-radius);
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: var(--transition);
            text-align: center;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
            color: white;
        }

        .action-btn i {
            font-size: 1.2rem;
        }

        .modal-content {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            border-bottom: none;
        }

        .modal-title {
            font-weight: 600;
        }

        .btn-close {
            filter: invert(1);
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 768px) {
            .dashboard-container {
                margin: 10px;
                padding: 20px;
            }

            .dashboard-header {
                padding: 20px;
            }

            .dashboard-header h1 {
                font-size: 2rem;
            }

            .action-buttons {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body class="bg-secondary bg-opacity-10">
    <?php
    include '_factory_nav.php';
    ?>
<body class="bg-secondary bg-opacity-10">
    <?php
    include '_factory_nav.php';
    ?>

    <div class="dashboard-container fade-in">
        <div class="dashboard-header">
            <h1><i class="fas fa-industry me-3"></i>Factory Dashboard</h1>
            <p>Monitor production, manage inventory, and track factory operations</p>
        </div>

        <main>
            <?php if ($page === 'dashboard'): ?>

                <?php
                $production = $conn->query("SELECT COUNT(*) as count FROM factory_production WHERE created_for='$user_name'")->fetch_assoc()['count'];
                $pending = $conn->query("SELECT COUNT(*) as count FROM retail_store_stock_request WHERE status='Ordered'")->fetch_assoc()['count'];

                // Get total stock value (current month)
                $totalValueSql = "
                    SELECT SUM(fs.value) AS total_value
                    FROM factory_stock fs
                    INNER JOIN (
                        SELECT item_name, MAX(stock_id) AS max_stock_id
                        FROM factory_stock
                        WHERE created_for = '$user_name'
                        GROUP BY item_name
                    ) latest ON fs.item_name = latest.item_name AND fs.stock_id = latest.max_stock_id
                    WHERE fs.created_for = '$user_name'
                ";
                $totalValueResult = $conn->query($totalValueSql);
                $totalValue = 0;
                if ($totalValueResult->num_rows > 0) {
                    $row = $totalValueResult->fetch_assoc();
                    $totalValue = $row['total_value'] ?? 0;
                }

                $worker = $conn->query("SELECT COUNT(*) as count FROM factory_workers WHERE created_for = '$user_name'")->fetch_assoc()['count'];
                ?>

                <!-- Enhanced Metrics Cards -->
                <div class="row g-4 mb-5">
                    <div class="col-lg-3 col-md-6">
                        <div class="metric-card production">
                            <div class="metric-icon">
                                <i class="fas fa-cogs"></i>
                            </div>
                            <div class="metric-title">Today's Production</div>
                            <div class="metric-value"><?= $production ?></div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="metric-card orders">
                            <div class="metric-icon">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div class="metric-title">Pending Orders</div>
                            <div class="metric-value"><?= $pending ?></div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="metric-card inventory">
                            <div class="metric-icon">
                                <i class="fas fa-warehouse"></i>
                            </div>
                            <div class="metric-title">Total Stock Value</div>
                            <div class="metric-value">₹<?php echo number_format($totalValue, 2); ?></div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="metric-card workers">
                            <div class="metric-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="metric-title">Total Workers</div>
                            <div class="metric-value"><?= $worker ?></div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <h4><i class="fas fa-bolt me-2"></i>Quick Actions</h4>
                    <div class="action-buttons">
                        <button type="button" class="action-btn" data-bs-toggle="modal" data-bs-target="#scheduleModal">
                            <i class="fas fa-calendar-plus"></i>
                            Production Scheduling
                        </button>

                        <button type="button" class="action-btn" data-bs-toggle="modal" data-bs-target="#addMaterialModal">
                            <i class="fas fa-box-open"></i>
                            Raw Materials
                        </button>

                        <a href="inventory.php" class="action-btn">
                            <i class="fas fa-boxes"></i>
                            Manage Inventory
                        </a>

                        <a href="workers.php" class="action-btn">
                            <i class="fas fa-user-friends"></i>
                            Worker Management
                        </a>
                    </div>
                </div>

                <?php
                // Get names for Add expense form dropdown
                $itemSql = "SELECT DISTINCT addedBy FROM factory_expenses ORDER BY addedBy";
                $itemResult = $conn->query($itemSql);
                $items = [];
                if ($itemResult->num_rows > 0) {
                    while ($row = $itemResult->fetch_assoc()) {
                        $items[] = $row['addedBy'];
                    }
                }
                ?>
                <?php
                // Get names for Add expense form dropdown
                $unitSql = "SELECT DISTINCT unit FROM factory_raw_material ORDER BY unit";
                $unitResult = $conn->query($unitSql);
                $units = [];
                if ($unitResult->num_rows > 0) {
                    while ($row = $unitResult->fetch_assoc()) {
                        $units[] = $row['unit'];
                    }
                }
                ?>

                <!-- Modal Structure -->
                <div class="modal fade" id="addMaterialModal" tabindex="-1" aria-labelledby="addMaterialModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="addMaterialModalLabel">Add Materials</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <!-- Form to add materials -->
                                <form action="raw_materials.php" method="POST">
                                    <div class="mb-3">
                                        <label for="materialName" class="form-label">Material Name</label>
                                        <input type="text" class="form-control" id="materialName" name="materialName"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="materialName" class="form-label">Category</label>
                                        <input type="text" class="form-control" id="category" name="category" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="createdBy" class="form-label">Created by</label>
                                        <select class="form-control" id="createdBy" name="createdBy"
                                            onchange="toggleItemInput()">
                                            <option value="">Select Name</option>
                                            <?php foreach ($items as $item): ?>
                                                <option value="<?php echo htmlspecialchars($item); ?>">
                                                    <?php echo htmlspecialchars($item); ?>
                                                </option>
                                            <?php endforeach; ?>
                                            <option value="Other">Other</option>
                                        </select>
                                        <input type="text" class="form-control mt-2" id="customCreatedBy"
                                            name="customCreatedBy" style="display:none;" placeholder="Enter new name">
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <input type="text" class="form-control" id="description" name="description"
                                            required>
                                    </div>
                                    <!-- <div class="mb-3">
                            <label for="unit" class="form-label">Per Unit</label>
                            <input type="text" class="form-control" id="unit" name="unit" required>
                        </div>  -->
                                    <div class="mb-3">
                                        <label for="unit" class="form-label">Per Unit</label>
                                        <select class="form-control" id="unit" name="unit" onchange="toggleUnitInput()">
                                            <option value="">Select Unit</option>
                                            <?php foreach ($units as $unit): ?>
                                                <option value="<?php echo htmlspecialchars($unit); ?>">
                                                    <?php echo htmlspecialchars($unit); ?>
                                                </option>
                                            <?php endforeach; ?>
                                            <option value="Other">Other</option>
                                        </select>
                                        <input type="text" class="form-control mt-2" id="customUnit" name="customUnit"
                                            style="display:none;" placeholder="Enter new unit">
                                    </div>
                                    <div class="mb-3">
                                        <label for="materialquantity" class="form-label">Quantity</label>
                                        <input type="number" step="0.01" class="form-control" id="materialquantity"
                                            name="materialquantity">
                                    </div>

                                    <div class="mb-3">
                                        <label for="cost" class="form-label">Cost per Unit</label>
                                        <input type="number" step="0.01" class="form-control" id="cost" name="cost">
                                    </div>

                                    <div class="mb-3">
                                        <label for="amount" class="form-label">Amount</label>
                                        <input type="number" class="form-control" id="amount" name="amount" readonly>
                                    </div>
                                    <script>
                                        const quantityInput = document.getElementById('materialquantity');
                                        const costInput = document.getElementById('cost');
                                        const amountInput = document.getElementById('amount');

                                        function updateAmount() {
                                            const quantity = parseFloat(quantityInput.value) || 0;
                                            const cost = parseFloat(costInput.value) || 0;
                                            const amount = quantity * cost;
                                            amountInput.value = amount.toFixed(2);
                                        }

                                        quantityInput.addEventListener('input', updateAmount);
                                        costInput.addEventListener('input', updateAmount);
                                    </script>
                                    <div class="mb-3">
                                        <label for="number" class="form-label">Mobile Number</label>
                                        <input type="number" class="form-control" id="number" name="number">
                                    </div>
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Date</label>
                                        <input type="date" class="form-control" id="date" name="date" required>
                                    </div>

                                    <div class="container mt-5">
                                        <!-- <form method="POST" action="your_php_file.php"> replace with actual PHP handler -->
                                        <!-- Payment Method Dropdown -->
                                        <div class="mb-3">
                                            <label for="method" class="form-label">Method</label>
                                            <select class="form-select" id="method" name="method" required
                                                onchange="togglePaymentFields()">
                                                <option value="" disabled selected>Select Payment Method</option>
                                                <option value="Digital payment">Digital payment</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Payment gateway">Payment gateway</option>
                                            </select>
                                        </div>

                                        <!-- Fields for Digital Payment -->
                                        <div id="digitalFields" style="display: none;">
                                            <div class="mb-3">
                                                <label for="bankName" class="form-label">Bank Account Name</label>
                                                <input type="text" class="form-control" id="bankName" name="bankName">
                                            </div>
                                            <div class="mb-3">
                                                <label for="accountNumber" class="form-label">Account Number</label>
                                                <input type="text" class="form-control" id="accountNumber"
                                                    name="accountNumber">
                                            </div>
                                        </div>

                                        <!-- Field for Cash -->
                                        <div id="cashFields" style="display: none;">
                                            <div class="mb-3">
                                                <label for="senderName" class="form-label">Sender Name</label>
                                                <input type="text" class="form-control" id="senderName" name="senderName">
                                            </div>
                                        </div>
                                        <!-- ✅ JavaScript for conditional fields -->
                                        <script>
                                            function togglePaymentFields() {
                                                const method = document.getElementById("method").value;
                                                const digitalFields = document.getElementById("digitalFields");
                                                const cashFields = document.getElementById("cashFields");

                                                digitalFields.style.display = (method === "Digital payment") ? "block" : "none";
                                                cashFields.style.display = (method === "Cash") ? "block" : "none";
                                            }
                                        </script>
                                        <!-- Material Fields -->
                                        <div class="mb-3">
                                            <label for="Status" class="form-label">Stock Status</label>
                                            <select class="form-select" id="Status" name="Status" required>
                                                <option value="In stock">In stock</option>
                                                <option value="Low stock">Low stock</option>
                                                <option value="Out Of stock">Out Of stock</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="status" class="form-label">Expense Status</label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option value="" disabled selected>Select Status</option>
                                                <option value="Pending">Pending</option>
                                                <option value="Approved">Approved</option>
                                                <option value="Rejected">Rejected</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="materialprimarysupplier" class="form-label">Primary Supplier</label>
                                            <input type="text" class="form-control" id="materialprimarysupplier"
                                                name="materialprimarysupplier" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="materialReorder" class="form-label">Reorder Point</label>
                                            <input type="text" class="form-control" id="materialReorder"
                                                name="materialReorder" required>
                                        </div>

                                        <!-- Submit Button -->
                                        <button type="submit" class="btn btn-primary" name="whatAction" value="addItem">Add
                                            Material</button>



                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

                <script>
                    function toggleItemInput() {
                        const select = document.getElementById('createdBy');
                        const customInput = document.getElementById('customCreatedBy');

                        if (select && customInput) {
                            if (select.value === 'Other') {
                                customInput.style.display = 'block';
                                customInput.required = true;
                            } else {
                                customInput.style.display = 'none';
                                customInput.required = false;
                            }
                        }
                    }

                    // Run this once on page load in case "Other" is already selected
                    window.addEventListener('DOMContentLoaded', toggleItemInput);

                    function toggleUnitInput() {
                        const unit = document.getElementById('unit');
                        const customUnit = document.getElementById('customUnit');

                        if (unit && customUnit) {
                            if (unit.value === 'Other') {
                                customUnit.style.display = 'block';
                                customUnit.required = true;
                            } else {
                                customUnit.style.display = 'none';
                                customUnit.required = false;
                            }
                        }
                    }

                    // Run this once on page load in case "Other" is already selected
                    window.addEventListener('DOMContentLoaded', toggleUnitInput);
                </script>

                <!-- Add Worker Button -->
                <button class="btn btn-outline-primary col-lg-3 col-sm-6" type="button" data-bs-toggle="modal"
                    data-bs-target="#addWorkerModal">
                    Add Worker
                </button>

                <!-- Modal Structure -->
                <div class="modal fade" id="addWorkerModal" tabindex="-1" aria-labelledby="addWorkerModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="workers.php" method="POST">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addWorkerModalLabel">Add Worker</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <!-- Modal Body -->
                                <div class="modal-body">
                                    <!-- Form to add worker -->
                                    <div class="mb-3">
                                        <label for="workerName" class="form-label">Worker Name</label>
                                        <input type="text" class="form-control" id="workerName" name="workerName" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="department" class="form-label">Department</label>
                                        <input type="text" class="form-control" id="department" name="department" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role</label>
                                        <input type="text" class="form-control" id="role" name="role" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="shift" class="form-label">Shift</label>
                                        <select class="form-select" id="shift" name="shift" required>
                                            <option value="">Select Shift</option>
                                            <option value="Morning">Morning</option>
                                            <option value="Evening">Evening</option>
                                            <option value="Night">Night</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success" name="whatAction" value="addWorker">Add
                                        Worker</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <a href="factory_dashboard.php?page=reports" class="btn btn-outline-primary col-lg-3 col-sm-6"
                    style="min-width: 120px;">
                    Reports
                </a>
            </div>

            <?php
            // Check if user has Delete permission
            $hasDeletePermission = false;
            $permissionSql = "SELECT Permission FROM user_management WHERE User_Name = '$user_name'";
            $permissionResult = $conn->query($permissionSql);
            if ($permissionResult->num_rows > 0) {
                $permissionRow = $permissionResult->fetch_assoc();
                $permissions = json_decode($permissionRow['Permission'], true);
                $hasDeletePermission = in_array('Delete', $permissions);
            }
            ?>

            <div class="card shadow-sm p-4 mt-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <h2 class="fw-bold">Production Schedule</h2>
                        <p class="text-muted">Upcoming and in-progress production runs</p>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr class="text-muted">
                                <th>ID</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            // Fetch transactions from the database
                            $result = $conn->query("SELECT * FROM factory_production WHERE created_for = '$user_name' ORDER BY id DESC");

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $status = htmlspecialchars($row['status']);
                                    $id = htmlspecialchars($row['id']);

                                    echo "<tr>";
                                    echo "<td>" . $id . "</td>";
                                    echo "<td>" . htmlspecialchars($row['product']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['quantity']) . " " . htmlspecialchars($row['unit']) . "</td>";
                                    echo "<td>" . date('d-M-Y', strtotime($row['start_date'])) . "</td>";
                                    echo "<td>" . date('d-M-Y', strtotime($row['end_date'])) . "</td>";
                                    echo "<td>" . $status . "</td>";
                                    echo "<td>";
                                    if ($status !== 'Completed' && $hasDeletePermission) {
                                        echo ' <div class="d-flex gap-2"> 
                                                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#statusModal' . $id . '">
                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                    </button>
                                                    <form method="post" action="" onsubmit="return confirm(&quot;Are you sure you want to delete this production item?&quot;);">
                                                        <input type="hidden" name="production_id" value=' . $id . '>
                                                        <button type="submit" name="deleteProduction" class="btn btn-danger btn-sm">
                                                            <i class="fa-solid fa-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                    ';
                                    } else if ($hasDeletePermission) {
                                        echo '<form method="post" action="" onsubmit="return confirm(&quot;Are you sure you want to delete this production item?&quot;);">
                                        <input type="hidden" name="production_id" value=' . $id . '>
                                        <button type="submit" name="deleteProduction" class="btn btn-danger btn-sm">
                                            <i class="fa-solid fa-trash"></i> Delete
                                        </button>
                                    </form>';
                                    } else {
                                        echo '<button class="btn btn-outline-secondary btn-sm" disabled>
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>';
                                    }
                                    echo "</td>";

                                    // Modal for updating status
                                    if ($status !== 'Completed') {
                                        ?>
                                        <div class="modal fade" id="statusModal<?= $id ?>" tabindex="-1"
                                            aria-labelledby="statusModalLabel<?= $id ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <form method="POST" action="production.php">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="statusModalLabel<?= $id ?>">Update Status</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="tracking_id" value="<?= $id ?>">
                                                            <label class="form-label">Status</label>
                                                            <!-- <input type="date" name="delivery_date" class="form-control"
                                                    placeholder="Delivery Date" required> -->
                                                            <select class="form-select" name="status" required>
                                                                <option value="">Select Status</option>
                                                                <?php if ($status === 'Scheduled') {
                                                                    ?>
                                                                    <option value="Pending">Pending</option>
                                                                <?php } else if ($status === 'Pending') { ?>
                                                                        <option value="Scheduled">Scheduled</option>
                                                                <?php } ?>
                                                                <option value="Completed">Completed</option>
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary" name="whatAction"
                                                                value="updateProduct">Update</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center'>No production found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteProduction']) && $hasDeletePermission) {
                $production_id = $conn->real_escape_string($_POST['production_id']);

                // Prepare and execute delete query
                $deleteSql = "DELETE FROM factory_production WHERE id = ? AND created_for = ?";
                $stmt = $conn->prepare($deleteSql);
                $stmt->bind_param("ss", $production_id, $user_name);

                if ($stmt->execute()) {
                    echo "<script>alert('Production item deleted successfully!'); window.location.href=window.location.href;</script>";
                } else {
                    echo "<script>alert('Error deleting production: " . $conn->error . "');</script>";
                }

                $stmt->close();
            }
            ?>

            <div class="card p-3 my-4 shadow-sm">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="fw-bold">Raw Material Stock</h2>
                        <p class="text-muted">Current raw materials inventory status</p>
                    </div>
                    <div>
                        <button id="refreshBtn" class="btn btn-outline-secondary me-2">Refresh</button>
                        <script>
                            // Refresh Button (Reload page)
                            document.getElementById('refreshBtn').addEventListener('click', function () {
                                location.reload();
                            });
                        </script>

                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle" id="rawmaterialsTable">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Material</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Reorder Point</th>
                                <th>Status</th>
                                <th>Primary Supplier</th>
                                <?php if ($hasDeletePermission): ?>
                                    <th>Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            // Fetch transactions from the database
                            $result = $conn->query("SELECT * FROM factory_raw_material WHERE created_for = '$user_name' ORDER BY id DESC");

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['material']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['quantity']) . " " . htmlspecialchars($row['unit']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['reorder_point']) . " " . htmlspecialchars($row['unit']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['Status']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['primary_supplier']) . "</td>";
                                    if ($hasDeletePermission) {
                                        echo "<td>
                                    <form method='post' action='' onsubmit='return confirm(\"Are you sure you want to delete this raw material item?\");'>
                                        <input type='hidden' name='raw_id' value='" . htmlspecialchars($row['id']) . "'>
                                        <button type='submit' name='deleteRawMaterial' class='btn btn-danger btn-sm'>
                                            <i class='fa-solid fa-trash'></i> Delete
                                        </button>
                                    </form>
                                  </td>";
                                    }
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='" . ($hasDeletePermission ? 8 : 7) . "' class='text-center'>No material found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteRawMaterial']) && $hasDeletePermission) {
                $raw_id = $conn->real_escape_string($_POST['raw_id']);

                // Prepare and execute delete query
                $deleteSql = "DELETE FROM factory_raw_material WHERE id = ? AND created_for = ?";
                $stmt = $conn->prepare($deleteSql);
                $stmt->bind_param("ss", $raw_id, $user_name);

                if ($stmt->execute()) {
                    echo "<script>alert('Raw material item deleted successfully!'); window.location.href=window.location.href;</script>";
                } else {
                    echo "<script>alert('Error deleting raw material: " . $conn->error . "');</script>";
                }

                $stmt->close();
            }
            ?>

            <div class="col-md-12 card p-3 shadow-sm my-4 table-responsive">
                <div id="factory">
                    <div class="container-fluid d-flex justify-content-between align-items-center">
                        <div class="justify-content-start">
                            <h1>Current Stock</h1>
                        </div>
                        <div class="justify-content-end">
                            <a href="factory_dashboard.php?page=dashboard&view=<?php echo isset($_GET['view']) && $_GET['view'] === 'all' ? 'none' : 'all'; ?>"
                                class="btn btn-outline-primary">
                                <?php echo isset($_GET['view']) && $_GET['view'] === 'all' ? 'Show Less' : 'View All'; ?>
                            </a>
                        </div>
                    </div>

                    <table id="Table" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Record Date</th>
                                <th>Item Name</th>
                                <th>Category</th>
                                <th>Quantity</th>
                                <th>Sale Value Total</th>
                                <th>Sale Value Per Piece</th>
                                <th>Total Manufacturing Cost</th>
                                <th>Manufacturing Cost Per Piece</th>
                                <th>Previous Stock</th>
                                <th>Previous Stock Value</th>
                                <th>Total Stock</th>
                                <th>Total Stock Value</th>
                                <th>Avg Previous Sale</th>
                                <th>Avg New Sale</th>
                                <th>Status</th>
                                <?php if ($hasDeletePermission): ?>
                                    <th>Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Adjust SQL query to limit to 5 or show all
                            $limit = (isset($_GET['view']) && $_GET['view'] === 'all') ? '' : 'LIMIT 5';
                            $sql = "SELECT * FROM factory_stock WHERE created_for = '$user_name' ORDER BY stock_id DESC $limit";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $status = htmlspecialchars($row['status']);
                                    echo "<tr>
                                <td>" . htmlspecialchars($row['stock_id']) . "</td>
                                <td>" . htmlspecialchars($row['record_date']) . "</td>
                                <td>" . htmlspecialchars($row['item_name']) . "</td>
                                <td>" . htmlspecialchars($row['category']) . "</td>
                                <td>" . htmlspecialchars($row['current_quantity']) . "</td>
                                <td>₹" . number_format($row['sale_value_total'], 2) . "</td>
                                <td>₹" . number_format($row['sale_value_piece'], 2) . "</td>
                                <td>₹" . number_format($row['total_manufacturing_cost'], 2) . "</td>
                                <td>₹" . number_format($row['manufacturing_cost_piece'], 2) . "</td>
                                <td>" . htmlspecialchars($row['previous_stock']) . "</td>
                                <td>₹" . number_format($row['previous_stock_value'], 2) . "</td>
                                <td>" . htmlspecialchars($row['quantity']) . "</td>
                                <td>₹" . number_format($row['value'], 2) . "</td>
                                <td>₹" . number_format($row['avg_previous_sale'], 2) . "</td>
                                <td>₹" . number_format($row['avg_new_sale'], 2) . "</td>
                                <td>";
                                    if ($status == 'In stock') {
                                        echo '<span class="badge rounded-pill" style="background-color: #198754; color: white; padding: 8px 16px;">In Stock</span>';
                                    } elseif ($status == 'Low stock') {
                                        echo '<span class="badge rounded-pill" style="background-color: #ffc107; color: white; padding: 8px 16px;">Low Stock</span>';
                                    } elseif ($status == 'Out of stock') {
                                        echo '<span class="badge rounded-pill" style="background-color: #dc3545; color: white; padding: 8px 16px;">Out of Stock</span>';
                                    }
                                    echo "</td>";
                                    if ($hasDeletePermission) {
                                        echo "<td>
                                    <form method='post' action='' onsubmit='return confirm(\"Are you sure you want to delete this stock item?\");'>
                                        <input type='hidden' name='stock_id' value='" . htmlspecialchars($row['stock_id']) . "'>
                                        <input type='hidden' name='item_name' value='" . htmlspecialchars($row['item_name']) . "'>
                                        <input type='hidden' name='quantity' value='" . htmlspecialchars($row['quantity']) . "'>
                                        <button type='submit' name='deleteStock' class='btn btn-danger btn-sm'>
                                            <i class='fa-solid fa-trash'></i> Delete
                                        </button>
                                    </form>
                                  </td>";
                                    }
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='" . ($hasDeletePermission ? 17 : 16) . "'>No stock data found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteStock']) && $hasDeletePermission) {
                $stock_id = $conn->real_escape_string($_POST['stock_id']);
                $productName = $conn->real_escape_string($_POST['item_name']);
                $quantity = floatval($_POST['quantity']);

                // Prepare and execute delete query
                $deleteSql = "DELETE FROM factory_stock WHERE stock_id = ? AND created_for = ?";
                $stmt = $conn->prepare($deleteSql);
                $stmt->bind_param("ss", $stock_id, $user_name);

                if ($stmt->execute()) {
                    // 1. Get product's raw materials from factory_product table
                    $productSql = "SELECT raw_materials FROM factory_product WHERE productName = ? AND created_for = ?";
                    $productStmt = $conn->prepare($productSql);
                    $productStmt->bind_param("ss", $productName, $user_name);
                    $productStmt->execute();
                    $productResult = $productStmt->get_result();

                    if ($productResult && $productRow = $productResult->fetch_assoc()) {
                        $rawMaterialsArr = json_decode($productRow['raw_materials'], true);

                        // 2. Subtract quantity for each raw material
                        if (is_array($rawMaterialsArr)) {
                            foreach ($rawMaterialsArr as $rm) {
                                $rawMaterialId = $rm['id'];
                                $usedQtyPerProduct = floatval($rm['quantity']);
                                $totalUsedQty = intval($usedQtyPerProduct * $quantity);

                                // Update factory_raw_material table: subtract usedQty from quantity
                                $updateSql = "UPDATE factory_raw_material SET quantity = quantity + ? WHERE id = ? AND created_for = ?";
                                $updateStmt = $conn->prepare($updateSql);
                                $updateStmt->bind_param("iss", $totalUsedQty, $rawMaterialId, $user_name);
                                $updateStmt->execute();
                                $updateStmt->close();
                            }
                        }
                    }
                    $productStmt->close();

                    echo "<script>alert('Stock item deleted successfully!'); window.location.href=window.location.href;</script>";
                } else {
                    echo "<script>alert('Error deleting stock: " . $conn->error . "');</script>";
                }

                $stmt->close();
            }
            ?>


            <div class="col-md-12 card p-3 shadow-sm my-4 table-responsive">
                <div id="workers">
                    <h1>Workers Directory</h1>
                    <p>Complete list of factory workers with status and details</p>
                    <table class="table table-bordered table-hover" id="supplyTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Worker Name</th>
                                <th>Department</th>
                                <th>Role</th>
                                <th>Shift</th>
                                <!-- <th>Status</th>
                                <th>Attendance</th> -->
                                <?php if ($hasDeletePermission): ?>
                                    <th>Action</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            // Fetch transactions from the database
                            $result = $conn->query("SELECT * FROM factory_workers WHERE created_for = '$user_name' ORDER BY id DESC");

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['department']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['role']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['shift']) . "</td>";
                                    if ($hasDeletePermission) {
                                        echo "<td>
                                    <form method='post' action='' onsubmit='return confirm(\"Are you sure you want to delete this worker?\");'>
                                        <input type='hidden' name='worker_id' value='" . htmlspecialchars($row['id']) . "'>
                                        <button type='submit' name='deleteWorker' class='btn btn-danger btn-sm'>
                                            <i class='fa-solid fa-trash'></i> Delete
                                        </button>
                                    </form>
                                  </td>";
                                    }
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='" . ($hasDeletePermission ? 6 : 5) . "' class='text-center'>No transactions found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteWorker']) && $hasDeletePermission) {
                $worker_id = $conn->real_escape_string($_POST['worker_id']);

                // Prepare and execute delete query
                $deleteSql = "DELETE FROM factory_workers WHERE id = ? AND created_for = ?";
                $stmt = $conn->prepare($deleteSql);
                $stmt->bind_param("ss", $worker_id, $user_name);

                if ($stmt->execute()) {
                    echo "<script>alert('Worker deleted successfully!'); window.location.href=window.location.href;</script>";
                } else {
                    echo "<script>alert('Error deleting worker: " . $conn->error . "');</script>";
                }

                $stmt->close();
            }
            ?>

        <?php elseif ($page === 'production'): ?>
            <?php include 'production.php'; ?>

        <?php elseif ($page === 'billing_system'): ?>
            <?php include 'billing_system.php'; ?>

        <?php elseif ($page === 'supply_management'): ?>
            <?php include 'supply_management.php'; ?>

        <?php elseif ($page === 'raw_materials'): ?>
            <?php include 'raw_materials.php'; ?>

        <?php elseif ($page === 'inventory'): ?>
            <?php include 'inventory.php'; ?>

        <?php elseif ($page === 'workers'): ?>
            <?php include 'workers.php'; ?>

        <?php elseif ($page === 'expenses'): ?>
            <?php include 'expenses.php'; ?>

        <?php elseif ($page === 'after_sales_service'): ?>
            <?php include 'after_sales_service.php'; ?>

        <?php elseif ($page === 'reports'): ?>
            <?php include 'reports.php'; ?>

        <?php elseif ($page === 'settings'): ?>
            <?php include 'settings.php'; ?>

        <?php endif; ?>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>