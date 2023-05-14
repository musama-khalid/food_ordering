<?php 
    include('top.php');

    $msg = "";
    $coupon_code = "";
    $coupon_type = "";
    $coupon_value = "";
    $cart_min_value = "";
    $expired_on = "";
    $id = "";

    if(isset($_GET['id']) && $_GET['id'] > 0){
      $id = $_GET['id'];
      $row = mysqli_fetch_assoc(mysqli_query($con, "select * from coupon_code where id = '$id'"));
      $coupon_code = $row['coupon_code'];
      $coupon_type = $row['coupon_type'];
      $coupon_value = $row['coupon_value'];
      $cart_min_value = $row['cart_min_value'];
      $expired_on = $row['expired_on'];
    }

    if(isset($_POST['submit'])){
      $coupon_code = $_POST['coupon_code'];
      $coupon_type = $_POST['coupon_type'];
      $coupon_value = $_POST['coupon_value'];
      $cart_min_value = $_POST['cart_min_value'];
      $expired_on = $_POST['expired_on'];
      $added_on = date('Y-m-d h:i:s');

      if($id == ''){
        $sql = "select * from coupon_code where coupon_code = '$coupon_code'";
      }else {
        $sql = "select * from coupon_code where coupon_code = '$coupon_code' and id!='$id'";
      }


      if(mysqli_num_rows(mysqli_query($con, $sql)) > 0){
        $msg = "Coupon code already added";
      }else{
        if($id == ''){
          mysqli_query($con, "insert into coupon_code(coupon_code, coupon_type, coupon_value, cart_min_value, expired_on, status, added_on) values('$coupon_code', '$coupon_type', '$coupon_value', '$cart_min_value', '$expired_on', 1, '$added_on')");
        }else {
          mysqli_query($con, "update coupon_code set coupon_code = '$coupon_code', coupon_type = '$coupon_type', coupon_value = '$coupon_value', cart_min_value = '$cart_min_value', expired_on = '$expired_on' where id = '$id'");
        }
        redirect('coupon_code.php');
      }

    }

?>



<div class="card">
            <div class="card-body">
              <div class="row">
			      <h1 class="card-title ml10 ml15 manage_category grid_title">Manage Coupon Code</h1>
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="POST">
                    <div class="form-group">
                      <label for="exampleInputName1">Coupon Code</label>
                      <input type="text" class="form-control" placeholder="Code" name="coupon_code" value="<?php echo $coupon_code ?>" required>
                      <span class="error"><?php echo $msg ?></span>                  
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Coupon Type</label>
                      <select name="coupon_type" class="form-control" required>
                        <option value="">Select Type</option>
                        <?php
                          $couponTypeArr = array('P' => 'Percentage', 'F' => 'Fixed');
                          foreach($couponTypeArr as $key => $val){
                            if($key == $coupon_type){
                              echo "<option value='".$key."' selected>".$val."</option>";
                            }else{
                              echo "<option value='".$key."'>".$val."</option>";
                            }
                            
                          }
                        ?>
                      </select>
                      <div class="mt8">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Coupon Value</label>
                      <input type="textbox" class="form-control" placeholder="Coupon Value" name="coupon_value" value="<?php echo $coupon_value ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Cart Min Value</label>
                      <input type="textbox" class="form-control" placeholder="Cart Min Value" name="cart_min_value" value="<?php echo $cart_min_value ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Expired On</label>
                      <input type="date" class="form-control" placeholder="Expired On" name="expired_on" value="<?php echo $expired_on ?>">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2" name="submit">Submit</button>
                  </form>
                </div>
              </div>
            </div>
            
		 </div>
            </div>
          </div>

<?php include('footer.php'); ?>
