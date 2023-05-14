<?php 
    include('top.php'); 

    if(isset($_GET['type']) && $_GET['type'] != "" && isset($_GET['id']) && $_GET['id'] > 0){
        $type = $_GET['type'];
        $id = $_GET['id'];

        if($type == 'delete'){
          mysqli_query($con, "delete from coupon_code where id='$id'");
          redirect('coupon_code.php');
      }

        if($type == 'deactive' || $type == 'active'){
            $status = 1;
            if($type == 'deactive'){
                $status = 0;
            }
            mysqli_query($con, "update coupon_code set status = '$status' where id = '$id'");
            redirect('coupon_code.php');

        }
    }

    $sql = "select * from coupon_code order by id desc";
    $res = mysqli_query($con, $sql);
?>

<div class="card">
            <div class="card-body">
              <h2 class="grid_title">Coupon Code Master</h2>
              <a href="manage_coupon_code.php" class="add_link">Add Coupon Code</a>
              <div class="row grid_box">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="5%">S/No</th>
                            <th width="15%">Coupon Code</th>
                            <th width="5%">Type</th>
                            <th width="10%">Value</th>
                            <th width="10%">Min Value</th>
                            <th width="10%">Expired On</th>
                            <th width="10%">Status</th>
                            <th width="10%">Added On</th>
                            <th width="25%">Actions</th>
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
                            <td><?php echo $row['coupon_code'] ?></td>
                            <td><?php echo $row['coupon_type'] ?></td>
                            <td><?php echo $row['coupon_value'] ?></td>
                            <td><?php echo $row['cart_min_value'] ?></td>
                            <td>
                              <?php
                                if($row['expired_on'] == '0000-00-00'){
                                  echo 'NA';
                                }else{
                                  echo $row['expired_on'];
                                }
                              ?>
                             </td>
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
                                &nbsp;
                                <a href="manage_coupon_code.php?id=<?php echo $row['id'] ?>"><label class="badge badge-success hand_cursor">Edit</label></a>

                                &nbsp;
                                <a href="?id=<?php echo $row['id'] ?>&type=delete"><label class="badge badge-danger badge_delete hand_cursor">Delete</label></a>
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
