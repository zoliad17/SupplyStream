
<!doctype html>
<html lang="en">
  <head>
    <title>Supplier</title>
    
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
    <button type="button" class="btn-add btn btn-success" data-bs-toggle="modal" data-bs-target="#addSupplier">
      <i class="bi bi-plus-lg"></i>Add Supplier
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
  <h1 class="titleSuppliers text-center">SUPPLIERS</h1>
  </div>
 
    <?php
      require('../config/connect.php');
      $select = mysqli_query($con,
      "SELECT 
        s.Supplier_Id,
        s.Supplier_Name, 
        c.Category_Name, 
        c.Category_Id
      FROM 
          Supplier s
      JOIN 
          Category c 
      ON 
          s.Category_Id = c.Category_Id;")
  
    ?>


<!-- Add Supplier Modal -->
<div class="modal fade" id="addSupplier" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addSupplierLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addSupplierLabel">Add Supplier</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../config/crud.php" method="POST" enctype="multipart/form-data">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Name</span>
                        <input type="text" class="form-control" name="supplier_Name" required>
                    </div>
                    <div class="mb-3">
                      <label class="input-group-text" for="editCategory">Category</label>
                      <select class="form-select" id="editCategory<?php echo $row['Product_Id']; ?>" name="editCategory" required >
                          <option value="">Choose Cateogry...</option>
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
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary me-3" name="addSupplier">Add</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>



  <div class="container "> 
    <table id="tableSupplier" class="table-supplier table table-hover" >
      <thead class="table-dark text-light">
          <tr class="text-center">
            <th width= "10%" scope="col">Supplier ID</th>
            <th width= "10%" scope="col">Supplier Name</th>
            <th width= "10%" scope="col">Category</th>
            <th width= "10%" scope="col" class="rounded-end">Action</th>
          </tr>
        </thead>
        <?php
          while($row = mysqli_fetch_assoc($select))
          {
          
        ?>
        <tr class="align-middle">
            <th scope="row"><?php echo $row['Supplier_Id'];?></th>
            <td><?php echo $row['Supplier_Name'];?></td>
            <td><?php echo $row['Category_Name'];?></td>
            <td>
            <div class="d-grid gap-2 d-md-flex justify-content-center">

            <!-- Button trigger modal Edit -->
            <a href="#" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['Supplier_Id']; ?>" class="text-decoration-none text">
                <button class="btn btn-success me-3 btn-edit">
                    <i class="bi bi-pencil-square"></i>Edit
                </button>
            </a>

            <?php
// Delete function
if(isset($_GET['delete'])){
    $Supplier_id = $_GET['delete'];
    
    echo "<script>";
    echo "if (confirm('Are you sure you want to delete this supplier?')) {";
    echo "  window.location.href = './supplier.php?confirmDelete=$Supplier_id';";
    echo "} else {";
    echo "  window.location.href = './supplier.php';";
    echo "}";
    echo "</script>";
}

// Process deletion only if confirmDelete is set
if(isset($_GET['confirmDelete'])){
    $Supplier_id = $_GET['confirmDelete'];
    $queryDel = "DELETE FROM `supplier` WHERE Supplier_id = $Supplier_id";
    $result = mysqli_query($con, $queryDel);

    if ($result) {
        echo "<script>
                alert('Supplier deleted successfully!');
                window.location.href = './supplier.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Error deleting supplier. Please try again later.');
                window.location.href = './supplier.php';
              </script>";
        exit();
    }
}
?>

          <a href="../page/supplier.php?delete=<?php echo $row['Supplier_Id']; ?>" onclick="return confirmDelete();">
              <button class="btn btn-danger"><i class="bi bi-trash3 btn-delete me-2"></i>Delete</button>
          </a>
            
<!-- Edit Modal Supplier --> 
        
<div class="modal fade" id="editModal<?php echo $row['Supplier_Id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Supplier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../config/crud.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="editSupplierId" value="<?php echo $row['Supplier_Id']; ?>">
                    <div class="mb-3">
                        <label for="editSupplierName" class="form-label">Supplier Name</label>
                        <input type="text" class="form-control" id="editSupplierName" name="editSupplierName" value="<?php echo $row['Supplier_Name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="input-group-text" for="editCategory">Category</label>
                        <select class="form-select" id="editCategory" name="editSupplierCategory">
                            <option value="">Choose...</option>
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
                    <button type="submit" name="submitEditSupplier" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
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
        $('#tableSupplier').DataTable({
            columnDefs: [
                { orderable: false, searchable: false, targets: 3 }
            ]
        });;
     });
    </script>
 
    
  </body>
</html>