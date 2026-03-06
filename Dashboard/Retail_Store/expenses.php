<?php
include('../../_conn.php'); 
include('_retail_nav.php'); 

// --- AUTOMATIC ID LOGIC (Based on your table structure) ---
// Hum existing "id" column (EXP-2025-001) se next number nikalenge
$get_last_v = mysqli_query($conn, "SELECT id FROM expenses ORDER BY expense_id DESC LIMIT 1");
if(mysqli_num_rows($get_last_v) > 0) {
    $last_row = mysqli_fetch_assoc($get_last_v);
    $last_id_str = $last_row['id']; // Example: "EXP-2025-002"
    $parts = explode('-', $last_id_str);
    $last_num = (int)end($parts);
    $next_num = $last_num + 1;
} else {
    $next_num = 1; 
}
$new_voucher_id = "EXP-2025-" . str_pad($next_num, 3, "0", STR_PAD_LEFT);

// --- BACKEND LOGIC: Save Expense ---
if (isset($_POST['save_expense'])) {
    $v_id = mysqli_real_escape_string($conn, $_POST['voucher_no']);
    $v_date = mysqli_real_escape_string($conn, $_POST['v_date']);
    $category = "Utilities"; // Default category as per your table
    $addedBy = mysqli_real_escape_string($conn, $_POST['emp_name']);
    $amount = mysqli_real_escape_string($conn, $_POST['grand_total_hidden']);
    $vendor = mysqli_real_escape_string($conn, $_POST['paid_by']);
    $method = mysqli_real_escape_string($conn, $_POST['pay_mode']);
    $status = "In Stock"; // As per your existing data

    // INSERT matching your table: id, date, category, addedBy, amount, vendor, status, method
    $sql = "INSERT INTO expenses (id, date, category, addedBy, amount, vendor, status, method) 
            VALUES ('$v_id', '$v_date', '$category', '$addedBy', '$amount', '$vendor', '$status', '$method')";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Success! Expense $v_id Saved.'); window.location.href='expenses.php';</script>";
    } else {
        echo "<div style='margin-left:230px; color:red;'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Professional Expense Voucher</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Sidebar Fix: Takki navbar ke piche na chhipe */
        .main-content { margin-left: 230px; padding: 25px; background: #f4f6fb; min-height: 100vh; transition: 0.3s; }
        @media (max-width: 768px) { .main-content { margin-left: 0; } }

        * { margin:0; padding:0; box-sizing:border-box; font-family:'Inter',sans-serif; }
        .container { max-width:1100px; margin:auto; background:white; padding:25px; border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.05); }
        h2 { text-align:center; margin-bottom:20px; color:#e74c3c; border-bottom: 2px solid #e74c3c; padding-bottom: 10px; }
        .grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:15px; margin-bottom: 20px; }
        input, select { padding:12px; border:1px solid #ddd; border-radius:6px; width:100%; background: #fff; }
        table { width:100%; border-collapse:collapse; margin-top:15px; }
        th, td { border:1px solid #eee; padding:12px; text-align:center; }
        th { background:#e74c3c; color:white; }
        .btn { padding:10px 20px; border:none; border-radius:6px; cursor:pointer; font-weight:600; }
        .save-btn { background:#28a745; color:white; width:100%; font-size:16px; margin-top:20px; }
        .summary { margin-top:20px; background:#fafbff; padding:20px; border-radius:8px; text-align:right; border: 1px solid #eee; }
    </style>
</head>
<body>

<div class="main-content">
    <div class="container">
        <h2>Professional Expense Voucher</h2>
        <form method="POST">
            <div class="grid">
                <div><label>Voucher ID</label><input type="text" name="voucher_no" value="<?php echo $new_voucher_id; ?>" readonly style="background:#f0f0f0;"></div>
                <div><label>Date</label><input type="date" name="v_date" value="<?php echo date('Y-m-d'); ?>"></div>
                <div><label>Pay Mode (Method)</label>
                    <select name="pay_mode">
                        <option>Cash</option><option>UPI</option><option>Bank Transfer</option>
                    </select>
                </div>
            </div>

            <div class="grid">
                <div><label>Added By (Employee)</label><input type="text" name="emp_name" placeholder="Manager Name" required></div>
                <div><label>Paid By (Vendor)</label>
                    <select name="paid_by">
                        <option>Sunil Tiwari</option><option>Pramod Sharma</option><option>Shop Cash</option>
                    </select>
                </div>
            </div>

            <table id="expenseTable">
                <tr><th>Item</th><th>Qty</th><th>Price</th><th>Total</th></tr>
                <tr>
                    <td><input type="text" placeholder="Description" required></td>
                    <td><input type="number" id="qty" value="1" oninput="updateTotal()"></td>
                    <td><input type="number" id="price" oninput="updateTotal()" required></td>
                    <td><input type="number" id="row_total" readonly></td>
                </tr>
            </table>

            <div class="summary">
                <h3>Grand Total: ₹ <span id="grand_display">0.00</span></h3>
                <input type="hidden" name="grand_total_hidden" id="grand_total_hidden">
            </div>

            <button type="submit" name="save_expense" class="save-btn">Save Expense Voucher</button>
        </form>
    </div>

    <div class="container" style="margin-top: 30px;">
        <h3 style="margin-bottom:15px;">Last 50 Entries</h3>
        <div style="overflow-x:auto;">
            <table>
                <thead>
                    <tr><th>ID</th><th>Date</th><th>Category</th><th>AddedBy</th><th>Amount</th><th>Method</th><th>Status</th></tr>
                </thead>
                <tbody>
                    <?php
                    $res = mysqli_query($conn, "SELECT * FROM expenses ORDER BY expense_id DESC LIMIT 50");
                    while($r = mysqli_fetch_assoc($res)) {
                        echo "<tr>
                            <td>{$r['id']}</td>
                            <td>{$r['date']}</td>
                            <td>{$r['category']}</td>
                            <td>{$r['addedBy']}</td>
                            <td>₹ {$r['amount']}</td>
                            <td>{$r['method']}</td>
                            <td><span style='color:green;'>{$r['status']}</span></td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function updateTotal() {
    let q = document.getElementById('qty').value || 0;
    let p = document.getElementById('price').value || 0;
    let total = q * p;
    document.getElementById('row_total').value = total.toFixed(2);
    document.getElementById('grand_display').innerText = total.toFixed(2);
    document.getElementById('grand_total_hidden').value = total.toFixed(2);
}
</script>

</body>
</html>