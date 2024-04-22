

                    <?php 
                    include '../includes/conn.php';

                    $matrix_name = mysqli_real_escape_string($conn,"Women's T-Shirt");
                    $measurement = "SELECT DISTINCT measurement_name FROM ts_matrices WHERE matrix_name = '$matrix_name'";
                    $measurement_rs = $conn->query($measurement);
                    if (!$measurement_rs) {
                        // Query execution failed, handle the error
                        echo "Error: " . $conn->error;
                    } else {
                    while ($row_measurement = $measurement_rs->fetch_assoc()) {
                    ?>
                    <hr>
                    <div class="row">
                        <!-- Size Name -->
                        <div class="col-4">
                            <label>Measurement Name:</label><br>
                            <input type="text" value="<?php echo $row_measurement['measurement_name']; ?>" required disabled>
                            <input type="hidden" name="measurement_name" value="<?php echo $row_measurement['measurement_name']; ?>" required>
                            <!-- Matrix Name -->
                            <input type="hidden" name="matrix_name" value="<?php echo $matrix_name; ?>">

                        </div>
                        <!-- Measurement Size -->
                        <div class="col-4">
                            <label>Measurement Size:</label><br>
                            <input type="text" name="measurement_size" required>
                        </div>
                        <!-- Additional -->
                        <div class="col-4">
                            <label>Additional:</label><br>
                            <input type="number" name="additional" value="0.00" step="0.01" min="0" required>
                        </div>
                    </div>
                    <?php 
                    }
                }
                    ?>