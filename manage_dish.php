<?php 
    include('top.php');

    $msg = "";
    $category_id = "";
    $dish = "";
    $dish_detail = "";
    $image = "";
    $id = "";

    if(isset($_GET['id']) && $_GET['id'] > 0){
      $id = $_GET['id'];
      $row = mysqli_fetch_assoc(mysqli_query($con, "select * from dish where id = '$id'"));
      $category_id = $row['category_id'];
      $dish = $row['dish'];
      $dish_detail = $row['dish_detail'];
      $image = $row['image'];
    }

    if(isset($_POST['submit'])){
      $category_id = $_POST['category_id'];
      $dish = $_POST['dish'];
      $dish_detail = $_POST['dish_detail'];
      $image = $_POST['image'];
      $added_on = date('Y-m-d h:i:s');

      if($id == ''){
        $sql = "select * from dish where dish = '$dish'";
      }else {
        $sql = "select * from dish where dish = '$dish' and id!='$id'";
      }


      if(mysqli_num_rows(mysqli_query($con, $sql)) > 0){
        $msg = "Dish already added";
      }else{
        if($id == ''){
          mysqli_query($con, "insert into dish(category_id, dish, dish_detail, image, status, added_on) values('$category_id', '$dish', '$dish_detail', '$image', 1, '$added_on')");
        }else {
          mysqli_query($con, "update dish set category_id = '$category_id', dish = '$dish', dish_detail = '$dish_detail', image = '$image' where id = '$id'");
        }
        redirect('dish.php');
      }

    }

    $res_category = mysqli_query($con, "select * from category where status = '1' order by category asc");

?>

<div class="card">
            <div class="card-body">
              <div class="row">
			      <h1 class="card-title ml10 ml15 manage_category grid_title">Manage Delivery Boy</h1>
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="POST">
                    <div class="form-group">
                      <label for="exampleInputName1">Category</label>
                      <select class="form-control" name="category_id" required>
                        <option value="">Select Category</option>
                        <?php
                          while($row_category = mysqli_fetch_assoc($res_category)){
                            if($row_category['id'] == $category_id){
                              echo "<option value='".$row_category['id']."' selected>".$row_category['category']."</option>";
                            }else{
                              echo "<option value='".$row_category['id']."'>".$row_category['category']."</option>";
                            }
                            
                          }
                        ?>
                        <option value="Select Category"></option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Dish Name</label>
                      <input type="textbox" class="form-control" placeholder="Dish Name" name="dish" value="<?php echo $dish ?>" required>
                      <div class="mt8">
                        <span class="error"><?php echo $msg ?></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Dish Detail</label>
                      <input type="textbox" class="form-control" placeholder="Dish Detail" name="dish_detail" value="<?php echo $dish_detail ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Image</label>
                      <input type="textbox" class="form-control" placeholder="Image" name="image" value="<?php echo $image ?>" >
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
