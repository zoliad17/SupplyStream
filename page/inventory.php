
<!doctype html>
<html lang="en">
  <head>
    <title>Inventory</title>
    
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

    <!-- Button trigger modal -->
    <div class="container d-flex flex-row-reverse align-items-center">
        <button type="button" class="btn-add btn btn-success" data-bs-toggle="modal" data-bs-target="#addInventoryModal">
        <i class="bi bi-plus-lg"></i>Add Inventory
        </button>
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

 

<div>
  <h1 class="text-center titleInventory">INVENTORY</h1>
  </div>


<!-- Add Inventory Modal -->
<div class="modal fade" id="addInventoryModal" tabindex="-1" aria-labelledby="addInventoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addInventoryLabel">Add Inventory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for adding inventory -->
            <form action="../config/crud.php" method="post" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="addProductId" class="form-label">Product</label>
                <select class="form-select" id="addProductId" name="addProductId" required>
                    
                    <?php
                    require('../config/connect.php');

                    // Fetch products from the product table that are not already in the inventory
                    $productQuery = mysqli_query($con, "SELECT p.Product_Id, p.Product_Name 
                                                        FROM product p 
                                                        LEFT JOIN inventory i ON p.Product_Id = i.Product_Id 
                                                        WHERE i.Product_Id IS NULL");

                    if(mysqli_num_rows($productQuery) > 0) {
                        // Loop through each product and populate the options
                        while ($productRow = mysqli_fetch_assoc($productQuery)) {
                            echo '<option value="">Choose Product...</option>';  
                            echo '<option value="' . $productRow['Product_Id'] . '">' . $productRow['Product_Name'] . '</option>';
                        }
                    }
                    ?>
                </select>
                <?php
                if(mysqli_num_rows($productQuery) == 0) {
                    echo '<option value="">No More Products Available</option>';
                    // Disable the select element
                    echo '<script>document.getElementById("addProductId").disabled = true;</script>';
                }
                ?>
        </div>


            <div class="mb-3">
                <label for="addLastAddedStock" class="form-label">Stock To Be Added</label>
                <input type="number" class="form-control" id="addLastAddedStock" name="addLastAddedStock" min="1" required>
            </div>
            <div class="modal-footer">
                <button type="submit" name="submitAddInventory" class="btn btn-primary me-3">Add Inventory</button>
                <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Close</button> 
            </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--Table Inventory-->
<div class="table-inventory container"> 

<div class="container">
<table class="table table-hover table-Inventory" id="tableInventory">
        <thead class="table-dark text-light">
            <tr class="text-center">
                <th width="10%" scope="col" class="rounded-start text-nowrap">Inventory ID</th>
                <th width="10%" scope="col" class="text-nowrap">Product Name</th>
                <th width="10%" scope="col" class="text-nowrap">Category</th>
                <th width="10%" scope="col" class="text-nowrap">Supplier</th>
                <th width="10%" scope="col" class="text-nowrap">Last Added Stock</th>
                <th width="10%" scope="col" class="text-nowrap">Total Stock</th>
                <th width="10%" scope="col" class="rounded-end">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../config/connect.php';
            $select = mysqli_query($con, 
        "SELECT 
            i.Inventory_Id,
            i.Product_Id,
            p.Product_Name,
            p.Category_Id,
            c.Category_Name, 
            i.Supplier_Id,
            s.Supplier_Name,
            i.Last_Added_Stock,
            i.Total_Stock
        FROM 
            inventory i
        INNER JOIN 
            product p ON i.Product_Id = p.Product_Id
        LEFT JOIN 
            category c ON p.Category_Id = c.Category_Id 
        INNER JOIN 
            supplier s ON i.Supplier_Id = s.Supplier_Id;"
            );

            
            while ($row = mysqli_fetch_assoc($select)) {
            ?>
            <tr class="align-middle">
                <th scope="row"><?php echo $row['Inventory_Id']; ?></th>
                <td><?php echo $row['Product_Name']; ?></td>
                <td><?php echo $row['Category_Name']; ?></td>
                <td><?php echo $row['Supplier_Name']; ?></td>
                <td><?php echo $row['Last_Added_Stock']; ?></td>
                <td><?php echo $row['Total_Stock']; ?></td>
                <td class="text-nowrap">


<!-- Button trigger modal Edit -->
    <a href="#" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['Inventory_Id']; ?>" class="text-decoration-none">
        <button class="btn btn-edit btn-success me-3">
            <i class="bi bi-pencil-square"></i>Edit
        </button>
    </a>

    <!-- Button trigger modal AddStock -->
    <a href="#" data-bs-toggle="modal" data-bs-target="#stockModal<?php echo $row['Inventory_Id']; ?>" class="text-decoration-none text">
        <button class="btn btn-add-stock btn-success me-3">
            <i class="bi bi-plus-circle me-2"></i>Stock
        </button>
    </a>

<!-- Stock Modal -->
<div class="modal fade" id="stockModal<?php echo $row['Inventory_Id']; ?>" tabindex="-1" aria-labelledby="stockModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="stockModalLabel">Add Stock</h5>
                <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <!-- Form for adding stock data -->
                <form action="../config/crud.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="stockId" value="<?php echo $row['Inventory_Id']; ?>">
                    <div class="mb-3">
                        <label for="stockProductName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="editProductName" name="editProductName" value="<?php echo $row['Product_Name']; ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="input-group-text" for="stockCategory">Category</label>
                        <select class="form-select" id="stockCategory" name="editCategory" disabled>
                        <option value="">Select a Category...</option>
                            <?php
                            $query = "SELECT * FROM category";
                            $result = mysqli_query($con, $query);
                            while ($category_row = mysqli_fetch_assoc($result)) {
                                $selected = ($category_row['Category_Id'] == $row['Category_Id']) ? 'selected' : '';
                                echo "<option value='" . $category_row['Category_Id'] . "' " . $selected . ">" . $category_row['Category_Name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="addLastAddedStock" class="form-label">Stock To Be Added</label>
                        <input type="number" class="form-control" id="addLastAddedStock" name="addStock" min="1"required>
                    </div>
                    <button type="submit" name="submitAddStock" class="btn btn-primary mx-auto">Add Stock</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Add Stock Modal -->

<!--Edit Stock Modal -->
<div class="modal fade" id="editModal<?php echo $row['Inventory_Id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Inventory</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- Form for editing data -->
                <form action="../config/crud.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="editId" value="<?php echo $row['Inventory_Id']; ?>">
                    <!-- Input fields for editing data -->
                    <div class="mb-3">
                        <label for="editProductName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="editProductName" name="editProductName" value="<?php echo $row['Product_Name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="input-group-text" for="editCategory">Category</label>
                        <select class="form-select" id="editCategory<?php echo $row['Inventory_Id']; ?>" name="editCategory">
                            <option value="">Select a Category...</option>
                            <?php
                            $query = "SELECT * FROM category";
                            $result = mysqli_query($con, $query);
                            while ($category_row = mysqli_fetch_assoc($result)) {
                                $selected = ($category_row['Category_Id'] == $row['Category_Id']) ? 'selected' : '';
                                echo "<option value='" . $category_row['Category_Id'] . "' " . $selected . ">" . $category_row['Category_Name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>

                <div class="mb-3">
                    <label class="input-group-text" for="editSupplier">Supplier</label>
                    <select class="form-select" id="editSupplier<?php echo $row['Product_Id']; ?>" name="editSupplier">
                        <option value="">Choose Supplier...</option>
                        <?php
                        $query = "SELECT * FROM supplier";
                        $result = mysqli_query($con, $query);
                        while ($supplier_row = mysqli_fetch_assoc($result)) {
                            $selected = ($supplier_row['Supplier_Id'] == $row['Supplier_Id']) ? 'selected' : '';
                            echo "<option value='" . $supplier_row['Supplier_Id'] . "' " . $selected . ">" . $supplier_row['Supplier_Name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                    <div class="mb-3">
                        <label for="editLastAddedStock" class="form-label">Last Added Stock</label>
                        <input type="number" class="form-control" id="editLastAddedStock" name="editLastAddedStock" value="<?php echo $row['Last_Added_Stock']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="editTotalStock" class="form-label">Total Stock</label>
                        <input type="number" class="form-control" id="editTotalStock" name="editTotalStock" value="<?php echo $row['Total_Stock']; ?>" required>
                    </div>
                    <button type="submit" name="submitEditInventory" class="btn btn-primary mx-auto">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!--End Edit Modal-->

</div>
    </td>
        </tr>

        <?php } ?>
        </tbody>
            </table> 
                </div>
                    </div>
                        <section class="overlay"></section>

<?php
  require('../config/connect.php');

  // Delete inventory
  if(isset($_GET['delete'])){
      $Id = intval($_GET['delete']); // Convert $Id to an integer
      
      echo "<script>";
      echo "if (confirm('Are you sure you want to delete this inventory?')) {";
      echo "  window.location.href = './inventory.php?confirmDelete=$Id';";
      echo "} else {";
      echo "  window.location.href = './inventory.php';";
      echo "}";
      echo "</script>";
  }

 
?>

            
                        
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
        $('#tableInventory').DataTable({
            columnDefs: [
                { orderable: false, searchable: false, targets: 6}
            ]
        });;
     });
    </script>

 
  </body>
</html>