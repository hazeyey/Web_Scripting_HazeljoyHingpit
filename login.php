<?php
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $users = file("users.txt", FILE_IGNORE_NEW_LINES);
    $found = false;

    foreach ($users as $user) {
        list($fn, $em, $un, $pw) = explode("|", $user);
        if ($un == $username && $pw == $password) {
            $found = true;
            break;
        }
    }
    $message = $found ? "🎉 Welcome back, $username!" : "❌ Invalid login.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="css\login_style.css">
</head>
<body>
  <div class="container">

    <!-- Left side -->
    <div class="welcome">
      <h1>WELCOME</h1>
      <h3>Glad to see you again!</h3>
      <p>Login to continue exploring awesome features with us.</p>
    </div>

    <!-- Right side -->
    <div class="form-card">
      <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
      <?php endif; ?>

      <h2>Sign In</h2>
      <form method="POST">
        <input type="text" name="username" placeholder="User Name" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Sign In</button>
      </form>

      <p class="switch">Don’t have an account? <a href="register.php">Register</a></p>
    </div>
  </div>
</body>
</html>
