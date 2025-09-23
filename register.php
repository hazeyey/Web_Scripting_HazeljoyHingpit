<?php
$file = "users.txt";
$message = "";

if (isset($_POST['register'])) {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm_password']);
    $gender = $_POST['gender'] ?? "";
    $hobbies = isset($_POST['hobbies']) ? implode(", ", $_POST['hobbies']) : "";
    $country = $_POST['country'];

    if (empty($fullname) || empty($email) || empty($username) || empty($password) || empty($confirm)) {
        $message = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format!";
    } elseif ($password !== $confirm) {
        $message = "Passwords do not match!";
    } else {
        $duplicate = false;
        if (file_exists($file)) {
            $users = file($file, FILE_IGNORE_NEW_LINES);
            foreach ($users as $user) {
                $data = explode("|", $user);
                if ($data[2] === $username) {
                    $duplicate = true;
                    break;
                }
            }
        }
        if ($duplicate) {
            $message = "Username already taken!";
        } else {
            $userData = "$fullname|$email|$username|$password|$gender|$hobbies|$country\n";
            file_put_contents($file, $userData, FILE_APPEND);
            $message = "Registration successful! <a href='login.php'>Login here</a>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* Add vertical divider */
    .form-divider {
      width: 2px;
      background: #000;
      margin: 0 15px;
    }
  </style>
</head>
<body>
<div class="container">
  <?php if (!empty($message)) : ?>
    <div class="message"><?= $message ?></div>
  <?php endif; ?>

  <form id="registerForm" method="POST" class="registerForm">
    <h2 style="width:100%;text-align:center;">Register</h2>
    <div style="display:flex; gap:30px;">
      
      <!-- Left -->
      <div class="form-left">
        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>

        <label>Gender:</label>
        <label><input type="radio" name="gender" value="Male" required> Male</label>
        <label><input type="radio" name="gender" value="Female"> Female</label>
      </div>

      <!-- Divider (vertical line) -->
      <div class="form-divider"></div>

      <!-- Right -->
      <div class="form-right">
        <label>Hobbies:</label>
        <label><input type="checkbox" name="hobbies[]" value="Sports"> Sports</label>
        <label><input type="checkbox" name="hobbies[]" value="Music"> Music</label>
        <label><input type="checkbox" name="hobbies[]" value="Reading"> Reading</label>
        <label><input type="checkbox" name="hobbies[]" value="Dancing"> Dancing</label>
        <label><input type="checkbox" name="hobbies[]" value="Singing"> Singing</label>
        <label><input type="checkbox" name="hobbies[]" value="Movies/Drama"> Movies/Drama</label>
        


        <hr class ="divider">

        <label>Country:</label>
        <select name="country" required>
          <option value="">--Select Country--</option>
          <option>Philippines</option>
          <option>USA</option>
          <option>UK</option>
        </select>
      </div>
    </div>

    <div class="form-actions">
      <button type="submit" name="register">Register</button>
      <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
  </form>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', function(e) {
  let pwd = this.password.value;
  let cpwd = this.confirm_password.value;
  if (pwd !== cpwd) {
    e.preventDefault();
    alert("Passwords do not match!");
  }
});
</script>
</body>
</html>
