<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Supply</title>
    <link rel="icon" href="../assets/logo/favicon.ico">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/assets/Css/bootstrap.css">
    <link rel="stylesheet" href="/assets/Css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/Css/stylesheet.css">

    <!-- Boxicons Link -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <!-- Sidebar -->
    <nav>
        <div class="logo container">
            <span class="logo-name">Supply Stream</span>
        </div>
    </nav>

    <div class="container text-center text-transaction">
        <h2 class="text-center text-transaction fw-bold mb-5">REQUEST SUPPLY FORM</h2>
    </div>

    <div class="container container-transaction">
        <main>

            <div class="row-transaction-form">
                <div class="col-md-7 col-lg-8">
                    <form class="needs-validation" method="POST" action="../page/RequestDelivery.php" enctype="multipart/form-data" novalidate>
                        <div class="row g-3">
                            <div class="col-12 mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group has-validation">
                                    <input type="text" class="form-control" id="username" name="username">
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="selectProductId" class="form-label">Product Name</label>
                                <?php
                                include '../config/connect.php';
                                // Get the selected product ID if the form is submitted
                                $selectedProductId = isset($_POST['selectProductId']) ? $_POST['selectProductId'] : '';

                                // Query to fetch products in inventory
                                $productQuery = mysqli_query($con, "SELECT i.Product_Id, p.Product_Name
                                                            FROM inventory i
                                                            INNER JOIN product p ON i.Product_Id = p.Product_Id");

                                if (!$productQuery) {
                                    echo '<p>Error fetching products: ' . mysqli_error($con) . '</p>';
                                } else {
                                    if (mysqli_num_rows($productQuery) > 0) {
                                        echo '<select class="form-select" id="selectProductId" name="selectProductId" onchange="this.form.submit()" required>';
                                        echo '<option value="">Choose a product...</option>';
                                        while ($productRow = mysqli_fetch_assoc($productQuery)) {
                                            // Escape output to prevent XSS
                                            $productId = htmlspecialchars($productRow['Product_Id'], ENT_QUOTES, 'UTF-8');
                                            $productName = htmlspecialchars($productRow['Product_Name'], ENT_QUOTES, 'UTF-8');
                                            // Retain selected product after form submission
                                            $selected = ($selectedProductId == $productId) ? 'selected' : '';
                                            echo '<option value="' . $productId . '" ' . $selected . '>' . $productName . '</option>';
                                        }
                                        echo '</select>';
                                    } else {
                                        echo '<p>No products available.</p>';
                                    }
                                }
                                ?>
                            </div>

                            <div class="mb-3">
                                <label for="selectSupplierId" class="form-label">Supplier Name</label>
                                <?php
                                include '../config/connect.php';
                                // Check if a product is selected
                                if (!empty($selectedProductId)) {
                                    // Query to fetch the supplier name based on the selected product ID
                                    $supplierQuery = mysqli_query($con, "SELECT s.Supplier_Name
                                                                 FROM inventory i
                                                                 INNER JOIN supplier s ON i.Supplier_Id = s.Supplier_Id
                                                                 WHERE i.Product_Id = '$selectedProductId'");

                                    if (!$supplierQuery) {
                                        echo '<p>Error fetching supplier: ' . mysqli_error($con) . '</p>';
                                    } else {
                                        if (mysqli_num_rows($supplierQuery) > 0) {
                                            // Fetch the supplier name
                                            $supplierRow = mysqli_fetch_assoc($supplierQuery);
                                            $supplierName = htmlspecialchars($supplierRow['Supplier_Name'], ENT_QUOTES, 'UTF-8');
                                            // Display the supplier name in the input field
                                            echo '<input type="text" class="form-control" id="selectSupplierId" name="selectSupplierId" value="' . $supplierName . '" readonly>';
                                        } else {
                                            echo '<input type="text" class="form-control" id="selectSupplierId" name="selectSupplierId" value="No supplier available" readonly>';
                                        }
                                    }
                                } else {
                                    echo '<input type="text" class="form-control" id="selectSupplierId" name="selectSupplierId" readonly>';
                                }
                                ?>
                            </div>
                            <div class="mb-3">
                                <label for="availableStock" class="form-label">Available Stock</label>
                                <?php
                                include '../config/connect.php';
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    if (isset($_POST['selectProductId'])) {
                                        include '../config/connect.php';
                                        $productId = $_POST['selectProductId'];
                                        // Query to fetch total stock for the given product
                                        $stockQuery = mysqli_query($con, "SELECT Total_Stock FROM inventory WHERE Product_Id = $productId");
                                        if ($stockQuery) {
                                            $stockData = mysqli_fetch_assoc($stockQuery);
                                            $totalStock = $stockData['Total_Stock'];
                                            echo '<input type="text" class="form-control" id="availableStock" name="availableStock" value="' . $totalStock . '" readonly>';
                                        } else {
                                            echo '<div class="alert alert-danger" role="alert">Error fetching stock data.</div>';
                                        }
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert">Product ID not set.</div>';
                                    }
                                }
                                ?>
                            </div>

                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                                <?php
                                include '../config/connect.php';
                                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                    if (isset($_POST['selectProductId']) && isset($_POST['quantity'])) {
                                        include '../config/connect.php';
                                        $productId = $_POST['selectProductId'];
                                        $quantity = $_POST['quantity'];

                                        // Query to fetch total stock for the given product
                                        $stockQuery = mysqli_query($con, "SELECT Total_Stock FROM inventory WHERE Product_Id = $productId");
                                        if ($stockQuery) {
                                            $stockData = mysqli_fetch_assoc($stockQuery);
                                            $totalStock = $stockData['Total_Stock'];
                                        } else {
                                            echo '<div class="alert alert-danger" role="alert">Error fetching stock data.</div>';
                                        }
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert">Product ID or quantity not set.</div>';
                                    }
                                }
                                ?>
                            </div>

                            <?php
                            require '../config/connect.php';
                            date_default_timezone_set('Asia/Manila');

                            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_button'])) {
                                if (isset($_POST['selectProductId']) && isset($_POST['quantity'])) {
                                    $productId = $_POST['selectProductId'];
                                    $quantity = $_POST['quantity'];

                                    // Query to fetch total stock for the given product
                                    $stockQuery = mysqli_query($con, "SELECT Total_Stock FROM inventory WHERE Product_Id = $productId");
                                    if ($stockQuery) {
                                        $stockData = mysqli_fetch_assoc($stockQuery);
                                        $totalStock = $stockData['Total_Stock'];

                                        // Check if the quantity exceeds the total stock
                                        if ($quantity > $totalStock) {
                                            echo '<div class="alert alert-warning" role="alert" id="alertMessage">Quantity exceeds the total stock.</div>';
                                        } else {
                                            // Insert into reqDelivery table
                                            $userId = $_POST['username']; // Assuming you have the user's ID in session
                                            $supplierQuery = mysqli_query($con, "SELECT Supplier_Id FROM inventory WHERE Product_Id = $productId");
                                            $supplierData = mysqli_fetch_assoc($supplierQuery);
                                            $supplierId = $supplierData['Supplier_Id'];
                                            $dateReq = date('Y-m-d'); // Current date

                                            $insertQuery = "INSERT INTO reqDelivery (Username, Product_Id, Supplier_Id, Quantity, Date_Req, Status) 
                                VALUES ('$userId', '$productId', '$supplierId', '$quantity', '$dateReq', 'Pending')";

                                            if (mysqli_query($con, $insertQuery)) {
                                                echo '<div class="alert alert-success" role="alert" id="alertMessage">Request submitted successfully.</div>';
                                            } else {
                                                echo '<div class="alert alert-danger" role="alert" id="alertMessage">Error submitting request: ' . mysqli_error($con) . '</div>';
                                            }
                                        }
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert" id="alertMessage">Error fetching stock data.</div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger" role="alert" id="alertMessage">Product ID or quantity not set.</div>';
                                }
                            }
                            ?>

                            <input type="submit" name="submit_button" value="Submit" class="btn btn-primary">

                            <a href="../index.php" class="back-arrow"><i class="bi bi-arrow-left-square-fill"></i></a>

                        </div>
                    </form>
        </main>
    </div>
    <section class="overlay"></section>
    </div>

    <script>
        setTimeout(function() {
            var alertMessage = document.getElementById('alertMessage');
            if (alertMessage) {
                alertMessage.style.display = 'none';
            }
        }, 3500);
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-VbPTo5RIBg2/1rAu3pSk7mAxWJZzNwrkGLR/8HPBdZEZ2k7uPMlUGzJ3/tIlT8hQ" crossorigin="anonymous">
    </script>

    <!-- Custom Scripts -->
    <script src="/assets/Js/script.js"></script>

    <!-- jQuery and Popper.js for Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

</body>

</html>