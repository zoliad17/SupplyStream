<!doctype html>
<html lang="en">
  <head>
    <title>Orders</title>
    
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
        include '../config/loginRegister.php'?>
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
<div class="container text-dashboard-logs mt-5">
  <h2 class="text-center deliveryLogs">REQUEST ORDER LOGS</h2>
</div>

<div class="container">
        <table class="table table-hover table-delivery" id="tableDelivery">
            <thead>
                <tr class="table-dark">
                    <th width="12%" scope="col">Order Id</th>
                    <th width="12%" scope="col">Name Requested</th>
                    <th width="10%" scope="col">Product Name</th>
                    <th width="10%" scope="col">Quantity</th>
                    <th width="10%" scope="col">Date Requested</th>
                    <th width="10%" scope="col">Date Approved</th>
                    <th width="10%" scope="col">Status</th>
                </tr>
            </thead>
            <tbody class="text-center">
      <?php
        require '../config/connect.php';

        $sql = mysqli_query($con, "SELECT req.Order_Id,
                req.Username, 
                p.Product_Name, 
                s.Supplier_Name,
                req.Quantity,
                req.Date_Req,
                req.Date_Approve,
                req.Status
            FROM 
                reqDelivery req
            LEFT JOIN product p
                ON req.Product_Id = p.Product_Id
            LEFT JOIN supplier s
                ON req.Supplier_Id = s.Supplier_Id
        ");

        while ($row = mysqli_fetch_assoc($sql)) { 
        ?>
                <tr>
                    <th scope="row"><?php echo $row["Order_Id"]; ?></th>
                    <th scope="row"><?php echo $row["Username"]; ?></th>
                    <td><?php echo $row["Product_Name"]; ?></td>
                    <td><?php echo $row["Quantity"]; ?></td>
                    <td><?php echo $row["Date_Req"]; ?></td>
                    <td><?php echo $row["Date_Approve"]; ?></td>
                    <td><?php echo $row["Status"]; ?></td>
                </tr>
                <?php }; ?>
            </tbody>
        </table>
</div>

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
        $('#tableDelivery').DataTable({
        });
    });
    </script>   
  </body>
</html>