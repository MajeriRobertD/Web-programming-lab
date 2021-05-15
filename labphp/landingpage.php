<?php include 'index.html';?>



<html>
  <head>
    <script src="script.js" async></script>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="style.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <!-- Load an icon library to show a hamburger menu (bars) on small screens -->

    <div class="bg">
      <div class="hero-text">
        <h1>Welcome to your URL managing system</h1>
        <p>Please log in or create an account to continue</p>
        <button type="button"  class="btn btn-success login-btn" ><a href="login.php">Login</a></button>
      </div>
    </div>
  </body>
</html>
