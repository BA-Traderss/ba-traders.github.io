<!doctype html>
<html lang="en">
<?php
require('connection.inc.php');
require('functions.inc.php');
require('add_to_cart.inc.php');

$cat_res = mysqli_query($con, "select * from categories where status = 1 ORDER BY `categories`ASC");
$cat_arr = array();
while ($row = mysqli_fetch_assoc($cat_res)) {
    $cat_arr[] = $row;
}

$product_id = mysqli_real_escape_string($con, $_GET['id']);
$get_product = get_product($con, '', $product_id);


//to update cart count 1-2-3-4 so on;
$obj = new add_to_cart();
$totalProduct = $obj -> totalProduct();


?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="favicon_io/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    require 'nav.php'
    ?>
    <nav class="navbar navbar-light">
        <div class="container-fluid">
            <form class="d-flex">
                <img src="https://img.icons8.com/material-rounded/24/000000/circled-left--v2.png" style="width: 27px;">
                <a href="users_categories.php?id=<?php echo $get_product['0']['categories_id'] ?>"
                    style="text-decoration: none; color: black; padding: 0px 8px;">Go Back</a>
            </form>
        </div>
    </nav>
    <div class="mb-2 ht__bradcaump__area">
    </div>
    <!-- End Bradcaump area -->
    <!-- Start Product Details Area -->
    <section class="htc__product__details bg__white ptb--100">
        <!-- Start Product Details Top -->
        <div class="htc__product__details__top">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 col-lg-5 col-sm-12 col-xs-12">
                        <div class="htc__product__details__tab__content">
                            <!-- Start Product Big Images -->
                            <div class="mb-2 product__big__images">
                                <div class="">
                                    <a href="#"><img class="card-img-top" alt="Thumbnail [100%x225]" src="<?php echo 'uploaded products/' . $get_product['0']['image'] ?>" data-holder-rendered="true"></a>
                                </div>
                            </div>
                            <!-- End Product Big Images -->
                        </div>
                    </div>



                    <div class="col-md-7 col-lg-7 col-sm-12 col-xs-12 smt-40 xmt-40 infos">
                        <div class="ht__product__dtl">
                            <h1>
                                <?php echo $get_product['0']['name'] ?>
                            </h1>
                            <div class="reviews">
                                 <i class="fas fa-star"></i>
                                 <i class="fas fa-star"></i>
                                 <i class="fas fa-star"></i>
                                 <i class="fas fa-star"></i>
                                 <i class="fas fa-star-half-alt"></i>
                                </div>
                             <ul class="pro__prize">
                                 Price<li class="old__prize">&#8377;
                                    <?php echo $get_product['0']['mrp'] ?>
                                </li>
                               
                            </ul>
                            <p class="pro__info"><?php echo $get_product['0']['short_desc'] ?></p>
                            <div>
                                <p><span>Qty:</span>
                                    <select id="qty">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>
                                        <option>9</option>
                                        <option>10</option>
                                    </select>
                                </p>
                            </div>
                            <a class="btn btn-primary product" href="javascript:void(0)" onclick="manage_cart('<?php echo $get_product['0']['id'] ?>','add')">Add To Cart</a>
                            <a href="#" class="btn btn-primary product">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- End Product Details Top -->
    </section>
    <!-- Start Product Description -->
    <section class="htc__produc__decription bg__white">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <!-- Start List And Grid View -->
                    
                    <!-- End List And Grid View -->
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="ht_prodetails_content">
                        <!-- Start Single Content -->
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                        aria-controls="panelsStayOpen-collapseOne">
                                        About Product
                                    </button>
                                </h2>
                                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                                    aria-labelledby="panelsStayOpen-headingOne">
                                    <div class="accordion-body">


                                        <div role="tabpanel" id="description"
                                            class="pro_single_content tab-pane active">
                                            <div class="pro_tabcontent_inner">
                                                <p>Formfitting clothing is all about a sweet spot. That elusive place
                                                    where an item is tight but not clingy, sexy but not cloying, cool
                                                    but not over the top. Alexandra Alvarez’s label, Alix, hits that
                                                    mark with its range of comfortable, minimal, and neutral-hued
                                                    bodysuits.</p>
                                                <h4 class="ht_pro_title">Description</h4>
                                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam
                                                    nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat
                                                    volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation
                                                    ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo
                                                    consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate
                                                    velit esse molestie consequat, vel illum dolore eu feugiat nulla
                                                    facilisis at vero eros et accumsan et iusto odio dignissim qui
                                                    blandit praesent luptatum zzril delenit augue duis dolore te feugait
                                                    nulla facilisi. Nam liber tempor cum soluta nobis eleifend option
                                                    congue nihil imperdiet doming id quod mazim placerat facer possim
                                                    assum. Typi non habent claritatem insitam; est usus legentis in iis
                                                    qui facit eorum claritatem</p>
                                                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam
                                                    nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat
                                                    volutpat. Duis autem vel eum iriure dolor in hendrerit in vulputate
                                                    velit esse molestie consequat, vel illum dolore eu feugiat nulla
                                                    facilisis at vero eros et accumsan et iusto odio dignissim qui
                                                    blandit praesent luptatum zzril delenit augue duis dolore te feugait
                                                    nulla facilisi.</p>
                                            </div>
                                        </div>
                                        <!-- End Single Content -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Product Description -->

  <!-- The Main Javascript file -->
  <script src="js/main.js" async></script>
  <script src="js/jquery-3.2.1.min.js" async></script>

</body>

</html>