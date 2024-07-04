<?php
// Static variables
$user = 'admin';
$pass = md5('admin');

// Start session
session_start();

// Check login via cookie
if (isset($_COOKIE['login'])) {
    if ($_COOKIE['login'] == $user) {
        // If valid, set session login
        $_SESSION['login'] = TRUE;
        $_SESSION['username'] = $user;
        header('Location: ./home.php');
        exit();
    }
}

// Retrieve saved username and remember status from cookies if they exist
$saved_username = isset($_COOKIE['saved_username']) ? $_COOKIE['saved_username'] : '';
$saved_remember = isset($_COOKIE['saved_remember']) && $_COOKIE['saved_remember'] == 'true' ? 'checked' : '';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login Remember Me</title>
</head>
<body>
<form action="aksi.php" method="post">
    <p>
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($saved_username); ?>" />
    </p>
    <p>
        <label for="password">Password:</label>
        <input type="password" name="password" />
    </p>
    <p>
        <label for="remember">
            <input type="checkbox" name="remember" value="true" <?php echo $saved_remember; ?> /> Remember Me
        </label>
    </p>
    <p>
        <button type="submit" name="login">Login</button>
        <button type="reset" name="reset">Reset</button>
    </p>
</form>
</body>
</html>