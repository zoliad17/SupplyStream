 <?php

 include('./connect.php');

 #AddProduct in Table Product
 
 if (isset($_POST['addProduct'])) {
    $productName = $_POST['product_name'];
    $price = $_POST['price'];
    $categoryId = $_POST['category_id']; 
    $supplierId = $_POST['supplier_id']; // Retrieve supplier ID from form

    $productImage = $_FILES['image']['name'];
    $productImage_tmpName = $_FILES['image']['tmp_name'];
    $productImage_folder = '../Image/' . $productImage;

    // Get current date and time
    $dateAdded = date('Y-m-d');

    // Modify the query to include Supplier_Id
    $query = "INSERT INTO `Product` (`Product_Name`, `Price`, `Image_url`, `Category_Id`, `Supplier_Id`, `Date_Added`) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sdsiis', $productName, $price, $productImage, $categoryId, $supplierId, $dateAdded);
        
        $upload = mysqli_stmt_execute($stmt);

        if ($upload) {
            move_uploaded_file($productImage_tmpName, $productImage_folder);
            echo "<script>alert('Product Added Successfully'); window.location.href = '../page/product.php';</script>";
        } else {
            echo '<script>alert("Error executing statement")</script>';
        }
    } else {
        echo '<script>alert("Error preparing statement")</script>';
    }
}

#Update Product in Table Product
if (isset($_POST['submitEdit'])) {
    $editProduct = $_POST['editId'];

    // Retrieve existing product data
    $existingDataQuery = "SELECT Product_Name, Price, Category_Id, Supplier_Id, Image_url FROM Product WHERE Product_Id = ?";
    $stmtExistingData = mysqli_prepare($con, $existingDataQuery);
    mysqli_stmt_bind_param($stmtExistingData, 'i', $editProduct);
    mysqli_stmt_execute($stmtExistingData);
    mysqli_stmt_bind_result($stmtExistingData, $existingProductName, $existingPrice, $existingCategory, $existingSupplier, $existingImage);
    mysqli_stmt_fetch($stmtExistingData);
    mysqli_stmt_close($stmtExistingData);

    // Retrieve new input data
    $productName = $_POST['editProductName'];
    $price = $_POST['editPrice'];
    $supplier = isset($_POST['editSupplier']) ? intval($_POST['editSupplier']) : null;
    $category = isset($_POST['editCategory']) ? intval($_POST['editCategory']) : null;

    // Check if any input is changed
    $isChanged = ($productName !== $existingProductName) ||
                 ($price !== $existingPrice) ||
                 ($supplier !== $existingSupplier) ||
                 ($category !== $existingCategory);

    // Handle image update
    $productImage = isset($_FILES['image-update']) ? $_FILES['image-update'] : null;
    $productImage_folder = '../Image/';

    if ($productImage && $productImage['error'] === UPLOAD_ERR_OK) {
        $productImageName = $productImage['name'];
        $productImage_tmpName = $productImage['tmp_name'];
        $productImage_folder .= $productImageName;

        // Prepare the update query with image URL
        $updateQuery = "UPDATE Product SET Product_Name = ?, Price = ?, Image_url = ?, Category_Id = ?, Supplier_Id = ? WHERE Product_Id = ?";
        $stmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($stmt, 'sdsiii', $productName, $price, $productImageName, $category, $supplier, $editProduct);

        // Execute the update query
        $upload = mysqli_stmt_execute($stmt);

        if ($upload) {
            // Move the uploaded file to the desired location
            move_uploaded_file($productImage_tmpName, $productImage_folder);
            echo "<script>alert('Product Updated Successfully'); window.location.href = '../page/product.php';</script>";
            exit();
        } else {
            echo "<script>alert('Error updating product. Please try again later.'); window.location.href = '../page/product.php'; </script>";
            exit();
        }
    } else {
        // Prepare the update query without image URL
        $updateQuery = "UPDATE Product SET Product_Name = ?, Price = ?, Category_Id = ?, Supplier_Id = ? WHERE Product_Id = ?";
        $stmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($stmt, 'sdsii', $productName, $price, $category, $supplier, $editProduct);

        // Execute the update query
        $upload = mysqli_stmt_execute($stmt);

        if ($upload) {
            echo "<script>alert('Product Updated Successfully'); window.location.href = '../page/product.php'; </script>";
            exit();
        } else {
            echo "<script>alert('Error updating product. Please try again later.'); window.location.href = '../page/product.php'; </script>";
            exit();
        }
    }
    mysqli_close($con);
}


#Add Supplier in Table Supplier
if(isset($_POST['addSupplier'])) {
    $supplierName = $_POST['supplier_Name'];
    $supplierCategory = isset($_POST['editCategory']) ? $_POST['editCategory'] : null;

    if($supplierCategory === null) {
        echo "<script>alert('Please select a category.'); window.location.href = '../page/supplier.php';</script>";
        exit();
    }

    // Insert query
    $query = "INSERT INTO `supplier`(`Supplier_Name`, `Category_Id`) VALUES (?, ?)";
    $stmt = mysqli_prepare($con, $query);

    // Bind parameters and execute query
    mysqli_stmt_bind_param($stmt, 'si', $supplierName, $supplierCategory);
    $upload = mysqli_stmt_execute($stmt);

    if($upload) {
        echo "<script>alert('Supplier Added Successfully'); window.location.href = '../page/supplier.php';</script>";
    } else {
        echo "<script>alert('Error adding supplier. Please try again later.'); window.location.href = '../page/supplier.php';</script>";
    }
}

#Update Supplier in Table Supplier
if(isset($_POST['submitEditSupplier'])) {
    include('../config/connect.php');

    // Get form data and sanitize
    $editSupplier = mysqli_real_escape_string($con, $_POST['editSupplierId']);
    $supplierName = mysqli_real_escape_string($con, $_POST['editSupplierName']);
    $supplierCategory = mysqli_real_escape_string($con, $_POST['editSupplierCategory']);

    // Update query
    $updateQuery = "UPDATE supplier SET Supplier_Name = ?, Category_Id = ? WHERE Supplier_Id = ?";
    $stmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'ssi', $supplierName, $supplierCategory, $editSupplier);

    // Execute the update query
    $upload = mysqli_stmt_execute($stmt);

    if($upload) {
        // Update successful
        echo "<script>alert('Supplier Updated Successfully'); window.location.href = '../page/supplier.php';</script>";
    } else {
        // Update failed
        echo "<script>alert('Error updating supplier. Please try again later.'); window.location.href = '../page/supplier.php'; </script>";
    }
}

#addStock in Table Inventory

if (isset($_POST['submitAddStock'])) {
    $stockId = (int)$_POST['stockId']; 
    $addStock = (int)$_POST['addStock']; 
    // Retrieve current stock data
    $query = "SELECT Total_Stock FROM inventory WHERE Inventory_Id = $stockId";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $newTotalStock = $row['Total_Stock'] + $addStock;

        // Query to update the stock
        $updateQuery = "UPDATE inventory 
                        SET 
                            Last_Added_Stock = $addStock, 
                            Total_Stock = $newTotalStock 
                        WHERE Inventory_Id = $stockId";

        if (mysqli_query($con, $updateQuery)) {
            echo "<script>alert('Added Stock Successfully'); window.location.href = '../page/inventory.php';</script>";
            
        } else {
            echo "Error updating stock: " . mysqli_error($con);
        }
    } else {
        echo "Error retrieving stock data or no rows found.";
    }

    mysqli_close($con);
}

#Add Inventory to Table Inventory
if (isset($_POST['submitAddInventory'])) {

    // Retrieve and sanitize input data
    $productId = isset($_POST['addProductId']) ? intval($_POST['addProductId']) : null;
    $lastAddedStock = isset($_POST['addLastAddedStock']) ? intval($_POST['addLastAddedStock']) : null;

    // Check if all required fields are provided
    if ($productId !== null && $lastAddedStock !== null) {
        // Retrieve Supplier_Id and Category_Id from the Product table
        $productQuery = mysqli_prepare($con, "SELECT Supplier_Id, Category_Id FROM product WHERE Product_Id = ?");
        mysqli_stmt_bind_param($productQuery, 'i', $productId);
        mysqli_stmt_execute($productQuery);
        mysqli_stmt_bind_result($productQuery, $supplierId, $categoryId);
        mysqli_stmt_fetch($productQuery);
        mysqli_stmt_close($productQuery);

        // Prepare the SQL query to insert into the inventory table
        $insertInventoryQuery = "INSERT INTO inventory (Product_Id, Category_Id, Supplier_Id, Last_Added_Stock, Total_Stock) VALUES (?, ?, ?, ?, ?)";
        $stmtInsert = mysqli_prepare($con, $insertInventoryQuery);

        // Initialize Total_Stock to be equal to Last_Added_Stock
        $totalStock = $lastAddedStock;

        // Bind parameters
        mysqli_stmt_bind_param($stmtInsert, 'iiiii', $productId, $categoryId, $supplierId, $lastAddedStock, $totalStock);

        // Execute the query
        $insertInventory = mysqli_stmt_execute($stmtInsert);

        // Check if the insertion was successful
        if ($insertInventory) {
            echo "<script>alert('Inventory added successfully.'); window.location.href = '../page/inventory.php';</script>";
        } else {
            // Error handling
            echo "<script>alert('Error adding inventory. Please try again later.');</script>";
        }

        // Close the prepared statement
        mysqli_stmt_close($stmtInsert);
    } else {
        // Error handling for missing or invalid input data
        echo "<script>alert('Please provide all required information.');</script>";
    }

    // Close the database connection
    mysqli_close($con);
}





#Update Inventory in Table Inventory
if (isset($_POST['submitEditInventory'])) {
    // Retrieve form data
    $inventoryId = $_POST['editId'];
    $productName = $_POST['editProductName'];
    $categoryId = $_POST['editCategory'];
    $supplierId = $_POST['editSupplier'];
    $lastAddedStock = $_POST['editLastAddedStock'];
    $totalStock = $_POST['editTotalStock'];

    // Prepare the SQL update query
    $sql = "UPDATE inventory 
            INNER JOIN product ON inventory.Product_Id = product.Product_Id
            SET product.Product_Name = ?, product.Category_Id = ?, inventory.Supplier_Id = ?, inventory.Last_Added_Stock = ?, inventory.Total_Stock = ? 
            WHERE inventory.Inventory_Id = ?";
    $stmt = mysqli_prepare($con, $sql);
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, 'siidii', $productName, $categoryId, $supplierId, $lastAddedStock, $totalStock, $inventoryId);
    
    // Execute the query
    $result = mysqli_stmt_execute($stmt);

    // Check if the update was successful
    if ($result) {
        echo "<script>alert('Inventory Updated Successfully.'); window.location.href = '../page/inventory.php';</script>";
    } else {
        echo "<script>alert('Error updating inventory. Please try again later.');</script>";
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
}




#add Category in Table Category

//Approve
if(isset($_POST['addCategory'])) {
    $categoryName = $_POST['category_Name'];

    // Insert query
    $query = "INSERT INTO `category`(`Category_Name`) VALUES (?)";
    $stmt = mysqli_prepare($con, $query);

    // Bind parameters and execute query
    mysqli_stmt_bind_param($stmt, 's', $categoryName);
    $upload = mysqli_stmt_execute($stmt);

    if($upload) {
        // Category added successfully
        echo "<script>alert('Category Added Successfully'); window.location.href = '../page/category.php';</script>";
    } else {
        // Error adding category
        echo "<script>alert('Error adding category. Please try again later.'); window.location.href = '../page/category.php';</script>";
    }
}


//update Category name in Table Category

if(isset($_POST['submitEditCategory'])) {


    // Get form data and sanitize
    $editCategory = mysqli_real_escape_string($con, $_POST['editCategoryId']);
    $categoryName = mysqli_real_escape_string($con, $_POST['editCategoryName']);

    // Update query
    $updateQuery = "UPDATE category SET Category_Name = ? WHERE Category_Id = ?";
    $stmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'si', $categoryName, $editCategory);

    // Execute the update query
    $upload = mysqli_stmt_execute($stmt);

    if($upload) {
        // Category updated successfully
        echo "<script>alert('Category Updated Successfully'); window.location.href = '../page/category.php';</script>";
    } else {
        // Error updating category
        echo "<script>alert('Error updating category. Please try again later.'); window.location.href = '../page/category.php';</script>";
    }
}







#UPDATE
/*$editProduct = $_GET['edit'];
if(isset($_POST['submitEdit'])) {
  $productName = $_POST['name'];
  $price = $_POST['price'];
  $category = $_POST['category'];
  
  // File upload handling
  $productImage = $_FILES['image']['name'];
  $productImage_tmpName = $_FILES['image']['tmp_name'];
  $productImage_folder = '../Image/'.$productImage;

  // Prepare the SQL statement using a prepared statement
  $updateQuery = "UPDATE SET `product` Product_Name= '$productName', Price = '$price', Image_url = '$productImage' Category = '$category' 
  WHERE Id = $editProduct";
  $stmt = mysqli_prepare($con, $updateQuery);

  // Bind parameters and execute the statement
  mysqli_stmt_bind_param($stmt, 'ssss', $productName, $price, $productImage, $category);
  $upload = mysqli_stmt_execute($stmt);

  if($upload) {
      // Move the uploaded file to the desired location
      move_uploaded_file($productImage_tmpName, $productImage_folder);
      echo "<script>alert('Product Updated Successfully'); window.location.href = '../page/product.php';</script>";

  } else {
      echo '<script>alert("Error")</script>';
  }
}*/

/*
if(isset($_POST['submitEdit'])) {
    // Retrieve form data
    $editId = $_POST['editId'];
    $editProductName = $_POST['editProductName'];
    $editPrice = $_POST['editPrice'];
    $editCategory = $_POST['editCategory'];
    
    // Check if a new image is uploaded
    if(!empty($_FILES['image-update']['name'])) {
        // New image uploaded, handle file upload
        $productImage = $_FILES['image-update']['name'];
        $productImage_tmpName = $_FILES['image-update']['tmp_name'];
        $productImage_folder = '../Image/'.$productImage;
    } else {
        // No new image uploaded, keep the existing image
        $productImage = ''; // Assuming you have a variable to store the existing image path
    }
    
    // Prepare the SQL statement using a prepared statement
    if(!empty($productImage)) {
        // Update image and other fields
        $query = "UPDATE `product` SET `Product_Name`=?, `Price`=?, `Image_url`=?, `Category`=? WHERE `Id`=?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'ssssi', $editProductName, $editPrice, $productImage, $editCategory, $editId);
    } else {
        // Update only other fields, keep existing image
        $query = "UPDATE `product` SET `Product_Name`=?, `Price`=?, `Category`=? WHERE `Id`=?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'sssi', $editProductName, $editPrice, $editCategory, $editId);
    }
    
    // Execute the statement
    $upload = mysqli_stmt_execute($stmt);
    
    if($upload) {
        // If a new image is uploaded, move the uploaded file to the desired location
        if(!empty($productImage)) {
            move_uploaded_file($productImage_tmpName, $productImage_folder);
        }
        echo "<script>alert('Product Updated Successfully'); window.location.href = '../page/product.php';</script>";
    } else {
        echo '<script>alert("Error")</script>';
    }
}  */



?>

