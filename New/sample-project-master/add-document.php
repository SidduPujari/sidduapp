<?php 

include_once('templates/header.php');
require_once('config/upload.php');
require_once('common-functions.php'); 
$statusMsg  = NULL; $erroCode = 0;
$msgVisible = 0; $errors=[];

if(isset($_GET['id'])){
    $stmt = $con->prepare("SELECT * FROM crm_folders WHERE id = ?");
    $stmt->bind_param("d", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows === 0) { 
        header('Location: document-list.php');
    } else {
        $row = $result->fetch_assoc();
    }
} else {
    header('Location: document-list.php');
}
//   Delete Records 
if(isset($_GET['id']) && isset($_GET['docId'])) {
    $id = $_GET['docId'];
    $fid = $_GET['id'];
    $stmt = $con->prepare("DELETE FROM crm_documents WHERE id = ? AND folder_id = ?");
    $stmt->bind_param("dd", $id,$fid);
    $stmt->execute();
    if($stmt->affected_rows === 0){
        $statusMsg  = 'Can not be delete '; $erroCode = 1;$msgVisible = 1;
    } else {
         $statusMsg  = 'Record has been deleted successfully'; $erroCode = 0;$msgVisible = 1;
         header("Refresh:0; url=add-document.php?id=".$fid);
    }
    $stmt->close();
    
   //header('Location: globalconnect.php');
}
// Delete records ends
if(isset($_POST['addDocument']))
{ 
            // echo '<pre>'; print_r($_POST); echo '</pre>';
            // exit;

            $dname = isset($_POST['dname']) ? clean_input($_POST['dname']) : '';
            $dtype = isset($_POST['dtype']) ? clean_input($_POST['dtype']) : ''; 
            $dstatus = isset($_POST['dstatus']) ? clean_input($_POST['dstatus']) : '';
            $dstartdate = isset($_POST['dstartdate']) ? clean_input($_POST['dstartdate']) : ''; 
            $dexpirationdate = isset($_POST['dexpirationdate']) ? clean_input($_POST['dexpirationdate']) : ''; 
            $cenddate = isset($_POST['cenddate']) ? clean_input($_POST['cenddate']) : ''; 
            $ddescription = isset($_POST['ddescription']) ? clean_input($_POST['ddescription']) : '';
            $duser = isset($_POST['duser']) ? clean_input($_POST['duser']) : '';
            $dteam = isset($_POST['dteam']) ? clean_input($_POST['dteam']) : '';  
            if (empty($dname)){
                $errors['dname'] = 'Please fill document name field input';
            }

            if (empty($dtype)){
                $errors['dtype'] = 'Please select type field input';
            }
            if (empty($dstatus)){
                $errors['dstatus'] = 'Please select status field input';
            }
            if (empty($dstartdate)){
                $errors['dstartdate'] = 'Please select publish date field input';
            }
            if (empty($dexpirationdate)){
                $errors['dexpirationdate'] = 'Please select expiration date input';
            }
            if (empty($ddescription)) {
                $errors['ddescription'] = 'Please fill description field input';
            }
            if (empty($duser)) {
                $errors['duser'] = 'Please fill user field input';
            }
            if (empty($dteam)){
                $errors['dteam'] = 'Please fill team field input';
            }
            if(isset($_FILES['ccfile'])){
                $uploadReturn = uploadChosenImage($_FILES['ccfile'],'upload/documents/',array("doc", "docx","pdf"),2048);
                //print_r($uploadReturn);
        
                if(isset($uploadReturn['errorCode']) && $uploadReturn['errorCode'] == 1) {
                    $errors['ccfile'] = $uploadReturn['message'];
                }
            } 
            // print_r($errors);
            if(empty($errors)){
                $fid = $_GET['id'];
                $createdby = $_SESSION['id'];
                $dstartdate = date('Y-m-d H:i:s',strtotime($dstartdate));
                $dexpirationdate = date('Y-m-d H:i:s',strtotime($dexpirationdate));
                $query = 'INSERT INTO crm_documents(name, folder_id, file_path, type, status, publish_date, expiration_date, description, assigned_id, department_id, created_by) VALUES (?,?,?,?,?,?,?,?,?,?,?)';
                $stmt = $con->prepare($query);
                   $stmt->bind_param("sdssssssddd", $dname,$fid,$uploadReturn['uplodedPath'],$dtype,$dstatus,$dstartdate,$dexpirationdate,$ddescription,$duser,$dteam,$createdby);
                   if($stmt->execute() == true){
                    $statusMsg  = 'Document has been created successfully.'; $erroCode = 0;
                    $msgVisible = 1;
                 } else {
                    // print_r($_POST);
                    // echo $con->error;
                    // exit;
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
        <li class="breadcrumb-item"><a href="document-list.php">Document</a></li>
        <li class="breadcrumb-item">Create Document</li>
    </ol>
    <div class="text-right col-md-4 pt-1">
    <h1 class="m-0 ">You are in:&nbsp;<b class="text-uppercase orange-text"><?php echo isset($row['name']) ? $row['name'] : '';?></b></h1> 
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
  <strong>'.APPNAME.' !! </strong>'.$statusMsg.'<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div></div></div>';
    }?>
    <form action="add-document.php?id=<?php echo  isset($row['id']) ? $row['id'] : '';?>" method="POST" autocomplete="off" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo isset($row['id']) ? $row['id'] : '';?>">
        <div class="row mb-4">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input class="form-control <?php echo isset($errors['dname']) ? 'is-invalid' : '';?>"
                                    type="text" name="dname" placeholder="Name *" />
                                <?php 
                                    if(isset($errors['dname'])){
                                        echo '<p class="text-danger">'.$errors['dname'].'</p>';
                                    }
                                ?>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="file"   name="ccfile" class="form-control<?php echo isset($errors['ccfile']) ? 'is-invalid' : ''?>">
                                <?php 
                                    if(isset($errors['ccfile'])){
                                        echo '<p class="text-danger m-0">'.$errors['ccfile'].'</p>';
                                    }
                                ?>
                            </div>        
                            <div class="form-group col-md-6">
                                <select class="form-control custom-select <?php echo isset($errors['dtype']) ? 'is-invalid' : '';?>" name="dtype">
                                 <?php echo get_typeOfDoc();?>
                                </select>
                                <?php 
                                      if(isset($errors['dtype'])){
                                          echo '<p class="text-danger m-0">'.$errors['dtype'].'</p>';
                                      }
                                  ?>
                            </div>
                            <div class="form-group col-md-6">
                                <select class="form-control custom-select <?php echo isset($errors['dstatus']) ? 'is-invalid' : '';?>" name="dstatus">
                                    <option value="">Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Draft">Draft</option>
                                    <option value="Expired">Expired</option>
                                    <option value="Canceled">Canceled</option>
                                </select>
                                <?php 
                                      if(isset($errors['dstatus'])){
                                          echo '<p class="text-danger m-0">'.$errors['dstatus'].'</p>';
                                      }
                                  ?>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <input
                                    class="form-control startdatetime <?php echo isset($errors['dstartdate']) ? 'is-invalid' : '';?>"
                                    type="text" name="dstartdate" placeholder="Publish Date*" />
                                <?php 
                                    if(isset($errors['dstartdate'])){
                                        echo '<p class="text-danger">'.$errors['dstartdate'].'</p>';
                                    }
                                ?>
                            </div>
                            <div class="form-group col-md-6">
                                <input
                                    class="form-control startdatetime <?php echo isset($errors['dexpirationdate']) ? 'is-invalid' : '';?>"
                                    type="text" name="dexpirationdate" placeholder="Expiration Date*" />
                                <?php 
                                    if(isset($errors['dexpirationdate'])){
                                        echo '<p class="text-danger">'.$errors['dexpirationdate'].'</p>';
                                    }
                                ?>
                            </div>
                           
                        </div>
                        <div class="row">

                        <div class="form-group col-md-6">
                            <select
                                class="form-control custom-select <?php echo isset($errors['duser']) ? 'is-invalid' : '';?>"
                                name="duser">
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
                                if(isset($errors['duser'])){
                                    echo '<p class="text-danger">'.$errors['duser'].'</p>';
                                }
                            ?>
                        </div>
                        <div class="form-group col-md-6">
                            <select
                                class="form-control custom-select <?php echo isset($errors['dteam']) ? 'is-invalid' : '';?>"
                                name="dteam">
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
                                if(isset($errors['dteam'])){
                                    echo '<p class="text-danger">'.$errors['dteam'].'</p>';
                                }
                            ?>
                        </div>
                        </div>
                        <div class="row">
                        <div class="form-group col-md-12">
                                <textarea class="form-control <?php echo isset($errors['ddescription']) ? 'is-invalid' : '';?>" placeholder="Description*" name="ddescription"></textarea>
                                <?php 
                                      if(isset($errors['ddescription'])){
                                          echo '<p class="text-danger m-0">'.$errors['ddescription'].'</p>';
                                      }
                                  ?>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="row mt-4">
                    <div class="col-md-12 text-right">
                        <button type="reset" class="btn btn-secondary mr-2">Clear</button>
                        <button type="submit" class="btn btn-primary" name="addDocument" value="submit">Submit</button>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
            <table class="table table-striped dataTable1">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>File</th>
                        <th>Status</th> 
                        <th>Created At</th> 
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $sql = 'SELECT id, name, status,file_path, created_date FROM crm_documents  WHERE folder_id = '.$_GET['id'].' ORDER BY id DESC ';
                    if ($stmt = $con->prepare($sql)) {
                        /* bind variables to prepared statement */
                        $stmt->bind_result($docId,$name,$status,$file_path,$created_date);
                        $stmt->execute();
                        while ($stmt->fetch()) { 
                        ?>
                    <tr>
                    <td><?php echo ucfirst($name); ?></td>
                    <td><?php echo '<p><a href="'.DOMAIN_NAME.$file_path.'" target="_blank"><i class="fas fa-file"></i></a></p>';?></td>
                    <td><?php echo $status; ?></td>
                    <td><?php $cstartdate = date('m/d/Y H:i A',strtotime($created_date)); echo $cstartdate;?></td>
                             <td>
                            <a href='edit-document.php?id=<?php echo $_GET['id'].'&docId='.$docId; ?>' class='mr-2' title='Edit'><i class='fas fa-edit'></i></a>
                            <a href='add-document.php?id=<?php echo $_GET['id'].'&docId='.$docId; ?>'
                                title='Delete' class='delete-record' data-title='Are you sure you want to delete?'><i
                                    class='fas fa-times-circle'></i></a>
                        </td>
                    </tr>
                    <?php   }
   
}
?>
                </tbody>
            </table>
        </div>             
                    </div>
                </div>
            </div>
        </div>


    </form>
</div>
  <!-- scripting for file input type starts -->
  <script>
        var baseurl = '<?php echo DOMAIN_NAME;?>';
        console.log(baseurl);
        $(document).ready(function () {
            $('#choose-file').change(function () {
                var i = $(this).prev('label').clone();
                var file = $('#choose-file')[0].files[0].name;
                $(this).prev('label').text(file);
            }); 
        });
    </script>
  <!-- scripting for file input type ends-->
  <script>
$('a.delete-record').confirm({
    theme: 'bootstrap',
    closeIcon: true,
    closeIconClass: 'fa fa-close',
    buttons: {
        delete: function() {
            location.href = this.$target.attr('href');
        },
        cancel: function() {}
    }
});
</script>

<?php
    include_once 'templates/footer.php';
    ?>