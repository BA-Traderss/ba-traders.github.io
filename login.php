<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <title>Customer Login Form</title>
</head>

<body>
  <div class="contact">
    <div class="row">
      <div class="col-md-9">
        <div>
          <form method="post" action="">
            <div class="form-floating mb-3">
              <label for="login_name">Enter a Username</label>
              <input type="text" class="form-control rounded-4" id="login_name" placeholder="Enter Username" name="login_name">
              <span class="field_error" id="login_name_error"></span>
            </div>

            <div class="form-floating mb-3">
              <label for="login_password">Enter a Password</label>
              <input type="password" class="form-control rounded-4" id="login_password" placeholder="Password" name="login_password">
              <span class="field_error" id="login_password_error"></span>
            </div>
            <div class="text-center">
              <button class="w-100 mb-2 btn btn-lg rounded-4 btn-primary" onclick="user_login()" type="button" name="submit">Login</button>
            </div>
            <hr class="my-4">
          </form>
          <div class="form-output login-msg">
            <p class="form-message field_error"></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="js/main.js"></script>
  <script src="js/jquery-3.2.1.min.js"></script>
</body>

</html>