$('.image-carousel').on('mousewheel', function (e) {
    e.preventDefault();
    $(this).scrollLeft($(this).scrollLeft() + e.originalEvent.deltaY);
});


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


document.addEventListener("DOMContentLoaded", function() {
    var forms = document.querySelectorAll('form[id^="addProductForm_"]');

    function submitFormstart(event) {
        event.preventDefault();

        var formData = new FormData(this);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "functions/add_product_to_matrix.php");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText.trim();
                    if (response.startsWith("Success:")) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.substring(8) 
                        });
                    } else {    
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.substring(6) 
                        });
                    }
                } else {
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

    forms.forEach(function(form) {
        form.addEventListener("submit", submitFormstart);
    });
});




document.addEventListener("DOMContentLoaded", function() {
var forms = document.querySelectorAll("form[id^='addSizeForm']");

function submitForm(event) {
    event.preventDefault();

    var formData = new FormData(this);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "functions/add_product_size.php");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = xhr.responseText.trim();
                if (response.startsWith("Success:")) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Size added successfully' 
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.substring(6)
                    });
                }
            } else {
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

forms.forEach(function(form) {
    form.addEventListener("submit", submitForm);
});
});



document.addEventListener("DOMContentLoaded", function() {
var forms = document.querySelectorAll('form[id^="addMeasurementForm-"]');

function submitForm3(event) {
    event.preventDefault();

    var form = event.target;

    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "functions/add_product_measurement.php");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = xhr.responseText.trim();
                if (response.startsWith("Success:")) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Measurement added successfully' 
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.substring(6)
                    });
                }
            } else {
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

forms.forEach(function(form) {
    form.addEventListener("submit", submitForm3);
});
});




document.addEventListener("DOMContentLoaded", function() {
var forms = document.querySelectorAll('form[id^="updateMatrixForm"]');

function submitForm4(event) {
    event.preventDefault();

    var form = event.target;

    var formData = new FormData(form);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "functions/update_measurement.php");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = xhr.responseText.trim();
                if (response.startsWith("Success:")) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Measurement added successfully' 
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.substring(6) 
                    });
                }
            } else {
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

forms.forEach(function(form) {
    form.addEventListener("submit", submitForm4);
});
});




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
        $.ajax({
            type: 'POST',
            url: 'functions/delete_measurement.php',
            data: { matrix_number : matrixNumber },
            success: function(response) {
                if (response === 'success') {
                    Swal.fire('Deleted!', 'The item has been deleted.', 'success');
                } else {
                    Swal.fire('Error!', 'Something went wrong during deletion.', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire('Error!', 'Failed to delete the item.', 'error');
            }
        });
    }
});
}



function confirmDelete2(assID) {
Swal.fire({
    title: 'Are you sure?',
    text: 'You are about to remove this product in matrix!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Yes, remove it!',
    cancelButtonText: 'Cancel'
}).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
            type: 'POST',
            url: 'functions/remove_products_in_matrix.php',
            data: { ass_id : assID },
            success: function(response) {
                if (response === 'success') {
                    Swal.fire('Removed!', 'The product has been removed in the matrix.', 'success');
                } else {
                    Swal.fire('Error!', 'Something went wrong during deletion.', 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                Swal.fire('Error!', 'Failed to remove the product in the matrix.', 'error');
            }
        });
    }
});
}

document.addEventListener("DOMContentLoaded", function() {
    var container = document.getElementById("measurementContainer");

    var addBtn = document.querySelector(".add-measurement-btn");
    var removeBtn = document.querySelector(".remove-measurement-btn");

    addBtn.addEventListener("click", function() {
        var measurementRow = createMeasurementRow();

        container.appendChild(measurementRow);
    });

    removeBtn.addEventListener("click", function() {
        var children = container.children;

        if (children.length > 1) {
            container.removeChild(children[children.length - 1]);
        }
    });

    function createMeasurementRow() {
        var measurementRow = document.createElement("div");
        measurementRow.className = "row measurement-row"; 

        var hr = document.createElement("hr");
        container.appendChild(hr);

        var col1 = createCol("Measurement Name:", "text", "measurement_name[]", true, "col-md-4");
        var col2 = createCol("Measurement Size:", "text", "measurement_size[]", true, "col-md-4");
        var col3 = createCol("Additional:", "number", "additional", false, "col-md-4", "0.00", "0.01", "0");

        measurementRow.appendChild(col1);
        measurementRow.appendChild(col2);
        measurementRow.appendChild(col3);

        var br = document.createElement("br");
        measurementRow.appendChild(br);

        return measurementRow;
    }

    function createCol(labelText, inputType, inputName, required, colClass, value, step, min) {
        var col = document.createElement("div");
        col.className = colClass; 

        var label = document.createElement("label");
        label.textContent = labelText;

        var input = document.createElement("input");
        input.type = inputType;
        input.name = inputName;
        if (value !== undefined) input.value = value;
        if (step !== undefined) input.step = step;
        if (min !== undefined) input.min = min;
        if (required) input.required = true;

        col.appendChild(label);
        col.appendChild(document.createElement("br"));
        col.appendChild(input);

        return col;
    }
});

document.addEventListener("DOMContentLoaded", function() {
    var addMatrixForm = document.getElementById("addMatrixForm");

    addMatrixForm.addEventListener("submit", function(event) {
        event.preventDefault();

        var formData = new FormData(addMatrixForm);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "functions/add_matrix.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    if (xhr.responseText.trim() === "Matrix added successfully!") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: xhr.responseText
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseText
                        });
                    }
                } else {
                    console.error("XHR Error:", xhr.status, xhr.statusText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while adding the matrix.'
                    });
                }
            }
        };
        xhr.onerror = function() {
            console.error("XHR Network Error");
        };
        xhr.send(formData);
    });
});
