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

<script>
  // Timer for Pop Up Message
  setTimeout(function() {
    let msg = document.getElementById("popupMessage");
    if (msg) {
      msg.style.transition = "opacity 0.5s";
      msg.style.opacity = "0";              

      setTimeout(() => msg.remove(), 500);   
    }
  }, 3000); 
</script>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="css\login_style.css">
</head>
<body>
  <div class="container">
    
    <!-- Welcome -->
    <div class="welcome">
      <img src="logo.png" alt="Welcome Illustration" class="welcome-img">
    </div>

    <!-- Pop Up Message -->
    <div class="form-card">
      <?php if ($message): ?>
        <div class="message" id="popupMessage"><?= $message ?></div>
      <?php endif; ?>

    <!-- Login Form -->
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
