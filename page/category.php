
<!doctype html>
<html lang="en">
  <head>
    <title>Category</title>
    
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
 
  </head>
  <body>

  <!-- Sidebar -->
  <nav>
    
  <div class="logo container">
    <i class="bx bx-menu menu-icon"></i>
    <span class="logo-name">Supply Stream</span>      
  </div>

     <!-- Button trigger modal for Add Category -->
     <div class="container d-flex flex-row-reverse align-items-center">
        <button type="button" class="btn-add btn btn-success" data-bs-toggle="modal" data-bs-target="#addCategory">
            <i class="bi bi-plus-lg"></i>Add Category
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
    <h1 class="titleCategory text-center">CATEGORY</h1>
  </div>
 
    <?php
      require('../config/connect.php');
      $select = mysqli_query($con,
      "SELECT 
        c.Category_Name, 
        c.Category_Id
      FROM 
          category c;")
  
    ?>


<!-- Add Category Modal -->
<div class="modal fade" id="addCategory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addCategoryLabel">Add Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../config/crud.php" method="POST" enctype="multipart/form-data">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Name</span>
                        <input type="text" class="form-control" name="category_Name" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary me-3" name="addCategory">Add</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>



  <div class="container container-table"> 
    <table id="tableCategory" class="table-category table table-hover" >
      <thead class="table-dark text-light">
          <tr class="text-center">
            <th width= "10%" scope="col">Category ID</th>
            <th width= "10%" scope="col">Category Name</th>
            <th width= "10%" scope="col" class="rounded-end">Action</th>
          </tr>
        </thead>
        <?php
          while($row = mysqli_fetch_assoc($select))
          {
          
        ?>
        <tr class="align-middle">
            <th scope="row"><?php echo $row['Category_Id'];?></th>
            <td><?php echo $row['Category_Name'];?></td>
            <td>
            <div class="d-grid gap-2 d-md-flex justify-content-center">

            <!-- Button trigger modal Edit -->
            <a href="#" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['Category_Id']; ?>" class="text-decoration-none text">
                <button class="btn btn-success me-3 btn-edit">
                    <i class="bi bi-pencil-square"></i>Edit
                </button>
            </a>

            <?php
require('../config/connect.php');

// Delete category
if(isset($_GET['delete'])){
    $Id = intval($_GET['delete']); // Convert $Id to an integer
    
    echo "<script>";
    echo "if (confirm('Are you sure you want to delete this category?')) {";
    echo "  window.location.href = './category.php?confirmDelete=$Id';";
    echo "} else {";
    echo "  window.location.href = './category.php';";
    echo "}";
    echo "</script>";
}

// Process deletion only if confirmDelete is set
if(isset($_GET['confirmDelete'])){
    $Id = intval($_GET['confirmDelete']);
    $queryDel = "DELETE FROM `category` WHERE Category_Id = $Id";
    $result = mysqli_query($con, $queryDel);

    if ($result) {
        // Deletion was successful
        echo "<script>
                alert('Category deleted successfully!');
                window.location.href = './category.php';
              </script>";
        exit();
    } else {
        // Error in deletion
        echo "<script>
                alert('Error deleting category. Please try again later.');
                window.location.href = './category.php';
              </script>";
        exit();
    }
}
?>


    <a href="../page/category.php?delete=<?php echo $row['Category_Id']; ?>" onclick="return confirmDelete();">
        <button class="btn btn-danger"><i class="bi bi-trash3 btn-delete me-2"></i>Delete</button>
    </a>

            
<!-- Edit Modal Category --> 
        
<div class="modal fade" id="editModal<?php echo $row['Category_Id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../config/crud.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="editCategoryId" value="<?php echo $row['Category_Id']; ?>">
                    <div class="mb-3">
                        <label for="editCategoryName" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="editCategoryName" name="editCategoryName" value="<?php echo $row['Category_Name']; ?>" required>
                    </div>
                    <button type="submit" name="submitEditCategory" class="btn btn-primary">Save Changes</button>
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



  </body>
</html>
