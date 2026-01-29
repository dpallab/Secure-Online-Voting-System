<?php
include('admin/inc/config.php');
$q = "SELECT * FROM elections";
$result = $conn->query($q);
while ($row = $result->fetch_assoc()) {
    $starting_date = $row['starting_date'];
    $ending_date = $row['ending_date'];
    $election_id = $row['id'];
    $current_date = date("Y-m-d");
    $status = $row['status'];

    if ($status == "Active") {
        $date1 = date_create($current_date);
        $date2 = date_create($ending_date);

        $diff = date_diff($date1, $date2);
        if ( (int)$diff->format("%R%a") < 0) {
            // echo "Expired";
            $queryToUpdateStatus = "UPDATE elections SET status='Expired' WHERE id='$election_id'";
            $conn->query($queryToUpdateStatus);
        }
    } elseif ($status == "InActive") {
         $date1 = date_create($current_date);
        $date2 = date_create($starting_date);

        $diff = date_diff($date1, $date2);
        if ( (int)$diff->format("%R%a") <= 0) {
            // echo "Active";
            $queryToUpdateStatus = "UPDATE elections SET status='Active' WHERE id='$election_id'";
            $conn->query($queryToUpdateStatus);
        }
    }
}
?>




<!DOCTYPE html>
<html>

<head>
    <title>Welcome Login Page</title>
    <link rel="stylesheet" href="assets/CSS/bootstrap.min.css">
    <link rel="stylesheet" href="assets/CSS/login.css">
</head>

<body>
    <div class="container h-100">
        <div class="d-flex justify-content-center h-100">
            <div class="user_card">
                <div class="d-flex justify-content-center">
                    <div class="brand_logo_container">
                        <img src="./assets/images/image.png" class="brand_logo" alt="Logo">
                    </div>
                </div>

                <?php
                if (isset($_GET['sign-up'])) {
                ?>
                    <div class="d-flex justify-content-center form_container">
                        <form method="POST">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="su_username" class="form-control input_user" placeholder="Username" required />
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="su_contact_no" class="form-control input_user" placeholder="Contact" required />
                            </div>

                            <div class="input-group mb-2">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password" name="su_password" class="form-control input_pass" placeholder="Password" required />
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="password" name="su_retype_password" class="form-control input_user" placeholder="Retype Password" required />
                            </div>

                            <div class="d-flex justify-content-center mt-3 login_container">
                                <button type="submit" name="sign_up_btn" class="btn login_btn">Sign Up</button>
                            </div>
                        </form>
                    </div>

                    <div class="mt-4">
                        <div class="d-flex justify-content-center links">
                            Already account created <a href="index.php" class="ml-2">Sign In</a>
                        </div>
                    </div>
                <?php
                } else {
                ?>
                    <div class="d-flex justify-content-center form_container">
                        <form method="POST">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="contact_no" class="form-control input_user" placeholder="Contact No. " required />
                            </div>
                            <div class="input-group mb-2">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="password" name="password" class="form-control input_pass" placeholder="Password" required />
                            </div>
                            <div class="d-flex justify-content-center mt-3 login_container">
                                <button type="submit" name="loginBtn" class="btn login_btn">Login</button>
                            </div>
                        </form>
                    </div>

                    <div class="mt-4">
                        <div class="d-flex justify-content-center links">
                            Don't have an account? <a href="?sign-up=1" class="ml-2">Sign Up</a>
                        </div>
                    </div>
                <?php
                }
                ?>

                <!-- message showing register time  -->
                <?php
                if (isset($_GET['registered'])) {
                ?>
                    <span class="bg-white text-success text-center my-3">Your account has been created</span>
                <?php
                } elseif (isset($_GET['invalid'])) {
                ?>
                    <span class="bg-white text-danger text-center my-3">Password mismatch</span>
                <?php
                } elseif (isset($_GET['invalid_access'])) {
                ?>
                    <span class="bg-white text-danger text-center my-3">Invalid Password</span>
                <?php
                } elseif (isset($_GET['not_registered'])) {
                ?>
                    <span class="bg-white text-warning text-center my-3">You are not registered user</span>
                <?php
                }
                ?>

            </div>
        </div>
    </div>

    <!-- <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- use direct link for jquery -->
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>

<!-- Register Logic  -->
<?php
include("admin/inc/config.php");
if (isset($_POST['sign_up_btn'])) {
    $username = $_POST['su_username'];
    $contact_no = $_POST['su_contact_no'];
    $password = $_POST['su_password'];
    $retype_password = $_POST['su_retype_password'];
    $user_role = "Voter";

    if ($password == $retype_password) {
        $insert_query = "INSERT INTO users (username, contact_no, password, user_role) VALUES ('$username', '$contact_no', '$password','$user_role' )";
        if ($conn->query($insert_query)) {
?>
            <script>
                location.assign("index.php?sign-up=1&registered=1");
            </script>
        <?php
        }
    } else {
        ?>
        <script>
            location.assign("index.php?sign-up=1&invalid=1");
        </script>
        <?php
    }
} elseif (isset($_POST['loginBtn'])) {
    $contact_no = $_POST['contact_no'];
    $password = $_POST['password'];

    $login_query = "SELECT * FROM users WHERE contact_no='$contact_no'";
    $result = $conn->query($login_query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // echo $user['password'];
        if ($contact_no == $user['contact_no'] && $password == $user['password']) {
            session_start();
            $_SESSION['user_role'] = $user['user_role'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];

            if ($user['user_role'] == "Admin") {
                $_SESSION['Key'] = "AdminKey";
        ?>
                <script>
                    location.assign("admin/index.php?homePage=1");
                </script>
            <?php
            } else {
                $_SESSION['Key'] = "VotersKey";
            ?>
                <script>
                    location.assign("voters/index.php");
                </script>
            <?php
            }
        } else {
            ?>
            <script>
                location.assign("index.php?&invalid_access=1");
            </script>
        <?php
        }
    } else {
        ?>
        <script>
            location.assign("index.php?&not_registered=1");
        </script>
<?php
    }
}
?>