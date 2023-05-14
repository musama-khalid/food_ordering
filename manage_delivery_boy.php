<?php 
    include('top.php');

    $msg = "";
    $name = "";
    $mobile = "";
    $password = "";
    $id = "";

    if(isset($_GET['id']) && $_GET['id'] > 0){
      $id = $_GET['id'];
      $row = mysqli_fetch_assoc(mysqli_query($con, "select * from delivery_boy where id = '$id'"));
      $name = $row['name'];
      $mobile = $row['mobile'];
      $password = $row['password'];
    }

    if(isset($_POST['submit'])){
      $name = $_POST['name'];
      $mobile = $_POST['mobile'];
      $password = $_POST['password'];
      $added_on = date('Y-m-d h:i:s');

      if($id == ''){
        $sql = "select * from delivery_boy where mobile = '$mobile'";
      }else {
        $sql = "select * from delivery_boy where mobile = '$mobile' and id!='$id'";
      }


      if(mysqli_num_rows(mysqli_query($con, $sql)) > 0){
        $msg = "Mobile number already added";
      }else{
        if($id == ''){
          mysqli_query($con, "insert into delivery_boy(name, mobile, password, status, added_on) values('$name', '$mobile', '$password', 1, '$added_on')");
        }else {
          mysqli_query($con, "update delivery_boy set name = '$name', mobile = '$mobile', password = '$password' where id = '$id'");
        }
        redirect('delivery_boy.php');
      }

    }

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
                      <label for="exampleInputName1">Name</label>
                      <input type="text" class="form-control" placeholder="Name" name="name" value="<?php echo $name ?>" required>                     
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Mobile</label>
                      <input type="textbox" class="form-control" placeholder="Mobile" name="mobile" value="<?php echo $mobile ?>" required>
                      <div class="mt8">
                        <span class="error"><?php echo $msg ?></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Password</label>
                      <input type="textbox" class="form-control" placeholder="Password" name="password" value="<?php echo $password ?>" required>
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
