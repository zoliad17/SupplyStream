
<!doctype html>
<html lang="en">
  <head>
    <title>Product</title>
    
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

    <!-- Button trigger modal for Add Product -->
    <div class="container d-flex flex-row-reverse align-items-center">
      <button type="button" class="btn-add btn btn-success" data-bs-toggle="modal" data-bs-target="#addProduct">
      <i class="bi bi-plus-lg"></i>Add Product
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
        </div>
      </nav>



  <div> 
    <h1 class="title-product text-dark text-center">PRODUCTS</h1>
  </div>
  
<!-- Add Product Modal -->
<div class="modal fade" id="addProduct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addProductLabel">Add Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../config/crud.php" method="POST" enctype="multipart/form-data">
                    <div class="input-group mb-4">
                        <span class="input-group-text">Product Name</span>
                        <input type="text" class="form-control" name="product_name" required>
                    </div>
                    <div class="input-group mb-4">
                        <span class="input-group-text">Price</span>
                        <input type="number" class="form-control" name="price" min="0.01" step="0.01" required>
                    </div>
                    <div class="input-group mb-4">
                        <label class="input-group-text" for="supplier">Supplier</label>
                        <select class="form-select" id="supplier" name="supplier_id" required>
                            <option value="">Choose a supplier..</option>
                            <?php
                            require('../config/connect.php');
                            $supplierQuery = mysqli_query($con, "SELECT Supplier_Id, Supplier_Name FROM supplier");
                            while ($supplierRow = mysqli_fetch_assoc($supplierQuery)) {
                                echo '<option value="' . $supplierRow['Supplier_Id'] . '">' . $supplierRow['Supplier_Name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group mb-4">
                        <label class="input-group-text" for="category">Category</label>
                        <select class="form-select" id="category" name="category_id" required>
                            <option value="">Choose a category..</option>
                            <?php
                            $categoryQuery = mysqli_query($con, "SELECT Category_Id, Category_Name FROM category");
                            while ($categoryRow = mysqli_fetch_assoc($categoryQuery)) {
                                echo '<option value="' . $categoryRow['Category_Id'] . '">' . $categoryRow['Category_Name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-group mb-3">
                        <label class="input-group-text">Image</label>
                        <input type="file" class="form-control" name="image" accept=".jpg, .png, .svg" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary me-3" name="addProduct">Add Product</button>
                <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>


  <?php
  require('../config/connect.php');
  $select = mysqli_query($con, 
            "SELECT 
              p.Product_Id,
              p.Product_Name,
              p.Price,
              p.Image_Url,
              s.Supplier_Name,
              c.Category_Name,
              p.Date_Added
          FROM 
              product p 
          JOIN 
              supplier s ON p.Supplier_Id = s.Supplier_Id
          JOIN 
              category c ON p.Category_Id = c.Category_Id;
          ");
          

  ?>

<div class="container"> 
  <table id="tableProduct" class="table-product table table-hover" >
    <thead class="table-dark text-light text-center">
          <tr>
            <th width= "12%" scope="col" class="rounded-start">Product ID</th>
            <th width= "10%" scope="col">Product Image</th>
            <th width= "10%" scope="col">Product Name</th>
            <th width= "10%" scope="col">Price (₱)</th>
            <th width= "10%" scope="col">Category</th>
            <th width= "10%" scope="col">Supplier</th>
            <th width= "10%" scope="col">Date</th>
            <th width= "12%" scope="col" class="rounded-end">Action</th>
          </tr>
        </thead>

        <?php
          while($row = mysqli_fetch_assoc($select))
          {

          
        ?>
        <tr class="align-middle font-weight-bold value-table">
            <th scope="row" class="text text-center "><?php echo $row['Product_Id'];?></th>
            <td class="text text-center imageProduct"><img src="../Image/<?php echo $row['Image_Url']; ?>" height="100" alt=""></td>
            <td class="text text-center text-nowrap "><?php echo $row['Product_Name'];?></td>
            <td class="text text-center "><?php echo $row['Price'];?></td>
            <td class="text text-center"><?php echo $row['Category_Name'];?></td>
            <td class="text text-center"><?php echo $row['Supplier_Name'];?></td>
            <td class="text text-center"><?php echo $row['Date_Added'];?></td>

            <td class="text-nowrap">
      

  <!-- Button trigger modal For Edit Modal -->
  <a href="#" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['Product_Id']; ?>" class="text-decoration-none text">
      <button class="btn btn-success btn-edit">
          <i class="bi bi-pencil-square"></i>Edit
      </button>
  </a>

  <!-- Edit Modal -->
  <div class="modal fade" id="editModal<?php echo $row['Product_Id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">

    <!-- Form for editing product data -->
    <form action="../config/crud.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="editId" value="<?php echo $row['Product_Id']; ?>">
        
    <!-- Input fields for editing product data -->
    <div class="mb-3">
        <label for="editProductName" class="form-label">Product Name</label>
        <input type="text" class="form-control" id="editProductName" name="editProductName" value="<?php echo $row['Product_Name']; ?>" >
    </div>
    <div class="mb-3">
        <label for="editPrice" class="form-label">Price (₱)</label>
        <input type="text" class="form-control" id="editPrice" name="editPrice" value="<?php echo $row['Price']; ?>">
    </div>
    <div class="mb-3">
    <label class="input-group-text" for="editSupplier">Supplier</label>
    <select class="form-select" id="editSupplier<?php echo $row['Product_Id']; ?>" name="editSupplier">
        <option value="">Choose Supplier...</option>
        <?php
        include('../config/connect.php');
        // Fetch existing product's supplier data
        $existingProductQuery = "SELECT Supplier_Id FROM Product WHERE Product_Id = ?";
        $stmtSupplier = mysqli_prepare($con, $existingProductQuery);
        mysqli_stmt_bind_param($stmtSupplier, 'i', $row['Product_Id']);
        mysqli_stmt_execute($stmtSupplier);
        mysqli_stmt_bind_result($stmtSupplier, $existingSupplierId);
        mysqli_stmt_fetch($stmtSupplier);
        mysqli_stmt_close($stmtSupplier);

        // Fetch all suppliers
        $query = "SELECT Supplier_Id, Supplier_Name FROM supplier";
        $result = mysqli_query($con, $query);
        while ($supplier_row = mysqli_fetch_assoc($result)) {
            $selected = ($supplier_row['Supplier_Id'] == $existingSupplierId) ? 'selected' : '';
            echo "<option value='" . $supplier_row['Supplier_Id'] . "' $selected>" . $supplier_row['Supplier_Name'] . "</option>";
        }
        ?>
    </select>
</div>
<div class="mb-3">
    <label class="input-group-text" for="editCategory">Category</label>
    <select class="form-select" id="editCategory<?php echo $row['Product_Id']; ?>" name="editCategory">
        <option value="">Choose Category...</option>

        <?php
        include '../config/config.php';
        // Fetch existing product's category data
        $existingProductQuery = "SELECT Category_Id FROM Product WHERE Product_Id = ?";
        $stmtCategory = mysqli_prepare($con, $existingProductQuery);
        mysqli_stmt_bind_param($stmtCategory, 'i', $row['Product_Id']);
        mysqli_stmt_execute($stmtCategory);
        mysqli_stmt_bind_result($stmtCategory, $existingCategoryId);
        mysqli_stmt_fetch($stmtCategory);
        mysqli_stmt_close($stmtCategory);

        // Fetch all categories
        $query = "SELECT Category_Id, Category_Name FROM category";
        $result = mysqli_query($con, $query);
        while ($category_row = mysqli_fetch_assoc($result)) {
            $selected = ($category_row['Category_Id'] == $existingCategoryId) ? 'selected' : '';
            echo "<option value='" . $category_row['Category_Id'] . "' $selected>" . $category_row['Category_Name'] . "</option>";
        }
        ?>
        
    </select>
</div>

          <div class="input-group mb-3">
              <label class="input-group-text">Image</label>
              <input type="file" class="form-control" name="image-update" accept=".jpg, .png, .svg">
          </div>
          <button type="submit" name="submitEdit" class="btn btn-primary mx-auto">Save Changes</button>
                  </form>
              </div>
          </div>
      </div>
  </div>

<?php
  require('../config/connect.php');

  // Delete Function
if (isset($_GET['delete'])) {
  $Id = intval($_GET['delete']); // Convert $Id to an integer

  echo "<script>
          if (confirm('Are you sure you want to delete this product?')) {
              window.location.href = './product.php?confirmDelete=$Id';
          } else {
              window.location.href = './product.php';
          }
        </script>";
  exit();
}

// Process deletion only if confirmDelete is set
if (isset($_GET['confirmDelete'])) {
  $Id = intval($_GET['confirmDelete']);
  $queryDel = "DELETE FROM `product` WHERE Product_Id = $Id";
  $result = mysqli_query($con, $queryDel);

  if ($result) {
      // Deletion was successful
      echo "<script>
              alert('Product deleted successfully!');
              window.location.href = './product.php';
            </script>";
      exit();
  } else {
      // Error in deletion
      echo "<script>
              alert('Error deleting product. Please try again later.');
              window.location.href = './product.php';
            </script>";
      exit();
  }
}
?>



    <a href="../page/product.php?delete=<?php echo $row['Product_Id']; ?>" onclick="return confirmDelete();">
        <button class="btn btn-danger"><i class="bi bi-trash3 btn-delete me-2"></i>Delete</button>
    </a>

    </td>
        </tr>

        <?php }; ?>
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
        $('#tableProduct').DataTable({
            columnDefs: [
                { orderable: false, searchable: false, targets: [1,7] }
            ]
        });;
     });
    </script>
    
  </body>
  </html>

  