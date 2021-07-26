<?php
    require_once('templates/header.php'); 
    require_once('common-functions.php');
    $statusMsg  = NULL; $erroCode = 0;
    $msgVisible = 0;
    $errors = [];



if(isset($_POST['addBaremetalLocations'])){ 

    $datacenter = isset($_POST['datacenter']) ? clean_input($_POST['datacenter']) : '';  
    $baremetal = isset($_POST['baremetal']) ? clean_input($_POST['baremetal']) : '';  
    $status = isset($_POST['status']) ? clean_input($_POST['status']) : '';  
        if(empty($datacenter)){
            $errors['datacenter'] = 'Datacenter field is required';
        }

         if(empty($baremetal)){
            $errors['baremetal'] = 'Baremetal field is required';
        }       
        if(empty($status)){
            $errors['status'] = 'Status field is required';
        }

        if(isset($_POST['price'])){
            if(!is_numeric($_POST['price'])){
                $errors['price'] = 'Price field should have numeric value';
            } else {
                $price = $_POST['price'];
            }
            
        } else {
                $price = 0;
        }
        if(empty($errors)){
            $stmt = $con->prepare("INSERT INTO baremetal_datacenter_price(baremetal_id, price,location_id,status) VALUES (?,?,?,?)");
            $stmt->bind_param("ddds",$baremetal,$price,$datacenter,$status);
             if($stmt->execute() == true){
                       $statusMsg  = 'Baremetal Location has been created successfully.'; $erroCode = 0;
                       $msgVisible = 1;
                    } else {
                       $statusMsg  = 'Something went wrong.'; $erroCode = 1;
                       $msgVisible = 1;
                    }
                $stmt->close();
            }
    }
  
?>

<div class="row  mb-3 mt-3">
    <ol class="breadcrumb bg-transparent col-md-8 m-0">
       <li class="breadcrumb-item"><a href="/dashboard.php">Dashboard</a></i></li>
       <li class="breadcrumb-item"><a href="/bare-metal-locations.php">Baremetal Locations</a></i></li>
        <li class="breadcrumb-item">Add Baremetal Location</li>
    </ol>
    <div class="col-md-4">
        <div class="text-right pt-2">
            <a href="bare-metal-locations.php" class="btn btn-primary btn-md"><i class="fas fa-list mr-2"></i>List</a>
        </div>
    </div>
</div>
 
<div class="tab-content">

     <?php if(isset($erroCode) && $msgVisible == 1){
        if($erroCode == 1) {
            $alertClass= 'danger';
        } else {
            $alertClass= 'success';
        }

        echo '<div class="row"><div class="col-md-6 offset-md-3"><div class="alert alert-'.$alertClass.' alert-dismissible fade show" role="alert">
  <strong> '.APPNAME.' !! </strong>'.$statusMsg.'<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div></div></div>';
    }?> 

<div class="row">
    <div class="col-md-6 offset-md-3">
        <form action="/add-baremetal-location.php" method="POST" autocomplete="off">  
            <div class="card mb-4 mt-4">
                <div class="card-body">
                        <div class="row">
                              <div class="form-group col-md-6">
                                <select class="form-control custom-select <?php echo isset($errors['baremetal']) ? 'is-invalid' : '';?>" id="baremetal" name="baremetal">
                                    <option value="">Bare metal</option>
                                        <?php
                                        if ($stmt = $con->prepare("SELECT id,processor_name,baremetal_type FROM baremetal")) {
                                            $stmt->execute();

                                            $stmt->bind_result($id, $processorName,$baremetalType);
                                            while ($stmt->fetch()) {
                                                if(isset($baremetal) && $id == $baremetal){
                                                    echo "<option value=" . $id . ">" . $processorName . " - ".ucfirst($baremetalType)."</option>";
                                                } else {

                                                    echo "<option value=" . $id . ">" . $processorName . " - ".ucfirst($baremetalType)."</option>";
                                                }
                                            }
                                            $stmt->close();
                                        }
                                        ?>
                                </select>
                                <?php 
                                    if(isset($errors['baremetal'])){
                                        echo '<p class="text-danger">'.$errors['baremetal'].'</p>';
                                    }
                                ?>
                            </div>

                            <div class="form-group col-md-6">
                                <select class="form-control custom-select <?php echo isset($errors['datacenter']) ? 'is-invalid' : '';?>" id="datacenter" name="datacenter">
                                    <option value="">Select Datacenter</option>
                                        <?php
                                        if ($stmt = $con->prepare("SELECT l.id as locid, l.alias,l.companyname,l.suite,l.city,s.statename FROM locations as l LEFT JOIN states as s ON  s.id =l.state_id ")) {
                                            $stmt->execute();

                                            $stmt->bind_result($locid, $alias,$companyname,$suite,$city,$statename);
                                            while ($stmt->fetch()) {
                                                if(isset($datacenter) && $locid == $datacenter){
                                                     echo "<option value=" . $locid . " selected='selected'>" . $alias . " - ".$companyname." - ".$suite." - ".$city.", ".$statename."</option>\n";
                                                } else {
                                                    echo "<option value=" . $locid . ">" . $alias . " - ".$companyname." - ".$suite." - ".$city.", ".$statename."</option>\n";
                                                }
                                            }
                                            $stmt->close();
                                        }
                                        ?>
                                </select>
                                 <?php 
                                    if(isset($errors['datacenter'])){
                                        echo '<p class="text-danger">'.$errors['datacenter'].'</p>';
                                    }
                                ?>
                            </div>
                          
                            <div class="form-group col-md-6">
                            <input type="text" id="price"  name="price" class="form-control <?php echo isset($errors['price']) ? 'is-invalid' : '';?>" placeholder="Price" value="<?php echo isset($price) ? $price : '';?>">
                             <?php 
                                    if(isset($errors['price'])){
                                        echo '<p class="text-danger">'.$errors['price'].'</p>';
                                    }
                                ?>

                        </div>
                            <div class="form-group col-md-6">
                                <select class="form-control custom-select <?php echo isset($errors['status']) ? 'is-invalid' : '';?>" name="status">
                                    <option value="">Select status</option>
                                    <option value="enable" <?php echo (isset($status) && $status == 'enable') ? 'selected="selected"' : '';?>>Enable</option>
                                    <option value="disable" <?php echo (isset($status) && $status == 'disable') ? 'selected="selected"' : '';?>>Disable</option>
                                </select>
                                <?php 
                                    if(isset($errors['status'])){
                                        echo '<p class="text-danger">'.$errors['status'].'</p>';
                                    }
                                ?>
                            </div>
                        </div>
                            
                       
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-right">
                    <button type="reset" class="btn btn-secondary mr-2">Cancel</button>
                    <button type="submit" class="btn btn-primary"  name="addBaremetalLocations" value="submit">Submit</button>
            </div>
        </div>
     </form>
    </div>
   
 </div>   

   
</div>

    <?php 
    require_once('templates/footer.php'); 

        //require_once('templates/footer.php'); 
    ?>
