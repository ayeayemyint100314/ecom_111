<?php
require_once "dbconnect.php";
if(!isset($_SESSION))
{
    session_start();
}

    if(isset($_POST['btnLogin']))  // login request
    {
        $email = $_POST['email']; // it is name attribute value of form control
        $password = $_POST['password']; // plain text
        $sql = "select * from admin where email=?";
        $stmt = $conn->prepare($sql); // prevent SQL injection attack
        $stmt->execute([$email]);
        $adminInfo = $stmt->fetch();
        //$errMsg = "";
        if($adminInfo) // email exists
        {   
            $hashcode = $adminInfo['password'];       
            if(password_verify($password, $hashcode )) // plain text, hashcode
            {  $_SESSION['email']= $email; 
                header("Location:viewInfo.php");                   
            }
            else{ // correct email and incorrect password
                    $errMsg = "Incorrect password!";
                }
        }// if end
        else{ // email does not exist.
                $errMsg = "Email does not exist.";
        }
       

    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>

</head>

<body style="height:100%" class="bg-light">

    <div class="container-fluid">
        <div class="row">
            <?php
            require_once "navigation.php";
            ?>

        </div>
        <div class="row ">
            <div class="col-md-4 mx-auto">
                <form action="login.php" class="form mt-3 border border-2 rounded px-2 py-2" method="post">
                    <fieldset>
                        <legend>Admin Login</legend>
                        <?php
                        if(isset($errMsg))
                        {
                            echo "<p class='alert alert-danger'>$errMsg</p>";
                            //unset($errMsg);
                            $errMsg = null;
                        }
                        ?>

                        <div class="mb-3">
                            <label for="" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary mt-2" name="btnLogin">Login</button>


                    </fieldset>
                </form>



            </div>

        </div>


    </div>

</body>

</html>