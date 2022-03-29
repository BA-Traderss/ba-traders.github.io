<!doctype html>
<html lang="en">
<?php
require('connection.inc.php');
require('functions.inc.php');
require('add_to_cart.inc.php');
// prx($_SESSION)
//to get categories from database to main page navbar
$cat_res = mysqli_query($con, "select * from categories where status = 1 ORDER BY `categories`ASC");
$cat_arr = array();
while ($row = mysqli_fetch_assoc($cat_res)) {
  $cat_arr[] = $row;
}

//to update cart count 1-2-3-4 so on;
$obj = new add_to_cart();
$totalProduct = $obj->totalProduct();

if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
  header('Location:thank_you.php');
  die();
}

$cart_total = 0;
foreach ($_SESSION['cart'] as $key => $val) {
  $productArr = get_product($con, '', $key);
  $price = $productArr['0']['price'];
  $qty = $val['qty'];
  $cart_total = $cart_total + ($qty * $price);
}

if (isset($_POST['submit'])) {
  $address = get_safe_value($con, $_POST['address']);
  $first_name = get_safe_value($con, $_POST['first_name']);
  $last_name = get_safe_value($con, $_POST['last_name']);
  $email = get_safe_value($con, $_POST['email']);
  $country = get_safe_value($con, $_POST['country']);
  $state = get_safe_value($con, $_POST['state']);
  $pincode = get_safe_value($con, $_POST['pincode']);
  $payment_type = get_safe_value($con, $_POST['payment_type']);
  $user_id = $_SESSION['USER_ID'];
  $total_price = $cart_total;
  $payment_status = 'pending';
  if ($payment_type == 'cod') {
    $payment_status = "success";
  }
  $order_status = 'pending';  
  $added_on = date('Y-m-d h:i:s');

  mysqli_query($con, "INSERT INTO `p_order`(`user_id`, `first_name`, `last_name`, `email`, `address`, `country`, `state`, `pincode`, `payment_type`, `total_price`, `payment_status`, `order_status`, `added_on`) VALUES ('$user_id','$first_name','$last_name','$email','$address','$country','$state','$pincode','$payment_type','$total_price','$payment_status','$order_status','$added_on')");

  $order_id = mysqli_insert_id($con);
  foreach ($_SESSION['cart'] as $key => $val) {
    $productArr = get_product($con, '', $key);
    $price = $productArr['0']['price'];
    $qty = $val['qty'];

    mysqli_query($con, "INSERT INTO `order_detail`(`order_id`, `product_id`, `qty`, `price`,`added_on`) VALUES ('$order_id','$key','$qty','$price','$added_on')");

  }
  unset($_SESSION['cart']);
  ?>
<script>
  window.location.href = 'thank_you.php';
</script>
<?php
}
?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
    integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
    crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="shortcut icon" href="favicon_io/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="css/style.css">

</head>

<style>
  /* body {
    background-color: rgba(231, 231, 226, 0.733);
  }

  .container {
    background-color: white;
  } */
</style>

<body>
  <?php
  require 'nav.php'
  ?>
  
  <!-- ----------------------------------LOGIN------------------------------------------------------- -->
<div class="container my-3">
    <?php
    $accordion_id='panelsStayOpen-collapseTwo';
    if (!isset($_SESSION['USER_LOGIN'])){
      $accordion_id='panelsStayOpen-collapse';
    ?>
  <div class="row">
    <div class="accordion-list">
      <div class="accordion accordion-flush" id="accordion_title">
       <div class="accordion-item">
        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
          <button class="accordion-button" type="button" data-bs-toggle="collapse"
            data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
            LOGIN
          </button>
        </h2>
        <div id="panelsStayOpen-collapse" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne"
          data-bs-parent="#accordionFlushExample">
          <div class="wrapper my-2">
            <div class="title"><span>Login</span></div>
            <form action="#">
              <div class="row">
                <div class="col-3"></div>
                <div class="col-sm-6">
                <i class="fas fa-user"></i>
                <input type="text" id="login_name" name="login_name" placeholder="Username" required>
                </div>
                <div class="col-sm-3">
              <span class="field_error"  id="login_name_error"></span>
                </div>
              </div>
              <div class="row">
              <div class="col-3"></div>
                <div class="col-sm-6">
                  <i class="fas fa-lock"></i>
                <input type="password" id="login_password" name="login_password" placeholder="Enter your password"
                required>
                <span><i class="fa-regular fa-eye show_pass" id="eye"
                    onclick="togglee()"></i></span>
                <script>
                  var state = 1
                  var state = false;
                  function togglee() {
                    if (state) {
                      document.getElementById("login_password").setAttribute("type", "password");
                      state = false;
                    }
                    else {
                      document.getElementById("login_password").setAttribute("type", "text");
                      state = true;
                    }
                  }
                </script>
                </div>
                <div class="col-sm-3">
              <span class="field_error" id="login_password_error"> </span>
                </div>
              </div>
              <div class="row">
              <div class="col-4"></div>
              <div class="col-sm-4  button">
              <input type="submit" value="Login" onclick="user_login()" id="login">
              </div>
                <div class="col-3"></div>
              </div>
          </div>
          </form>
          <div class="form-output login-msg">
            <p class="form-message field_error"></p>
          </div>
        </div>
      </div>
      </div>
      <?php } ?>  
      <!-- -----------------------------------ADDRESS-------------------------------------------------- -->

      <form action="" method="post">
        <div class="accordion-item">
          <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo" onclick="address_alert()" id="address_alert">
              Address Details
            </button>
          </h2>
          <div id="<?php echo $accordion_id?>" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
          <div class="row">
                  <div class="col-md-6 mb-2">
                    <label for="firstName">First name</label>
                    <input type="text" class="form-control" id="firstName" name="first_name" value="" required="">
                    <div class="invalid-feedback">
                      Valid first name is required.
                    </div>
                  </div>
                  <div class="col-md-6 mb-2">
                    <label for="lastName">Last name</label>
                    <input type="text" class="form-control" id="lastName" name="last_name" placeholder="" value="" required="">
                  </div>
                </div>
      
                <div class="mb-3">
                  <label for="email">Email <span class="text-muted">(Optional)</span></label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com">
                </div>
      
                <div class="mb-3">
                  <label for="address">Address</label>
                  <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" required="">
                </div>
      
                <div class="row">
                  <div class="col-md-5 mb-3">
                    <label for="country">Country</label>
                    <select class="custom-select d-block w-100" id="country" name="country" required="">
                      <option value="">Choose...</option>
                      <option>India</option>
                    </select>
                  </div>
                  <div class="col-md-4 mb-3">
                    <label for="state">State</label>
                    <select class="custom-select d-block w-100" id="state" name="state" required="">
                      <option value="">Choose...</option>
                      <option>Maharashtra</optio>
                    </select>
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="pincode">pincode</label>
                    <input type="text" class="form-control" id="pincode" placeholder="" name="pincode" required="">
                  </div>
                </div>
          </div>
        </div>                      
      <!-- --------------------------------------PAYMENT------------------------------------------------ -->
      <div class="accordion-item">
      <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo" onclick="address_alert()">
          Payment Method
        </button>
      </h2>
      <div id="<?php echo $accordion_id?>" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingThree">
      <div class="d-block my-3">
              <div class="custom-control custom-radio">
                <input id="credit" name="payment_type" type="radio" class="custom-control-input" checked="" required="">
                <label class="custom-control-label" for="credit">Credit/Debit Card</label>  <div class="padding">
        <div class="row">
            <div class="container-fluid d-flex justify-content-center">
                <div class="col-sm-8 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                   <span>CREDIT/DEBIT CARD PAYMENT</span>
                                   </div>
                                <div class="col-md-6 text-right" style="margin-top: -5px;"> <img
                                        src="https://img.icons8.com/color/36/000000/visa.png" class="c_img"> <img
                                        src="https://img.icons8.com/color/36/000000/mastercard.png" class="c_img"> <img
                                        src="https://img.icons8.com/color/36/000000/amex.png" class="c_img"> </div>
                            </div>
                        </div>
                        <div class="card-body" style="height: 350px">
                            <div class="form-group"> 
                                <label class="label">CARD NUMBER</label>
                                <input type="text" class="input form-control" name="card_number" placeholder="•••• •••• •••• ••••" data-mask="0000 0000 0000 0000" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label class="label">CARD EXPIRY</label> 
                                        <input  type="text" name="expiry-date"
                                            class="input form-control" placeholder="MM / YY" data-mask="00 / 00" required> 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group"> 
                                        <label class="label">CARD CVC</label>
                                        <input type="text" name="cvc" class="input form-control" placeholder=""
                                             placeholder="•••" data-mask="000" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group"> 
                                <label for="numeric" class="label">CARD HOLDER NAME</label>
                                <input type="text" class="input-lg form-control">
                            </div>
                            <div class="form-group"> <input value="MAKE PAYMENT" type="button"
                                    class="btn btn-success btn-lg form-control" style="font-size: .8rem;"> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
              </div>
              <div class="custom-control custom-radio">
                <input id="COD" name="payment_type" type="radio" class="custom-control-input" required="">
                <label class="custom-control-label" for="COD">Cash On Delivery</label>
              </div>
            </div>
            <button class="btn btn-primary btn-lg btn-block" type="submit" name="submit">Continue to checkout</button>
            </form>
          </div>
          <div class="col-md-4 order-md-2 mb-4">
              <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your cart</span>
                <span class="badge badge-secondary badge-pill"><?php echo $totalProduct ?></span>
              </h4>
              <ul class="list-group mb-3">
                <?php
                $cart_total = 0;
                foreach ($_SESSION['cart'] as $key => $val) {
                  $productArr = get_product($con, '', $key);
                  $pname = $productArr['0']['name'];
                  $mrp = $productArr['0']['mrp'];
                  $price = $productArr['0']['price'];
                  $image = $productArr['0']['image'];
                  $qty = $val['qty'];
                  $cart_total = $cart_total + ($qty * $price);
                ?>
                  <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                      <h6 class="my-0"><?php echo $pname ?></h6>
                      <small class="text-muted">Quantity :- <?php echo $qty ?></small>
                    </div>
                    <div>
                      <span class="text-muted"><?php echo $qty * $price ?></span>
                      <a href="javascript:void(0)" onclick="manage_cart('<?php echo $key ?>','remove')"><i class="icon-trash icons"></i></a>
                    </div>
                  </li>
                <?php } ?>
                <li class="list-group-item d-flex justify-content-between">
                  <span>Total</span>
                  <strong><?php echo $cart_total ?></strong>
                </li>
              </ul>
              <form class="card p-2">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Promo code">
                  <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary">Redeem</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Button trigger modal -->

    
    
  <script>
    
function address_alert(){
  if(user_login() == true){
    alert("Please Login before filling your details");
  }
}
  </script>
  <script src="js/jquery-3.2.1.min.js"></script>
  <!-- Bootstrap framework js -->
  <script src="js/bootstrap.min.js"></script>
  <!-- All js plugins included in this file. -->
  <script src="js/plugins.js"></script>
  <script src="js/slick.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <!-- Waypoints.min.js. -->
  <script src="js/waypoints.min.js"></script>
  <!-- Main js file that contents all jQuery plugins activation. -->
  <script src="js/main.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
</body>
</html>