<?php

session_start();

include '../includes/conn.php';

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;


$records_per_page = 10;

$total_records_query = "SELECT COUNT(*) AS total_records FROM ts_users";
$total_records_result = $conn->query($total_records_query);
$total_records_row = $total_records_result->fetch_assoc();
$total_records = $total_records_row['total_records'];

$total_pages = ceil($total_records / $records_per_page);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRBS | User Management</title>
    <link rel="icon" href="../images/icon.png"> 
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        <center><h1>User Management</h1></center>
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
                        <h6 class="fw-semibold mb-0 text-center" style="background-color: black; color: white;">Profile</h6>
                    </th>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0 text-center" style="background-color: black; color: white;">Full Name</h6>
                    </th>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0 text-center" style="background-color: black; color: white;">Email</h6>
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
 $view = "SELECT * FROM ts_users";
 $view_rs = $conn->query($view);
 while ($row1 = $view_rs->fetch_assoc()) {
    $profileImage = $row1['profile'] ? 'data:image/jpeg;base64,' . base64_encode($row1['profile']) : '../images/default_profile.png';

?>
<div class="modal fade" id="view-modal<?php echo $row1['id']; ?>" tabindex="-1" aria-labelledby="viewProductModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProductModal">View Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <!-- Display profile image -->
                    <img src="<?php echo $profileImage; ?>" alt="Profile Image" class="rounded-circle mx-auto d-block" style="width: 200px; height: 200px;">
                    <div class="row">
                        <div class="col-12">
                            <br>
                            <label>Full Name:</label><br>
                            <center><h3><?php echo $row1['fullname']; ?></h3></center>
                        </div>
                    </div>
                </div>
                <!-- Product Description -->
                <div class="mb-3">
                    <div class="row">
                        <div class="col-12">
                            <label>Email Address:</label><br>
                            <center><p><?php echo $row1['email']; ?></p></center>
                        </div>
                    </div>
                </div>
                <!-- Product Base Price -->
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label>Address:</label><br>
                            <p><?php echo $row1['address']; ?></p>
                        </div>
                        <div class="col-6">
                            <label>Mobile:</label><br>
                            <p><?php echo $row1['mobile_number']; ?></p>
                        </div>
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
    function reloadTable() {
        fetch('functions/fetch_user.php?page=<?php echo isset($_GET['page']) ? $_GET['page'] : 1; ?>') 
            .then(response => response.text())
            .then(data => {
                document.getElementById('myTableBody').innerHTML = data;
            })
            .catch(error => {
                console.error('Error fetching table content:', error);
            });
    }
 
    setInterval(reloadTable, 10000); 
    reloadTable();
</script>
</body>
</html>
