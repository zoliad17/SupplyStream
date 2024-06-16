<!doctype html>
<html lang="en">

<head>
  <title>Transaction</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="icon" href="../assets/logo/favicon.ico">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="/assets/Css/bootstrap.css">
  <link rel="stylesheet" href="/assets/Css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/Css/stylesheet.css">

  <!-- Boxicons Link -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">

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


  <div>
    <h1 class="title-transaction text-dark text-center">Transaction</h1>
  </div>


  <?php
  require '../config/connect.php';

  $sql = "SELECT req.Order_Id,
            req.Username, 
            p.Product_Name, 
            s.Supplier_Name,
            req.Quantity,
            req.Date_Req,
            req.Status
        FROM 
            reqDelivery req
        LEFT JOIN product p
            ON req.Product_Id = p.Product_Id
        LEFT JOIN supplier s
            ON req.Supplier_Id = s.Supplier_Id
            
        WHERE Status = 'Pending'";

  $result = $con->query($sql);
  ?>


  <div class="container container-ReqTable">
    <table id="tableTransaction" class="table table-hover text-center table-Req">
      <thead>
        <tr class="table-dark">
          <th width="12%" scope="col">Order Id</th>
          <th width="12%" scope="col">Name Requested</th>
          <th width="10%" scope="col">Product Name</th>
          <th width="10%" scope="col">Supplier Name</th>
          <th width="10%" scope="col">Quantity</th>
          <th width="10%" scope="col">Date Requested</th>
          <th width="14%" scope="col">Action</th>
        </tr>
      </thead>
      <tbody class="text-center">
        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
        ?>
            <tr class="align-middle text-nowrap justify-content-center align-items-center fw-bold">
              <td><?php echo $row["Order_Id"]; ?></td>
              <td><?php echo $row["Username"]; ?></td>
              <td><?php echo $row["Product_Name"]; ?></td>
              <td><?php echo $row["Supplier_Name"]; ?></td>
              <td><?php echo $row["Quantity"]; ?></td>
              <td><?php echo $row["Date_Req"]; ?></td>

              <!-- Action Column -->
              <td class="text-center">
                <div class="d-flex justify-content-center align-items-center">
                  <form action="./transaction.php" method="post" class="me-2">
                    <input type="hidden" name="order_id" value="<?php echo $row["Order_Id"]; ?>">
                    <button type="submit" class="btn btn-success" name="approve">Approve</button>
                  </form>
                  <button type="button" class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#declineModal-<?php echo $row["Order_Id"]; ?>">Decline</button>
                  <a href="./transaction.php?confirmDelete=<?php echo $row["Order_Id"]; ?>" onclick="return confirmDelete();" class="btn btn-danger">Delete</a>
                </div>
              </td>
            </tr>

            <!-- Decline Modal -->
            <div class="modal fade" id="declineModal-<?php echo $row["Order_Id"]; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="declineModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <form action="./transaction.php" method="post">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="addProductLabel">Reason of Decline</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <input type="hidden" name="order_id" value="<?php echo $row["Order_Id"]; ?>">
                      <textarea class="form-control" id="declineFormControlTextarea" rows="3" name="decline_reason"></textarea>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary me-3" name="submitDecline">Submit</button>
                      <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Close</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- End of Decline Modal -->
        <?php
          }
        } else {
          echo "<tr><td colspan='7'>No delivery information found</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

  <!-- Delete -->
  <?php
  if (isset($_GET['confirmDelete'])) {
    $orderId = intval($_GET['confirmDelete']); // Convert orderId to an integer

    $queryDel = "DELETE FROM reqDelivery WHERE Order_Id = $orderId";
    $result = mysqli_query($con, $queryDel);

    if ($result) {
      // Deletion was successful
      echo "<script>
                alert('Order deleted successfully!');
                window.location.href = './transaction.php';
              </script>";
      exit();
    } else {
      // Error in deletion
      echo "<script>
                alert('Error deleting. Please try again later.');
                window.location.href = './transaction.php';
              </script>";
      exit();
    }
  }
  ?>

  <!-- Decline PHP -->
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitDecline'])) {
    // Get the reason for decline from the form
    $reasonDecline = trim($_POST['decline_reason']);
    $order_id = intval($_POST['order_id']); // Get the order ID from the form

    if (!empty($reasonDecline)) {
      // Prepare the SQL statement
      $updateReasonDeclineQuery = "UPDATE reqDelivery 
            SET Reason_Decline = ?, 
                Status = 'Declined'
            WHERE Order_Id = ?";
      $stmt = mysqli_prepare($con, $updateReasonDeclineQuery);
      mysqli_stmt_bind_param($stmt, "si", $reasonDecline, $order_id);

      // Execute the statement
      $result = mysqli_stmt_execute($stmt);

      if ($result) {
        // Query executed successfully
        echo "<script>alert('Decline reason updated successfully.');</script>";
        echo "<script>window.location.href = './transaction.php';</script>";
        exit();
      } else {
        // Query failed
        echo "<script>alert('Error: Unable to update decline reason.');</script>";
      }

      // Close the statement
      mysqli_stmt_close($stmt);
    } else {
      // Decline reason not provided
      echo "<script>alert('Error: Decline reason not provided.');</script>";
    }
  }
  ?>

  <!-- Approve PHP -->
  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['approve'])) {
    $order_id = $_POST['order_id'];
    $current_date = date('Y-m-d');

    // Start a transaction
    mysqli_begin_transaction($con);

    try {
      // Get the product ID and quantity from the request
      $query = "SELECT Product_Id, Quantity FROM reqDelivery WHERE Order_Id = ?";
      $stmt = mysqli_prepare($con, $query);
      mysqli_stmt_bind_param($stmt, "i", $order_id);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_bind_result($stmt, $product_id, $quantity);
      mysqli_stmt_fetch($stmt);
      mysqli_stmt_close($stmt);

      // Update the status of the order
      $query = "UPDATE reqDelivery SET Status = 'Approved', Date_Approve = ? WHERE Order_Id = ?";
      $stmt = mysqli_prepare($con, $query);
      mysqli_stmt_bind_param($stmt, "si", $current_date, $order_id);
      $result = mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);

      if (!$result) {
        throw new Exception('Error approving order.');
      }

      // Deduct the quantity from the total stock in the inventory table
      $query = "UPDATE inventory SET Total_Stock = Total_Stock - ? WHERE Product_Id = ?";
      $stmt = mysqli_prepare($con, $query);
      mysqli_stmt_bind_param($stmt, "ii", $quantity, $product_id);
      $result = mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);

      if (!$result) {
        throw new Exception('Error updating inventory.');
      }

      // Commit the transaction
      mysqli_commit($con);

      echo "<script>alert('Order approved successfully.')</script>";
      echo "<script>window.location.href = './transaction.php';</script>";
      exit();
    } catch (Exception $e) {
      // Rollback the transaction if any query fails
      mysqli_rollback($con);
      echo "<script>alert('{$e->getMessage()}')</script>";
    }
  }
  ?>


  <script>
    function confirmDelete() {
      return confirm("Are you sure you want to delete?");
    }
  </script>
  <script src="../assets/Js/script.js"></script>
  <script src="/assets/Js/bootstrap.bundle.js"></script>
  <script src="/assets/Js/bootstrap.bundle.min.js"></script>
  <script src="/assets/Js/form-validation.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>