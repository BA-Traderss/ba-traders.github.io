<?php
require('top.inc.php');
$condition='';
$condition1='';

$categories_id = '';
$name = '';
$mrp = '';
$price = '';
$qty = '';
$image = '';
$short_desc = '';
$description = '';
$meta_title = '';
$meta_desc = '';
$meta_keyword = "";
$MultipleImageArr=[];
$msg = '';
$image_required = "required";

if(isset($_GET['pi']) && $_GET['pi']>0){
	$pi=get_safe_value($con,$_GET['pi']);
	$delete_sql="delete from product_images where id='$pi'";
	mysqli_query($con,$delete_sql);
}

if (isset($_GET['id']) && $_GET['id'] != '') {
   $image_required = '';
   $id = get_safe_value($con, $_GET['id']);
   $res = mysqli_query($con, "select * from product where id = '$id' $condition1");
   $check = mysqli_num_rows($res);
   if ($check > 0) {
      $row = mysqli_fetch_assoc($res);
      $categories_id = $row['categories_id'];
      $name = $row['name'];
      $mrp = $row['mrp'];
      $price = $row['price'];
      $qty = $row['qty'];
      $short_desc = $row['short_desc'];
      $description = $row['description'];
      $meta_title = $row['meta_title'];
      $meta_desc = $row['meta_desc'];
      $meta_keyword = $row['meta_keyword'];
      $image = $row['image'];

      $resMultipleImage=mysqli_query($con, "select id,product_images from product_images where product_id='$id'");
      if (mysqli_num_rows($resMultipleImage)>0){
         $jj=0;
         while($rowMultipleImage=mysqli_fetch_assoc($resMultipleImage)){
            $MultipleImageArr[$jj] ['product_images']=$rowMultipleImage['product_images'];
            $MultipleImageArr[$jj] ['id']=$rowMultipleImage['id'];
            $jj++;
         }
      }
   } else {
      header('location:admin_product.php');
      die();
   }
}
//SUBMIT VALIDATION
if (isset($_POST['submit'])) {
   $categories_id = get_safe_value($con, $_POST['categories_id']);
   $name = get_safe_value($con, $_POST['name']);
   $mrp = get_safe_value($con, $_POST['mrp']);
   $price = get_safe_value($con, $_POST['price']);
   $qty = get_safe_value($con, $_POST['qty']);
   $short_desc = get_safe_value($con, $_POST['short_desc']);
   $meta_title = get_safe_value($con, $_POST['meta_title']);
   $meta_desc = get_safe_value($con, $_POST['meta_desc']);
   $meta_keyword = get_safe_value($con, $_POST['meta_keyword']);
   
   $res = mysqli_query($con, "select * from product where name = '$name' $condition1");
   $check = mysqli_num_rows($res);
   if ($check > 0) {
      if (isset($_GET['id']) && $_GET['id'] != '') {
         $getData = mysqli_fetch_assoc($res);
         if ($id == $getData['id']) {
         } else {
            $msg = "Product already exists";
         }
      } else {
         $msg = "Product already exists";
      }
   }


   if(isset($_GET['id']) && $_GET['id']==0){
		if($_FILES['image']['type']!='image/png' && $_FILES['image']['type']!='image/jpg' && $_FILES['image']['type']!='image/jpeg'){
			$msg="Please select only png,jpg and jpeg image formate";
		}
	}else{
		if($_FILES['image']['type']!=''){
				if($_FILES['image']['type']!='image/png' && $_FILES['image']['type']!='image/jpg' && $_FILES['image']['type']!='image/jpeg'){
				$msg="Please select only png,jpg and jpeg image formate";
			}
		}
	}
   if (isset($_FILES['product_images'])){
      foreach ($_FILES['product_images']['type'] as $key => $val){
         if ($_FILES['product_images']['type'][$key]!='image/jpeg' && $_FILES['product_images']['type'][$key]!='image/png' && $_FILES['product_images']['type'][$key]!='image/jpg') {
            $msg ="Please select only png , jpg , jpeg image format";
         }
      }
   }
   //update & insert validation
   if ($msg == '') {
      if (isset($_GET['id']) && $_GET['id'] != '') {
         if ($_FILES['image']['name'] !== '') {
            $image = rand(11111111, 99999999) . '_' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH. $image);
            $update_sql = "UPDATE `product` SET categories_id='$categories_id',name='$name',mrp='$mrp',price='$price',qty='$qty',short_desc='$short_desc',description='$description',meta_title='$meta_title',meta_desc='$meta_desc',meta_keyword='$meta_keyword',image='$image' where id='$id'";
         } else {
            $update_sql = "UPDATE `product` SET categories_id='$categories_id',name='$name',mrp='$mrp',price='$price',qty='$qty',short_desc='$short_desc',description='$description',meta_title='$meta_title',meta_desc='$meta_desc',meta_keyword='$meta_keyword' where id='$id'";
         }
         $query = $update_sql;
         $con->query($query);
      } else {
         $image = rand(11111111, 99999999) . '_' . $_FILES['image']['name'];
         move_uploaded_file($_FILES['image']['tmp_name'], PRODUCT_IMAGE_SERVER_PATH. $image);
         $query = "INSERT INTO `product`(`categories_id`,`name`,`mrp`,`price`,`qty`,`short_desc`,`description`,`meta_title`,`meta_desc`,`meta_keyword`,`status`,`image`) VALUES ('$categories_id','$name','$mrp','$price','$qty','$short_desc','$description','$meta_title','$meta_desc','$meta_keyword','1','$image')";
         $con->query($query);
      }


      //product multiple img starts 
      if (isset($_GET['id']) && $_GET['id'] != '') {
         foreach ($_FILES['product_images']['name'] as $key => $val){
            if($_FILES['product_images']['name'][$key]!=''){
               if(isset($_POST['product_images_id'][$key])){
                  $image = rand(11111111, 99999999) . '_' .$_FILES['product_images']['name'][$key];
                   move_uploaded_file($_FILES['product_images']['tmp_name'][$key], PRODUCT_MULTIPLE_IMAGE_SERVER_PATH . $image);

                   mysqli_query($con,"update product_images set product_images='$image'where id= '".$_POST['product_images_id'][$key]."'");
               }else{
                  $image = rand(11111111, 99999999) . '_' .$_FILES['product_images']['name'][$key];
                  move_uploaded_file($_FILES['product_images']['tmp_name'][$key], PRODUCT_MULTIPLE_IMAGE_SERVER_PATH . $image);
      
                  mysqli_query($con,"insert into `product_images`(product_id,product_images) values('$id','$image')");
               }
            }
         }
      }else{
         if(isset($_FILES['product_images']['name'])){
				foreach($_FILES['product_images']['name'] as $key=>$val){
					if($_FILES['product_images']['name'][$key]!=''){
						$image=rand(111111111,999999999).'_'.$_FILES['product_images']['name'][$key];
						move_uploaded_file($_FILES['product_images']['tmp_name'][$key],PRODUCT_MULTIPLE_IMAGE_SERVER_PATH.$image);
						mysqli_query($con,"insert into product_images(product_id,product_images) values('$id','$image')");
					}
				}
			}
		}
      //product multiple img ends 
      
      
      header('location:admin_product.php');
      die();
   }
}



?>
<style>
   .field_error {
      color: red;
      margin-top: 15px;
   }
</style>
<div class="content pb-0">
   <div class="animated fadeIn">
      <div class="row">
         <div class="col-lg-12">
            <div class="card">
               <div class="card-header"><strong>Products</strong><small> Form</small></div>
               <form method="post" enctype="multipart/form-data">
                  <div class="card-body card-block">
                     <div class="form-group">
                        <label for="categories" class=" form-control-label">Categories</label>
                        <select class="form-control" name="categories_id">
                           <option>Select category</option>
                           <?php
                           $res = mysqli_query($con, "select id,categories from categories order by categories");
                           while ($row = mysqli_fetch_assoc($res)) {
                              if ($row['id'] == $categories_id) {
                                 echo "<option selected value=" . $row['id'] . ">" . $row['categories'] . "</option>";
                              } else {
                                 echo "<option value=" . $row['id'] . ">" . $row['categories'] . "</option>";
                              }
                           }
                           ?>
                        </select>
                     </div>
                     
                     <div class="form-group"><label for="categories" class=" form-control-label">Product Name</label>
                        <input type="text" name="name" placeholder="Enter product name" class="form-control" required value="<?php echo $name ?>">
                     </div>
                     <div class="form-group"><label for="categories" class=" form-control-label">MRP</label>
                        <input type="text" name="mrp" placeholder="Enter product mrp" class="form-control" required value="<?php echo $mrp ?>">
                     </div>
                     <div class="form-group"><label for="categories" class=" form-control-label">Product Price</label>
                        <input type="text" name="price" placeholder="Enter product price" class="form-control" >
                     </div>
                     <div class="form-group"><label for="categories" class=" form-control-label">Product Qty</label>
                        <input type="text" name="qty" placeholder="Enter product qty" class="form-control" required value="<?php echo $qty ?>">
                     </div>
                     
                     <div class="form-group">
                        <div class="row" id="image_box">
                           <div class="col-lg-10">
                           <label for="categories" class=" form-control-label">Product Image</label>
                        <input type="file" name="image" class="form-control" <?php echo $image_required ?>>
                         <?php
										if($image!=''){
echo "<a target='_blank' href='".PRODUCT_IMAGE_SITE_PATH.$image."'><img width='150px' src='".PRODUCT_IMAGE_SITE_PATH.$image."'/></a>";
										}
										?>
                           </div>
                           <div class="col-lg-2">
                           <label for="categories" class=" form-control-label"></label>
                           <button id=""  type="button" class="btn btn-lg btn-info btn-block" onclick="add_more_images()">
                        <span id="payment-button-amount">Add Image</span>
                     </button>
                        </div>
                        <?php
									 if(isset($multipleImageArr[0])){
foreach($multipleImageArr as $list){
	echo '<div class="col-lg-6" style="margin-top:20px;" id="add_image_box_'.$list['id'].'"><label for="categories" class=" form-control-label">Image</label><input type="file" name="product_images[]" class="form-control" ><a href="manage_product.php?id='.$id.'&pi='.$list['id'].'" style="color:white;"><button type="button" class="btn btn-lg btn-danger btn-block"><span id="payment-button-amount"><a href="manage_product.php?id='.$id.'&pi='.$list['id'].'" style="color:white;">Remove</span></button></a>';
	echo "<a target='_blank' href='".PRODUCT_MULTIPLE_IMAGE_SITE_PATH.$list['product_images']."'><img width='150px' src='".PRODUCT_MULTIPLE_IMAGE_SITE_PATH.$list['product_images']."'/></a>";
	echo '<input type="hidden" name="product_images_id[]" value="'.$list['id'].'"/></div>';
	
}										 
									 }
									 ?>

                        </div>
                        
                     <div class="form-group"><label for="categories" class=" form-control-label">Short Description </label>
                        <textarea class="form-control" name="short_desc" placeholder="Enter product Short Description" required><?php echo $short_desc ?></textarea>
                     </div>

                     

                     <div class="form-group"><label for="categories" class=" form-control-label">Meta Title </label>
                        <textarea class="form-control" name="meta_title" placeholder="Enter product Meta Title"><?php echo $meta_title ?></textarea>
                     </div>

                     <div class="form-group"><label for="categories" class=" form-control-label">Meta Description </label>
                        <textarea class="form-control" name="meta_desc" placeholder="Enter product Meta Description"><?php echo $meta_desc ?></textarea>
                     </div>

                     <div class="form-group"><label for="categories" class=" form-control-label">Meta Keyword </label>
                        <textarea class="form-control" name="meta_keyword" placeholder="Enter product Meta Keyword"><?php echo $meta_keyword ?></textarea>
                     </div>

                     <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
                        <span id="payment-button-amount">Submit</span>
                     </button>
                     <div class="field_error"><?php echo $msg ?></div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
   var total_image=1;
   function add_more_images(){
      total_image++;
      var html='<div class="col-lg-6" id="add_image_box_'+total_image+'">  <label for="categories" class="  form-control-label">Add Image</label><input type="file" name="product_images[]" class="form-control" required><button   type="button" class="btn btn-lg btn-danger btn-block" onclick=remove_image("'+total_image+'")><span id="payment-button-amount">Remove</span></button></div> ';
    jQuery('#image_box').after(html)
}
function remove_image(id){
   jQuery('#add_image_box_'+id).remove();
}
</script>
<?php
require('footer.inc.php');
?>