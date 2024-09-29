<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register an Account</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <div class="box form-box">
    <?php

      include("config.php");
      
      if(isset($_POST['submit'])){  
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $password = password_hash($_POST['pass'], PASSWORD_BCRYPT);

        $verify_query = mysqli_query($con, "SELECT Username FROM users WHERE Username='$username'");

        if(mysqli_num_rows($verify_query) != 0) {
          echo "<div class='message'>
                <p>This username is already taken, try another.</p>
                </div><br>";
          echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
        } else {
            mysqli_query($con, "INSERT INTO users(Username,Password) VALUES('$username', '$password')") or die("An error occurred.");

            echo "<div class='messageTrue'>
                <p>Registered Successfully!</p>
                </div> <br>";
            echo "<a href='login.php'><button class='btn'>Login Now</button>";
        }
      } else {
    ?>
      <header>Sign Up</header>
      <form action="" method="post"> 
        <div class="field input">
          <input type="text" name="username" id="username" class="pholder" placeholder="Username" required> <i class='bx bxs-user'></i> 
        </div>

        <div class="field input">
          <input type="password" name="pass" id="pass" class="pholder" placeholder="Password" required> <i class='bx bxs-lock-alt' ></i>
        </div>

        <div class="field">
          <input type="submit" class="btn" name="submit" value="REGISTER">
        </div>

        <div class="links">
          Already a member? <a href="login.php" style="margin-left: 5px;"> Login Now!</a>
        </div>
      </form> 
    </div>
    <?php } ?>
  </div>
</body>
</html>
