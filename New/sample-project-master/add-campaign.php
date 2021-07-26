<?php 

include_once('templates/header.php');
require_once('config/upload.php');
// require_once('common-functions.php');
$statusMsg  = NULL; $erroCode = 0;
$msgVisible = 0; $errors=[];

function clean_input($field = false){
    $field = trim($field);
    $field = stripslashes($field);
    $field = htmlspecialchars($field);
    return $field;
}

if(isset($_POST['addCampaign']))
{ 
            // echo '<pre>'; print_r($_POST); echo '</pre>';
            // exit;

            $cname = isset($_POST['cname']) ? clean_input($_POST['cname']) : '';
            $cstatus = isset($_POST['cstatus']) ? clean_input($_POST['cstatus']) : '';
            $ctype = isset($_POST['ctype']) ? clean_input($_POST['ctype']) : ''; 
            $cbudget = isset($_POST['cbudget']) ? clean_input($_POST['cbudget']) : ''; 
            $ctarget = isset($_POST['ctarget']) ? clean_input($_POST['ctarget']) : '';
            $cstartdate = isset($_POST['cstartdate']) ? clean_input($_POST['cstartdate']) : ''; 
            $cenddate = isset($_POST['cenddate']) ? clean_input($_POST['cenddate']) : ''; 
            $cdescription = isset($_POST['cdescription']) ? clean_input($_POST['cdescription']) : '';
            $cuser = isset($_POST['cuser']) ? clean_input($_POST['cuser']) : '';
            $cteam = isset($_POST['cteam']) ? clean_input($_POST['cteam']) : '';  
            $created_at = date('Y-m-d H:i:s');
            if (empty($cname)){
                $errors['cname'] = 'Please fill campaign name field input';
            }
            if (empty($cstatus)){
                $errors['cstatus'] = 'Please fill status field input';
            }
            if (empty($ctype)){
                $errors['ctype'] = 'Please fill type field input';
            }
            if (empty($cbudget)){
                $errors['cbudget'] = 'Please enter budget field input';
            }
            if (empty($ctarget)){
                $errors['ctarget'] = 'Please fill target field input';
            }
            if (empty($cstartdate)){
                $errors['cstartdate'] = 'Please select start date input';
            }
            if (empty($cenddate)){
                $errors['cenddate'] = 'Please select end date input';
            }
            if (empty($cdescription)) {
                $errors['cdescription'] = 'Please fill description field input';
            }
            if (empty($cuser)) {
                $errors['cuser'] = 'Please fill user field input';
            }
            if (empty($cteam)){
                $errors['cteam'] = 'Please fill team field input';
            }

            if(empty($errors)){
                $createdby = $_SESSION['id'];
                $cstartdate = date('Y-m-d H:i:s',strtotime($cstartdate));
                $cenddate = date('Y-m-d H:i:s',strtotime($cenddate));
                $query = 'INSERT INTO crm_campaign (name, status,type,budget,target,start_date,end_date,description,assigned_user,department_id,created_at,created_by) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)';
                $stmt = $con->prepare($query);
                   $stmt->bind_param("sssddsssddsd", $cname,$cstatus,$ctype,$cbudget,$ctarget,$cstartdate,$cenddate,$cdescription,$cuser,$cteam,$created_at,$createdby);
                   if($stmt->execute() == true){
                    $statusMsg  = 'Campaign has been created successfully.'; $erroCode = 0;
                    $msgVisible = 1;
                 } else {
                    // print_r($_POST);
                    // echo $con->error;
                    // exit;
                  $statusMsg  = 'Something went wrong.'; $erroCode = 1;
                    $msgVisible = 1;
                 }
                        //      echo  $stmt->error;
                        //   exit;
                       $stmt->close();
                   }
                //    print_r($_POST);
                //    echo $con->error;
                //    exit;
}            
?>
<div class="row  mb-3 mt-3">
    <ol class="breadcrumb bg-transparent col-md-8 m-0">
        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></i></li>
        <li class="breadcrumb-item"><a href="campaign-list.php">Campaign</a></li>
        <li class="breadcrumb-item">Create Campaign</li>
    </ol>

    <div class="text-right col-md-4 pt-1">
        <a href="campaign-list.php" class="btn btn-primary btn-md"><i class="fas fa-list mr-1"></i>List</a>
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
  <strong>MODUX!! </strong>'.$statusMsg.'<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div></div></div>';
    }?>
    <form action="/add-campaign.php" method="POST" autocomplete="off">
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input class="form-control <?php echo isset($errors['cname']) ? 'is-invalid' : '';?>"
                                    type="text" name="cname" placeholder="Name *" />
                                <?php 
                                    if(isset($errors['cname'])){
                                        echo '<p class="text-danger">'.$errors['cname'].'</p>';
                                    }
                                ?>
                            </div>
                            <div class="form-group col-md-6">
                                <select
                                    class="form-control custom-select <?php echo isset($errors['cstatus']) ? 'is-invalid' : '';?>"
                                    name="cstatus">
                                    <option value="">Select Status</option>
                                    <option value="Planning">Planning</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Complete">Complete</option>
                                </select>
                                <?php 
                                    if(isset($errors['cstatus'])){
                                        echo '<p class="text-danger">'.$errors['cstatus'].'</p>';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <select
                                    class="form-control custom-select <?php echo isset($errors['ctype']) ? 'is-invalid' : '';?>"
                                    name="ctype">
                                    <option value="">Select type</option>
                                    <option value="Email"> Email</option>
                                    <option value="Newsletter"> Newsletter</option>
                                    <option value="Web"> Web</option>
                                    <option value="Television"> Television</option>
                                    <option value="Radio"> Radio</option>
                                    <option value="Mail"> Mail</option>
                                </select>
                                <?php 
                                    if(isset($errors['ctype'])){
                                        echo '<p class="text-danger">'.$errors['ctype'].'</p>';
                                    }
                                ?>
                            </div>
                            <div class="form-group col-md-6">
                            <input class="form-control <?php echo isset($errors['cbudget']) ? 'is-invalid' : '';?>"
                                   name="cbudget" placeholder="Budget *" />
                                <?php 
                                    if(isset($errors['cbudget'])){
                                        echo '<p class="text-danger">'.$errors['cbudget'].'</p>';
                                    }
                                ?>
                            </div>
                            
                        </div>
                        <div class="row">   
                        <div class="form-group col-md-6">
                            <select class="form-control custom-select <?php echo isset($errors['ctarget']) ? 'is-invalid' : '';?>" name="ctarget">
                                    <option value="">Select Target</option>
                                        <?php
                                if ($stmt = $con->prepare("SELECT id, name from crm_targetlist ORDER BY name ASC")) {
                                        $stmt->execute();

                                        $stmt->bind_result($id, $name);
                                        while ($stmt->fetch()) {
                                            if(isset($target) && $id == $target){
                                                echo "<option value=" . $id . " selected='selected'>" . ucfirst($name)."</option>\n";
                                            } else {
                                                 echo "<option value=" . $id . ">" . ucfirst($name)."</option>\n";
                                            }
                                        }
                                    $stmt->close();
                                }
                                ?>
                                </select>
                                <?php 
                                    if(isset($errors['ctarget'])){
                                        echo '<p class="text-danger">'.$errors['ctarget'].'</p>';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input
                                    class="form-control startdatetime <?php echo isset($errors['cstartdate']) ? 'is-invalid' : '';?>"
                                    type="text" name="cstartdate" placeholder="Date Start *" />
                                <?php 
                                    if(isset($errors['cstartdate'])){
                                        echo '<p class="text-danger">'.$errors['cstartdate'].'</p>';
                                    }
                                ?>
                            </div>
                            <div class="form-group col-md-6">
                                <input
                                    class="form-control enddatetime <?php echo isset($errors['cenddate']) ? 'is-invalid' : '';?>"
                                    type="text" name="cenddate" placeholder="End Date*" />
                                <?php 
                                    if(isset($errors['cenddate'])){
                                        echo '<p class="text-danger">'.$errors['cenddate'].'</p>';
                                    }
                                ?>
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="form-group col-md-12">
                                <textarea
                                    class="form-control <?php echo isset($errors['cdescription']) ? 'is-invalid' : '';?>"
                                    name="cdescription" placeholder="Description*"></textarea>
                                <?php 
                                    if(isset($errors['cdescription'])){
                                        echo '<p class="text-danger">'.$errors['cdescription'].'</p>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-md-12">
                                <select
                                    class="form-control custom-select <?php echo isset($errors['cuser']) ? 'is-invalid' : '';?>"
                                    name="cuser">
                                    <option value=""> Select Assigned user*</option>
                                    <?php
                                if ($stmt = $con->prepare("SELECT id, firstname,lastname from users ")) {
                                        $stmt->execute();

                                        $stmt->bind_result($id, $firstname,$lastname);
                                        while ($stmt->fetch()) {
                                                echo "<option value=" . $id . ">" . ucfirst($firstname.' '.$lastname)."</option>\n";
                                        }
                                    $stmt->close();
                                }
                                ?>
                                </select>
                                <?php 
                                    if(isset($errors['cuser'])){
                                        echo '<p class="text-danger">'.$errors['cuser'].'</p>';
                                    }
                                ?>
                            </div>
                            <div class="form-group col-md-12">
                                <select
                                    class="form-control custom-select <?php echo isset($errors['cteam']) ? 'is-invalid' : '';?>"
                                    name="cteam">
                                    <option value=""> Select Team</option>
                                    <?php
                                if ($stmt = $con->prepare("SELECT id, title from crm_department ")) {
                                        $stmt->execute();

                                        $stmt->bind_result($id, $title);
                                        while ($stmt->fetch()) {
                                                echo "<option value=" . $id . ">" . ucfirst($title)."</option>\n";
                                        }
                                    $stmt->close();
                                }
                                ?>
                                </select>
                                <?php 
                                    if(isset($errors['cteam'])){
                                        echo '<p class="text-danger">'.$errors['cteam'].'</p>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-8 text-right">
                <button type="reset" class="btn btn-secondary">Clear</button>
                <button type="submit" class="btn btn-primary" name="addCampaign" value="submit">Submit</button>
            </div>
        </div>
    </form>
</div>
<?php
    include_once 'templates/footer.php';
    ?>