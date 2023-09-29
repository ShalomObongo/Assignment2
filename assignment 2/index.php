<?php
require_once('DBconnect.php');

$logname = $logemail = $logpass = '';
$errors = array();


if (isset($_POST['signup'])) {
    
    $logname = $_POST['logname'];
    $logemail = $_POST['logemail'];
    $logpass = $_POST['logpass'];

    if (empty($logname)) {
        $errors[] = 'Full Name is required.';
    }
    if (empty($logemail)) {
        $errors[] = 'Email is required.';
    }
    if (empty($logpass)) {
        $errors[] = 'Password is required.';
    }

    if (empty($errors)) {
        try {
            
            $hashed_password = md5($logpass);

            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$logname, $logemail, $hashed_password]);

            header("Location: home.php");

        } catch (PDOException $e) {
            $errors[] = 'Error: ' . $e->getMessage();
        }
    }
}


if (isset($_POST['login'])) {
    // Retrieve user input from the login form
    $logemail = $_POST['logemail'];
    $logpass = $_POST['logpass'];

    // Validate user input
    if (empty($logemail)) {
        $errors[] = 'Email is required for login.';
    }
    if (empty($logpass)) {
        $errors[] = 'Password is required for login.';
    }

    
    if (empty($errors)) {
        try {
            // Hash the password
            $hashed_password = md5($logpass);

            
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
            $stmt->execute([$logemail, $hashed_password]);
            $user = $stmt->fetch();

            if ($user) {
                
                header("Location: home.php");
            } else {
                
                $errors[] = 'Incorrect email or password. Please try again.';
            }

        } catch (PDOException $e) {
            $errors[] = 'Error: ' . $e->getMessage();
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