<?php 
    include('top.php'); 

    if(isset($_GET['type']) && $_GET['type'] != "" && isset($_GET['id']) && $_GET['id'] > 0){
        $type = $_GET['type'];
        $id = $_GET['id'];

        if($type == 'deactive' || $type == 'active'){
            $status = 1;
            if($type == 'deactive'){
                $status = 0;
            }
            mysqli_query($con, "update dish set status = '$status' where id = '$id'");
            redirect('dish.php');

        }
    }

    $sql = "select dish.*, category.category from dish, category where dish.category_id = category.id order by dish.id desc";
    $res = mysqli_query($con, $sql);
?>

<div class="card">
            <div class="card-body">
              <h2 class="grid_title">Dish Master</h2>
              <a href="manage_dish.php" class="add_link">Add Dish</a>
              <div class="row grid_box">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="5%">S/No</th>
                            <th width="20%">Category</th>
                            <th width="20%">Dish</th>
                            <th width="10%">Image</th>
                            <th width="10%">Status</th>
                            <th width="20%">Added On</th>
                            <th width="15%">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        if(mysqli_num_rows($res) > 0){ 
                            $i = 1;
                            while($row = mysqli_fetch_assoc($res)){
                        ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $row['category'] ?></td>
                            <td><?php echo $row['dish'] ?></td>
                            <td><?php echo $row['image'] ?></td>
                            <td><?php echo $row['status'] ?></td>
                            <td>
                              <?php
                                $dateStr = strtotime($row['added_on']);
                                
                                echo date('d-m-Y', $dateStr); 
                              ?>
                            </td>
                            <td>  
                                <?php
                                if($row['status'] == 1){
                                    ?>
                                    <a href="?id=<?php echo $row['id'] ?>&type=deactive"><label class="badge badge-danger hand_cursor">Active</label></a>

                                <?php
                                }else{
                                    ?>
                                    <a href="?id=<?php echo $row['id'] ?>&type=active"><label class="badge badge-info hand_cursor">Deactive</label></a>
                                <?php
                                }
                                ?>

                                <a href="manage_dish.php?id=<?php echo $row['id'] ?>"><label class="badge badge-success hand_cursor">Edit</label></a>
                            </td>
                        </tr>
                        <?php 
                        $i++; 
                        } } else{ ?>
                        <tr>
                            <td colspan="5">No Data Found</td>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
				</div>
              </div>
            </div>
          </div>

<?php include('footer.php'); ?>
