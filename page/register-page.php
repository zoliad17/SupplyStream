<!doctype html>
<html lang="en">
  <head>
    <title>REGISTER</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="icon" href="./assets/logo/favicon.ico">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/Css/stylesheet.css">

    <style>
         .loginBody {
            background-image: linear-gradient(120deg, #a1c4fd 0%, #c2e9fb 100%);
        }

        .card
        {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
    </style>
  </head>

  <body class="loginBody ">
    <div class="loginRegisterTitle">
    
    </div>
  
    <div class="container container-loginRegister">
        <div class="row justify-content-center align-items-center h-100">
            <div class="card w-50">
                <div class="card-header text-center text-dark">
                    <h2>SIGN UP</h2>
                </div>
                <div class="card-body">
                    <form action="../config/loginRegister.php" method="post">
                        <div class="form-group mb-3">
                            <div class="form-floating mb-3">
                                <input type="text" name="userName" class="form-control" id="floatingInputUsername" placeholder="Username" required>
                                <label for="floatingInputUsername"></label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control" id="floatingInputEmail" placeholder="Email" required>
                                <label for="floatingInputEmail"></label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="passWord" class="form-control" id="floatingInputPassword" placeholder="Password" required>
                                <label for="floatingInputPassword"></label>
                            </div>
                            
                        </div>
                        
                        <input type="submit" class="btn btn-success btn-block mb-3" value="Register" name="submit_register"> 
                        <p class="text-center">Already have an account? <a href="../page/login-page.php">Sign In</a></p>
                    </form>
                </div>
                <div class="card-footer text-muted text-right">
                    <small>&copy; BSIT 2-A Group III Supply Management System</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4xF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
