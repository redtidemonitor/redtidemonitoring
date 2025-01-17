<?php
  session_start();  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Algal Bloom Monitoring</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="style.css">
</head>
<body style="background-image: url('algae.png');">
  <div class="container">
    <div class="box form-box">
      <?php
        include("config.php");

        if (isset($_POST['submit'])) {
          $username = mysqli_real_escape_string($con, $_POST['username']);
          $password = mysqli_real_escape_string($con, $_POST['pass']);

          
          $stmt = mysqli_prepare($con, "SELECT * FROM users WHERE Username=?");
          mysqli_stmt_bind_param($stmt, "s", $username);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);

          $row = mysqli_fetch_assoc($result);

          if ($row) {
            if (password_verify($password, $row['Password'])) {
              $_SESSION['valid'] = $row['Username'];
              $_SESSION['pass'] = $row['Password'];

              header("Location: navigation/main.html");
              exit();
            } else {
              echo "<div class='message'>
                      <p>Invalid Password.</p>
                    </div> <br>";
              echo "<button class='btn' onclick='history.back()'>Go Back</button>";
            }
          } else {
            echo "<div class='message'>
                    <p>Invalid Username.</p>
                  </div><br>";
            echo "<button class='btn' onclick='history.back()'>Go Back</button>";
          }
        } else {
      ?>
      <header>Login</header>
      <form action="" method="post">
        <div class="field input">
        <i class='bx bxs-user'></i>
          <input type="text" name="username" id="username" class="pholder" placeholder="Username" required> 
        </div>

        <div class="field input">
          <input type="password" name="pass" id="pass" class="pholder" placeholder="Password" required> <i class='bx bxs-lock-alt' ></i>
        </div>

        <div class="field">
          <input type="submit" class="btn" name="submit" value="LOGIN">
        </div>

        <div class="links">
          Don't have an account?<a href="register.php" style="margin-left: 5px;"> Sign Up Now!</a>
        </div>
      </form>
    </div>
    <?php } ?>
  </div>
</body>
</html>
