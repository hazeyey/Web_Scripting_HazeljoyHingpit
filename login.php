<?php
$file = "users.txt";
$message = "";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $message = "Both fields are required!";
    } elseif (!file_exists($file)) {
        $message = "No registered users yet!";
    } else {
        $users = file($file, FILE_IGNORE_NEW_LINES);
        $found = false;
        foreach ($users as $user) {
            $data = explode("|", $user);
            if ($data[2] === $username && $data[3] === $password) {
                $found = true;
                break;
            }
        }
        $message = $found ? "🎉 Welcome, $username!" : "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <?php if (!empty($message)) : ?>
    <div class="message"><?= $message ?></div>
  <?php endif; ?>

  <form id="loginForm" method="POST">
    <h2>Login</h2>
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
    <p>Don’t have an account? <a href="register.php">Register</a></p>
  </form>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
  let user = this.username.value.trim();
  let pass = this.password.value.trim();
  if (!user || !pass) {
    e.preventDefault();
    alert("Both fields are required!");
  }
});
</script>
</body>
</html>
