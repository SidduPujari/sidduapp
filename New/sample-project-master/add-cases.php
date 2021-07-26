<?php 

include_once('templates/header.php');
require_once('config/upload.php');
require_once('common-functions.php');
$statusMsg  = NULL; $erroCode = 0;
$msgVisible = 0; $errors=[];



if(isset($_POST['addCases'])) { 

            $cname = isset($_POST['cname']) ? clean_input($_POST['cname']) : '';
            $cstatus = isset($_POST['cstatus']) ? clean_input($_POST['cstatus']) : '';
            $caccount = isset($_POST['caccount']) ? clean_input($_POST['caccount']) : ''; 
            $cpriority = isset($_POST['cpriority']) ? clean_input($_POST['cpriority']) : ''; 
            $ccontacts = isset($_POST['ccontacts']) ? clean_input($_POST['ccontacts']) : '';
            $ctype = isset($_POST['ctype']) ? clean_input($_POST['ctype']) : ''; 
            $cenddate = isset($_POST['cenddate']) ? clean_input($_POST['cenddate']) : ''; 
            $cdescription = isset($_POST['cdescription']) ? clean_input($_POST['cdescription']) : '';
            $cuser = isset($_POST['cuser']) ? clean_input($_POST['cuser']) : '';
            $cteam = isset($_POST['cteam']) ? clean_input($_POST['cteam']) : '';  
            $created_at = date('Y-m-d H:i:s');
            if (empty($cname)){
                $errors['cname'] = 'Name field is required';
            }
            if (empty($cstatus)){
                $errors['cstatus'] = 'Status field is required';
            }
            if (empty($caccount)){
                $errors['caccount'] = 'Account field is required ';
            }
            if (empty($cpriority)){
                $errors['cpriority'] = 'Priority field is required';
            }
            if (empty($ccontacts)){
                $errors['ccontacts'] = 'Contact field is required';
            }
            if (empty($ctype)){
                $errors['ctype'] = 'Type field is required';
            }
            if (empty($cdescription)) {
                $errors['cdescription'] = 'Description field is required';
            }
            if (empty($cuser)) {
                $errors['cuser'] = 'Assigned user field is required';
            }
            if (empty($cteam)){
                $errors['cteam'] = 'Team field is required'; 
            }
            if(isset($_FILES['ccfile'])){
                $uploadReturn = uploadChosenImage($_FILES['ccfile'],'upload/cases/',array("doc", "docx","pdf","png", "jpg","jpeg"),777);
        
                if(isset($uploadReturn['errorCode']) && $uploadReturn['errorCode'] == 1) {
                    $errors['ccfile'] = $uploadReturn['message'];
                }
              
            }

            if(empty($errors)){
              /*  echo 'No errors';
                 exit;*/
                $createdby = $_SESSION['id'];
                $query = 'INSERT INTO crm_cases(name, status, account_id, priority, contact_id, type, description, file_path, assigned_user, department_id, created_by) VALUES (?,?,?,?,?,?,?,?,?,?,?)';
                $stmt = $con->prepare($query);
                   $stmt->bind_param("ssdsdsssddd", $cname,$cstatus,$caccount,$cpriority,$ccontacts,$ctype,$cdescription,  $uploadReturn['uplodedPath'],$cuser,$cteam,$createdby);
                   if($stmt->execute() == true){
                    $statusMsg  = 'Case has been created successfully.'; $erroCode = 0;
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
        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></i></li>
        <li class="breadcrumb-item"><a href="cases-list.php">Cases</a></li>
        <li class="breadcrumb-item">Create Case</li>
    </ol>

    <div class="text-right col-md-4 pt-1">
        <a href="cases-list.php" class="btn btn-primary btn-md"><i class="fas fa-list mr-1"></i>List</a>
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
  <strong>'.APPNAME.'!! </strong>'.$statusMsg.'<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div></div></div>';
    }?>
    <form action="/add-cases.php" method="POST" autocomplete="off" enctype="multipart/form-data">
        <div class="row mb-4">
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input class="form-control <?php echo isset($errors['cname']) ? 'is-invalid' : '';?>"
                                    type="text" name="cname" placeholder="Name *" value="<?php echo isset($cname) ? $cname : '';?>"/>
                                <?php 
                                    if(isset($errors['cname'])){
                                        echo '<p class="text-danger">'.$errors['cname'].'</p>';
                                    }
                                ?>
                            </div>
                            <div class="form-group col-md-6">
                                <select class="form-control custom-select <?php echo isset($errors['cstatus']) ? 'is-invalid' : '';?>" name="cstatus">
                                    <?php 
                                    if(isset($cstatus)){
                                         echo get_caseStatus($cstatus);
                                    } else {
                                        echo get_caseStatus();
                                    }
                                    ?>
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
                                <select class="form-control custom-select <?php echo isset($errors['caccount']) ? 'is-invalid' : '';?>" name="caccount">
                                    <option value="">Select Account</option>
                                     <?php
                                if ($stmt = $con->prepare("SELECT id, name FROM  crm_account ")) {
                                        $stmt->execute();

                                        $stmt->bind_result($id, $name);
                                        while ($stmt->fetch()) {
                                            if(isset($caccount) && $id == $caccount ){
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
                                    if(isset($errors['caccount'])){
                                        echo '<p class="text-danger">'.$errors['caccount'].'</p>';
                                    }
                                ?>
                            </div>
                            <div class="form-group col-md-6">
                            <select class="form-control custom-select <?php echo isset($errors['cpriority']) ? 'is-invalid' : '';?>" name="cpriority">
                                    <?php  
                                     if(isset($cpriority)){
                                         echo get_priorities($cpriority);
                                    } else {
                                    echo get_priorities();
                                }?>
                                </select>
                                <?php 
                                    if(isset($errors['cpriority'])){
                                        echo '<p class="text-danger">'.$errors['cpriority'].'</p>';
                                    }
                                ?>
                            </div>
                            
                        </div>
                        <div class="row">   
                            <div class="form-group col-md-6">
                                    <select class="form-control custom-select <?php echo isset($errors['ccontacts']) ? 'is-invalid' : '';?>" name="ccontacts">
                                        <option value="">Select Contacts</option>
                                         <?php
                               if ($stmt = $con->prepare("SELECT id,personal_title,firstname,lastname FROM   crm_contacts ")) {
                                        $stmt->execute();

                                        $stmt->bind_result($id, $title,$firstname,$lastname);
                                        while ($stmt->fetch()) {
                                            if(isset($ccontacts) && $id == $ccontacts ){
                                                echo "<option value=" . $id . " selected='selected'>" . ucfirst($title.' '.$firstname.' '.$lastname)."</option>\n";
                                            } else {
                                                echo "<option value=" . $id . ">" . ucfirst($title.' '.$firstname.' '.$lastname)."</option>\n";
                                            }
                                        }
                                    $stmt->close();
                                }
                                ?>
                                    </select>
                                    <?php 
                                        if(isset($errors['ccontacts'])){
                                            echo '<p class="text-danger">'.$errors['ccontacts'].'</p>';
                                        }
                                    ?>
                            </div>
                            <div class="form-group col-md-6">
                                    <select class="form-control custom-select <?php echo isset($errors['ctype']) ? 'is-invalid' : '';?>"  name="ctype">
                                        <?php 
                                            if(isset($ctype)){
                                                 echo get_casetype($ctype);
                                            } else {
                                                echo get_casetype();
                                            }    
                                            ?>

                                    </select>
                                    <?php 
                                        if(isset($errors['ctype'])){
                                            echo '<p class="text-danger">'.$errors['ctype'].'</p>';
                                        }
                                    ?>
                            </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-12">
                            <input type="file"  name="ccfile" class="form-control <?php echo isset($errors['ccfile']) ? 'is-invalid' : ''?>" >
                             <small>Upload Doc,Docx,Pdf,Png,Jpg,Jpeg files</small>
                            <?php 
                                if(isset($errors['ccfile'])){
                                    echo '<p class="text-danger m-0">'.$errors['ccfile'].'</p>';
                                }
                            ?>
                        </div>
                        </div>                
                        <div class="row">
                            <div class="form-group col-md-12">
                                <textarea class="form-control <?php echo isset($errors['cdescription']) ? 'is-invalid' : '';?>" name="cdescription" placeholder="Description*"><?php echo isset($cdescription)  ? $cdescription :'';?></textarea>
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
                                <select class="form-control custom-select <?php echo isset($errors['cuser']) ? 'is-invalid' : '';?>" name="cuser">
                                    <option value=""> Select Assigned user*</option>
                                    <?php
                                if ($stmt = $con->prepare("SELECT id, firstname,lastname from users ")) {
                                        $stmt->execute();

                                        $stmt->bind_result($id, $firstname,$lastname);
                                        while ($stmt->fetch()) {
                                         if(isset($cuser) && $id == $cuser ){
                                                echo "<option value=" . $id . " selected='selected'>" . ucfirst($firstname.' '.$lastname)."</option>\n";
                                            } else {

                                                echo "<option value=" . $id . ">" . ucfirst($firstname.' '.$lastname)."</option>\n";
                                            }
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
                                <select class="form-control custom-select <?php echo isset($errors['cteam']) ? 'is-invalid' : '';?>" name="cteam">
                                    <option value=""> Select Team</option>
                                    <?php
                                if ($stmt = $con->prepare("SELECT id, title from crm_department ")) {
                                        $stmt->execute();

                                        $stmt->bind_result($id, $title);
                                        while ($stmt->fetch()) {
                                            if(isset($cteam) && $id == $cteam ){
                                                echo "<option value=" . $id . " selected='selected'>" . ucfirst($title)."</option>\n";
                                            } else {

                                                echo "<option value=" . $id . ">" . ucfirst($title)."</option>\n";
                                            }
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
                <button type="reset" class="btn btn-secondary mr-2">Clear</button>
                <button type="submit" class="btn btn-primary" name="addCases" value="submit">Submit</button>
            </div>
        </div>
    </form>
</div>
<?php
    include_once 'templates/footer.php';
    ?>