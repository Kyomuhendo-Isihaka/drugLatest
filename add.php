<?php
session_start();
include_once "config.php";
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$connection) {
    echo mysqli_error($connection);
    throw new Exception("Database cannot Connect");
} else {
    $action = $_REQUEST['action'] ?? '';


    if ('addManager' == $action) {
        $fname = $_REQUEST['fname'] ?? '';
        $lname = $_REQUEST['lname'] ?? '';
        $email = $_REQUEST['email'] ?? '';
        $phone = $_REQUEST['phone'] ?? '';
        $password = $_REQUEST['password'] ?? '';

        if ($fname && $lname && $lname && $phone && $password) {
            $hashPassword = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO managers(fname,lname,email,phone,password) VALUES ('{$fname}','$lname','$email','$phone','$hashPassword')";
            mysqli_query($connection, $query);
            header("location:index.php?id=allManager");
        }

    } elseif ('updateManager' == $action) {
        $id = $_REQUEST['id'] ?? '';
        $fname = $_REQUEST['fname'] ?? '';
        $lname = $_REQUEST['lname'] ?? '';
        $email = $_REQUEST['email'] ?? '';
        $phone = $_REQUEST['phone'] ?? '';

        if ($fname && $lname && $lname && $phone) {
            $query = "UPDATE managers SET fname='{$fname}', lname='{$lname}', email='$email', phone='$phone' WHERE id='{$id}'";
            mysqli_query($connection, $query);
            header("location:index.php?id=allManager");
        }

    } elseif ('addPharmacist' == $action) {
        $fname = $_REQUEST['fname'] ?? '';
        $lname = $_REQUEST['lname'] ?? '';
        $email = $_REQUEST['email'] ?? '';
        $phone = $_REQUEST['phone'] ?? '';
        $password = $_REQUEST['password'] ?? '';

        if ($fname && $lname && $lname && $phone && $password) {
            $hashPassword = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO pharmacists(fname,lname,email,phone,password) VALUES ('{$fname}','$lname','$email','$phone','$hashPassword')";
            mysqli_query($connection, $query);
            header("location:index.php?id=allPharmacist");
        }
    } elseif ('updatePharmacist' == $action) {
        $id = $_REQUEST['id'] ?? '';
        $fname = $_REQUEST['fname'] ?? '';
        $lname = $_REQUEST['lname'] ?? '';
        $email = $_REQUEST['email'] ?? '';
        $phone = $_REQUEST['phone'] ?? '';


        if ($fname && $lname && $lname && $phone) {
            $query = "UPDATE pharmacists SET fname='{$fname}', lname='{$lname}', email='$email', phone='$phone' WHERE id='{$id}'";
            mysqli_query($connection, $query);
            header("location:index.php?id=allPharmacist");
        }
    } elseif ('addDrug' == $action) {
        $b_num = $_REQUEST['batch_num'] ?? '';
        $d_name = $_REQUEST['d_name'] ?? '';
        $d_price = $_REQUEST['d_price']?? '';
        $d_description = $_REQUEST['d_desc'] ?? '';
        $d_quantity = $_REQUEST['d_quantity'];
        $mnf_date = $_REQUEST['mnf_date'] ?? '';
        $exp_date = $_REQUEST['exp_date'] ?? '';
       
        $status = '1';
        $currentDate = date('Y-m-d');

        $thresholdDate = date('Y-m-d', strtotime('+2 months'));
        if ($exp_date <= $thresholdDate) {
            $status = '0';
        }
        if ($exp_date < $currentDate || $exp_date==$currentDate) {
            $status = '-1';
        }
        

        if ($b_num && $d_name && $d_description && $d_quantity && $mnf_date && $exp_date) {
            $query = "INSERT INTO drugs(batch_num,drug_name,drug_description,drug_price,drug_quantity,manufacturing_date,expiry_date,status) VALUES('$b_num','$d_name','$d_description',$d_price,$d_quantity,'$mnf_date','$exp_date','$status')";
            mysqli_query($connection, $query);
            header("location:index.php?id=allDrug");
        }
    } elseif ('updateDrug' == $action) {
        $id = $_REQUEST['id'] ?? '';
        $d_name = $_REQUEST['d_name'] ?? '';
        $d_description = $_REQUEST['d_desc'] ?? '';
        $d_price=$_REQUEST['d_price']?? '';
        $d_quantity=$_REQUEST['d_quantity']??'';
        $mnf_date = $_REQUEST['mnf_date'] ?? '';
        $exp_date = $_REQUEST['exp_date'] ?? '';

        $status = '1';
        $currentDate = date('Y-m-d');

        $thresholdDate = date('Y-m-d', strtotime('+2 months'));
        if ($exp_date <= $thresholdDate) {
            $status = '0';
            if($exp_date < $currentDate){
                $status = '-1';
            }elseif($exp_date==$currentDate){
                $status = '-1';
            }
        
        }
       
        if ($d_name && $d_description && $mnf_date && $exp_date) {
            $query = "UPDATE drugs SET drug_name='{$d_name}', drug_description='{$d_description}', drug_price='{$d_price}', drug_quantity='{$d_quantity}', manufacturing_date='{$mnf_date}', expiry_date='{$exp_date}', status='$status' WHERE id='{$id}'";
            mysqli_query($connection, $query);
            header("location:index.php?id=allDrug");

        }

    } elseif ('addSalesman' == $action) {
        $fname = $_REQUEST['fname'] ?? '';
        $lname = $_REQUEST['lname'] ?? '';
        $title = $_REQUEST['title'] ?? '';
        $email = $_REQUEST['email'] ?? '';
        $phone = $_REQUEST['phone'] ?? '';
        $password = $_REQUEST['password'] ?? '';

        if ($fname && $lname && $lname && $phone && $password) {
            $hashPassword = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO salesmans(fname,lname,email,phone,password,title) VALUES ('{$fname}','$lname','$email','$phone','$hashPassword','$title')";
            mysqli_query($connection, $query);
            header("location:index.php?id=allSalesman");
        }
    } elseif ('updateSalesman' == $action) {
        $id = $_REQUEST['id'] ?? '';
        $fname = $_REQUEST['fname'] ?? '';
        $lname = $_REQUEST['lname'] ?? '';
        $email = $_REQUEST['email'] ?? '';
        $phone = $_REQUEST['phone'] ?? '';

        if ($fname && $lname && $lname && $phone) {
            $query = "UPDATE salesmans SET fname='{$fname}', lname='{$lname}', email='$email', phone='$phone' WHERE id='{$id}'";
            mysqli_query($connection, $query);
            header("location:index.php?id=allSalesman");
        }
    } elseif ('updateProfile' == $action) {

        $fname = $_REQUEST['fname'] ?? '';
        $lname = $_REQUEST['lname'] ?? '';
        $email = $_REQUEST['email'] ?? '';
        $phone = $_REQUEST['phone'] ?? '';
        $oldPassword = $_REQUEST['oldPassword'] ?? '';
        $newPassword = $_REQUEST['newPassword'] ?? '';
        $sessionId = $_SESSION['id'] ?? '';
        $sessionRole = $_SESSION['role'] ?? '';
        $avatar = $_FILES['avatar']['name'] ?? "";

        if ($fname && $lname && $email && $phone && $oldPassword && $newPassword) {
            $query = "SELECT password,avatar FROM {$sessionRole}s WHERE id='$sessionId'";
            $result = mysqli_query($connection, $query);

            if ($data = mysqli_fetch_assoc($result)) {
                $_password = $data['password'];
                $_avatar = $data['avatar'];
                $avatarName = '';
                if ($_FILES['avatar']['name'] !== "") {
                    $allowType = array(
                        'image/png',
                        'image/jpg',
                        'image/jpeg'
                    );
                    if (in_array($_FILES['avatar']['type'], $allowType) !== false) {
                        $avatarName = $_FILES['avatar']['name'];
                        $avatarTmpName = $_FILES['avatar']['tmp_name'];
                        move_uploaded_file($avatarTmpName, "assets/img/$avatar");
                    } else {
                        header("location:index.php?id=userProfileEdit&avatarError");
                        return;
                    }
                } else {
                    $avatarName = $_avatar;
                }
                if (password_verify($oldPassword, $_password)) {
                    $hashPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                    $updateQuery = "UPDATE {$sessionRole}s SET fname='{$fname}', lname='{$lname}', email='{$email}', phone='{$phone}', password='{$hashPassword}', avatar='{$avatarName}' WHERE id='{$sessionId}'";
                    mysqli_query($connection, $updateQuery);

                    header("location:index.php?id=userProfile");
                }

            }

        } else {
            echo mysqli_error($connection);
        }

    }elseif('sellDrug'==$action){
        $salemanId = $_REQUEST['salesmanId']??'';
        $drugId = $_REQUEST['drugId']??'';
        $qty = $_REQUEST['quantity']?? '';
        $d_qty=$_REQUEST['qty']??'';
        $totalPrice=$_REQUEST['total-price']??'';

        $newQty = intval($d_qty) - intval($qty);
       
        if($salemanId && $drugId && $qty && $totalPrice){
            $query = "INSERT INTO sale(salesman_id, drug_id, quantity_sold, total_price) VALUES('$salemanId', '$drugId','$qty', '$totalPrice')";
            $result = mysqli_query($connection, $query);
            if($result){
                $sql="UPDATE drugs SET drug_quantity='{$newQty}' WHERE id='{$drugId}'";
                mysqli_query($connection, $sql);
                header("Location:index.php?id=sales");
           
            }
        }
    }
}