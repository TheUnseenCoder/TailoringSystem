<?php

session_start();

include '../includes/conn.php';if(isset($_SESSION["loggedinasadmin"])){
  
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
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        body, html {
        height: 100%;
        margin: 0;
        font-family: 'Poppins', sans-serif;
        }
        .main1 {
            flex: 1;
            display: flex;
            margin: 2%;
            width: 50%;
            justify-content: center;
            align-items: top;
            background:rgba(128,128,128, 0.2);
        }
        .content {
            text-align: left;
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
        <center><h1>Customization Schedule</h1></center>
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
                        <h6 class="fw-semibold mb-0 text-center" style="background-color: black; color: white;">Date</h6>
                    </th>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0 text-center" style="background-color: black; color: white;">Time</h6>
                    </th>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0 text-center" style="background-color: black; color: white;">Status</h6>
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
 $view = "SELECT * FROM ts_customization";
 $view_rs = $conn->query($view);
 while ($row1 = $view_rs->fetch_assoc()) {
?>
<div class="modal fade" id="view-modal<?php echo $row1['customize_id']; ?>" tabindex="-1" aria-labelledby="viewProductModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProductModal">View Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Product Details -->
                <div class="mb-3">
                    <div class="row">
                        <div class="col-12">
                            <br>
                            <label>Email:</label><br>
                            <h3><?php echo $row1['email']; ?></h3>
                        </div>
                    </div>
                </div>
                <!-- Product Description -->
                <div class="mb-3">
                    <div class="row">
                        <div class="col-12">
                            <label for="productDescription">Description:</label><br>
                            <p><?php echo $row1['description']; ?></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label>Date & Time:</label><br>
                        <?php
                            // Assuming $row1['date'] contains the date string
                            $date = date('F j, Y', strtotime($row1['date']));
                            // Assuming $row1['time'] contains the time string
                            $time = date('g:i A', strtotime($row1['time']));
                            echo $date . ' ' . $time;
                        ?>
                    </div>
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
        fetch('functions/fetch_schedule.php?page=<?php echo isset($_GET['page']) ? $_GET['page'] : 1; ?>') 
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
    url: 'functions/customization_update_status.php',
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