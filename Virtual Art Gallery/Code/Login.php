<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css">
  <title>Login</title>
</head>
<body>
<?php
    include_once "header.php" 
      ?>
<main>
  <div class="container">
    <h2>Login</h2>
      <form action="loginh.inc.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="pwd">Password:</label>
        <input type="password" id="pwd" name="pwd" required><br>

        <button type="submit">Login</button>
      </form>
    
  </div>
</main>

<?php include 'footer.php'; ?>
</body>
</html>