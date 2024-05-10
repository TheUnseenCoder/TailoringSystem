<?php

session_start();

include '../includes/conn.php';if(isset($_SESSION["loggedinasadmin"])){
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

    // Number of records per page
    $records_per_page = 10; // Adjust as needed
    
    // Query to count total number of records
    $total_records_query = "SELECT COUNT(*) AS total_records FROM ts_customization";
    $total_records_result = $conn->query($total_records_query);
    $total_records_row = $total_records_result->fetch_assoc();
    $total_records = $total_records_row['total_records'];
    
    // Calculate total pages
    $total_pages = ceil($total_records / $records_per_page);
  
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>TRBS | Orders</title>
  <link rel="icon" href="../images/icon.png"> 
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }
        .main1 {
            margin-top: 2%;
            margin-left: 2%;
            margin-right: 2%;
            width: 100%;
            background: rgba(128, 128, 128, 0.2);
        }
        .text-center {
            justify-content: center;
            align-items: flex-end; /* Align items to the bottom */
        }
    </style>
</head>

<body>

<div class="wrapper">
    <aside id="sidebar1">
        <?php include 'components/sidebar.php'; ?>
    </aside>
    <div class="main1">
        <br>
        <center><h1>Orders</h1></center>
        <div class="mx-3 my-3">
            <label for="searchInput" class="form-label">Search:</label>
            <input type="text" class="form-control" id="searchInput" onkeyup="searchTable()" placeholder="Enter search terms">
        </div>
        <center><div class="table-responsive" style="justify-content: center;">
            <table id="myTable" class="table text-nowrap mb-0 align-middle" style="justify-content: center;">
                <thead class="text-dark fs-4">
                  <tr>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0 text-center" style="background-color: black; color: white;">ID</h6>
                    </th>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0 text-center" style="background-color: black; color: white;">Email</h6>
                    </th>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0 text-center" style="background-color: black; color: white;">Product Name</h6>
                    </th>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0 text-center" style="background-color: black; color: white;">Order Status</h6>
                    </th>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0 text-center" style="background-color: black; color: white;">Timestamp</h6>
                    </th>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0 text-center" style="background-color: black; color: white;">Action</h6>
                    </th>
                  </tr>
                </thead>
                <tbody id="myTableBody">
                    <!-- Table rows will be inserted here dynamically -->
                </tbody>
            </table>
        </div>
    </center>
        <!-- Pagination Links -->
        <div class="text-center">
            <ul id="pagination" class="pagination justify-content-center">
            <?php
            // Generate pagination links
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<li class='page-item " . ($i == $current_page ? 'active' : '') . "'><a class='page-link' href='?page=$i'>$i</a></li>";
            }
            ?>
            </ul>
        </div>
        
    </div>   
</div>

<!-- VIEW MODAL -->
<?php 
 $view = "SELECT * FROM ts_orders";
 $view_rs = $conn->query($view);
 while ($row1 = $view_rs->fetch_assoc()) {
?>
<div class="modal fade" id="view-modal<?php echo $row1['order_id']; ?>" tabindex="-1" aria-labelledby="viewProductModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProductModal">View Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Product Details -->
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <br>
                            <label>Full Name:</label><br>
                            <h6><?php 
                            $email = $row1['email'];
                            $selectors = "SELECT * FROM ts_users WHERE email = '$email'";
                            $selress = $conn->query($selectors);
                            $row3 = $selress->fetch_assoc();
                            echo $row3['fullname']; 
                            ?></h6>
                        </div>
                        <div class="col-6">
                            <br>
                            <label>Email:</label><br>
                            <h6><?php echo $row1['email']; ?></h6>
                        </div>
                    </div>
                </div>
                <!-- Product Description -->
                    <div class="row">
                        <div class="col-12">
                            <label for="">Product Name:</label><br>
                            <p><?php 
                                    $product_id = $row1['product_id'];
                                    $selector = "SELECT * FROM ts_products WHERE product_id = '$product_id'";
                                    $selres = $conn->query($selector);
                                    $row2 = $selres->fetch_assoc();
                                    $product_name = $row2['name'];
                                    echo $product_name; 
                            ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="">Size:</label><br>
                            <p><?php 
                                    echo $row1['size']; 
                            ?></p>
                        </div>
                        <div class="col-6">
                            <label for="">Variant:</label><br>
                            <p><?php 
                                    echo $row1['variant']; 
                            ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label for="">Base Price:</label><br>
                            <p><?php 
                                    echo $row1['base_price']; 
                            ?></p>
                        </div>
                        <div class="col-4">
                            <label for="">Quantity:</label><br>
                            <p><?php 
                                    echo $row1['quantity']; 
                            ?></p>
                        </div>
                        <div class="col-4">
                            <label for="">Total Additional:</label><br>
                            <p><?php 
                                    echo $row1['total_additional']; 
                                    $total_amount_to_be_paid = ($row1['base_price'] * $row1['quantity']) + $row1['total_additional'];
                            ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <label for="">Payment_Status:</label><br>
                            <?php 
                            $payment_status = $row1['payment_status'];
                            if($row1['payment_status'] == "partially paid"){
                                echo '<p style="color:orange;"> Partially Paid</p>';
                             }else{
                                echo '<p style="color:green;"> Fully Paid</p>';
                             }

                            ?>
                        </div>
                        <div class="col-6">
                            <label for="">Order Status:</label><br>
                            <?php 
                            if($row1['order_status'] == "packing order"){
                                echo '<p style="color:orange;"> Packing Order</p>';
                             }elseif($row1['order_status'] == "ready for pick up"){
                                echo '<p style="color:blue;">Fully Paid</p>';
                             }else{
                                echo '<p style="color:green;">Order Received</p>';
                             }

                            ?>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-12">
                        <label>Date & Time:</label><br>
                        <?php
                            // Assuming $row1['date'] contains the date string
                            $date = date('F j, Y - H:i A', strtotime($row1['timestamp']));
                            echo $date;
                        ?>
                    </div>
                </div><br>
                <hr><br>
                <div class='row'>
                <?php
                    $order_id = $row1['order_id'];
                    $selectorss = "SELECT payer_id, payer_fullname
                                    FROM ts_payments
                                    WHERE order_id = '$order_id'
                                    ORDER BY id ASC
                                    LIMIT 1 OFFSET 0";
                    $selresss = $conn->query($selectorss);
                    $row2s = $selresss->fetch_assoc();

                    $payer_id = $row2s['payer_id'];
                    $payer_fullname = $row2s['payer_fullname'];

                    $echo = "<div class='col-6'>";
                    $echo .= "<label>Payer ID</label><br>";
                    $echo .= "<label>$payer_id</label><br>";
                    $echo .= "</div>";

                    $echo .= "<div class='col-6'>"; // Concatenate to the existing $echo variable
                    $echo .= "<label>Payer Fullname</label><br>"; // Changed label to Payer Fullname
                    $echo .= "<label>$payer_fullname</label><br>";
                    $echo .= "</div>";

                    echo $echo;
                    ?>
                </div><br>
                <div class='row'>
                        <?php
                             $order_id = $row1['order_id'];
                             $selectorss = "SELECT * FROM ts_payments WHERE order_id = '$order_id'";
                             $selresss = $conn->query($selectorss);
                             while($row2s = $selresss->fetch_assoc()){
                                $transaction_id = $row2s['transaction_id'];
                                $echo = "<div class='col-6'>";
                                $echo .= "<label>Transaction ID</label><br>";
                                $echo .= "<label>$transaction_id</label><br>";
                                $echo .= "</div>";
                                echo $echo;
                             }
                        ?>

                </div><br>
                <div class='row'>
                <?php
                    $selectorss = "SELECT (SELECT amount
                                                FROM ts_payments
                                                WHERE order_id = '$order_id'
                                                ORDER BY id ASC
                                                LIMIT 1 OFFSET 0) AS initial_payment,
                                            (SELECT amount
                                                FROM ts_payments
                                                WHERE order_id = '$order_id'
                                                ORDER BY id DESC
                                                LIMIT 1 OFFSET 0) AS final_payment
                                                FROM ts_payments WHERE order_id = '$order_id'" ;
                    $selresss = $conn->query($selectorss);

                    // Check if there is only one record in payment
                    if ($selresss->num_rows > 1) {
                            $row2s = $selresss->fetch_assoc(); 
                            $amount1 = $row2s['initial_payment'];
                            $amount2 = $row2s['final_payment'];
                            echo "<div class='col-6'>";
                            echo "<label>Initial Payment</label><br>";
                            echo "<label>$amount1</label><br>";
                            echo "</div>";
                            echo "<div class='col-6'>";
                            echo "<label>Final Payment</label><br>";
                            echo "<label>$amount2</label><br>";
                            echo "</div>";
                    } else {
                            $row2s = $selresss->fetch_assoc();
                            $amount1 = $row2s['initial_payment'];
                            // Display initial payment
                            echo "<div class='col-6'>";
                            echo "<label>Initial Payment</label><br>";
                            echo "<label>$amount1</label><br>";
                            echo "</div>";                        
                    }
                    ?>
                </div><br>
                <div class='row'>
                        <?php
                             $selectorss = "SELECT SUM(amount) as amount_paid FROM ts_payments WHERE order_id = '$order_id'";
                             $selresss = $conn->query($selectorss);
                             while($row2s = $selresss->fetch_assoc()){
                                $amount = $row2s['amount_paid'];
                                $echo = "<div class='col-6'>";
                                $echo .= "<label>Total Amount Paid</label><br>";
                                $echo .= "<label>$amount</label><br>";
                                $echo .= "</div>";
                                $echo .= "<div class='col-6'>";
                                $echo .= "<label>Total Amount of Product</label><br>";
                                $echo .= "<label>$total_amount_to_be_paid</label><br>";
                                $echo .= "</div>";
                                echo $echo;
                             }
                        ?>

                </div><br>
                <div class='row'>
                <?php
                    $selectorss = "SELECT SUM(amount) as amount_paid, 
                                (SELECT balance
                                    FROM ts_payments
                                    WHERE order_id = '$order_id'
                                    ORDER BY id ASC
                                    LIMIT 1 OFFSET 0) AS balance
                                FROM ts_payments WHERE order_id = '$order_id'";
                    $selresss = $conn->query($selectorss);
                    while ($row2s = $selresss->fetch_assoc()) {
                        if($payment_status == "fully paid"){
                            $balance = 0;
                        }else{
                            $balance = $row2s['balance'];
                        }
                        $total_amount_paid = $row2s['amount_paid'] - $row2s['balance'];

                        $echo = "<div class='col-6'>";
                        $echo .= "<label>Remaining Balance</label><br>";
                        $echo .= "<label>$balance</label><br>";
                        $echo .= "</div>";
                        echo $echo;
                    }
                ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php
 }
?>
<!-- END OF VIEW MODAL -->
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/script.js"></script>
    <script>
    function searchTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toUpperCase();
        const table = document.getElementById('myTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const cells = rows[i].getElementsByTagName('td');
            let found = false;

            for (let j = 0; j < cells.length; j++) {
                const cell = cells[j];
                if (cell) {
                    const textValue = cell.textContent || cell.innerText;

                    if (textValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
            }

            if (found) {
                rows[i].style.display = '';
                rows[i].classList.remove('highlight');
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
</script>
<script>
    // Function to reload the table content and pagination links
    function reloadTable() {
        // Fetch the table content and pagination links using AJAX
        fetch('functions/fetch_orders.php?page=<?php echo isset($_GET['page']) ? $_GET['page'] : 1; ?>') 
            .then(response => response.text())
            .then(data => {
                // Update the table body with the fetched data
                document.getElementById('myTableBody').innerHTML = data;
            })
            .catch(error => {
                console.error('Error fetching table content:', error);
            });
    }
 
    // Refresh the table every 30 seconds
    setInterval(reloadTable, 5000); // Adjust the interval as needed (in milliseconds)

    // Initial table load
    reloadTable();
</script>
<script>
function updateStatus(element, id, email) {
  var newStatus = element.value;
  
  // Make an AJAX request to update the status in the database
  $.ajax({
    url: 'functions/order_update_status.php',
    type: 'POST',
    data: { id: id, email: email, status: newStatus }, // Include email in the data object
    success: function(response) {
      // Check if the response indicates success
      if (response === 'success') {
        // Show success message using SweetAlert
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: 'Status updated successfully',
        });
      } else {
        // Show error message using SweetAlert
        Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: response, 
          
        });
      }
    },
    error: function(xhr, status, error) {
      // Show error message using SweetAlert
      Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: 'Failed to update status: ' + error,
        timer: 2000 // Auto close after 2 seconds
      });
      console.error('Error updating status: ' + error);
    }
  });
}
</script>



</body>

</html>

<?php 
}else{
  header("location: ../index.php");
  exit;
}
?>