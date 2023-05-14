<?php 
    include('top.php');

    $msg = "";
    $category = "";
    $order_number = "";
    $id = "";

    if(isset($_GET['id']) && $_GET['id'] > 0){
      $id = $_GET['id'];
      $row = mysqli_fetch_assoc(mysqli_query($con, "select * from category where id = '$id'"));
      $category = $row['category'];
      $order_number = $row['order_number'];
    }

    if(isset($_POST['submit'])){
      $category = $_POST['category'];
      $order_number = $_POST['order_number'];
      $added_on = date('Y-m-d h:i:s');

      if($id == ''){
        $sql = "select * from category where category = '$category'";
      }else {
        $sql = "select * from category where category = '$category' and id!='$id'";
      }


      if(mysqli_num_rows(mysqli_query($con, $sql)) > 0){
        $msg = "Category already added";
      }else{
        if($id == ''){
          mysqli_query($con, "insert into category(category, order_number, status, added_on) values('$category', '$order_number', 1, '$added_on')");
        }else {
          mysqli_query($con, "update category set category = '$category', order_number = '$order_number' where id = '$id'");
        }
        redirect('category.php');
      }

    }

?>

<div class="card">
            <div class="card-body">
              <div class="row">
			      <h1 class="card-title ml10 ml15 manage_category grid_title">Manage Category</h1>
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="POST">
                    <div class="form-group">
                      <label for="exampleInputName1">Category Name</label>
                      <input type="text" class="form-control" placeholder="Category Name" name="category" value="<?php echo $category ?>" required>
                      <div class="mt8">
                        <span class="error"><?php echo $msg ?></span>
                      </div>                     
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Order Number</label>
                      <input type="textbox" class="form-control" placeholder="Order Number" name="order_number" value="<?php echo $order_number ?>" required>
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
