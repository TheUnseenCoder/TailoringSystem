<?php

session_start();

 include '../includes/conn.php';

// if(isset($_SESSION["loggedinasadmin"]) || isset($_SESSION["loggedinasmainuser"])){
  
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>TRBS | Products</title>
  <link rel="icon" href="../images/icon.jpg"> 
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
            margin: 2%;
            width: 100%;
            background: rgba(128, 128, 128, 0.2);
        }

    </style>
</head>

<body>

<div class="wrapper">
        <aside id="sidebar1">
            <?php include 'components/sidebar.php'; ?>
        </aside>
        <div class="main1">
            <center><h1>Products</h1></center>
            <div class="text-end mx-5"> <!-- Adjusted class and added margin top -->
                <button type='button' class="btn btn-primary" data-bs-toggle='modal' data-bs-target='#addProductModal'>Add Product</button>
            </div>
            <br>
            <div class="mx-3 my-3">
                <label for="searchInput" class="form-label">Search:</label>
                <input type="text" class="form-control" id="searchInput" onkeyup="searchTable()" placeholder="Enter search terms">
            </div><br>
            <div class="table-responsive">
            <table id="myTable" class="table text-nowrap mb-0 align-middle" >
                <thead class="text-dark fs-4">
                  <tr>
                  <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0 text-center">ID</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0 text-center">Product Name</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0 text-center">Base Price</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0 text-center">Clothing Type</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0 text-center">Action</h6>
                    </th>
                  </tr>
                </thead>
                <tbody>
                <?php
                    $sql = "SELECT * FROM ts_products";
                    if($rs=$conn->query($sql)){
                        $i = 1;
                        while ($row=$rs->fetch_assoc()) {
            
                    ?>
                  <tr>
                    <td class="border-bottom-0 text-center"><h6 class="fw-semibold mb-0"><?php echo $i++; ?></h6></td>
                    <td class="border-bottom-0 text-center"><h6 class="fw-semibold mb-0"><?php echo $row['name']; ?></h6></td>
                    <td class="border-bottom-0 text-center"><h6 class="fw-semibold mb-0"><?php echo $row['base_price']; ?></h6></td>
                    <td class="border-bottom-0 text-center"><h6 class="fw-semibold mb-0"><?php echo $row['clothing_type']; ?></h6></td>
                    <td class="border-bottom-0 text-center">
                        <a class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#view-modal<?php echo $row['product_id']; ?>"><i class="ti ti-edit fs-3"></i> View</a>
                        <a class="btn btn-sm btn-primary me-2" data-bs-toggle="modal" data-bs-target="#update-modal<?php echo $row['product_id']; ?>"><i class="ti ti-edit fs-3"></i> Update</a>
                    </td>
                    <?php
                            }
                            }
                          ?>
                  </tr>      
                </tbody>
              </table>
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
                <form id="addProductForm">
                    <!-- Product Name -->
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12">
                                <label for="productName">Name:</label><br>
                                <input type="text" id="productName" name="productName" required>
                            </div>
                        </div>
                    </div>
                    <!-- Product Description -->
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12">
                                <label for="productDescription">Description:</label><br>
                                <textarea id="productDescription" name="productDescription" required></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- Product Base Price and Clothing Type -->
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="productBasePrice">Base Price:</label><br>
                                <input type="number" id="productBasePrice" name="productBasePrice" step="0.01" required>
                            </div>
                            <div class="col-6">
                                <label for="productClothingType">Clothing Type:</label><br>
                                <input type="text" id="productClothingType" name="productClothingType" required>
                            </div>
                        </div>
                    </div>
                    <!-- Insert images here -->
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-12">
                                <label for="productImages">Images:</label><br>
                                <!-- Add multiple images here -->
                                <input type="file" id="productImages" name="productImages" multiple accept="image/*">
                            </div>
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <center>
                        <button type="submit" id="addProduct" class="btn btn-primary">Add Product</button>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>

  
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
</body>

</html>

<?php 
// }else{
//   header("location: ../../index.php");
//   exit;
// }
?>