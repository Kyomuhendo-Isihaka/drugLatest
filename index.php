<?php
session_start();
$sessionId = $_SESSION['id'] ?? '';
$sessionRole = $_SESSION['role'] ?? '';
echo "$sessionId $sessionRole";
if (!$sessionId && !$sessionRole) {
    header("location:login.php");
    die();
}

ob_start();

include_once "config.php";
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (!$connection) {
    echo mysqli_error($connection);
    throw new Exception("Database cannot Connect");
}

$id = $_REQUEST['id'] ?? 'dashboard';
$action = $_REQUEST['action'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=1024">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>DMS||DashBoard</title>
</head>

<body">
    <!--------------------------------- Secondary Navber -------------------------------->
    <section class="topber">
        <div class="topber__title">
            <span class="topber__title--text">
                <?php
                if ('dashboard' == $id) {
                    echo "DashBoard";
                }elseif ('statistics' == $id) {
                    echo "Statistics";
                }elseif ('reports' == $id) {
                    echo "Reports";
                }  elseif ('addPharmacist' == $id) {
                    echo "Add Pharmacist";
                } elseif ('allPharmacist' == $id) {
                    echo "Pharmacists";
                } elseif ('sellDrug' == $action) {
                    echo "Sell Drug";
                }elseif ('addDrug' == $id) {
                    echo "Add Drug";
                } elseif ('allDrug' == $id) {
                    echo "Drugs";
                } elseif ('expiredDrug' == $id) {
                    echo "Expired Drugs";
                } elseif ('addSalesman' == $id) {
                    echo "Add OtherUser";
                } elseif ('allSalesman' == $id) {
                    echo "Otherusers";
                } elseif ('userProfile' == $id) {
                    echo "Your Profile";
                } elseif ('editPharmacist' == $action) {
                    echo "Edit Pharmacist";
                } elseif ('editDrug' == $action) {
                    echo "Edit Drug";
                } elseif ('viewDrug' == $action) {
                    echo "View Drug";
                } elseif ('editSalesman' == $action) {
                    echo "Edit Otheruser";
                }elseif ('sales' == $id) {
                    echo "Sales";
                }
                ?>

            </span>
        </div>

        <div class="topber__profile">
            <?php
            $query = "SELECT * FROM {$sessionRole}s WHERE id='$sessionId'";
            $result = mysqli_query($connection, $query);

            if ($data = mysqli_fetch_assoc($result)) {
                $fname = $data['fname'];
                $lname = $data['lname'];
                $role = $data['role'];
                $avatar = $data['avatar'];

                if ($role != 'admin' && $role != 'pharmacist') {
                    $title = $data['title'];
                }


                ?>
            <img src="assets/img/<?php echo "$avatar"; ?>" height="25" width="25" class="rounded-circle" alt="profile">
            <div class="dropdown">
                <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <?php
                                        if ($role == 'salesman') {

                                            echo "$fname $lname (" . $title . " )";

                                        } elseif ($role == 'admin') {

                                            echo "$fname $lname (Systems Admin)";
                                        } else {

                                            echo "$fname $lname (" . ucwords($role) . " )";
                                        }

            }
            ?>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="index.php">Dashboard</a>
                    <a class="dropdown-item" href="index.php?id=userProfile">Profile</a>
                    <a class="dropdown-item" href="logout.php">Log Out</a>
                </div>
            </div>
        </div>
    </section>
    <!--------------------------------- Secondary Navber -------------------------------->


    <!--------------------------------- Sideber -------------------------------->
    <section id="sideber" class="sideber">
        <ul class="sideber__ber">
            <h3 class="sideber__panel"><i id="left" class="fas fa-laugh-wink"></i> DMS</h3>
            <li id="left" class="sideber__item<?php if ('dashboard' == $id) {
                echo " active";
            } ?>">
                <a href="index.php?id=dashboard"><i id="left" class="fas fa-tachometer-alt"></i>Dashboard</a>
            </li>


            <li id="left" class="sideber__item sideber__item--modify<?php if ('statistics' == $id) {
                                    echo " active";
                                } ?>">
                <a href="index.php?id=statistics"><i id="left" class="fas fa-bars"></i></i>Statistics</a>
            </li>

            <li id="left" class="sideber__item sideber__item--modify<?php if ('reports' == $id) {
                                    echo " active";
                                } ?>">
                <a href="index.php?id=reports"><i id="left" class="fas fa-book"></i></i>Reports</a>
            </li>

            <?php if ('admin' == $sessionRole) { ?>
            <!-- For Admin,  -->
            <li id="left" class="sideber__item sideber__item--modify<?php if ('addPharmacist' == $id) {
                                    echo " active";
                                } ?>">
                <a href="index.php?id=addPharmacist"><i id="left" class="fas fa-user-plus"></i></i>Add
                    Pharmacist</a>
            </li>
            <?php } ?>
            <li id="left" class="sideber__item<?php if ('allPharmacist' == $id) {
                echo " active";
            } ?>">
                <a href="index.php?id=allPharmacist"><i id="left" class="fas fa-user"></i>All Pharmacist</a>
            </li>
            <?php if ('admin' == $sessionRole || 'pharmacist' == $sessionRole) { ?>
            <!-- For Admin , Pharmacist-->
            <li id="left" class="sideber__item sideber__item--modify<?php if ('addDrug' == $id) {
                                    echo " active";
                                } ?>">
                <a href="index.php?id=addDrug"><i id="left" class="fas fa-capsules"></i></i>Add
                    Drug</a>
            </li>
            <?php } ?>

            <li id="left" class="sideber__item<?php if ('allDrug' == $id) {
                echo " active";
            } ?>">
                <a href="index.php?id=allDrug"><i id="left" class="fas fa-tablets"></i>All Drugs</a>

            </li>

            <li id="left" class="sideber__item<?php if ('expiredDrug' == $id) {
                echo " active";
            } ?>">
                <a href="index.php?id=expiredDrug"><i id="left" class="fas fa-pills"></i>Expired Drugs</a>

            </li>


            <?php if ('admin' == $sessionRole || 'pharmacist' == $sessionRole) { ?>
            <!-- For Admin, Pharmacist-->
            <li id="left" class="sideber__item sideber__item--modify<?php if ('addSalesman' == $id) {
                                    echo " active";
                                } ?>">
                <a href="index.php?id=addSalesman"><i id="left" class="fas fa-user-plus"></i>Add Otheruser</a>
            </li>
            <?php } ?>
            <li id="left" class="sideber__item<?php if ('allSalesman' == $id) {
                echo " active";
            } ?>">
                <a href="index.php?id=allSalesman"><i id="left" class="fas fa-user"></i>All Otherusers</a>
            </li>

            <?php if ('admin' == $sessionRole || 'pharmacist' == $sessionRole) { ?>
            <!-- For Admin, Pharmacist-->
            <li id="left" class="sideber__item sideber__item--modify<?php if ('sales' == $id) {
                                    echo " active";
                                } ?>">
                <a href="index.php?id=sales"><i id="left" class="fas fa-shopping-cart"></i>Total Sales</a>
            </li>
            <?php }else{?>
            <li id="left" class="sideber__item sideber__item--modify<?php if ('sales' == $id) {
                                    echo " active";
                                } ?>">
                <a href="index.php?id=sales"><i id="left" class="fas fa-shopping-cart"></i>My Sales</a>
            </li>
            <?php
            } ?>
        </ul>

    </section>
    <!--------------------------------- #Sideber -------------------------------->


    <!--------------------------------- Main section -------------------------------->
    <section class="main">
        <div class="container">

            <!-- ---------------------- DashBoard ------------------------ -->
            <?php if ('dashboard' == $id) { ?>
            <div class="dashboard p-5">
                <div class="total">
                    <div class="row">

                        <?php if($sessionRole=='admin'|| $sessionRole=='pharmacist'){?>
                        <div class="col-3">
                            <div class="total__box text-center">
                                <h1>
                                    <?php
                                                        $query = "SELECT COUNT(*) totalSale FROM sale;";
                                                        $result = mysqli_query($connection, $query);
                                                        $totalSales = mysqli_fetch_assoc($result);
                                                        echo $totalSales['totalSale'];
                                                        ?>

                                </h1>
                                <h2> Sales</h2>
                            </div>
                        </div>
                        <?php }else{?>
                        <div class="col-3">
                            <div class="total__box text-center">
                                <h1>
                                    <?php
                                                        $query = "SELECT COUNT(*) totalSale FROM sale WHERE salesman_id='{$sessionId}';";
                                                        $result = mysqli_query($connection, $query);
                                                        $totalSales = mysqli_fetch_assoc($result);
                                                        echo $totalSales['totalSale'];
                                                        ?>

                                </h1>
                                <h2>My Sales</h2>
                            </div>
                        </div>
                        <?php }
                        ?>

                        <div class="col-3">
                            <div class="total__box text-center">
                                <h1>
                                    <?php
                                                        $query = "SELECT COUNT(*) totalPharmacist FROM pharmacists;";
                                                        $result = mysqli_query($connection, $query);
                                                        $totalPharmacist = mysqli_fetch_assoc($result);
                                                        echo $totalPharmacist['totalPharmacist'];
                                                        ?>
                                </h1>

                                <h2>Pharmacists</h2>

                            </div>
                        </div>

                        <div class="col-3">
                            <div class="total__box text-center">
                                <h1>
                                    <?php
                                                        $query = "SELECT COUNT(*) totalDrug FROM drugs;";
                                                        $result = mysqli_query($connection, $query);
                                                        $totalPharmacist = mysqli_fetch_assoc($result);
                                                        echo $totalPharmacist['totalDrug'];
                                                        ?>

                                </h1>
                                <h2>Drugs</h2>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="total__box text-center">
                                <h1>
                                    <?php
                                        $query = "SELECT COUNT(*) totalSalesman FROM salesmans;";
                                        $result = mysqli_query($connection, $query);
                                        $totalSalesman = mysqli_fetch_assoc($result);
                                        echo $totalSalesman['totalSalesman'];
                                        ?>
                                </h1>
                                <h2>Otherusers</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <!-- ---------------------- DashBoard endsssssssssssssss------------------------ -->

            <!-- ------------------------------statistics------------------------ -->
            <?php if($id=='statistics'){ 
                $getDrug = "SELECT * FROM drugs";
                $result = mysqli_query($connection, $getDrug);
                
                $drugs = array();                
                while ($drug = mysqli_fetch_assoc($result)) {
                    $drugs[] = $drug;}

                $getSales = "SELECT MONTH(time_sold) AS month, SUM(quantity_sold) AS total_sales FROM sale GROUP BY MONTH(time_sold)";
                $result = mysqli_query($connection, $getSales);
                
                $salesData = array();
                
                while ($sale = mysqli_fetch_assoc($result)) {
                    $salesData[] = $sale;
                }
                if('admin' == $sessionRole || 'pharmacist' == $sessionRole){?>

            <div class="d-flex row h-75">
                <div class="col-md-6">
                    <canvas id="pieChart" class="h-100"></canvas>
                </div>
                <div class="col-md-6">
                    <canvas id="barGraph" class="h-100"></canvas>
                </div>

            </div>
            <hr>
            <div class="container mt-5">
                <div class="h-75">
                    <h4 class="text-center">Drug Sales Per Month</h4>
                    <canvas id="salesChart" width="100%" height="50px"></canvas>
                </div>
            </div>
            <?php }else{
                    $getSales = "SELECT s.id, s.quantity_sold, s.drug_id, d.drug_name FROM sale s
                    JOIN drugs d ON s.drug_id = d.id
                    WHERE s.salesman_id = '$sessionId'";
                    $result = mysqli_query($connection, $getSales);
                    
                    $salesData = array();
                    
                    while ($sale = mysqli_fetch_assoc($result)) {
                        $salesData[] = $sale;
                    }
                    
                    ?>
            <div class="container mt-5">
                <div>

                    <canvas id="salesCharts" width="100%" height="50px"></canvas>
                </div>
            </div>
            <?php } }?>


            <!-- -----------------------------------------reports--------------------------------------------- -->
            <?php if($id=='reports'){?>
            <div class="container">
                <a href="index.php?id=generate_report" class="btn btn-success">Generate New report</a>
                <div class="main__table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Date Generated</th>
                                <th scope="col">Report Name</th>
                                <th scope="col">Download</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2-02-2023</td>
                                <td>Report One</td>
                                <td><a href=""><i class="fa fa-download"></i></a></td>
                            </tr>


                        </tbody>
                    </table>


                </div>
            </div>
            <?php } ?>


            <?php if($id=='generate_report'){
                $report = "  <div class='container p-4'>
                <h3 class='text-center text-success'>Drug Management System</h3>
                <h5  class='text-center'>Comparative Analysis of Available Drugs: Good, Warning, and Expired</h5>
                <h6><b>1. Good Drugs:</b></h6>
                <p><b>• Percentage: 70%</b><br>-High efficacy, safety, and reliability.<br>
                    -Adherence to GMP standards, accurate labeling, and proper storage
                </p>
                <h6><b>2. Drugs with Warning Signs:</b></h6>
                <p><b>• Percentage: 20%</b><br>
                    - Early identification of potential issues.<br>
                    - Unusual odor, appearance, packaging inconsistencies, or batch recalls.
                </p>
                <h6><b>3. Good Drugs:</b></h6>
                <p><b>• Percentage: 20%</b><br>
                    - Early identification of potential issues.<br>
                    - Unusual odor, appearance, packaging inconsistencies, or batch recalls.
                </p>

                <h6><b>Sales</b></h6>
                <p>The sales have increased</p>

            </div>";
                ?>

            <form action="">
                <input type="hidden" value="<?=$sessionId?>" name="" id="">
                <input type="hidden" value="<?=$sessionRole?>" name="" id="">
                <label for="">Report name</label><br>
                <input type="text" name="report_name" id="" required>
                <button class="btn-success p-1 ">Save</button>
                <a href="index.php?id=reports" class="btn-secondary ml-2 p-2">Cancel</a>
            </form>
            <hr>
            <?=$report?>

          

            <?php } ?>


            <!-- ---------------------- Pharmacist ------------------------ -->
            <div class="pharmacist">
                <?php if ('allPharmacist' == $id) { ?>
                <div class="allPharmacist">
                    <div class="main__table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Avatar</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <?php if ('admin' == $sessionRole || 'manager' == $sessionRole) { ?>
                                    <!-- For Admin, Manager -->
                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                                    $getPharmacist = "SELECT * FROM pharmacists";
                                                    $result = mysqli_query($connection, $getPharmacist);

                                                    while ($pharmacist = mysqli_fetch_assoc($result)) { ?>

                                <tr>
                                    <td>
                                        <center><img class="rounded-circle" width="40" height="40"
                                                src="assets/img/<?php echo $pharmacist['avatar']; ?>" alt=""></center>
                                    </td>
                                    <td>
                                        <?php printf("%s %s", $pharmacist['fname'], $pharmacist['lname']); ?>
                                    </td>
                                    <td>
                                        <?php printf("%s", $pharmacist['email']); ?>
                                    </td>
                                    <td>
                                        <?php printf("%s", $pharmacist['phone']); ?>
                                    </td>
                                    <?php if ('admin' == $sessionRole || 'manager' == $sessionRole) { ?>
                                    <!-- For Admin, Manager -->
                                    <td>
                                        <?php printf("<a href='index.php?action=editPharmacist&id=%s'><i class='fas fa-edit text-success'></i></a>", $pharmacist['id']) ?>
                                    </td>
                                    <td>
                                        <?php printf("<a class='delete' href='index.php?action=deletePharmacist&id=%s'><i class='fas fa-trash text-danger'></i></a>", $pharmacist['id']) ?>
                                    </td>
                                    <?php } ?>
                                </tr>

                                <?php } ?>

                            </tbody>
                        </table>


                    </div>
                </div>
                <?php } ?>

                <?php if ('addPharmacist' == $id) { ?>
                <div class="addPharmacist">
                    <div class="main__form">
                        <div class="main__form--title text-center">Add New Pharmacist</div>
                        <form action="add.php" method="POST">
                            <div class="form-row">
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-user-circle"></i>
                                        <input type="text" name="fname" placeholder="First name" required>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-user-circle"></i>
                                        <input type="text" name="lname" placeholder="Last Name" required>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-envelope"></i>
                                        <input type="email" name="email" placeholder="Email" required>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-phone-alt"></i>
                                        <input type="number" name="phone" placeholder="Phone" required>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-key"></i>
                                        <input id="pwdinput" type="password" name="password" placeholder="Password"
                                            required>
                                        <i id="pwd" class="fas fa-eye right"></i>
                                    </label>
                                </div>
                                <input type="hidden" name="action" value="addPharmacist">
                                <div class="col col-12">
                                    <input type="submit" value="Submit">
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <?php } ?>

                <?php if ('editPharmacist' == $action) {
                    $pharmacistID = $_REQUEST['id'];
                    $selectPharmacist = "SELECT * FROM pharmacists WHERE id='{$pharmacistID}'";
                    $result = mysqli_query($connection, $selectPharmacist);

                    $pharmacist = mysqli_fetch_assoc($result); ?>
                <div class="addManager">
                    <div class="main__form">
                        <div class="main__form--title text-center">Update Pharmacist</div>
                        <form action="add.php" method="POST">
                            <div class="form-row">
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-user-circle"></i>
                                        <input type="text" name="fname" placeholder="First name"
                                            value="<?php echo $pharmacist['fname']; ?>" required>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-user-circle"></i>
                                        <input type="text" name="lname" placeholder="Last Name"
                                            value="<?php echo $pharmacist['lname']; ?>" required>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-envelope"></i>
                                        <input type="email" name="email" placeholder="Email"
                                            value="<?php echo $pharmacist['email']; ?>" required>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-phone-alt"></i>
                                        <input type="number" name="phone" placeholder="Phone"
                                            value="<?php echo $pharmacist['phone']; ?>" required>
                                    </label>
                                </div>
                                <input type="hidden" name="action" value="updatePharmacist">
                                <input type="hidden" name="id" value="<?php echo $pharmacistID; ?>">
                                <div class="col col-12">
                                    <input type="submit" value="Update">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php } ?>

                <?php if ('deletePharmacist' == $action) {
                    $pharmacistID = $_REQUEST['id'];
                    $deletePharmacist = "DELETE FROM pharmacists WHERE id ='{$pharmacistID}'";
                    $result = mysqli_query($connection, $deletePharmacist);
                    header("location:index.php?id=allPharmacist");
                } ?>
            </div>
            <!-- ---------------------- Pharmacist ------------------------ -->

            <!-- ---------------------- drugs ------------------------ -->
            <div class="drugs">
                <?php if ('allDrug' == $id) { ?>
                <div class="allDrug">
                    <form class="form-group ml-5 mr-5 row">
                        <input type="text" name="searchKeyword" id="searchInput" onkeyup="searchTable()"
                            placeholder="search" class="form-control">

                    </form>
                    <div class="main__table">

                        <table class="table" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col">BATCH NO</th>
                                    <th scope="col">Drug Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Quatity</th>
                                    <th scope="col">Drug Status</th>
                                    <th scope="col">View</th>
                                    <?php if ('admin' == $sessionRole || 'manager' == $sessionRole || 'pharmacist' == $sessionRole) { ?>
                                    <!-- For Admin, Manager, pharmacist -->

                                    <th scope="col">Edit</th>
                                    <th scope="col">Delete</th>
                                    <?php }else{?>
                                    <th scope="col">Sell</th>

                                    <?php
                                    } ?>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                                    $getDrug = "SELECT * FROM drugs";
                                                    $result = mysqli_query($connection, $getDrug);

                                                    while ($drug = mysqli_fetch_assoc($result)) {

                                                        $current_time = date("Y-m-d");
                                                        $thresholdDate = date('Y-m-d', strtotime('+2 months'));

                                                        if ($drug['expiry_date'] == $current_time) {
                                                            $query = "UPDATE drugs SET status='0' where id='{$drug['id']}'";
                                                            mysqli_query($connection, $query);

                                                            if ($drug['expiry_date'] <= $thresholdDate) {
                                                                $query = "UPDATE drugs SET status='-1' where id='{$drug['id']}'";
                                                                mysqli_query($connection, $query);
                                                            }
                                                        }
                                                        ?>


                                <tr>
                                    <td>
                                        <?php printf("%s", $drug['batch_num']); ?>
                                    </td>
                                    <td>
                                        <?php printf("%s", $drug['drug_name']); ?>
                                    </td>
                                    <td>
                                        <?php printf("%s", $drug['drug_description']); ?>
                                    </td>
                                    <td>
                                        <?php printf("%s", $drug['drug_quantity']); ?>
                                    </td>
                                    <td>
                                        <?php

                                                                                if ($drug['status'] == '1') {
                                                                                    echo "<p style='color:green;'>Good</p>";
                                                                                } elseif ($drug['status'] == '0') {
                                                                                    echo "<p style='color:orange;'>Warning</p>";
                                                                                } elseif ($drug['status'] == '-1') {
                                                                                    echo "<p style='color:red;'>Expired</p>";
                                                                                }

                                                                                ?>

                                    </td>
                                    <td>
                                        <?php printf("<a href='index.php?action=viewDrug&id=%s'><i class='fas fa-eye text-primary'></i></a>", $drug['id']) ?>
                                    </td>
                                    <?php if ('admin' == $sessionRole || 'manager' == $sessionRole || 'pharmacist' == $sessionRole) { ?>
                                    <!-- For Admin, Manager -->

                                    <td>
                                        <?php printf("<a href='index.php?action=editDrug&id=%s'><i class='fas fa-edit text-warning'></i></a>", $drug['id']) ?>
                                    </td>
                                    <td>
                                        <?php printf("<a class='delete' href='index.php?action=deleteDrug&id=%s'><i class='fas fa-trash text-danger'></i></a>", $drug['id']) ?>
                                    </td>

                                    <?php }else{?>
                                    <td>
                                        <?php printf("<a href='index.php?action=sellDrug&id=%s' class='btn btn-success'>Sell</a>", $drug['id']) ?>
                                    </td>
                                    <?php } ?>
                                </tr>

                                <?php } ?>

                            </tbody>
                        </table>


                    </div>
                </div>
                <?php
                }
                ?>

                <!-- ==========================expiredDrug ========================= -->
                <div class="drugs">
                    <?php if ('expiredDrug' == $id) { ?>
                    <div class="expiredDrug">
                        <form class="form-group ml-5 mr-5 row">
                            <input type="text" name="searchKeyword" id="searchInput" onkeyup="searchTable()"
                                placeholder="search" class="form-control">

                        </form>

                        <div class="main__table">

                            <table class="table" id="dataTable">
                                <thead>
                                    <tr>
                                        <th scope="col">BATCH NO</th>
                                        <th scope="col">Drug Name</th>
                                        <th scope="col">Description</th>
                                        <th scope="COL">Quantity</th>
                                        <th scope="col">Drug Status</th>
                                        <?php if ('admin' == $sessionRole || 'manager' == $sessionRole || 'pharmacist' == $sessionRole) { ?>
                                        <!-- For Admin, Manager, pharmacist -->
                                        <th scope="col">View</th>
                                        <th scope="col">Edit</th>
                                        <th scope="col">Delete</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                                        $getDrug = "SELECT * FROM drugs";
                                                        $result = mysqli_query($connection, $getDrug);

                                                        while ($drug = mysqli_fetch_assoc($result)) {
                                                            if ($drug['status'] == '-1') { ?>

                                    <tr>

                                        <td>
                                            <?php printf("%s", $drug['batch_num']); ?>
                                        </td>
                                        <td>
                                            <?php printf("%s", $drug['drug_name']); ?>
                                        </td>
                                        <td>
                                            <?php printf("%s", $drug['drug_description']); ?>
                                        </td>
                                        <td>
                                            <?php printf("%s", $drug['drug_quantity']); ?>
                                        </td>
                                        <td>
                                            <?php

                                                                                                        if ($drug['status'] == '1') {
                                                                                                            echo "<p style='color:green;'>Good</p>";
                                                                                                        } elseif ($drug['status'] == '0') {
                                                                                                            echo "<p style='color:orange;'>Warning</p>";
                                                                                                        } elseif ($drug['status'] == '-1') {
                                                                                                            echo "<p style='color:red;'>Expired</p>";
                                                                                                        }

                                                                                                        ?>
                                        </td>
                                        <?php if ('admin' == $sessionRole || 'manager' == $sessionRole || 'pharmacist' == $sessionRole) { ?>
                                        <!-- For Admin, Manager, pharmacist-->
                                        <td>
                                            <?php printf("<a href='index.php?action=viewDrug&id=%s'><i class='fas fa-eye text-success'></i></a>", $drug['id']) ?>
                                        </td>
                                        <td>
                                            <?php printf("<a href='index.php?action=editDrug&id=%s'><i class='fas fa-edit text-success'></i></a>", $drug['id']) ?>
                                        </td>
                                        <td>
                                            <?php printf("<a class='delete' href='index.php?action=deleteDrug&id=%s'><i class='fas fa-trash text-danger'></i></a>", $drug['id']) ?>
                                        </td>
                                        <?php } ?>
                                    </tr>

                                    <?php }
                                                        } ?>

                                </tbody>
                            </table>


                        </div>
                    </div>
                    <?php
                    }
                    ?>


                    <!-- ====================================== add drug ================================================================== -->
                    <?php if ('addDrug' == $id) { ?>
                    <div class="addDrug">
                        <div class="main__form">
                            <div class="main__form--title text-center">Add New Drug</div>
                            <form action="add.php" method="POST">
                                <div class="form-row">
                                    <div class="col col-12">
                                        <label class="input">
                                            <p id="left">B/N</p>
                                            <input type="text" class="form-control" name="batch_num" required>
                                        </label>
                                    </div>


                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-capsules"></i>
                                            <input type="text" name="d_name" placeholder="Drug Name" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-tablets"></i>
                                            <input type="text" name="d_desc" placeholder="Drug description" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-hospital"></i>
                                            <input type="number" name="d_price" placeholder="Drug Price" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-tablets"></i>
                                            <input type="text" name="d_quantity" placeholder="Drug Quantity" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <p id="left">mnf</p>
                                            <input type="text" name="mnf_date" placeholder="YYYY-MM-DD" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <p id="left">Exp</p>
                                            <input type="text" name="exp_date" placeholder="YYYY-MM-DD" required>
                                        </label>
                                    </div>

                                    <input type="hidden" name="action" value="addDrug">
                                    <div class="col col-12">
                                        <input type="submit" name="add_drug" value="Submit">
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <?php } ?>
                    <!--------------------------------- view drug --------------------------------------------------------------------------------------------->
                    <?php if ('viewDrug' == $action) {
                        $drugID = $_REQUEST['id'];
                        $selectDrug = "SELECT * FROM drugs WHERE id='{$drugID}'";
                        $result = mysqli_query($connection, $selectDrug);

                        $drug = mysqli_fetch_assoc($result); ?>
                    <div class="addManager">
                        <div class="main__form">
                            <div class="main__form--title text-center">
                                <?= $drug['drug_name'] ?>
                            </div>
                            <h5 class="mb-3">Batch Number:
                                <?= $drug['batch_num'] ?>
                            </h5>
                            <div class="row">

                                <div class="col-4">
                                    <h6>Manufacturing Date</h6>
                                    <p>
                                        <?= $drug['manufacturing_date'] ?>
                                    </p>
                                </div>

                                <div class="col-4">
                                    <h6>Expiry Date</h6>
                                    <p>
                                        <?= $drug['expiry_date'] ?>
                                    </p>
                                </div>

                                <div class="col-4">
                                    <h6>Status</h6>
                                    <?php


                                    if ($drug['status'] == '1') {
                                        echo "<p style='color:green;'>Good</p>";
                                    } elseif ($drug['status'] == '0') {
                                        echo "<p style='color:orange;'>Warning</p>";
                                    } elseif ($drug['status'] == '-1') {
                                        echo "<p style='color:red;'>Expired</p>";
                                    }

                                    ?>
                                </div>

                            </div>

                            <div class="mt-3">
                                <h6 class="">Drug description</h6>
                                <p>
                                    <?= $drug['drug_description'] ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    <!-------------------------------------------------- edit drug------------------------------------------------------------------------------------------ -->
                    <?php if ('editDrug' == $action) {
                        $drugID = $_REQUEST['id'];
                        $selectDrug = "SELECT * FROM drugs WHERE id='{$drugID}'";
                        $result = mysqli_query($connection, $selectDrug);

                        $drug = mysqli_fetch_assoc($result); ?>
                    <div class="addManager">
                        <div class="main__form">
                            <div class="main__form--title text-center">Update Drug</div>
                            <form action="add.php" method="POST">
                                <div class="form-row">
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-hospital"></i>
                                            <input type="text" name="d_name" placeholder="Drug Name"
                                                value="<?php echo $drug['drug_name']; ?>" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <p id="left">Dec</p>
                                            <input type="text" name="d_desc" placeholder="Drug Description"
                                                value="<?php echo $drug['drug_description']; ?>" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-hospital"></i>
                                            <input type="number" name="d_price" placeholder="Drug Price"
                                                value="<?php echo $drug['drug_price']; ?>" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left">Qty</i>
                                            <input type="number" name="d_quantity" placeholder="Drug Quantity"
                                                value="<?php echo $drug['drug_quantity']; ?>" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <p id="left">Mnf</p>
                                            <input type="text" name="mnf_date" placeholder="YYYY-MM-DD"
                                                value="<?php echo $drug['manufacturing_date']; ?>" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <p id="left">Exp</p>
                                            <input type="text" name="exp_date" placeholder="Expiry Date"
                                                value="<?php echo $drug['expiry_date']; ?>" required>
                                        </label>
                                    </div>
                                    <input type="text" hidden name="status" value="<?php echo $drug['status'] ?>">
                                    <input type="hidden" name="action" value="updateDrug">
                                    <input type="hidden" name="id" value="<?php echo $drugID; ?>">
                                    <div class="col col-12">
                                        <input type="submit" name="edit_drug" value="Update">
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <?php } ?>

                    <?php if ('deleteDrug' == $action) {
                        $drugID = $_REQUEST['id'];
                        $deleteDrug = "DELETE FROM drugs WHERE id ='{$drugID}'";
                        $result = mysqli_query($connection, $deleteDrug);
                        header("location:index.php?id=allDrug");
                    } ?>
                </div>
                <!-- ---------------------- drugs ------------------------ -->

                <!-- ---------------------- OtherUsers ------------------------ -->
                <div class="salesman">
                    <?php if ('allSalesman' == $id) { ?>
                    <div class="allSalesman">
                        <div class="main__table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Avatar</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <?php if ('admin' == $sessionRole || 'manager' == $sessionRole || 'pharmacist' == $sessionRole) { ?>
                                        <!-- For Admin, Manager, Pharmacist-->
                                        <th scope="col">Edit</th>
                                        <th scope="col">Delete</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                                        $getSalesman = "SELECT * FROM salesmans";
                                                        $result = mysqli_query($connection, $getSalesman);

                                                        while ($salesman = mysqli_fetch_assoc($result)) { ?>

                                    <tr>
                                        <td>
                                            <center><img class="rounded-circle" width="40" height="40"
                                                    src="assets/img/<?php echo $salesman['avatar']; ?>" alt=""></center>
                                        </td>
                                        <td>
                                            <?php printf("%s %s", $salesman['fname'], $salesman['lname']); ?>
                                        </td>
                                        <td>
                                            <?php printf("%s", $salesman['email']); ?>
                                        </td>
                                        <td>
                                            <?php printf("%s", $salesman['phone']); ?>
                                        </td>
                                        <?php if ('admin' == $sessionRole || 'manager' == $sessionRole || 'pharmacist' == $sessionRole) { ?>
                                        <!-- For Admin, Manager, Pharmacist-->
                                        <td>
                                            <?php printf("<a href='index.php?action=editSalesman&id=%s'><i class='fas fa-edit text-success'></i></a>", $salesman['id']) ?>
                                        </td>
                                        <td>
                                            <?php printf("<a class='delete' href='index.php?action=deleteSalesman&id=%s'><i class='fas fa-trash text-danger'></i></a>", $salesman['id']) ?>
                                        </td>
                                        <?php } ?>
                                    </tr>

                                    <?php } ?>

                                </tbody>
                            </table>


                        </div>
                    </div>
                    <?php } ?>

                    <?php if ('addSalesman' == $id) { ?>
                    <div class="addSalesman">
                        <div class="main__form">
                            <div class="main__form--title text-center">Add New User</div>
                            <form action="add.php" method="POST">
                                <div class="form-row">
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-user-circle"></i>
                                            <input type="text" name="fname" placeholder="First name" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-user-circle"></i>
                                            <input type="text" name="lname" placeholder="Last Name" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-user-circle"></i>
                                            <select name="title">
                                                <option value="">Select Title</option>
                                                <option value="Medical Officer">Medical Officer</option>
                                                <option value="Clinical Officer">Clinical Officer</option>
                                                <option value="Principle Nursing Officer">Principle Nursing Officer
                                                </option>
                                                <option value="Nurse">Nurse</option>
                                                <option value="Accounting Officer">Accounting Officer</option>
                                                <option value="Procurement Officer">Procurement Officer</option>
                                            </select>
                                        </label>
                                    </div>

                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-envelope"></i>
                                            <input type="email" name="email" placeholder="Email" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-phone-alt"></i>
                                            <input type="number" name="phone" placeholder="Phone" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-key"></i>
                                            <input id="pwdinput" type="password" name="password" placeholder="Password"
                                                required>
                                        </label>
                                    </div>
                                    <input type="hidden" name="action" value="addSalesman">
                                    <div class="col col-12">
                                        <input type="submit" value="Submit">
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                    <?php } ?>

                    <?php if ('editSalesman' == $action) {
                        $salesmanID = $_REQUEST['id'];
                        $selectSalesman = "SELECT * FROM salesmans WHERE id='{$salesmanID}'";
                        $result = mysqli_query($connection, $selectSalesman);

                        $salesman = mysqli_fetch_assoc($result); ?>
                    <div class="addManager">
                        <div class="main__form">
                            <div class="main__form--title text-center">Update OtherUser</div>
                            <form action="add.php" method="POST">
                                <div class="form-row">
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-user-circle"></i>
                                            <input type="text" name="fname" placeholder="First name"
                                                value="<?php echo $salesman['fname']; ?>" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-user-circle"></i>
                                            <input type="text" name="lname" placeholder="Last Name"
                                                value="<?php echo $salesman['lname']; ?>" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-envelope"></i>
                                            <input type="email" name="email" placeholder="Email"
                                                value="<?php echo $salesman['email']; ?>" required>
                                        </label>
                                    </div>
                                    <div class="col col-12">
                                        <label class="input">
                                            <i id="left" class="fas fa-phone-alt"></i>
                                            <input type="number" name="phone" placeholder="Phone"
                                                value="<?php echo $salesman['phone']; ?>" required>
                                        </label>
                                    </div>
                                    <input type="hidden" name="action" value="updateSalesman">
                                    <input type="hidden" name="id" value="<?php echo $salesmanID; ?>">
                                    <div class="col col-12">
                                        <input type="submit" value="Update">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php } ?>

                    <?php if ('deleteSalesman' == $action) {
                        $salesmanID = $_REQUEST['id'];
                        $deleteSalesman = "DELETE FROM salesmans WHERE id ='{$salesmanID}'";
                        $result = mysqli_query($connection, $deleteSalesman);
                        header("location:index.php?id=allSalesman");
                        ob_end_flush();
                    } ?>
                </div>
                <!-- ---------------------- otherUsers ------------------------ -->

                <!-- ---------------------- User Profile ------------------------ -->
                <?php if ('userProfile' == $id) {
                    $query = "SELECT * FROM {$sessionRole}s WHERE id='$sessionId'";
                    $result = mysqli_query($connection, $query);
                    $data = mysqli_fetch_assoc($result)
                        ?>
                <div class="userProfile">
                    <div class="main__form myProfile">
                        <form action="index.php">
                            <div class="main__form--title myProfile__title text-center">My Profile</div>
                            <div class="form-row text-center">
                                <div class="col col-12 text-center pb-3">
                                    <img src="assets/img/<?php echo $data['avatar']; ?>"
                                        class="img-fluid rounded-circle" alt="">
                                </div>
                                <div class="col col-12">
                                    <h4><b>Full Name : </b>
                                        <?php printf("%s %s", $data['fname'], $data['lname']); ?>
                                    </h4>
                                </div>
                                <div class="col col-12">
                                    <h4><b>Email : </b>
                                        <?php printf("%s", $data['email']); ?>
                                    </h4>
                                </div>
                                <div class="col col-12">
                                    <h4><b>Phone : </b>
                                        <?php printf("%s", $data['phone']); ?>
                                    </h4>
                                </div>
                                <input type="hidden" name="id" value="userProfileEdit">
                                <div class="col col-12">
                                    <input class="updateMyProfile" type="submit" value="Update Profile">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php } ?>

                <?php if ('userProfileEdit' == $id) {
                    $query = "SELECT * FROM {$sessionRole}s WHERE id='$sessionId'";
                    $result = mysqli_query($connection, $query);
                    $data = mysqli_fetch_assoc($result)
                        ?>


                <div class="userProfileEdit">
                    <div class="main__form">
                        <div class="main__form--title text-center">Update My Profile</div>
                        <form enctype="multipart/form-data" action="add.php" method="POST">
                            <div class="form-row">
                                <div class="col col-12 text-center pb-3">
                                    <img id="pimg" src="assets/img/<?php echo $data['avatar']; ?>"
                                        class="img-fluid rounded-circle" alt="">
                                    <i class="fas fa-pen pimgedit"></i>
                                    <input
                                        onchange="document.getElementById('pimg').src = window.URL.createObjectURL(this.files[0])"
                                        id="pimgi" style="display: none;" type="file" name="avatar">
                                </div>
                                <div class="col col-12">
                                    <?php if (isset($_REQUEST['avatarError'])) {
                                                            echo "<p style='color:red;' class='text-center'>Please make sure this file is jpg, png or jpeg</p>";
                                                        } ?>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-user-circle"></i>
                                        <input type="text" name="fname" placeholder="First name"
                                            value="<?php echo $data['fname']; ?>" required>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-user-circle"></i>
                                        <input type="text" name="lname" placeholder="Last Name"
                                            value="<?php echo $data['lname']; ?>" required>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-envelope"></i>
                                        <input type="email" name="email" placeholder="Email"
                                            value="<?php echo $data['email']; ?>" required>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-phone-alt"></i>
                                        <input type="number" name="phone" placeholder="Phone"
                                            value="<?php echo $data['phone']; ?>" required>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-key"></i>
                                        <input id="pwdinput" type="password" name="oldPassword"
                                            placeholder="Old Password" required>
                                        <i id="pwd" class="fas fa-eye right"></i>
                                    </label>
                                </div>
                                <div class="col col-12">
                                    <label class="input">
                                        <i id="left" class="fas fa-key"></i>
                                        <input id="pwdinput" type="password" name="newPassword"
                                            placeholder="New Password" required>
                                        <p>Type Old Password if you don't want to change</p>
                                        <i id="pwd" class="fas fa-eye right"></i>
                                    </label>
                                </div>
                                <input type="hidden" name="action" value="updateProfile">
                                <div class="col col-12">
                                    <input type="submit" value="Update">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php } ?>
                <!-- ---------------------- User Profile ------------------------ -->

            </div>

            <!-- --------------------------------sell drugs------------------------ -->

            <?php if('sellDrug'==$action){
                $drugId = $_REQUEST['id'];
                $selectDrug = "SELECT * FROM drugs WHERE id='{$drugId}'";
                        $result = mysqli_query($connection, $selectDrug);
                        $drug = mysqli_fetch_assoc($result);
                ?>
            <div class="addManager">
                <div class="main__form">
                    <div class="main__form--title text-center">
                        <?= $drug['drug_name'] ?>
                    </div>


                    <div class="row">
                        <div class="col-6">
                            <h6 class="product-price" data-price="<?=$drug['drug_price']?>">Price :
                                <?=$drug['drug_price']?> ugx
                            </h6>
                        </div>
                        <div class="col-6">
                            <h6>Available Quantity : <?=$drug['drug_quantity']?></h6>
                        </div>
                    </div>
                    <hr>
                    <form action="add.php" class="p-4 sell-product-form" method="POST">
                        <input type="hidden" name="salesmanId" value="<?=$sessionId?>" id="">
                        <input type="hidden" name="drugId" value="<?=$drugId?>" id="">
                        <input type="hidden" name="qty" id="" value="<?=$drug['drug_quantity']?>">
                        <div class="row">
                            <div class="col-6">
                                <label for="quantity-input">Quantity Required</label>
                            </div>
                            <div class="col-6">
                                <input type="number" class="my-2 quantity-input" min="1" placeholder="1" name="quantity"
                                    id="quantity-input" onchange="updateTotalPrice()">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-6">
                                <label for="total-price">Total Price</label>
                            </div>
                            <div class="col-6">
                                <input type="text" name="total-price" class="my-2 total-price" placeholder="0" readonly>
                            </div>
                        </div>

                        <input type="hidden" name="action" value="sellDrug">
                        <div class="col col-12">
                            <input type="submit" value="Sell">
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <?php }?>



        <!-- -------------------sales-------------------------------------- -->
        <?php if($id=='sales'){ 
            $query = "SELECT * FROM sale ORDER BY -id";
            $sales = mysqli_query($connection, $query);
            
                       
                if('admin' == $sessionRole || 'pharmacist' == $sessionRole){?>
        Total sales
        <form class="form-group ml-5 mr-5 row">
            <input type="text" name="searchKeyword" id="searchInput" onkeyup="searchTable()" placeholder="search"
                class="form-control">

        </form>

        <div class="main__table">

            <table class="table" id="dataTable">
                <thead>
                    <tr>
                        <th scope="col">Seller Name</th>
                        <th scope="col">Drug Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="COL">Total Price</th>
                        <th scope="col">Time Sold</th>

                    </tr>
                <tbody>
                    <?php foreach($sales as $sale){?>
                    <tr>
                        <td>
                            <?php $salemanId=$sale['salesman_id'];
                            $sql = "SELECT * FROM salesmans WHERE id='{$salemanId}'";
                            $stmt = mysqli_query($connection, $sql);    
                            $salesman = mysqli_fetch_assoc($stmt);
                            $fName = $salesman['fname'];
                            $lName = $salesman['lname'];
                            
                            ?>
                            <?=$fName?> <?=$lName?>
                        </td>
                        <td>
                            <?php $drugId=$sale['drug_id'];
                            $sql = "SELECT * FROM drugs WHERE id='{$drugId}'";
                            $stmt = mysqli_query($connection, $sql);    
                            $drug = mysqli_fetch_assoc($stmt);
                            $drugName = $drug['drug_name'];
                                                       
                            ?>
                            <?=$drugName?>
                        </td>
                        <td><?=$sale['quantity_sold']?></td>
                        <td><?=$sale['total_price']?></td>
                        <td><?=$sale['time_sold']?></td>
                    </tr>
                    <?php }?>
                </tbody>
                </thead>
            </table>
        </div>
        <?php }else{?>
        My Sales
        <form class="form-group ml-5 mr-5 row">
            <input type="text" name="searchKeyword" id="searchInput" onkeyup="searchTable()" placeholder="search"
                class="form-control">

        </form>

        <div class="main__table">

            <table class="table" id="dataTable">
                <thead>
                    <tr>
                        <th scope="col">Drug Name</th>
                        <th scope="col">Quantity</th>
                        <th scope="COL">Total Price</th>
                        <th scope="col">Time Sold</th>

                    </tr>
                <tbody>
                    <?php foreach($sales as $sale){
                        if($sale['salesman_id']==$sessionId){?>
                    <tr>

                        <td>
                            <?php $drugId=$sale['drug_id'];
                            $sql = "SELECT * FROM drugs WHERE id='{$drugId}'";
                            $stmt = mysqli_query($connection, $sql);    
                            $drug = mysqli_fetch_assoc($stmt);
                            $drugName = $drug['drug_name'];
                                                       
                            ?>
                            <?=$drugName?>
                        </td>
                        <td><?=$sale['quantity_sold']?></td>
                        <td><?=$sale['total_price']?></td>
                        <td><?=$sale['time_sold']?></td>
                    </tr>
                    <?php }
                }?>
                </tbody>
                </thead>
            </table>
        </div>

        <?php } }?>
        </div>
    </section>

    <!--------------------------------- #Main section -------------------------------->

    <script>
    function updateTotalPrice() {
        var quantity = parseInt($("#quantity-input").val()) || 0;
        var price = parseFloat($(".product-price").data("price")) || 0;
        var totalPrice = quantity * price;
        $(".total-price").val(totalPrice.toFixed(2)); // Set the total price with 2 decimal places
    }
    </script>



    <script>
    function searchTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toLowerCase();
        table = document.getElementById("dataTable");
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) { // Start from index 1 to skip header row
            td = tr[i].getElementsByTagName("td");
            for (var j = 0; j < td.length; j++) {
                var cell = td[j];
                if (cell) {
                    txtValue = cell.textContent || cell.innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                        break; // Show the row if any cell matches
                    } else {
                        tr[i].style.display = "none"; // Hide the row if no cell matches
                    }
                }
            }
        }
    }
    </script>

    <script>
    // PHP data
    var drugs = <?php echo json_encode($drugs); ?>;

    // Process data for charts
    var drugStatusData = {
        labels: ['Good', 'Warning', 'Expired'],
        pieData: [0, 0, 0],
        barData: [0, 0, 0],
    };

    // Count drug statuses
    drugs.forEach(function(drug) {
        switch (drug.status) {
            case '1':
                drugStatusData.pieData[0]++;
                drugStatusData.barData[0]++;
                break;
            case '0':
                drugStatusData.pieData[1]++;
                drugStatusData.barData[1]++;
                break;
            case '-1':
                drugStatusData.pieData[2]++;
                drugStatusData.barData[2]++;
                break;
        }
    });

    // Get the canvas elements
    var pieCtx = document.getElementById('pieChart').getContext('2d');
    var barCtx = document.getElementById('barGraph').getContext('2d');

    // Pie Chart configuration
    var pieOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'top',
            },
        },
    };

    // Bar Graph configuration
    var barOptions = {
        scales: {
            y: {
                beginAtZero: true
            }
        },
        responsive: true,
        maintainAspectRatio: false,
    };

    // Create the Pie Chart
    var pieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: drugStatusData.labels,
            datasets: [{
                data: drugStatusData.pieData,
                backgroundColor: [
                    'rgba(0, 128, 0, 0.8)', // Good
                    'rgba(255, 165, 0, 0.8)', // Warning
                    'rgba(255, 0, 0, 0.8)', // Expired
                ],
            }],
        },
        options: pieOptions
    });

    // Create the Bar Graph
    var barChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: drugStatusData.labels,
            datasets: [{
                label: 'Drug Count',
                data: drugStatusData.barData,
                backgroundColor: [
                    'rgba(0, 128, 0, 0.8)', // Good
                    'rgba(255, 165, 0, 0.8)', // Warning
                    'rgba(255, 0, 0, 0.8)', // Expired
                ],
                borderWidth: 1,
            }],
        },
        options: barOptions
    });
    </script>

    <script>
    // PHP data
    var salesData = <?php echo json_encode($salesData); ?>;

    // Process data for the chart
    var chartData = {
        labels: [],
        barData: [],
        lineData: [],
        colors: []
    };

    // Extract labels and data
    salesData.forEach(function(sale) {
        chartData.labels.push(sale.month);
        chartData.barData.push(sale.total_sales);
        chartData.lineData.push(sale.total_sales * 1.5); // Adjust multiplier as needed for line graph
        // Generate a random color
        chartData.colors.push(getRandomColor());
    });

    // Get the canvas element
    var salesCtx = document.getElementById('salesChart').getContext('2d');

    // Chart configuration
    var chartOptions = {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                beginAtZero: true
            }
        },
    };

    // Create the chart
    var salesChart = new Chart(salesCtx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Total Sales',
                data: chartData.barData,
                backgroundColor: chartData.colors, // Use the generated colors
                borderWidth: 1,
                yAxisID: 'bar-y-axis',
            }, {
                label: 'Trend Line',
                data: chartData.lineData,
                type: 'line',
                borderColor: 'rgba(255, 69, 0, 0.8)', // Fixed color for the trend line
                borderWidth: 2,
                yAxisID: 'line-y-axis',
            }],
        },
        options: chartOptions
    });

    // Function to generate a random color
    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
    </script>

    <script>
    // PHP data
    var salesData = <?php echo json_encode($salesData); ?>;

    // Process data for the chart
    var chartData = {
        labels: [],
        barData: [],
        colors: []
    };

    // Extract labels and data
    salesData.forEach(function(sale) {
        // Check if drug_name is defined
        var label = 'Sale ' + sale.sale_id;
        if (sale.drug_name !== null) {
            label += ' - ' + sale.drug_name;
        }
        chartData.labels.push(label);
        chartData.barData.push(sale.quantity_sold);
        // Generate a random color
        chartData.colors.push(getRandomColor());
    });

    // Get the canvas element
    var salesCtx = document.getElementById('salesCharts').getContext('2d');

    // Chart configuration
    var chartOptions = {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                beginAtZero: true
            }
        },
    };

    // Create the chart
    var salesChart = new Chart(salesCtx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Quantity Sold',
                data: chartData.barData,
                backgroundColor: chartData.colors, // Use the generated colors
                borderWidth: 1,
            }],
        },
        options: chartOptions
    });

    // Function to generate a random color
    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
    </script>
    <script src="assets/js/jquery-3.5.1.slim.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Custom Js -->
    <script src="./assets/js/app.js"></script>
    </body>

</html>