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
            mysqli_query($con, "update delivery_boy set status = '$status' where id = '$id'");
            redirect('delivery_boy.php');

        }
    }

    $sql = "select * from delivery_boy order by id desc";
    $res = mysqli_query($con, $sql);
?>

<div class="card">
            <div class="card-body">
              <h2 class="grid_title">Delivery Boy Master</h2>
              <a href="manage_delivery_boy.php" class="add_link">Add Delivery Boy</a>
              <div class="row grid_box">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="5%">S/No</th>
                            <th width="25%">Name</th>
                            <th width="20%">Mobile</th>
                            <th width="10%">Status</th>
                            <th width="25%">Added On</th>
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
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['mobile'] ?></td>
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

                                <a href="manage_delivery_boy.php?id=<?php echo $row['id'] ?>"><label class="badge badge-success hand_cursor">Edit</label></a>
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
