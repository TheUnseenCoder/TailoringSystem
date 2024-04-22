<?php

session_start();

include '../includes/conn.php';

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Number of records per page
$records_per_page = 10; // Adjust as needed

// Query to count total number of records
$total_records_query = "SELECT COUNT(DISTINCT matrix_name) AS total_records FROM ts_matrices";
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
    <title>TRBS | Matrices</title>
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
        .image-carousel {
            display: flex;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
        }

        .image-carousel img {
            flex: 0 0 auto;
            width: 100%;
            scroll-snap-align: start;
            margin-right: 10px; /* Add spacing between images */
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
        <center><h1>Matrices</h1></center>
        <div class="text-end mx-5">
            <button type='button' class="btn btn-success" data-bs-toggle='modal' data-bs-target='#addMatrix'>Add Matrix</button>
        </div>
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
                        <h6 class="fw-semibold mb-0 text-center" style="background-color: black; color: white;">Matrix Name</h6>
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


<!-- ADD MEASUREMENT START-->
<?php 
$sizes = "SELECT DISTINCT matrix_name FROM ts_matrices";
$sizes_rs = $conn->query($sizes);
while ($row_sizes = $sizes_rs->fetch_assoc()) {
?>
<div class="modal fade" id="addMeasurement-<?php echo base64_encode($row_sizes['matrix_name']); ?>" tabindex="-1" aria-labelledby="addMeasurementLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMeasurementLabel">Add Measurement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle='modal' data-bs-target='#view-modal<?php echo base64_encode($row_sizes['matrix_name']); ?>'></button>
            </div>
            <div class="modal-body">
                <!-- Form for adding a product -->
                <form id="addMeasurementForm-<?php echo base64_encode($row_sizes['matrix_name']); ?>" enctype="multipart/form-data">

                    <!-- Measurement Name -->
                    <div class="mb-3">
                        <label>Matrix Name:</label><br>
                        <center><h2><?php echo $row_sizes['matrix_name']; ?></h2></center>
                        <div class="row">
                        <label>Measurement Name:</label><br>
                            <div class="col-4">
                                <input type="text" name="measurement_name" required>
                            </div>
                            <div class="col-8">
                                <h6>(Example: Arm Length, Waist, Chest, etc.)</h6>
                            </div>
                        </div>
                    </div>

                    <?php 
                        $matrix_name = mysqli_real_escape_string($conn, $row_sizes['matrix_name']);
                        $size = "SELECT DISTINCT size_name FROM ts_matrices WHERE matrix_name = '$matrix_name'";
                        $size_rs = $conn->query($size);
                        while ($row_size = $size_rs->fetch_assoc()) {
                        ?>
                        <hr>
                        <div class="row">
                            <!-- Size Name -->
                            <div class="col-4">
                                <label>Size Name:</label><br>
                                <input type="text" value="<?php echo $row_size['size_name']; ?>" required disabled>
                                <input type="hidden" name="size_name[]" value="<?php echo $row_size['size_name']; ?>" required>
                                <input type="hidden" name="matrix_name" value="<?php echo $row_sizes['matrix_name']; ?>" required>
                            </div>
                            <!-- Measurement Size -->
                            <div class="col-4">
                                <label>Measurement Size:</label><br>
                                <input type="text" name="measurement_size[]" required>
                            </div>
                            <!-- Additional -->
                            <div class="col-4">
                                <label>Additional:</label><br>
                                <input type="number" name="additional" value="0.00" step="0.01" min="0" required>
                            </div>
                        </div>
                    <?php 
                    }
                    ?>
                        <br>
                    <center>
                        <button type="submit" class="btn btn-primary">Add Measurement</button>
                        <br><br>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>
<?php 
}
?>
<!-- ADD MEASUREMENT DONE-->


<!-- ADD SIZE START-->
<?php 
$meas = "SELECT DISTINCT matrix_name FROM ts_matrices";
$meas_rs = $conn->query($meas);
while ($row_meas = $meas_rs->fetch_assoc()) {
?>
<div class="modal fade" id="addSize-<?php echo base64_encode($row_meas['matrix_name']); ?>" tabindex="-1" aria-labelledby="addSizeLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSizeLabel">Add Size</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle='modal' data-bs-target='#view-modal<?php echo base64_encode($row_meas['matrix_name']); ?>'></button>
            </div>
            <div class="modal-body">
                <!-- Form for adding a product -->
                <form id="addSizeForm-<?php echo base64_encode($row_meas['matrix_name']); ?>" enctype="multipart/form-data">

                    <!-- Matrix Name -->
                    <div class="mb-3">
                        <label>Matrix Name:</label><br>
                        <center><h2><?php echo $row_meas['matrix_name']; ?></h2></center>
                        <div class="row">
                            <label>Size Name:</label><br>
                            <div class="col-4">
                                <input type="text" name="size_name" required>
                            </div>
                            <div class="col-8">
                                <h6>(Example: Small, Medium, Large, XL, etc.)</h6>
                            </div>
                        </div>
                    </div>

                    <?php 
                    $matrix_name = mysqli_real_escape_string($conn, $row_meas['matrix_name']);
                    $measurement = "SELECT DISTINCT measurement_name FROM ts_matrices WHERE matrix_name = '$matrix_name'";
                    $measurement_rs = $conn->query($measurement);
                    while ($row_measurement = $measurement_rs->fetch_assoc()) {
                    ?>
                    <hr>
                    <div class="row">
                        <!-- Measurement Name -->
                        <div class="col-4">
                            <label>Measurement Name:</label><br>
                            <input type="text" value="<?php echo $row_measurement['measurement_name']; ?>" required disabled>
                            <input type="hidden" name="measurement_name[]" value="<?php echo $row_measurement['measurement_name']; ?>" required>
                            <!-- Matrix Name -->
                            <input type="hidden" name="matrix_name" value="<?php echo $row_meas['matrix_name']; ?>">

                        </div>
                        <!-- Measurement Size -->
                        <div class="col-4">
                            <label>Measurement Size:</label><br>
                            <input type="text" name="measurement_size[]" required>
                        </div>
                        <!-- Additional -->
                        <div class="col-4">
                            <label>Additional:</label><br>
                            <input type="number" name="additional" value="0.00" step="0.01" min="0" required>
                        </div>
                    </div>
                    <?php 
                    }
                    ?>
                    <br>
                    <center>
                        <button type="submit" class="btn btn-primary">Add Size</button>
                        <br><br>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>
<?php 
}
?>
<!-- ADD SIZE DONE-->


<!-- LINK PRODUCT AND MATRIX START-->
<?php 
 $ma = "SELECT DISTINCT matrix_name FROM ts_matrices_associate";
 $ma_rs = $conn->query($ma);
 while ($row_ma = $ma_rs->fetch_assoc()) {
?>
<div class="modal fade" id="addProductModal-<?php echo base64_encode($row_ma['matrix_name']); ?>" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductLabel">Link Product to Matrix</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle='modal' data-bs-target='#view-modal<?php echo base64_encode($row_ma['matrix_name']); ?>'></button>
            </div>
            <div class="modal-body">
                <!-- Form for adding a product -->
                <form id="addProductForm" enctype="multipart/form-data">
                    <!-- Product Name -->
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label>Product Name:</label><br>
                                <select name="productName" required>
                                <option value="none" selected disabled>Please Select a Product</option>
                                    <?php 
                                        $view = "SELECT * FROM ts_products";
                                        $view_rs = $conn->query($view);
                                        while ($row1 = $view_rs->fetch_assoc()) {
                                    ?>
                                        <option value="<?php echo $row1['name']; ?>"><?php echo $row1['name']; ?></option>
                                    <?php 
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6">
                                <label>Matrix Name:</label><br>
                                <input type="text" name="matrix_name" value="<?php echo $row_ma['matrix_name']; ?>" required>
                            </div>
                        </div>
                    </div>
                    <center>
                        <button type="submit" id="addProduct" class="btn btn-primary">Add Product</button>
                        <br><br>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>
<?php 
    }
?>
<!-- LINK PRODUCT AND MATRIX DONE-->



<!-- VIEW MATRIX -->
<?php 
    // Function to fetch measurements for a given matrix name
    function fetchMeasurements($matrix_name) {
        // Query to fetch measurements for the current matrix
        $measurement_query = "SELECT * FROM ts_matrices WHERE matrix_name = '$matrix_name'";
        $measurement_result = $conn->query($measurement_query);

        // Check if there are measurements available
        if ($measurement_result->num_rows > 0) {
            // Start building the measurements content
            $measurements_content = "<div class='measurements-container'>";
            
            // Loop through each measurement for the current matrix
            while ($measurement_row = $measurement_result->fetch_assoc()) {
                // Add the measurement details to the content
                $measurements_content .= "<div>{$measurement_row['measurement_name']}: {$measurement_row['measurement_size']} ({$measurement_row['size_name']})</div>";
            }
            
            // Close the container
            $measurements_content .= "</div>";
            
            // Return the measurements content
            return $measurements_content;
        } else {
            // If no measurements found, return empty content
            return "";
        }
    }

    // Query to fetch all unique matrix names
    $matrix_query = "SELECT DISTINCT matrix_name FROM ts_matrices";
    $matrix_result = $conn->query($matrix_query);

    // Check if there are matrices available
    if ($matrix_result->num_rows > 0) {
        // Loop through each matrix
        while ($matrix_row = $matrix_result->fetch_assoc()) {
            // Fetch the matrix name and encode it for ID generation
            $matrix_name = $matrix_row['matrix_name'];
            $matrix_name_base64 = base64_encode($matrix_name);
?>
            <!-- Modal for viewing matrix details -->
            <div class="modal fade" id="view-modal<?php echo $matrix_name_base64;?>" tabindex="-1" aria-labelledby="viewProductModal" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewProductModal">View Matrix</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-12">
                                        <label>Matrix Name:</label><br>
                                        <center><h3><?php echo $matrix_name; ?></h3></center>
                                    </div>
                                </div>
                            </div>
                            <!-- Display measurements for the current matrix -->
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-12">
                                        <!-- Measurements container will be populated dynamically using JavaScript -->
                                        <div id="measurements-container-<?php echo $matrix_name_base64; ?>"></div>
                                    </div>
                                </div>
                            </div>

                             <!-- Display associates -->
                             <div class="mb-3">
                                <div class="row">
                                    <div class="col-12">
                                        <div id="associate-container-<?php echo $matrix_name_base64; ?>"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        <!-- JavaScript to fetch and display measurements for the current matrix -->
        <script>
            function fetchAndDisplayMeasurements() {
                // Fetch and display measurements for the current matrix
                fetch('functions/fetch_measurement.php?matrix_name=<?php echo urlencode($matrix_name); ?>')
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('measurements-container-<?php echo $matrix_name_base64; ?>').innerHTML = data;
                    });

                // Fetch and display measurements for the current matrix
                fetch('functions/fetch_associates.php?matrix_name=<?php echo urlencode($matrix_name); ?>')
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('associate-container-<?php echo $matrix_name_base64; ?>').innerHTML = data;
                    });
            }

            // Fetch and display measurements initially
            fetchAndDisplayMeasurements();

            // Reload measurements every 5 seconds
            setInterval(fetchAndDisplayMeasurements, 5000);
        </script>

<?php 
        }
    }
?>
<!-- END OF VIEW MATRICES -->

<!-- VIEW PRODUCTS -->
<?php 
 $view = "SELECT * FROM ts_products";
 $view_rs = $conn->query($view);
 while ($row1 = $view_rs->fetch_assoc()) {
?>
<div class="modal fade" id="view-product<?php echo $row1['product_id']; ?>" tabindex="-1" aria-labelledby="viewProductModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProductModal">View Product</h5>
                <?php 
                $product_id = $row1['product_id']; 
                $product_select = "SELECT * FROM ts_matrices_associate WHERE product_id = '$product_id'";
                $product_result = $conn->query($product_select);
                $row2 = $product_result->fetch_assoc();
                $matrix_name = $row2['matrix_name'];
                $matrix_name_base64 = base64_encode($matrix_name);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle='modal' data-bs-target='#view-modal<?php echo $matrix_name_base64; ?>'></button>
            </div>
            <div class="modal-body">
                <!-- Image Carousel -->
                <div class="image-carousel">
                    <?php
                        // Assuming you have a column named 'image_path' in your database for storing image paths
                        $images_query = "SELECT * FROM ts_products WHERE product_id = " . $row1['product_id'];
                        $images_result = $conn->query($images_query);
                        while ($image_row = $images_result->fetch_assoc()) {
                                $unserializedData = unserialize($image_row['images']);

                                // Iterate through the array and create HTML img elements
                                foreach ($unserializedData as $imagePath) {
                                    // Check if the current element is an array (this handles the case when there's only one image path)
                                    if (is_array($imagePath)) {
                                        foreach ($imagePath as $path) {
                                            echo '<img src="' . $path . '" alt="Product Image" width="250" height="250">';
                                        }
                                    } else {
                                        echo '<img src="' . $imagePath . '" alt="Product Image" width="250" height="250">';
                                    }
                                }
                            }
                    ?>
                </div>
                <!-- Product Details -->
                <div class="mb-3">
                    <div class="row">
                        <div class="col-12">
                            <br>
                            <label>Product Name:</label><br>
                            <center><h3><?php echo $row1['name']; ?></h3></center>
                        </div>
                    </div>
                </div>
                <!-- Product Description -->
                <div class="mb-3">
                    <div class="row">
                        <div class="col-12">
                            <label>Description:</label><br>
                            <p><?php echo $row1['description']; ?></p>
                        </div>
                    </div>
                </div>
                <!-- Product Base Price -->
                <div class="mb-3">
                    <div class="row">
                        <div class="col-12">
                            <label>Base Price:</label><br>
                            <p><?php echo $row1['base_price']; ?></p>
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

 <?php
// Query to fetch all unique matrix names
    $matrix_query = "SELECT DISTINCT matrix_name FROM ts_matrices";
    $matrix_result = $conn->query($matrix_query);

    // Check if there are matrices available
    if ($matrix_result->num_rows > 0) {
        // Loop through each matrix
        while ($matrix_row = $matrix_result->fetch_assoc()) {
            // Fetch the matrix name and encode it for ID generation
            $matrix_name = $matrix_row['matrix_name'];
            $matrix_name_base64 = base64_encode($matrix_name);
?>
            <!-- Modal for viewing matrix details -->
            <div class="modal fade" id="update-modal<?php echo $matrix_name_base64;?>" tabindex="-1" aria-labelledby="updateProductModal" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateProductModal">Edit Matrix</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-12">
                                        <label>Matrix Name:</label><br>
                                        <center><h3><?php echo $matrix_name; ?></h3></center>
                                    </div>
                                </div>
                            </div>
                            <!-- Display measurements for the current matrix -->
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-12">
                                        <!-- Measurements container will be populated dynamically using JavaScript -->
                                        <div id="measurements-update-container-<?php echo $matrix_name_base64; ?>"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        <!-- JavaScript to fetch and display measurements for the current matrix -->
        <script>
            function fetchAndDisplayMeasurements() {
                // Fetch and display measurements for the current matrix
                fetch('functions/fetch_update_measurement.php?matrix_name=<?php echo urlencode($matrix_name); ?>')
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('measurements-update-container-<?php echo $matrix_name_base64; ?>').innerHTML = data;
                    });
            }

            // Fetch and display measurements initially
            fetchAndDisplayMeasurements();

            // Reload measurements every 5 seconds
            setInterval(fetchAndDisplayMeasurements, 5000);
        </script>

<?php 
        }
    }
?>

<!-- UPDATING MATRIX START-->
<?php 
 $update = "SELECT * FROM ts_matrices";
 $update_rs = $conn->query($update);
 while ($update_row = $update_rs->fetch_assoc()) {
?>
<div class="modal fade" id="updating-modal<?php echo $update_row['matrix_id']; ?>" tabindex="-1" aria-labelledby="updatingMeasurement" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatingMeasurement">Update Measurement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" data-bs-toggle='modal' data-bs-target='#update-modal<?php echo base64_encode($update_row['matrix_name']); ?>'></button>
            </div>
            <div class="modal-body">
                <!-- Form for adding a product -->
                <form id="updateMatrixForm" enctype="multipart/form-data">
                    <!-- Product Name -->
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label>Measurement Name:</label><br>
                                <input type="text" name="measurement_name" value="<?php echo $update_row['measurement_name']; ?>" required>
                                <input type="hidden" name="matrix_id" value="<?php echo $update_row['matrix_id']; ?>" required>
                            </div>
                            <div class="col-6">
                                <label>Measurement Size:</label><br>
                                <input type="text" name="measurement_size" value="<?php echo $update_row['measurement_size']; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label>Size Name:</label><br>
                                <input type="text" name="size_name" value="<?php echo $update_row['size_name']; ?>" required>
                            </div>
                            <div class="col-6">
                                <label>Additional:</label><br>
                                <input  type="number" name="additional" step="0.01" min="0" value="<?php echo $update_row['additional']; ?>" required>
                            </div>
                        </div>
                    </div>
                    <center>
                        <button type="submit" id="updateMeasurement" class="btn btn-primary">Update Measurement</button>
                        <br><br>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>
<?php 
    }
?>
<!-- LINK PRODUCT AND MATRIX DONE-->
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../assets/script.js"></script>
    <script>
    // Activate horizontal scrolling for the image carousel
    $('.image-carousel').on('mousewheel', function (e) {
        e.preventDefault();
        $(this).scrollLeft($(this).scrollLeft() + e.originalEvent.deltaY);
    });
</script>
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

<!-- Script to handle table reload and pagination -->
<script>
    // Function to reload the table content and pagination links
    function reloadTable() {
        // Fetch the table content and pagination links using AJAX
        fetch('functions/fetch_matrix.php?page=<?php echo isset($_GET['page']) ? $_GET['page'] : 1; ?>') 
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
<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- JavaScript code to handle form submission -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Get the form element
    var form = document.getElementById("addProductForm");

    // Function to handle form submission
    function submitForm() {
        // Create FormData object to store form data
        var formData = new FormData(form);

        // Send AJAX request to the backend PHP script
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "functions/add_product_to_matrix.php");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Check the response from the server
                    var response = xhr.responseText.trim();
                    if (response.startsWith("Success:")) {
                        // Success message using SweetAlert2
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.substring(8) // Remove "Success:" prefix from the response
                        });
                    } else {
                        // Error message using SweetAlert2
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.substring(6) // Remove "Error:" prefix from the response
                        });
                    }
                } else {
                    // Error message using SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Error occurred while adding product: ' + xhr.status
                    });
                }
            }
        };
        xhr.send(formData);
    }

    // Add event listener for form submission
    form.addEventListener("submit", function(event) {
        // Prevent default form submission
        event.preventDefault();

        // Call the function to handle form submission
        submitForm();
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Get the form elements
    var forms = document.querySelectorAll("form[id^='addSizeForm']");

    // Function to handle form submission
    function submitForm(event) {
        // Prevent default form submission
        event.preventDefault();

        // Create FormData object to store form data
        var formData = new FormData(this);

        // Send AJAX request to the backend PHP script
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "functions/add_product_size.php");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Check the response from the server
                    var response = xhr.responseText.trim();
                    if (response.startsWith("Success:")) {
                        // Success message using SweetAlert2
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Size added successfully' // Remove "Success:" prefix from the response
                        });
                    } else {
                        // Error message using SweetAlert2
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.substring(6) // Remove "Error:" prefix from the response
                        });
                    }
                } else {
                    // Error message using SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Error occurred while adding size: ' + xhr.status
                    });
                }
            }
        };
        xhr.send(formData);
    }

    // Add event listener for form submission to each form
    forms.forEach(function(form) {
        form.addEventListener("submit", submitForm);
    });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Get all form elements with IDs starting with "addMeasurementForm-"
    var forms = document.querySelectorAll('form[id^="addMeasurementForm-"]');

    // Function to handle form submission
    function submitForm3(event) {
        // Prevent default form submission
        event.preventDefault();

        // Get the form element
        var form = event.target;

        // Create FormData object to store form data
        var formData = new FormData(form);

        // Send AJAX request to the backend PHP script
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "functions/add_product_measurement.php");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Check the response from the server
                    var response = xhr.responseText.trim();
                    if (response.startsWith("Success:")) {
                        // Success message using SweetAlert2
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Measurement added successfully' // Remove "Success:" prefix from the response
                        });
                    } else {
                        // Error message using SweetAlert2
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.substring(6) // Remove "Error:" prefix from the response
                        });
                    }
                } else {
                    // Error message using SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Error occurred while adding product: ' + xhr.status
                    });
                }
            }
        };
        xhr.send(formData);
    }

    // Add event listener for form submission for each form
    forms.forEach(function(form) {
        form.addEventListener("submit", submitForm3);
    });
});

</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Get all form elements with IDs starting with "addMeasurementForm-"
    var forms = document.querySelectorAll('form[id^="updateMatrixForm"]');

    // Function to handle form submission
    function submitForm4(event) {
        // Prevent default form submission
        event.preventDefault();

        // Get the form element
        var form = event.target;

        // Create FormData object to store form data
        var formData = new FormData(form);

        // Send AJAX request to the backend PHP script
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "functions/update_measurement.php");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Check the response from the server
                    var response = xhr.responseText.trim();
                    if (response.startsWith("Success:")) {
                        // Success message using SweetAlert2
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Measurement added successfully' // Remove "Success:" prefix from the response
                        });
                    } else {
                        // Error message using SweetAlert2
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.substring(6) // Remove "Error:" prefix from the response
                        });
                    }
                } else {
                    // Error message using SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Error occurred while adding product: ' + xhr.status
                    });
                }
            }
        };
        xhr.send(formData);
    }

    // Add event listener for form submission for each form
    forms.forEach(function(form) {
        form.addEventListener("submit", submitForm4);
    });
});

</script>

<script>
function confirmDelete(matrixNumber) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to delete this matrix!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // If user confirms, send AJAX request
            $.ajax({
                type: 'POST',
                url: 'functions/delete_measurement.php',
                data: { matrix_number : matrixNumber },
                success: function(response) {
                    // Handle success response
                    if (response === 'success') {
                        Swal.fire('Deleted!', 'The item has been deleted.', 'success');
                        // Reload or update the view modal here
                    } else {
                        Swal.fire('Error!', 'Something went wrong during deletion.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    // Log the error in the console
                    console.error(xhr.responseText);
                    // Handle error response
                    Swal.fire('Error!', 'Failed to delete the item.', 'error');
                }
            });
        }
    });
}
</script>

<script>
function confirmDelete(assID) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to remove this product in matrix!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, remove it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // If user confirms, send AJAX request
            $.ajax({
                type: 'POST',
                url: 'functions/remove_products_in_matrix.php',
                data: { ass_id : assID },
                success: function(response) {
                    // Handle success response
                    if (response === 'success') {
                        Swal.fire('Removed!', 'The product has been removed in the matrix.', 'success');
                        // Reload or update the view modal here
                    } else {
                        Swal.fire('Error!', 'Something went wrong during deletion.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    // Log the error in the console
                    console.error(xhr.responseText);
                    // Handle error response
                    Swal.fire('Error!', 'Failed to remove the product in the matrix.', 'error');
                }
            });
        }
    });
}
</script>



</body>

</html>
