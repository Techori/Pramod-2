<?php
session_start();
include './_conn.php';
?>

<!DOCTYPE html>
<html class="dark" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Login | Shree Unnati Wires &amp; Traders</title>
<!-- Google Fonts: Inter -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet"/>
<!-- Tailwind CSS v3 -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            brand: {
              DEFAULT: '#f48c25',
              dark: '#d6761a',
              light: '#ffaa54'
            },
            industrial: {
              900: '#121212',
              800: '#1e1e1e',
              700: '#2d2d2d'
            }
          },
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
          },
          borderRadius: {
            'custom': '4px', // ROUND_FOUR implementation
          }
        }
      }
    }
  </script>
<style data-purpose="custom-layout">
    body {
      background-color: #121212;
      color: #ffffff;
    }
    /* Subtle industrial wire mesh pattern overlay */
    .wire-mesh-bg {
      background-image: radial-gradient(circle, #f48c25 0.5px, transparent 0.5px);
      background-size: 30px 30px;
      opacity: 0.05;
    }
    .accent-gradient {
      background: linear-gradient(135deg, #f48c25 0%, #d6761a 100%);
    }
    .glass-effect {
      background: rgba(30, 30, 30, 0.8);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
  </style>
    <style>
        /* ensure dropdown text remains black even in dark mode */
        select.form-select {
            color: #000 !important;
            background-color: #fff !important;
        }
        select.form-select option {
            color: #000 !important;
        }
    </style>
</head>

<body class="font-sans antialiased min-h-screen flex items-center justify-center p-4 relative overflow-x-hidden">
<!-- background decorations -->
<div class="fixed inset-0 wire-mesh-bg pointer-events-none"></div>
<div class="fixed -top-24 -left-24 w-96 h-96 bg-brand/10 rounded-full blur-[120px] pointer-events-none"></div>
<div class="fixed -bottom-24 -right-24 w-96 h-96 bg-brand/5 rounded-full blur-[120px] pointer-events-none"></div>
    <?php
    if (isset($_SESSION["uid"]) && isset($_SESSION["user_type"]) && isset($_SESSION["session_id"])) {
        header("location:./index.php");
        exit;
    } else if ((isset($_POST['email'])) && isset($_POST['password']) && isset($_POST['submit'])) {
        // echo "<script>console.log('Form submitted');</script>";
        $pass = $_POST['password'];
        $user_type = $_POST['user_type'];
        // $salt = bin2hex(random_bytes(16));
        // $saltedPW =  $pass . $salt;
        // $hashedPW = hash('sha256', $saltedPW);
        // echo "<p style='color:red'>HashedPW: $hashedPW</p>";
        // echo "<p style='color:red'>salt: $salt</p>";
    
        if (isset($_POST['email'])) {
            $uniq_id = $_POST['email'];
            $sql = "SELECT * FROM users WHERE email = '$uniq_id' AND user_type = '$user_type';";
        }

        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {

            $salt = $row['salt'];
            $saltedPW = $pass . $salt;
            $hashedPW = hash('sha256', $saltedPW);
            if ($hashedPW == $row['password']) {

                $user_type = $row['user_type'];
                $email = $row["email"];
                $user_name = $row["user_name"];

                $charset = "QAZWSXEDCRFVTGBYHNUJMIKLOPqwertyuiopasdfghjklmnbvcxz1234567890";
                $session_id = "";
                for ($i = 0; $i < 25; $i++) {
                    $rand_int = rand(0, 61);
                    $session_id = $session_id . $charset[$rand_int];
                }
                $_SESSION["user_type"] = $user_type;
                $_SESSION["uid"] = $row['email'];
                $_SESSION["user_name"] = $row['user_name'];
                $_SESSION["session_id"] = $session_id;
                if (isset($_POST['remember'])) {
                    // Cookie valid for 30 days
                    setcookie("remember_email", $email, time() + (86400 * 30), "/");
                    setcookie("remember_pass", $pass, time() + (86400 * 30), "/");
                    setcookie("remember_type", $user_type, time() + (86400 * 30), "/");
                } else {
                    // Agar unchecked hai to delete kar do
                    setcookie("remember_email", "", time() - 3600, "/");
                    setcookie("remember_pass", "", time() - 3600, "/");
                    setcookie("remember_type", "", time() - 3600, "/");
                }
                header("Location:./Dashboard/");
                exit;


            } else {
                $_SESSION["uid_error"] = true;
                header('location:./login.php');
                exit;
            }
        } else {
            $_SESSION["uid_error"] = true;
            header('location:./login.php');
            exit;
        }
    }
    ?>
    <?php

    if (isset($_SESSION["already_error"])) {

        echo "<script>
                swal({
                    title: 'Login error',
                    text: 'Try again after few minutes',
                    icon: 'warning',
                    button: 'Ok'
                });
            </script>";
        unset($_SESSION["already_error"]);

    } else if (isset($_SESSION["uid_error"])) {

        echo "<script>
                swal({
                    title: 'INVALID CREDENTIAL',
                    text: 'The email Or password is wrong.',
                    icon: 'error',
                    button: 'Ok, understood!'
                });
            </script>";
        unset($_SESSION["uid_error"]);

    } else if (isset($_SESSION["something_went_wrong"])) {

        echo "<script>
                swal({
                    title: 'SOMETHING WENT WRONG!!',
                    text: 'Something went wrong \\n \\n Note: Please try again. Reload the page or clear the cache.',
                    icon: 'error',
                    button: 'Ok, understood!'
                });
            </script>";
        unset($_SESSION["something_went_wrong"]);

    }




    ?>
    <div class="container py-5">
        <div class="row align-items-start gy-4 pt-4">
            <div class="col-lg-6 pt-5">
                <h2 class="fw-bold mb-3">Welcome to Unnati Traders Management System</h2>
                <p>Access your dashboard to manage inventory, billing, and business operations efficiently.</p>
                <div class="login-box">
                    <ul class="process-list">
                        <h5>System Features:</h5>
                        <li>Comprehensive inventory management</li>
                        <li>GST & non-GST billing and invoicing</li>
                        <li>Financial tracking and reporting</li>
                        <li>Buy Now, Pay Later management</li>
                        <li>Supplier and distributor management</li>
                        <li>Real-time business analytics</li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-6 ">
                <div class="login-box">
                    <h4 class="fw-bold text-center">Login to Unnati Traders</h4>
                    <p class="text-center">Access your business management dashboard</p>

                    <form action="login.php" method="POST">
                        <div class="login-fields">
                            <label for="user_type">Login As</label>
                            <select name="user_type" id="user_type" class="form-select mb-3 text-black bg-white" required>
                                <option value="Admin" <?= (isset($_COOKIE['remember_type']) && $_COOKIE['remember_type'] == 'Admin') ? 'selected' : '' ?>>Admin</option>
                                <option value="Store" <?= (isset($_COOKIE['remember_type']) && $_COOKIE['remember_type'] == 'Store') ? 'selected' : '' ?>>Store</option>
                                <option value="Vendor" <?= (isset($_COOKIE['remember_type']) && $_COOKIE['remember_type'] == 'Vendor') ? 'selected' : '' ?>>Vendor</option>
                                <option value="Factory" <?= (isset($_COOKIE['remember_type']) && $_COOKIE['remember_type'] == 'Factory') ? 'selected' : '' ?>>Factory</option>
                            </select>
                            <label for="username">Email</label>
                            <input type="email" name="email" class="form-control mb-3" placeholder="Username"
                                value="<?= isset($_COOKIE['remember_email']) ? $_COOKIE['remember_email'] : '' ?>"
                                required>

                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control mb-3" placeholder="Password"
                                value="<?= isset($_COOKIE['remember_pass']) ? $_COOKIE['remember_pass'] : '' ?>"
                                required>

                            <div style="display: flex; justify-content: space-between;">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" style="border: 2px solid #ccc"
                                        id="dropdownCheck" name="remember" <?= isset($_COOKIE['remember_email']) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="dropdownCheck">Remember me</label>
                                </div>
                                <a href="./forgotpass.php">Forgot your password</a>
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-fancy mb-4" name="submit" type="submit">Login</button>
                            <!-- <p>Demo Logins:</p>
                        <p>Admin: admin@unnati.com / admin123</p>
                        <p>Retail Store: store@unnati.com / store123</p>
                        <p>Vendor: vendor@unnati.com / vendor123</p>
                        <p>Factory: factory@unnati.com / factory123</p> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>