<!doctype html>
<html lang="en">
<?php
require('connection.inc.php');
require('functions.inc.php');
require('add_to_cart.inc.php');

//to get categories from database to main page navbar
$cat_res = mysqli_query($con, "select * from categories where status = 1 ORDER BY `categories`ASC");
$cat_arr = array();
while ($row = mysqli_fetch_assoc($cat_res)) {
  $cat_arr[] = $row;
}

//to update cart count 1-2-3-4 so on;
$obj = new add_to_cart();
$totalProduct = $obj->totalProduct();

?>

<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
  
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="shortcut icon" href="favicon_io/favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="css/style.css">
  <!-- <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  <link rel="shortcut icon" href="#">
  <link rel="shortcut icon" href="favicon_io/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="style.css">
  <script src="main.js" async></script> -->

  <title>BA Traders | The Best Shopping Website</title>
</head>


<body>

  <?php
  require 'nav.php'
  ?>

  <nav class="navbar navbar-light">
    <div class="container-fluid justify-content-center">
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-light " type="submit">Search</button>
      </form>
    </div>
  </nav>
  <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="img/carosuel/1.jpeg" class="d-block w-100" alt="..." style="height: 75vh">
      </div>
      <div class="carousel-item">
        <img src="img/carosuel/2.jpg" class="d-block w-100" alt="..." style="height: 75vh">
      </div>
      <div class="carousel-item">
        <img src="img/carosuel/3.jpg " class="d-block w-100" alt="..." style="height: 75vh">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <!--first section  -->
  <div class="container my-3">
    <div class="row">
      <div class="heading">
        <h2>Featured</h2>
      </div>
      <hr>
      <?php
      $get_product = get_product($con);
      foreach ($get_product as $list) {
      ?>
        <div class="col-md-4">
          <div class="card mb-4 box-shadow">
            <a href="users_product.php?id=<?php echo $list['id'] ?>"><img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" src="<?php echo 'uploaded products/' . $list['image'] ?>" data-holder-rendered="true">
              <img class="hover-img" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" src="<?php echo 'uploaded products/' . $list['image'] ?>" data-holder-rendered="true"></a>
            <div class="card-body" style="text-align: center;">
              <h5 class="card-title"><?php echo $list['name'] ?></h5>
              <p class="card-text">&#8377;<?php echo $list['mrp'] ?>/-</p>
              <a href="#" class="btn btn-primary product">Add To Cart</a>
              <a href="#" class="btn btn-primary product">Buy Now</a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
  <!-- second section -->
  <div class="container" style="overflow: auto;">
    <div class="row">
      <div class="heading">
        <h2>Suggested For You</h2>
      </div>
      <hr>
      <div class="col-md-4">
        <div class="card mb-4 box-shadow">
          <a href="#"><img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" src="img/Products/5.jpg" data-holder-rendered="true">
            <img class="hover-img" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" src="img/Products/51.jpeg" data-holder-rendered="true"></a>
          <div class="card-body" style="text-align: center;">
            <h5 class="card-title">THG Stainless Steel Towel Rack</h5>
            <p class="card-text">&#8377;799/-</p>
            <a href="#" class="btn btn-primary product">Add To Cart</a>
            <a href="#" class="btn btn-primary product">Buy Now</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card mb-4 box-shadow">
          <a href=""><img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" src="img/Products/9.jpeg" data-holder-rendered="true">
            <img class="hover-img" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" src="img/Products/91.jpeg" data-holder-rendered="true"></a>
          <div class="card-body" style="text-align: center;">
            <h5 class="card-title">Magnetic Toolkit.</h5>
            <p class="card-text">&#8377;195/-</p>
            <a href="#" class="btn btn-primary product">Add To Cart</a>
            <a href="#" class="btn btn-primary product">Buy Now</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card mb-4 box-shadow">
          <a href=""><img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" src="img/Products/11.jpg" data-holder-rendered="true">
            <img class="hover-img" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" src="img/Products/11(1).jpeg" data-holder-rendered="true"></a>
          <div class="card-body" style="text-align: center;">
            <h5 class="card-title">Leaf Shape Soap Dish Holder</h5>
            <p class="card-text">&#8377;259/-</p>
            <a href="#" class="btn btn-primary product">Add To Cart</a>
            <a href="#" class="btn btn-primary product">Buy Now</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card mb-4 box-shadow">
          <a href=""><img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" src="img/Products/1.jpeg" data-holder-rendered="true">
            <img class="hover-img" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" src="img/Products/111.jpg" data-holder-rendered="true"></a>
          <div class="card-body" style="text-align: center;">
            <h5 class="card-title">Copper String LED light (10Mtr)</h5>
            <p class="card-text">&#8377;255/-</p>
            <a href="#" class="btn btn-primary product">Add To Cart</a>
            <a href="#" class="btn btn-primary product">Buy Now</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card mb-4 box-shadow">
          <a href=""><img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" src="img/Products/12.jpeg" data-holder-rendered="true">
            <img class="hover-img" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" src="img/Products/121.jpeg" data-holder-rendered="true"></a>
          <div class="card-body" style="text-align: center;">
            <h5 class="card-title">Curtain Knobs</h5>
            <p class="card-text">&#8377;259/-</p>
            <a href="#" class="btn btn-primary product">Add To Cart</a>
            <a href="#" class="btn btn-primary product">Buy Now</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card mb-4 box-shadow">
          <a href=""><img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" src="img/Products/13.jpg" data-holder-rendered="true">
            <img class="hover-img" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" src="img/Products/131.jpeg" data-holder-rendered="true"></a>
          <div class="card-body" style="text-align: center;">
            <h5 class="card-title"> Fish Shape Soap Dish Holder</h5>
            <p class="card-text">&#8377;199/-</p>
            <a href="#" class="btn btn-primary product">Add To Cart</a>
            <a href="#" class="btn btn-primary product">Buy Now</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- The Main Javascript file -->
  <script src="js/main.js" async></script>
  <script src="js/jquery-3.2.1.min.js"></script>


</body>

</html>