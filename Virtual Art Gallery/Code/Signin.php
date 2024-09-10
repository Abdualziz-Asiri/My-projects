<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css">
  <title>Registration</title>
</head>
<body>
<?php
    include_once "header.php" 
      ?>
<main>
  <div class="container">
    <h2>Registration</h2>
    <form action="register.php" method="POST">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required><br>
      
      <label for="pwd">Password:</label>
      <input type="password" id="pwd" name="pwd" required><br>

      <label for="nam">Name:</label>
      <input type="text" id="nam" name="nam" required><br>
      
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required><br>
      
      <label for="addres">Address:</label>
      <input type="text" id="addres" name="addres" required><br>

      <label for="typ">User Type:</label>
      <select id="typ" name="typ" required>
        <option value="Artist">Artist</option>
        <option value="Art_enthusiast">Art_enthusiast</option>
      </select><br>

      <label for="bio">Bio:</label>
      <textarea id="bio" name="bio" ></textarea><br>
      
      <button type="submit">Register</button>
    </form>
  </div>
</main>

<footer>
<?php include 'footer.php'; ?>
</footer>
<script src="jscodes.js"></script>
</body>
</html>