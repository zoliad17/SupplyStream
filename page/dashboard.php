<!doctype html>
<html lang="en">

<head>
  <title>Home</title>

  <meta charset="utf-8">

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="icon" href="../assets/logo/favicon.ico">

  <!--Boostrap-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!--Custom Css-->
  <link rel="stylesheet" href="/assets/Css/bootstrap.css">
  <link rel="stylesheet" href="/assets/Css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/Css/stylesheet.css">

  <!--Boxicons Link-->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <!--Bootstrap Icons-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">

</head>

<body>


  <!-- Sidebar -->
  <nav>
    <div class="logo container">
      <i class="bx bx-menu menu-icon"></i>
      <span class="logo-name">Supply Stream</span>
    </div>

    <div class="sidebar">
      <div class="logo">
        <i class="bx bx-menu menu-icon"></i>
        <span class="logo-name">Supply Stream</span>
      </div>

      <div class="sidebar-content">

        <ul class="lists">

          <li class="list user-text">
            <Span class="text text-center">
              <?php
              include '../config/connect.php';
              include '../config/loginRegister.php' ?>
              <h5>Hello, <?php echo $_SESSION['username']; ?></h5>
            </Span>
          </li>

          <li class="list">
            <a href="./dashboard.php" class="nav-link">
              <i class="bx bx-home-alt icon"></i>
              <span class="link">Dashboard</span>
            </a>
          </li>
          <li class="list">
            <a href="./product.php" class="nav-link">
              <i class="product-logo bi bi-bag"></i>
              <span class="link">Products</span>
            </a>
          </li>
          <li class="list">
            <a href="./inventory.php" class="nav-link">
              <i class="inventory-logo bi bi-boxes"></i>
              <span class="link">Inventory</span>
            </a>
          </li>
          <li class="list">
            <a href="./supplier.php" class="nav-link">
              <i class="supplier-logo bi bi-truck"></i>
              <span class="link">Supplier</span>
            </a>
          </li>
          <li class="list">
            <a href="./category.php" class="nav-link">
              <i class="category-logo bi bi-tag"></i>
              <span class="link">Category</span>
            </a>
          </li>

          <li class="list">
            <a href="./orders.php" class="nav-link">
              <i class=" transaction-logo  bi bi-cart"></i>
              <span class="link">Orders</span>
            </a>
          </li>

          <li class="list">
            <a href="./transaction.php" class="nav-link">
              <i class="bi bi-receipt transaction-logo"></i>
              <span class="link">Transaction</span>
            </a>
          </li>

        </ul>
        <div class="bottom-content">
          <ul class="lists">
            <li class="list">
              <a href="./login-page.php" class="nav-link">
                <i class="bx bx-log-out icon"></i>
                <span class="link">Logout</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <!--FOR CARDS SQL TOTAL-->
  <?php
  require '../config/connect.php';

  // Products TOTAL
  $sql = "SELECT COUNT(DISTINCT Product_Id) AS total_products FROM product";
  $result = mysqli_query($con, $sql);

  $total_products = 0;

  if ($result) {
    $row = mysqli_fetch_assoc($result);
    $total_products = $row['total_products'];
  } else {
    die("Query failed: " . mysqli_error($con));
  }

  // Suppliers TOTAL
  $sqlSuppliers = "SELECT COUNT(DISTINCT Supplier_Id) AS total_suppliers FROM supplier";
  $result = mysqli_query($con, $sqlSuppliers);

  $total_suppliers = 0;

  if ($result) {
    $row = mysqli_fetch_assoc($result);
    $total_suppliers = $row['total_suppliers'];
  } else {
    die("Query failed: " . mysqli_error($con));
  }

  // Inventory TOTAL
  $sqlInventory = "SELECT SUM(Total_Stock) AS total_stock FROM inventory";
  $result = mysqli_query($con, $sqlInventory);

  if ($result) {
    $row = mysqli_fetch_assoc($result);
    $total_stocks = $row['total_stock'];
  } else {
    die("Query failed: " . mysqli_error($con));
  }

  // Check for low stock in any inventory ID
  $sqlLowStock = "SELECT Inventory_ID, Total_Stock FROM inventory WHERE Total_Stock <= 5";
  $resultLowStock = mysqli_query($con, $sqlLowStock);

  $lowStockItems = [];
  if ($resultLowStock) {
    while ($row = mysqli_fetch_assoc($resultLowStock)) {
      $lowStockItems[] = $row;
    }
  } else {
    die("Query failed: " . mysqli_error($con));
  }

  ?>

  <div class="container container-card">

    <div class="dashboard container d-flex justify-content-center flex-row ">
      <div class="col-md-3 mb-3 product-status">
        <div class="card bg-success text-light h-100">
          <div class="product-card card-body py-5"><i class="bi bi-bag-dash-fill"></i>Products: <?php echo $total_products; ?> </div>
          <div class="card-footer d-flex bg-dark">
            <a href="./product.php" class="text text-light text-decoration-none">View Details</a>
            <span class="ms-auto">
              <a href="./product.php" class="text-light text-decoration-none"><i class="bi bi-chevron-right"></i></a>
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3 supplier-status">
        <div class="card bg-success text-white h-100">
          <div class="supplier-card card-body py-5"><i class='bx bxs-truck' style='color:#ffffff'></i></i>Suppliers: <?php echo $total_suppliers; ?> </div>
          <div class="card-footer d-flex bg-dark ">
            <a href="./supplier.php" class="text text-light text-decoration-none">View Details</a>
            <span class="ms-auto">
              <a href="./supplier.php" class="text text-light text-decoration-none"><i class="bi bi-chevron-right"></i></a>
            </span>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-3 inventory-status">
        <div class="card bg-success text-white h-100">
          <div class="currentStock-card card-body py-5"><i class="bi bi-box2-fill"></i>Current Stocks: <?php echo $total_stocks; ?></div>
          <div class="card-footer d-flex bg-dark">
            <a href="./inventory.php" class="text text-light text-decoration-none">View Details</a>
            <span class="ms-auto">
              <a href="./inventory.php" class="text text-light text-decoration-none"><i class="bi bi-chevron-right"></i></a>
            </span>
          </div>
        </div>
      </div>
      <?php if (!empty($lowStockItems)) { ?>
        <div class="col-md-3 mb-3 inventory-status">
          <div class="card bg-danger text-white h-100">
            <div class="card-body py-5">
              <i class="bi bi-exclamation-triangle-fill"></i> Warning: Low Stock!
              <?php foreach ($lowStockItems as $item) { ?>
                Inventory ID: <?php echo $item['Inventory_ID']; ?> Total Stock: <?php echo $item['Total_Stock']; ?>
              <?php } ?>
            </div>
            <div class="card-footer d-flex bg-dark">
              <a href="./inventory.php" class="text text-light text-decoration-none">View Details</a>
              <span class="ms-auto">
                <a href="./inventory.php" class="text text-light text-decoration-none"><i class="bi bi-chevron-right"></i></a>
              </span>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>

  </div>

  <div class="text-dashboard">
    <h2 class="text-center statusDashboard">STATUS</h2>
  </div>

  <!--Start of Status table-->
  <div class="container">
    <table id="tableDashboard" class="table-dashboard table table-hover text-center">
      <thead class="table-dark text-light">
        <tr>
          <th width="10%" scope="col" class="">Product ID</th>
          <th width="15%" scope="col">Product Image</th>
          <th width="10%" scope="col">Product</th>
          <th width="10%" scope="col">Category</th>
          <th width="10%" scope="col">Date</th>
        </tr>
      </thead>
      <tbody>
        <?php
        require('../config/connect.php');
        $select = mysqli_query($con, "SELECT
        p.Product_Id,
        p.Product_Name,
        p.Image_Url,
        c.Category_Name,
        p.Date_Added
      FROM 
        product p
      JOIN 
        category c ON p.Category_Id = c.Category_Id");

        while ($row = mysqli_fetch_assoc($select)) {
        ?>
          <tr class="align-middle">
            <th scope="row"><?php echo $row['Product_Id']; ?></th>
            <td><img src="../Image/<?php echo $row['Image_Url']; ?>" height="100" alt=""></td>
            <td><?php echo $row['Product_Name']; ?></td>
            <td><?php echo $row['Category_Name']; ?></td>
            <td><?php echo $row['Date_Added']; ?></td>
          </tr>
        <?php }; ?>
      </tbody>
    </table>
  </div>
  <!------End of Status table----->
  <section class="overlay"></section>



  <script src="../assets/Js/script.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="/assets/Js/bootstrap.bundle.js"></script>
  <script src="/assets/Js/bootstrap.bundle.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#tableDelivery').DataTable({});
    });
  </script>
  <script>
    $(document).ready(function() {
      $('#tableDashboard').DataTable({});
    });
  </script>
</body>

</html>