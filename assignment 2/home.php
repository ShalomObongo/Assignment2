<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Welcome to My Website</title>
    <link rel="stylesheet" href="style2.css"> 
    <link rel="stylesheet" href="style.css">
    <style>
        
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Welcome to My Website</h1>
            <nav>
            <ul style="list-style: none;">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
    <main>
        <section class="container">
            <h2>About Us</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed suscipit ante a velit accumsan, eget elementum dolor malesuada.</p>
        </section>
        
        <section class="container">
            <h2>Our Services</h2>
            <ul style="list-style: none;" class="centered">
                <li>Service 1</li>
                <li>Service 2</li>
                <li>Service 3</li>
            </ul>
        </section>
        
        <a href="index.php" class="logout-button">Logout</a>
    </main>
    
    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> My Website</p>
        </div>
    </footer>
</body>
</html>

