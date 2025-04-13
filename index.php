<?php
session_start();
$errors = [
    'login' => isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '',
    'signup' => isset($_SESSION['signup_error']) ? $_SESSION['signup_error'] : ''
];
$activeForm = isset($_SESSION['active_form']) ? $_SESSION['active_form'] : 'login';
session_unset();

function showError($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sliding Login/Signup</title>
    <style>
        /* Reset Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Center Everything */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100vw;
            background: #f0f0f0;
            overflow: hidden;
        }

        /* Main Container */
        .container {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
            display: flex;
            flex-direction: row;
            transition: transform 1s ease-in-out;
        }

        /* Form Containers (Login & Signup) */
        .form-container {
            width: 50%;
            height: 100%;
            position: absolute;
            transition: transform 1s ease-in-out;
            background: white;
            padding: 40px;
        }

        /* Logo */
        .logo {
            width: 150px;
            height: 40px;
            padding-bottom: 20px;
        }

        /* Form Text */
        .p1 {
            font-size: 14px;
            color: black;
            opacity: 38%;
            padding-bottom: 10px;
            margin-top: 40px;
            margin-left: 90px;
        }

        .h11 {
            font-size: 24px;
            padding-bottom: 30px;
            margin-left: 90px;
        }

        /* Form Styling */
        form {
            display: flex;
            flex-direction: column;
            width: 100%;
            margin-left: 90px;
        }

        /* Input Fields */
        .input {
            max-width: 500px;
            width: 100%;
            height: 50px;
            padding-left: 15px;
            margin-top: 15px;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            border: none;
            font-size: 14px;
        }

        /* Password Input Container */
        .password-container {
            position: relative;
            width: 100%;
            max-width: 500px;
        }

        /* Toggle Password Icon */
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 60%;
            transform: translateY(-50%);
            cursor: pointer;
            width: 20px;
            height: 20px;
        }

        /* Button */
        .btn {
            max-width: 500px;
            width: 100%;
            height: 50px;
            margin-top: 50px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            border: none;
            background: #3498db;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .btn:hover {
            background: #2980b9;
        }

        /* Divider (OR Line) */
        .ordiv {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 35px;
        }

        .dashdiv {
            width: 200px;
            border-top: 1px solid black;
        }

        .paradiv {
            font-size: 10px;
            opacity: 60%;
            padding: 0 10px;
        }

        /* Social Media Login Buttons */
        .orLogin {
            max-width: 590px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            width: 100%;
            padding-left: 90px;
            gap: 20px;
        }

        /* Social Media Icon Containers */
        .logodiv {
            margin-top: 20px;
            width: 80px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            /*box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);*/
            border: 1px solid #e5e7eb;
            padding: 2px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .logodiv:hover {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            transform: scale(1.05);
        }
        .logodiv img {
            width: 30px;
            height: auto;
            object-fit: contain;
        }

        /* Bottom Text (Login/Signup Toggle) */
        .p2 {
            font-size: 15px;
            position: absolute;
            left: 30px;
            bottom: 20px;
            cursor: pointer;
        }

        /* Login Form (Initially Visible) */
        #login-form {
            left: 0;
            transform: translateX(0%);
            z-index: 2;
        }

        /* Signup Form (Initially Hidden) */
        #signup-form {
            left: 50%;
            transform: translateX(100%);
            z-index: 2;
        }

        /* Overlay Container (Background Image) */
        .overlay-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: transform 1s ease-in-out;
            z-index: 3;
        }

        /* Background Image with Fading Effect */
        .overlay {
            background-image: url("cbum.jpg");
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            transition: opacity 0.5s linear;
            opacity: 1;
        }

        /* Active State: Sliding and Background Fading */
        .container.active .overlay-container {
            transform: translateX(-100%);
        }

        .container.active #login-form {
            transform: translateX(-100%);
        }

        .container.active #signup-form {
            transform: translateX(0%);
        }

        /* Link Styling */
        .link {
            margin-top: 10px;
            color: #3498db;
            cursor: pointer;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                width: 100%;
                height: 100vh;
            }

            .form-container, .overlay-container {
                width: 100%;
                height: 100%;
                position: absolute;
            }

            #signup-form, #login-form {
                left: 0;
                transform: translateX(0%);
            }

            .overlay-container {
                display: none;
            }

            .input, .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container" id="container">
        <!-- Login Form (Initially Visible) -->
        <div class="form-container <?= isActiveForm('login',$activeForm);?>" id="login-form">
            <img src="logo.jpg" alt="logo" class="logo">
            <p class="p1">Start your transformation</p>
            <h1 class="h11">Sign In to Iron Core</h1>
            <form action="login_register.php" method="post">
                <?=showError($errors['login']); ?>
                <input class="input" type="email" name="email" placeholder="Email" required>
                <div class="password-container">
                    <input class="input" id="login-password" name="password" type="password" placeholder="Password" required>
                    <img src="eye-open.png" alt="Toggle Password" class="toggle-password" onclick="togglePassword('login-password', this)">
                </div>
                <button type="submit" name="login" class="btn" >Login</button>
            </form>
            <div class="ordiv">
                <div class="dashdiv"></div>
                <div class="paradiv">or sign up with</div>
                <div class="dashdiv"></div>
            </div>
            <div class="orLogin">
                <div class="logodiv"><img src="facebook_logo.jpg" alt="facebook_logo"></div>
                <div class="logodiv"><img src="google_logo.jpg" alt="google_logo"></div>
                <div class="logodiv"><img src="apple_logo.jpg" alt="apple_logo"></div>
            </div>
    
            <p class="p2">Dont have an account? <span class="link" onclick="toggleForm()">Sign Up</span></p>
        </div>  

        <!-- Signup Form (Initially Hidden) -->
        <div class="form-container <?= isActiveForm('signup',$activeForm);?>" id="signup-form">
            <img src="logo.jpg" alt="logo" class="logo">
            <p class="p1">Start your transformation</p>
            <h1 class="h11">Sign Up to Iron Core</h1>
            <form action="login_register.php" method="post">
                <?= showError($errors['signup']); ?>
                <input class="input" type="text" name="name" placeholder="Your Name">
                <input class="input" type="Email" name="email" placeholder="Email">
                <div class="password-container">
                    <input class="input" id="signup-password" type="password" name="password" placeholder="Password">
                    <img src="eye-open.png" alt="Toggle Password" class="toggle-password" onclick="togglePassword('signup-password', this)">
                </div>
                <button type="submit" class="btn" name="signup">Sign Up</button>
            </form>
            <div class="ordiv">
                <div class="dashdiv"></div>
                <div class="paradiv">or sign up with</div>
                <div class="dashdiv"></div>
            </div>
            <div class="orLogin">
                <div class="logodiv"><img src="facebook_logo.jpg" alt="facebook_logo"></div>
                <div class="logodiv"><img src="google_logo.jpg" alt="google_logo"></div>
                <div class="logodiv"><img src="apple_logo.jpg" alt="apple_logo"></div>
            </div>
    
            <p class="p2">Have an account? <span class="link" onclick="toggleForm()"> Login</span></p> 
        </div>

        <!-- Sliding Blue Overlay -->
        <div class="overlay-container" id="overlay">
            <div class="overlay"></div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const bgImage = document.querySelector(".overlay");
            const container = document.getElementById("container");
            let loginImage = true;
            let isAnimating = false;

            function toggleForm() {
                if (isAnimating) return;
                isAnimating = true;
                
                container.classList.toggle("active");
                
                const totalDuration = 1000;
                const fadeOutDuration = 500;
                const fadeInDuration = 500;
                
                bgImage.style.transition = `opacity ${fadeOutDuration}ms linear`;
                bgImage.style.opacity = "0";
                
                setTimeout(() => {
                    if (loginImage) {
                        bgImage.style.backgroundImage = "url('cbum2.png')";
                    } else {
                        bgImage.style.backgroundImage = "url('cbum.jpg')";
                    }
                    
                    bgImage.style.transition = `opacity ${fadeInDuration}ms linear`;
                    setTimeout(() => {
                        bgImage.style.opacity = "1";
                    }, 10);
                    
                }, fadeOutDuration);
                
                setTimeout(() => {
                    isAnimating = false;
                    loginImage = !loginImage;
                }, totalDuration);
            }

            // Toggle password visibility
            window.togglePassword = function(inputId, icon) {
                const passwordInput = document.getElementById(inputId);
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    icon.src = "eye-closed.png";
                } else {
                    passwordInput.type = "password";
                    icon.src = "eye-open.png";
                }
            }

            // Attach event listeners
            document.querySelectorAll(".link").forEach((link) => {
                link.addEventListener("click", toggleForm);
            });
        });
    </script>
</body>
</html>