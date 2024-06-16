<?php
// Include database connection file
include '../config/connect.php';

session_start(); // Start the session

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['submit_login'])) {
        // Handle login
        $userName = trim($_POST['userName']);
        $password = trim($_POST['passWord']);

        // Check if the database connection is established
        if ($con) {
            // Check if username or password fields are empty
            if (empty($userName) || empty($password)) {
                echo "<script>alert('Please fill in all fields');</script>";
                echo "<script>window.location.href = '../page/login-page.php';</script>";
                exit();
            }

            // Prepare the SQL statement to prevent SQL injection
            $stmt = $con->prepare("SELECT Id, Password FROM users WHERE Username = ?");
            $stmt->bind_param("s", $userName);

            if ($stmt->execute()) {
                // Store the result
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($userId, $hashedPassword);
                    $stmt->fetch();

                    if (password_verify($password, $hashedPassword)) {
                        // Login successful
                        $_SESSION['user_id'] = $userId; 
                        $_SESSION['username'] = $userName;
                        echo "<script>alert('Log in Successfully'); window.location.href = '../page/dashboard.php';</script>";
                        exit();
                    } else {
                        // Invalid password
                        echo "<script>alert('Invalid username or password.'); window.location.href = '../page/login-page.php';</script>";
                        exit();
                    }
                } else {
                    // Invalid username
                    echo "<script>alert('Invalid username or password.'); window.location.href = '../page/login-page.php';</script>";
                    exit();
                }
            } else {
                // Error in query execution
                echo "Error: " . $stmt->error;
            }

            // Close the statement and the database connection
            $stmt->close();
            mysqli_close($con);
        } else {
            // Database connection failed
            echo "Failed to connect to the database.";
        }
    } elseif (isset($_POST['submit_register'])) {
        // Handle registration
        $userName = trim($_POST['userName']);
        $password = trim($_POST['passWord']);
        $email = trim($_POST['email']);

        // Check if the database connection is established
        if ($con) {
            // Check if any field is empty
            if (empty($userName) || empty($password) || empty($email)) {
                echo "<script>alert('Please fill in all fields');</script>";
                echo "<script>window.location.href = '../page/register-page.php';</script>";
                exit();
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Validate email format
                echo "<script>alert('Invalid email format');</script>";
                echo "<script>window.location.href = '../page/register-page.php';</script>";
                exit();
            } else {
                // Hash the password
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Prepare an SQL statement to prevent SQL injection
                $stmt = $con->prepare("INSERT INTO users (Username, `Email Address`, Password) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $userName, $email, $hashedPassword);

                // Execute the statement and check if it was successful
                if ($stmt->execute()) {
                    echo "<script>alert('Registered Successfully'); window.location.href = '../page/login-page.php';</script>";
                } else {
                    echo "Error: " . $stmt->error;
                }

                // Close the statement
                $stmt->close();
            }

            // Close the database connection
            mysqli_close($con);
        } else {
            // Database connection failed
            echo "Failed to connect to the database.";
        }
    }
}
?>

