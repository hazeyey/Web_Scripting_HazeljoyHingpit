<?php
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm = $_POST["confirm"];
    $gender = $_POST["gender"] ?? "";
    $hobbies = isset($_POST["hobbies"]) ? implode(",", $_POST["hobbies"]) : "";
    $country = $_POST["country"];

    // check if passwords match
    if ($password !== $confirm) {
        $message = "❌ Passwords do not match.";
    } else {
        // check duplicate username
        $users = file("users.txt", FILE_IGNORE_NEW_LINES);
        $exists = false;
        foreach ($users as $user) {
            list($fn, $em, $un, $pw) = explode("|", $user);
            if ($un == $username) {
                $exists = true;
                break;
            }
        }

        if ($exists) {
            $message = "❌ Username already exists!";
        } else {
            $data = "$fullname|$email|$username|$password|$gender|$hobbies|$country\n";
            file_put_contents("users.txt", $data, FILE_APPEND);
            $message = "✅ Registration successful! You can now login.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel="stylesheet" href="css/register_style.css">
</head>
<body>
  <div class="container">

    <!-- Left side -->
    <div class="welcome">
      <h1>WELCOME</h1>
      <h3>Join us today!</h3>
      <p>Create your account and start your journey with us.</p>
    </div>

    <!-- Right side -->
    <div class="form-card">
      <?php if ($message): ?>
        <div class="message"><?= $message ?></div>
      <?php endif; ?>

      <h2>Register</h2>
      <form method="POST">
        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm" placeholder="Confirm Password" required>

        <div class="form-sections">


        <!-- Gender -->
<div class="form-group">
  <label class="section-title">Gender</label>
  <div class="options">
    <label><input type="radio" name="gender" value="Male"> Male</label>
    <label><input type="radio" name="gender" value="Female"> Female</label>
  </div>
</div>

<!-- Hobbies -->
<div class="form-group">
  <label class="section-title">Hobbies</label>
  <div class="options">
    <label><input type="checkbox" name="hobby" value="Reading"> Reading</label>
    <label><input type="checkbox" name="hobby" value="Sports"> Sports</label>
    <label><input type="checkbox" name="hobby" value="Music"> Music</label>
    <label><input type="checkbox" name="hobby" value="Traveling"> Traveling</label>
  </div>
</div>



        <button type="submit">Register</button>
      </form>

      <p class="switch">Already have an account? <a href="login.php">Login</a></p>
    </div>
  </div>
</body>
</html>
