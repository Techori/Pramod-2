<?php
// Database aur Navigation include karein
include('../../_conn.php'); 
include('_retail_nav.php'); // Aapka sidebar is file se aata hai
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Professional Purchase Billing | Techori</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

<style>
    /* Sidebar ke saath space manage karne ke liye main-content style */
    .main-content {
        margin-left: 250px; /* Agar aapka sidebar 250px ka hai toh ye zaroori hai */
        padding: 20px;
        transition: all 0.3s;
    }

    /* Screen choti hone par sidebar ke niche content na dabe */
    @media (max-width: 768px) {
        .main-content { margin-left: 0; padding: 10px; }
    }

    /* Aapka Professional Design CSS */
    *{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif;}
    body{background:#f4f6fb;}
    .container{
        max-width:100%; margin:auto; background:white;
        padding:25px; border-radius:12px;
        box-shadow:0 10px 25px rgba(0,0,0,0.05);
    }
    h2{text-align:center;margin-bottom:20px;color:#333;}
    .section{margin-bottom:25px;}
    .section h3{margin-bottom:10px;color:#444;border-bottom:1px solid #eee;padding-bottom:5px;}
    .grid{
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
        gap:10px;
    }
    input,select{
        padding:10px;border:1px solid #ddd;border-radius:6px;width:100%;
    }
    .table-wrapper{overflow-x:auto;}
    table{width:100%;border-collapse:collapse;margin-top:10px;}
    th,td{border:1px solid #eee;padding:8px;text-align:center;}
    th{background:#4a63e7;color:white;}
    .btn{
        padding:8px 14px;border:none;border-radius:6px;
        cursor:pointer;font-size:14px;
    }
    .add-btn{background:#4a63e7;color:white;}
    .delete-btn{background:#e74c3c;color:white;}
    .print-btn{background:#28a745;color:white; width: 100%; margin-top: 15px;}
    .summary{
        margin-top:20px;background:#fafbff;
        padding:15px;border-radius:8px;border:1px solid #eee;
    }
    .summary h3{color:#4a63e7;}
    @media print{
        .btn, .sidebar, nav, #_retail_nav {display:none !important;} /* Print ke waqt sirf bill dikhe */
        .main-content {margin-left: 0 !important; padding: 0 !important;}
    }
</style>

<script>
function toggleGST(){
    let type=document.getElementById("gst_type").value;
    let gstCols=document.querySelectorAll(".gst-col");
    gstCols.forEach(col=>{
        col.style.display=(type==="with")?"table-cell":"none";
    });
    calculateTotal();
}

function addRow(){
    let table=document.getElementById("itemTable");
    let row=table.insertRow(-1);
    row.innerHTML=`
        <td><input type="text" name="item_name[]" required></td>
        <td>
            <select name="unit[]">
                <option>PCS</option><option>KG</option><option>BOX</option>
                <option>LTR</option><option>METER</option><option>SET</option>
            </select>
        </td>
        <td><input type="number" name="qty[]" value="1" oninput="calculateTotal()"></td>
        <td><input type="number" name="price[]" oninput="calculateTotal()"></td>
        <td>
            <select name="gst_rate[]" class="gst-col" oninput="calculateTotal()">
                <option value="0">0%</option><option value="5">5%</option>
                <option value="12">12%</option><option value="18" selected>18%</option>
                <option value="28">28%</option>
            </select>
        </td>
        <td><input type="number" name="amt[]" readonly></td>
        <td class="gst-col"><input type="number" name="gst_amt[]" readonly></td>
        <td><input type="number" name="total[]" readonly></td>
        <td><button type="button" class="btn delete-btn" onclick="deleteRow(this)">X</button></td>
    `;
    toggleGST();
}

function deleteRow(btn){
    btn.parentNode.parentNode.remove();
    calculateTotal();
}

function calculateTotal(){
    let table=document.getElementById("itemTable");
    let subtotal=0,totalGST=0,finalTotal=0;
    let type=document.getElementById("gst_type").value;

    for(let i=1;i<table.rows.length;i++){
        let qty=table.rows[i].cells[2].children[0].value||0;
        let price=table.rows[i].cells[3].children[0].value||0;
        let gstRate=table.rows[i].cells[4].children[0].value||0;

        let amount=qty*price;
        table.rows[i].cells[5].children[0].value=amount.toFixed(2);

        let gstAmount=0;
        if(type==="with"){
            gstAmount=amount*gstRate/100;
            table.rows[i].cells[6].children[0].value=gstAmount.toFixed(2);
        }

        let total=amount+gstAmount;
        table.rows[i].cells[7].children[0].value=total.toFixed(2);

        subtotal+=amount;
        totalGST+=gstAmount;
        finalTotal+=total;
    }

    finalTotal+=parseFloat(document.getElementById("transport_charge").value)||0;
    document.getElementById("subtotal").innerText=subtotal.toFixed(2);
    document.getElementById("gstTotal").innerText=totalGST.toFixed(2);
    document.getElementById("grand").innerText=finalTotal.toFixed(2);
}

// Pehla row auto-load
window.onload = addRow;
</script>
</head>

<body>

<div class="main-content">
    <div class="container">
        <h2>Professional Purchase Billing</h2>

        <form action="save_purchase.php" method="POST">
            <div class="section">
                <h3>Supplier Details</h3>
                <div class="grid">
                    <input type="text" name="s_name" placeholder="Supplier Name" required>
                    <input type="text" name="s_gst" placeholder="Supplier GST No">
                    <input type="text" name="s_mobile" placeholder="Mobile">
                    <input type="text" name="s_city" placeholder="City">
                    <input type="text" name="s_state" placeholder="State">
                    <input type="text" name="bill_no" placeholder="Bill No">
                    <input type="date" name="bill_date" value="<?php echo date('Y-m-d'); ?>">
                    <select id="gst_type" name="gst_type" onchange="toggleGST()">
                        <option value="with">With GST</option>
                        <option value="without">Without GST</option>
                    </select>
                </div>
            </div>

            <div class="section">
                <h3>Transport Details</h3>
                <div class="grid">
                    <input type="text" name="v_no" placeholder="Vehicle Number">
                    <input type="text" name="lr_no" placeholder="LR / LT Number">
                    <input type="number" id="transport_charge" name="t_charge" value="0" oninput="calculateTotal()" placeholder="Transport Charges">
                </div>
            </div>

            <div class="section">
                <h3>Items</h3>
                <div class="table-wrapper">
                    <table id="itemTable">
                        <tr>
                            <th>Item</th><th>Unit</th><th>Qty</th><th>Price</th>
                            <th class="gst-col">GST %</th><th>Amount</th>
                            <th class="gst-col">GST Amt</th><th>Total</th><th>Action</th>
                        </tr>
                    </table>
                </div>
                <br>
                <button type="button" class="btn add-btn" onclick="addRow()">+ Add Item</button>
            </div>

            <div class="summary">
                <p>Subtotal: ₹ <span id="subtotal">0.00</span></p>
                <p>Total GST: ₹ <span id="gstTotal">0.00</span></p>
                <hr>
                <h3>Grand Total: ₹ <span id="grand">0.00</span></h3>
            </div>

            <button type="submit" class="btn print-btn">Save & Print Bill</button>
        </form>
    </div>
</div>

</body>
</html>