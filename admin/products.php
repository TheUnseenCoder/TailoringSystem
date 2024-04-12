<?php

session_start();

include '../includes/conn.php';

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

// Number of records per page
$records_per_page = 10; // Adjust as needed

// Query to count total number of records
$total_records_query = "SELECT COUNT(*) AS total_records FROM ts_products";
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
    <title>TRBS | Products</title>
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
        <center><h1>Products</h1></center>
        <div class="text-end mx-5">
            <button type='button' class="btn btn-success" data-bs-toggle='modal' data-bs-target='#addProductModal'>Add Product</button>
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
                        <h6 class="fw-semibold mb-0 text-center" style="background-color: black; color: white;">Product Name</h6>
                    </th>
                    <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0 text-center" style="background-color: black; color: white;">Base Price</h6>
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

<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for adding a product -->
                <form id="addProductForm" enctype="multipart/form-data">
                    <!-- Product Name -->
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12">
                                <label for="productName">Product Name:</label><br>
                                <input type="text" id="productName" name="productName" required>
                            </div>
                        </div>
                    </div>
                    <!-- Product Description -->
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12">
                                <label for="productDescription">Description:</label><br>
                                <textarea id="productDescription" name="productDescription" style="height: 100%; width: 100%;" required></textarea>
                            </div>
                        </div>
                    </div><br>
                    <!-- Product Base Price and Clothing Type -->
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="productBasePrice">Base Price:</label><br>
                                <input type="number" id="productBasePrice" name="productBasePrice" step="0.01" required>
                            </div>
                            <div class="col-6">
                                <label for="productImages">Images:</label><br>
                                <!-- Add multiple images here -->
                                <input type="file" id="productImages" name="productImages[]" multiple accept="image/*">
                            </div>
                        </div>
                    </div><br>
                    <!-- Submit Button -->
                    <center>
                        <button type="submit" id="addProduct" class="btn btn-primary">Add Product</button>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- VIEW MODAL -->
<?php 
 $view = "SELECT * FROM ts_products";
 $view_rs = $conn->query($view);
 while ($row1 = $view_rs->fetch_assoc()) {
?>
<div class="modal fade" id="view-modal<?php echo $row1['product_id']; ?>" tabindex="-1" aria-labelledby="viewProductModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProductModal">View Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                            <label for="productName">Product Name:</label><br>
                            <center><h3><?php echo $row1['name']; ?></h3></center>
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
                <!-- Product Base Price -->
                <div class="mb-3">
                    <div class="row">
                        <div class="col-12">
                            <label for="productBasePrice">Base Price:</label><br>
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
<!-- END OF VIEW MODAL -->

<!-- UPDATE MODAL -->
<?php 
 $update = "SELECT * FROM ts_products";
 $update_rs = $conn->query($update);
 while ($row2 = $update_rs->fetch_assoc()) {
?>
<div class="modal fade" id="update-modal<?php echo $row2['product_id']; ?>" tabindex="-1" aria-labelledby="updateProductModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProductModal">Update Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateProductForm" enctype="multipart/form-data">

                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12">
                                <input type="text" id="productID" name="productID" value="<?php echo $row2['product_id']; ?>" hidden>
                                <label for="productName">Product Name:</label><br>
                                <input type="text" id="productName" name="productName" value="<?php echo $row2['name']; ?>" required>
                            </div>
                        </div>
                    </div>
                    <!-- Product Description -->
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12">
                                <label for="productDescription">Description:</label><br>
                                <textarea id="productDescription" name="productDescription" style="height: 100%; width: 100%;" required><?php echo $row2['description']; ?></textarea>
                            </div>
                        </div>
                    </div><br>
                    <!-- Product Base Price and Clothing Type -->
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12">
                                <label for="productBasePrice">Base Price:</label><br>
                                <input type="number" id="productBasePrice" name="productBasePrice" value="<?php echo $row2['base_price']; ?>" step="0.01" required>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-12">
                                <label for="productImages">Images:</label><br>
                                <div class="image-carousel">
                                    <?php
                                        // Assuming you have a column named 'image_path' in your database for storing image paths
                                        $images_query2 = "SELECT * FROM ts_products WHERE product_id = " . $row2['product_id'];
                                        $images_result2 = $conn->query($images_query2);
                                        while ($image_row2 = $images_result2->fetch_assoc()) {
                                                $unserializedData2 = unserialize($image_row2['images']);

                                                // Iterate through the array and create HTML img elements
                                                foreach ($unserializedData2 as $imagePath2) {
                                                    // Check if the current element is an array (this handles the case when there's only one image path)
                                                    if (is_array($imagePath2)) {
                                                        foreach ($imagePath2 as $path2) {
                                                            echo '<img src="' . $path2 . '" alt="Product Image" width="250" height="250">';
                                                        }
                                                    } else {
                                                        echo '<img src="' . $imagePath2 . '" alt="Product Image" width="250" height="250">';
                                                    }
                                                }
                                            }
                                    ?>
                                </div><br>
                                <input type="text" id="oldimage" name="oldimage" value="<?php echo htmlspecialchars($row2['images']); ?>" hidden>
                                <input type="file" id="productImages" name="productImages[]" multiple accept="image/*">
                            </div>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <center>
                        <button type="submit" id="updateProduct" class="btn btn-primary">Update Product</button>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
 }
?>
<!-- END OF UPDATE MODAL -->




  
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

<script>
    // Function to handle form submission
    document.getElementById('addProductForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Fetch form data
        let formData = new FormData(this);

        // Send AJAX request
        fetch('functions/add_product.php', { // Updated URL
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // If insertion is successful, show success message using SweetAlert
                Swal.fire({
                    title: 'Success',
                    text: data.message,
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                });
                // Optionally, you can reset the form after successful submission
                this.reset();
            } else {
                // If insertion fails, show error message using SweetAlert
                Swal.fire({
                    title: 'Error',
                    text: data.message,
                    icon: 'error'
                });
            }
        })
        .catch(error => {
            // Handle any error that occurs during AJAX request
            console.error('Error:', error);
        });
    });

</script>

<script>
    // Function to handle form submission
    document.getElementById('updateProductForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        // Fetch form data
        let formData = new FormData(this);

        // Send AJAX request
        fetch('functions/update_product.php', { // Updated URL
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // If insertion is successful, show success message using SweetAlert
                Swal.fire({
                    title: 'Success',
                    text: data.message,
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    // Reload the page
                    location.reload();
                });
            } else {
                // If insertion fails, show error message using SweetAlert
                Swal.fire({
                    title: 'Error',
                    text: data.message,
                    icon: 'error'
                });
            }
        })
        .catch(error => {
            // Handle any error that occurs during AJAX request
            console.error('Error:', error);
        });
    });

</script>

<!-- Script to handle table reload and pagination -->
<script>
    // Function to reload the table content and pagination links
    function reloadTable() {
        // Fetch the table content and pagination links using AJAX
        fetch('functions/fetch_products.php?page=<?php echo isset($_GET['page']) ? $_GET['page'] : 1; ?>') 
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
    setInterval(reloadTable, 4000); // Adjust the interval as needed (in milliseconds)

    // Initial table load
    reloadTable();
</script>


</body>

</html>
