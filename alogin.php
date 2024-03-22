<?php
$errors = array();
session_start();
$err = '';
require("db.php");

if (isset($_POST['adminLogin'])) {
  $adminUsername = mysqli_real_escape_string($db, $_POST['adminUsername']);
  $adminPassword = mysqli_real_escape_string($db, $_POST['adminPassword']);

  $res = mysqli_query($db, "select * from admin where username='$adminUsername'");
  $check = mysqli_num_rows($res);
  if ($check > 0) {
    $row = mysqli_fetch_assoc($res);
    $dbpassword = $row['password'];

    if ($password = $dbpassword) {
      $box = $_SESSION['username'] = $adminUsername;
      setcookie('uname', $box, time() + (48 * 60 * 60));
      header("location: ./allot.php");
      $arr = array('Status' => 'Login Success', 'Success Message' => 'Login Successfuly, Please Wait to Redirect....');
    } else {
      $arr = array('Status' => 'Login Failed', 'Error Message' => 'Please enter correct password');
    }
  } else {
    $arr = array('Status' => 'Login Failed', 'Error Message' => 'Please enter correct Roll no');
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Housekeeper Admin Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
    /* CSS Styles */

    @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

    * {
        box-sizing: border-box;
    }

    body {
        background-image: url('assets/imgs/p.jpg');

        background-repeat: no-repeat;
        background-size: 2000px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        font-family: 'Montserrat', sans-serif;
        height: 100vh;
        margin: -20px 0 50px;
    }

    h1 {
        font-weight: bold;
        margin: 0;
    }

    h2 {
        text-align: center;
    }

    .link a {
        color: white;
        /* Change this color to the desired color */
    }

    p {
        font-size: 14px;
        font-weight: 100;
        line-height: 20px;
        letter-spacing: 0.5px;
        margin: 20px 0 30px;
    }

    span {
        font-size: 12px;
    }

    a {
        color: #333;
        font-size: 14px;
        text-decoration: none;
        margin: 15px 0;
    }

    button {
        border-radius: 20px;
        border: 1px solid #FF4B2B;
        background-color: #FF4B2B;
        color: white;
        font-size: 12px;
        font-weight: bold;
        padding: 12px 45px;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: transform 80ms ease-in;
    }

    button:active {
        transform: scale(0.95);
    }

    button:focus {
        outline: none;
    }

    button.ghost {
        background-color: transparent;
        border-color: #FFFFFF;
    }

    form {
        background-color: #d7a2d5;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 50px;
        height: 100%;
        text-align: center;
    }

    input {
        background-color: white;
        border: none;
        padding: 12px 15px;
        margin: 8px 0;
        width: 100%;
    }

    .container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
        position: relative;
        overflow: hidden;
        width: 768px;
        max-width: 100%;
        min-height: 480px;
    }

    .log-in-container h1 {
        font-size: 28px;
        /* Adjust the font size as needed */
    }

    .overlay-right h1 {
        font-size: 28px;
        /* Adjust the font size as needed */
    }

    .form-container {
        position: absolute;
        top: 0;
        height: 100%;
        transition: all 0.6s ease-in-out;
    }

    .log-in-container {
        left: 0;
        width: 50%;
        z-index: 2;
    }

    .container.right-panel-active .sign-in-container {
        transform: translateX(100%);
    }

    .sign-up-container {
        left: 0;
        width: 50%;
        opacity: 0;
        z-index: 1;
    }

    .container.right-panel-active .sign-up-container {
        transform: translateX(100%);
        opacity: 1;
        z-index: 5;
        animation: show 0.6s;
    }

    @keyframes show {

        0%,
        49.99% {
            opacity: 0;
            z-index: 1;
        }

        50%,
        100% {
            opacity: 1;
            z-index: 5;
        }
    }

    .overlay-container {
        position: absolute;
        top: 0;
        left: 50%;
        width: 50%;
        height: 100%;
        overflow: hidden;
        transition: transform 0.6s ease-in-out;
        z-index: 100;
    }

    .container.right-panel-active .overlay-container {
        transform: translateX(-100%);
    }

    .overlay {
        background: #FF416C;
        background: -webkit-linear-gradient(to right, #0cdc25, #28ce1f);
        background: linear-gradient(to right, #86d672, #27e00e);
        background-repeat: no-repeat;
        background-size: cover;
        background-position: 0 0;
        color: #000000;
        position: relative;
        left: -100%;
        height: 100%;
        width: 200%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .container.right-panel-active .overlay {
        transform: translateX(50%);
    }

    .overlay-panel {
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        padding: 0 40px;
        text-align: center;
        top: 0;
        height: 100%;
        width: 50%;
        transform: translateX(0);
        transition: transform 0.6s ease-in-out;
    }

    .overlay-left {
        transform: translateX(-20%);
    }

    .container.right-panel-active .overlay-left {
        transform: translateX(0);
    }

    .overlay-right {
        right: 0;
        transform: translateX(0);
    }

    .container.right-panel-active .overlay-right {
        transform: translateX(20%);
    }

    .social-container {
        margin: 20px 0;
        color: #f4f1f0;

    }

    .social-container a {
        border: 2px solid white;
        border-radius: 90%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        margin: 0 5px;
        height: 40px;
        width: 40px;
    }

    .link {
        font-weight: bold;
        color: white;

    }

    footer {
        background-color: #222;
        color: #fff;
        font-size: 14px;
        bottom: 0;
        position: fixed;
        left: 0;
        right: 0;
        text-align: center;
        z-index: 999;
    }

    footer p {
        margin: 10px 0;
    }

    footer i {
        color: red;
    }

    footer a {
        color: #3c97bf;
        text-decoration: none;
    }
    </style>



<body>
    <header>
        <div class="container" id="container">
            <div class="form-container sign-up-container">
                <form action="#">
                    <h1 style="font-size: 30px;">Create Account</h1>
                    <div class="social-container"><a href="#" class="social"><i class="fab fa-facebook-f"></i></a><a
                            href="#" class="social"><i class="fab fa-google-plus-g"></i></a><a href="#"
                            class="social"><i class="fab fa-linkedin-in"></i></a></div><span>or use your email for
                        registration</span><input type="text" placeholder="Name" /><input type="email"
                        placeholder="[Email]" /><input type="password" placeholder="[Password]" /><button>Sign
                        Up</button>
                </form>
            </div>
            <div class="form-container log-in-container">
                <form action="#">
                    <h1>Login <img src="assets/imgs/logo.png" width="50" height="50" style="vertical-align: top "></h1>
                    <div class="social-container"><a href="#" class="social"><i class="fab fa-facebook-f"></i></a><a
                            href="#" class="social"><i class="fab fa-google-plus-g"></i></a><a href="#"
                            class="social"><i class="fab fa-linkedin-in"></i></a></div><span>or use your
                        account</span><input type="email" placeholder="Email" /><input type="password"
                        placeholder="Password" /><a href="#">Forgot your password?</a><button>Log in</button>
                </form>
            </div>
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-left">
                        <h1 style="font-size: 30px;">Welcome Admin !</h1>
                        <p>To keep connected with us please Login with your personal info</p><button class="ghost"
                            id="login">Login</button>
                    </div>
                    <div class="overlay-panel overlay-right">
                        <h1 style="font-size: 30px;">Hello,
                            Admin !</h1>
                        <p>Enter your personal details and start journey with us</p><button class="ghost"
                            id="signUp">Sign Up</button>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <footer>
        <p>Welcome to KIIT HOSTEL MANAGEMENT SYSTEM <a href='https://kiit.ac.in/'>Learn More</a></p>
    </footer>
    <p class="link">or <a href="login.php">Student Login</a></p>

    <script>
    // JavaScript
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('login');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
            container.classList.add("right-panel-active");
        }

    );

    signInButton.addEventListener('click', () => {
            container.classList.remove("right-panel-active");
        }

    );
    </script>
</body>

</html>