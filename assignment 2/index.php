<?php
require_once('DBconnect.php'); // Include the database connection file

// Initialize variables for storing user input and error messages
$logname = $logemail = $logpass = '';
$errors = array();

// Check if the signup form is submitted
if (isset($_POST['signup'])) {
    // Retrieve user input from the signup form
    $logname = $_POST['logname'];
    $logemail = $_POST['logemail'];
    $logpass = $_POST['logpass'];

    // Validate user input (you can add more validation as needed)
    if (empty($logname)) {
        $errors[] = 'Full Name is required.';
    }
    if (empty($logemail)) {
        $errors[] = 'Email is required.';
    }
    if (empty($logpass)) {
        $errors[] = 'Password is required.';
    }

    // If there are no validation errors, insert user data into the database
    if (empty($errors)) {
        try {
            // Hash the password for security (you should use password_hash() in production)
            $hashed_password = md5($logpass); // Note: MD5 is not a secure password hashing method, use password_hash().

            // Create a prepared statement to insert user data
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$logname, $logemail, $hashed_password]);

            // Redirect to the home page or display a success message
            header("Location: home.php"); // Replace 'home.php' with your actual home page

        } catch (PDOException $e) {
            $errors[] = 'Error: ' . $e->getMessage(); // Handle any database errors
        }
    }
}

// Check if the login form is submitted
if (isset($_POST['login'])) {
    // Retrieve user input from the login form
    $logemail = $_POST['logemail'];
    $logpass = $_POST['logpass'];

    // Validate user input (you can add more validation as needed)
    if (empty($logemail)) {
        $errors[] = 'Email is required for login.';
    }
    if (empty($logpass)) {
        $errors[] = 'Password is required for login.';
    }

    // If there are no validation errors, check user credentials
    if (empty($errors)) {
        try {
            // Hash the password for comparison (you should use password_verify() in production)
            $hashed_password = md5($logpass); // Note: MD5 is not a secure password hashing method, use password_verify().

            // Create a prepared statement to fetch user data by email and password
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
            $stmt->execute([$logemail, $hashed_password]);
            $user = $stmt->fetch();

            if ($user) {
                // User credentials are correct, redirect to the home page
                header("Location: home.php"); // Replace 'home.php' with your actual home page
            } else {
                // Display an error message if credentials are incorrect
                $errors[] = 'Incorrect email or password. Please try again.';
            }

        } catch (PDOException $e) {
            $errors[] = 'Error: ' . $e->getMessage(); // Handle any database errors
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div class="container">
        <div class="section">
            <div class="container">
                <div class="row full-height justify-content-center">
                    <div class="col-12 text-center align-self-center py-5">
                        <div class="section pb-5 pt-5 pt-sm-2 text-center">
                            <h6 class="mb-0 pb-3"><span>Log In </span><span>Sign Up</span></h6>
                            <input class="checkbox" type="checkbox" id="reg-log" name="reg-log" />
                            <label for="reg-log"></label>
                            <div class="card-3d-wrap mx-auto">
                                <div class="card-3d-wrapper">
                                    <div class="card-front">
                                        <div class="center-wrap">
                                            <div class="section text-center">
                                                <h4 class="mb-4 pb-3">Log In</h4>
                                                <form method="post" action="">
                                                    <!-- Empty action to submit to the same page -->
                                                    <div class="form-group">
                                                        <input type="email" name="logemail" class="form-style"
                                                            placeholder="Your Email" id="logemail"
                                                            autocomplete="off" />
                                                        <i class="input-icon uil uil-at"></i>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <input type="password" name="logpass" class="form-style"
                                                            placeholder="Your Password" id="logpass"
                                                            autocomplete="off" />
                                                        <i class="input-icon uil uil-lock-alt"></i>
                                                    </div>
                                                    <button type="submit" class="btn mt-4" name="login">Submit</button>
                                                </form>
                                                <p class="mb-0 mt-4 text-center"><a href="#0" class="link">Forgot your
                                                        password?</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-back">
                                        <div class="center-wrap">
                                            <div class="section text-center">
                                                <h4 class="mb-4 pb-3">Sign Up</h4>
                                                <form method="post" action="">
                                                    <!-- Empty action to submit to the same page -->
                                                    <div class="form-group">
                                                        <input type="text" name="logname" class="form-style"
                                                            placeholder="Your Full Name" id="logname"
                                                            autocomplete="off" />
                                                        <i class="input-icon uil uil-user"></i>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <input type="email" name="logemail" class="form-style"
                                                            placeholder="Your Email" id="logemail" autocomplete="off" />
                                                        <i class="input-icon uil uil-at"></i>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <input type="password" name="logpass" class="form-style"
                                                            placeholder="Your Password" id="logpass"
                                                            autocomplete="off" />
                                                        <i class="input-icon uil uil-lock-alt"></i>
                                                    </div>
                                                    <button type="submit" class="btn mt-4" name="signup">Submit</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Display error messages, if any -->
                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger mt-4">
                                    <ul>
                                        <?php foreach ($errors as $error): ?>
                                            <li>
                                                <?php echo $error; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>