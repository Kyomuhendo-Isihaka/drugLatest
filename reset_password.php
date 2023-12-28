<?php
session_start();

include_once "config.php";
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$connection) {
    echo mysqli_error($connection);
    throw new Exception("Database cannot Connect");
}
$action = $_REQUEST['action'] ?? '';

if ('reset_pass' == $action) {
    $email = $_REQUEST['email'] ?? '';
    $new_pass = $_REQUEST['new_pass'] ?? '';
    $conf_pass = $_REQUEST['conf_pass'] ?? '';
    $role = $_REQUEST['role'] ?? '';

    if ($role && $email && $new_pass && $conf_pass) {
        $query = "SELECT * FROM {$role} WHERE email='{$email}'";
        $result = mysqli_query($connection, $query);
        if ($data = mysqli_fetch_assoc($result)) {
            $_email = $data['email'] ?? '';
            $_id = $data['id'] ?? '';
           
            if($new_pass==$conf_pass){
                $h_pass = password_hash($new_pass, PASSWORD_BCRYPT);
                $connection->query("UPDATE {$role} SET password='$h_pass' WHERE id='$_id'");
                header("location:login.php");
            }else {
            
                header("location:reset_password.php?error1");
            }
        } else {
            
            header("location:reset_password.php?error");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
    <div class="main">
        <div class="main__form">
            <div class="main__form--title text-center">Reset Password</div>

            <form  method="GET">
                <div class="form_row">
                    <div class="col col-12">
                        <label class="input">
                            <i id="left" class="fas fa-male left"></i>
                            <select name="role" id="Role">
                                <option value="">Select Role</option>
                                <option value="admins">Medical Supretendant</option>
                                <option value="pharmacists">Pharmacist</option>
                                <option value="salesmans">OtherUser</option>
                            </select>
                        </label>
                    </div>
                    <div class="col col-12">
                        <label class="input">
                            <i id="left" class="fas fa-envelope left"></i>
                            <input type="text" name="email" placeholder="Email" required>
                        </label>
                    </div>

                    <div class="col col-12">
                        <label class="input">
                            <i id="left" class="fas fa-key"></i>
                            <input id="pwdinput" type="password" name="new_pass" placeholder="New Password" required>
                            <i id="pwd" class="fas fa-eye right"></i>
                        </label>
                    </div>

                    <div class="col col-12">
                        <label class="input">
                            <i id="left" class="fas fa-key"></i>
                            <input type="password" name="conf_pass" placeholder="Confirm Password" required>
                        </label>
                    </div>
                    <input type="hidden" name="action" value="reset_pass">
                    <?php if ( isset( $_GET['error'] ) ) {
                                    echo "<h5 class='text-center' style='color:red;'>Email doesn't Exist</h5>";
                            }?>
                             <?php if ( isset( $_GET['error1'] ) ) {
                                    echo "<h5 class='text-center' style='color:red;'>Passwords don't match</h5>";
                            }?>
                    <div class="col col-12">
                        <input type="submit" value="Reset">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <script src="assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Custom Js -->
    <script src="./assets/js/app.js"></script>
</body>

</html>