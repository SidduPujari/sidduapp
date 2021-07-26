<?php
    require_once('templates/header.php'); 
    $statusMsg  = NULL; $erroCode = 0;
    $msgVisible = 0;

    $errors = [];
   
 function clean_input($field = false){
        $field = trim($field);
        $field = stripslashes($field);
        $field = htmlspecialchars($field);
        return $field;
    }
//echo 'User id::'.$_SESSION['id'];

if(isset($_POST['addbaremetal'])){ 

    /*if($_SERVER['REMOTE_ADDR'] == '157.45.69.13'){
        echo '<pre>';print_r($_POST);echo '</pre>';
        exit;
    }*/


    $processor_name = clean_input($_POST['processor_name']);
    $cores = clean_input($_POST['cores']);
    $memory = clean_input($_POST['memory']);
    $storage = clean_input($_POST['storage']);
    $transfer = clean_input($_POST['transfer']);
    $price = clean_input($_POST['price']);
    $sale_price = clean_input($_POST['sale_price']);
    $baremetal_type = clean_input($_POST['baremetal_type']);
    $availability = clean_input($_POST['availability']);
    $location_id = clean_input($_POST['location_id']);
    $status = clean_input($_POST['status']);
    $stock = clean_input($_POST['stock']);

    $locationOption = isset($_POST['location-option']) ? clean_input($_POST['location-option']) : '';
    $processor = isset($_POST['processor']) ? clean_input($_POST['processor']) : '';
    $memoryOption = isset($_POST['memory-option']) ? clean_input($_POST['memory-option']) : '';
    $os = isset($_POST['os']) ? clean_input($_POST['os']) : '';
    $servermanage = isset($_POST['servermanage']) ? clean_input($_POST['servermanage']) : '';
    $bandwidth = isset($_POST['bandwidth']) ? clean_input($_POST['bandwidth']) : '';
    $internalnet = isset($_POST['internalnet']) ? clean_input($_POST['internalnet']) : '';
    $networkddos = isset($_POST['networkddos']) ? clean_input($_POST['networkddos']) : '';

    $chassis = (isset($_POST['chassis']) && $_POST['chassis'] != 0 ) ? clean_input($_POST['chassis']) : '';
    $raid = (isset($_POST['raid']) && $_POST['raid'] != 0) ? clean_input($_POST['raid']) : '';
    $raidaddons = (isset($_POST['raidaddons']) && $_POST['raidaddons'] != 0 ) ? clean_input($_POST['raidaddons']) : '';
    $raidbackup = (isset($_POST['raidbackup']) && $_POST['raidbackup'] != 0) ? clean_input($_POST['raidbackup']) : '';
    $sqlserver = (isset($_POST['sqlserver']) && $_POST['sqlserver'] != 0) ? clean_input($_POST['sqlserver']) : '';
    $cpanel = (isset($_POST['cpanel']) && $_POST['cpanel'] != 0) ? clean_input($_POST['cpanel']) : '';
    $softaculous = (isset($_POST['softaculous']) && $_POST['softaculous'] != 0) ? clean_input($_POST['softaculous']) : '';
    $kernalcare = (isset($_POST['kernalcare']) && $_POST['kernalcare'] != 0) ? clean_input($_POST['kernalcare']) : '';
    $litespeed = (isset($_POST['litespeed']) && $_POST['litespeed'] != 0) ? clean_input($_POST['litespeed']) : '';
    $whmcs = (isset($_POST['whmcs']) && $_POST['whmcs'] != 0) ? clean_input($_POST['whmcs']) : '';
    $loadbalancing = (isset($_POST['loadbalancing']) && $_POST['loadbalancing'] != 0) ? clean_input($_POST['loadbalancing']) : '';
    $hfirewall = (isset($_POST['hfirewall']) && $_POST['hfirewall'] != 0) ? clean_input($_POST['hfirewall']) : '';
    $dailybackup = (isset($_POST['dailybackup']) && $_POST['dailybackup'] != 0) ? clean_input($_POST['dailybackup']) : '';
    $datamigration = (isset($_POST['datamigration']) && $_POST['datamigration'] != 0) ? clean_input($_POST['datamigration']) : '';


    if (empty($processor_name)) {
            $errors['processor_name'] = 'Processor name field is required';
        }
    if (empty($cores)) {
            $errors['cores'] = 'Cores field is required';
        }   
    if (empty($memory)) {
            $errors['memory'] = 'Memory field is required';
        } 
    if (empty($storage)) {
            $errors['storage'] = 'Storage field is required';
        }    
    if (empty($transfer)) {
            $errors['transfer'] = 'Transfer field is required';
        }
    if (empty($price)) {
            $errors['price'] = 'Price field is required';
        }
    if(empty($sale_price)) {
            $errors['sale_price'] = 'Sale price field is required';
        }   
    if (empty($baremetal_type)) {
            $errors['baremetal_type'] = 'Baremetal type field is required';
        }    
    if (empty($availability)) {
            $errors['availability'] = 'Availability field is required';
        }   
    if (empty($location_id)) {
            $errors['location_id'] = 'Data center field is required';
        } 
    if (empty($status)) {
            $errors['status'] = 'Status field is required';
        } 
    if (empty($status)) {
            $errors['stock'] = 'Stock field is required';
        } 
       if($baremetal_type == 'instant'){
       
        if(empty($locationOption)) {
            $errors['locationOption'] = 'Select any one location below';
        } 
        if(empty($processor)) {
            $errors['processor'] = 'Select any one Processor below';
        } 
        if(empty($memoryblock)) {
            $errors['memoryblock'] = 'Select any one Memory below';
        } 
        if(empty($os)) {
            $errors['os'] = 'Select any one Operating System below';
        } 
        if(empty($servermanage)) {
            $errors['servermanage'] = 'Select any one Managed Service below';
        }
        if(empty($bandwidth)) {
            $errors['bandwidth'] = 'Select any one Bandwidth below';
        }
        if(empty($internalnet)) {
            $errors['internalnet'] = 'Select any one Internal Network below';
        }
        if(empty($networkddos)) {
            $errors['networkddos'] = 'Select any one DDoS below';
        }
       } 
                       
    if(empty($errors)){
       $created_at = date('Y-m-d H:i:s');
       $createdby = $_SESSION['id'];
       $rent_basis = '0';
       $query = 'INSERT INTO baremetal(processor_name, cores, memory, storage, transfer, price, sale_price, rent_basis, baremetal_type, availability, location_id, status, stock, created_at, created_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
       $stmt = $con->prepare($query);
        $stmt->bind_param("sssssdddssdsssd", $processor_name, $cores, $memory, $storage, $transfer, $price,$sale_price,$rent_basis,$baremetal_type, $availability,$location_id,$status,$stock,$created_at,$createdby);
             if($stmt->execute() == true){
                if($baremetal_type == 'instant'){
                    $lastId = $stmt->insert_id;
                        
                        $stmt = $con->prepare("INSERT INTO instant_baremetal_config(baremetal_id, location_id, processor_id, memory_id, chassis_id, raid_id, raid_addons, raid_backup, os_id, control_panel_id, server_management_id, sql_server_licence, softaculous_id, karnel_care_id, bandwidth_id, internal_network_id, load_balancing_id, ddos_id, backup_id, data_migration_id, hardware_firewall_id, lite_speed_id, whmcs_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

                        $stmt->bind_param("ddddddddddddddddddddddd",$lastId,$locationOption,$processor,$memoryOption,$chassis,$raid,$raidaddons,$raidbackup,$os,$cpanel,$servermanage,$sqlserver,$softaculous,$kernalcare,$bandwidth,$internalnet,$loadbalancing,$networkddos,$dailybackup,$datamigration,$hfirewall,$litespeed,$whmcs);
                            $stmt->execute();

                }

                 if(isset($_POST['harddrives']) && count($_POST['harddrives']) > 0){
                    foreach ($_POST['harddrives'] as $key => $value) {
                        $hddQuery = 'INSERT INTO instant_baremetal_config_hdd(baremetal_id,title,hdd_option) VALUES (?,?,?)';
                        $hddStmt = $con->prepare($hddQuery);

                        $hddStmt->bind_param("dss",$lastId,$key,$value);
                        $hddStmt->execute();
                      }
                }




                    $statusMsg  = 'Bare metal has been created successfully.'; $erroCode = 0;
                    $msgVisible = 1;
                    } else {
                       $statusMsg  = 'Something went wrong.'; $erroCode = 1;
                       $msgVisible = 1;
                    // print_r($_POST);
                    // echo $con->error;
                    // exit;
                    }
                $stmt->close();
            }
    }


   

?>
<div class="row  mb-3 mt-3">
    <ol class="breadcrumb bg-transparent col-md-8 m-0">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></i></li>
    <li class="breadcrumb-item"><a href="bare-metal-list.php">Bare Metals</a></li>
    <li class="breadcrumb-item">Add Bare Metal</li>
    </ol>

    <div class="text-right col-md-4 pt-1">
        <a href="bare-metal-list.php" class="btn btn-primary btn-md"><i class="fas fa-list mr-1"></i>List</a>
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
            <strong> '.APPNAME.' !! </strong>'.$statusMsg.'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button></div></div></div>';
    }?>
    <form action="/add-bare-metal.php" method="POST" autocomplete="off">
        <div class="card mb-4">
            <!-- <div class="card-header"><i class="fab fa-connectdevelop"></i>Add Bare Metal </div> -->
            <div class="card-body">		
		<div class="row">			
            <div class="form-group col-md-3">
                    <input class="form-control <?php echo isset($errors['processor_name']) ? 'is-invalid' : '';?>"
                                    type="text" name="processor_name" placeholder="Processor Name(Ex.,728 2.8GHzAMD)" value="<?php echo isset($processor_name) ? $processor_name : '';?>"/>
                    <?php 
                        if(isset($errors['processor_name'])){
                            echo '<p class="text-danger">'.$errors['processor_name'].'</p>';
                        }
                    ?>
				</div>
                <div class="form-group col-md-3">
                    <input class="form-control <?php echo isset($errors['cores']) ? 'is-invalid' : '';?>"
                                type="text" name="cores" placeholder="Cores (Ex., 16 cores/32 threads)" value="<?php echo isset($cores) ? $cores : '';?>"/>
                    <?php 
                        if(isset($errors['cores'])){
                            echo '<p class="text-danger">'.$errors['cores'].'</p>';
                        }
                    ?>
                </div>
                
                <div class="form-group col-md-3">
                    <input class="form-control <?php echo isset($errors['memory']) ? 'is-invalid' : '';?>"
                                    type="text" name="memory" placeholder="Memory (Ex., 32GB)" value="<?php echo isset($memory) ? $memory : '';?>"/>
                    <?php 
                        if(isset($errors['memory'])){
                            echo '<p class="text-danger">'.$errors['memory'].'</p>';
                        }
                    ?>
                </div>
                <div class="form-group col-md-3">

                    <input class="form-control <?php echo isset($errors['storage']) ? 'is-invalid' : '';?>"
                                    type="text" name="storage" placeholder="Storage (Ex., 480GB SSD)" value="<?php echo isset($memory) ? $memory : '';?>"/>
                    <?php 
                        if(isset($errors['storage'])){
                            echo '<p class="text-danger">'.$errors['storage'].'</p>';
                        }
                    ?>
                </div>
              
				<div class="form-group col-md-3">
                    <input class="form-control <?php echo isset($errors['transfer']) ? 'is-invalid' : '';?>"type="text" name="transfer" placeholder="Transfer (Ex., 100TB / 1Gbps)" value="<?php echo isset($transfer) ? $transfer : '';?>"/>
                    <?php 
                        if(isset($errors['transfer'])){
                            echo '<p class="text-danger">'.$errors['transfer'].'</p>';
                        }
                    ?>
                </div>
                <div class="form-group col-md-3">
                    <input class="form-control <?php echo isset($errors['price']) ? 'is-invalid' : '';?>"type="text" name="price" placeholder="Price" value="<?php echo isset($price) ? $price : '';?>"/>
                    <?php 
                        if(isset($errors['price'])){
                            echo '<p class="text-danger m-0">'.$errors['price'].'</p>';
                        }
                    ?>
                </div>
                <div class="form-group col-md-3">
                    <input class="form-control <?php echo isset($errors['sale_price']) ? 'is-invalid' : '';?>"type="text" name="sale_price" placeholder="Sale Price" value="<?php echo isset($sale_price) ? $sale_price : '';?>"/>
                    <?php 
                        if(isset($errors['sale_price'])){
                            echo '<p class="text-danger m-0">'.$errors['sale_price'].'</p>';
                        }
                    ?>
                </div>

                <div class="form-group col-md-3">
                        <select class="form-control custom-select <?php echo isset($errors['baremetal_type']) ? 'is-invalid' : '';?>" name="baremetal_type" id="selectbaremetal">
                             <option value=" ">Select Baremetal Type</option> 
                            <option value="instant" <?php echo (isset($baremetal_type) && $baremetal_type == 'instant') ? 'selected="selected"' : '';?>>Instant</option>
                            <option value="custom" <?php echo (isset($baremetal_type) && $baremetal_type == 'custom') ? 'selected="selected"' : '';?>>Custom</option>
                            
                    </select>
                    <?php 
                        if(isset($errors['baremetal_type'])){
                            echo '<p class="text-danger m-0">'.$errors['baremetal_type'].'</p>';
                        }
                    ?>                    
                </div>
              
                <div class="form-group col-md-3">
                    <input class="form-control <?php echo isset($errors['availability']) ? 'is-invalid' : '';?>"type="text" name="availability" placeholder="Availablity" value="<?php echo isset($availablity) ? $availablity : '';?>"/>
                    <?php 
                        if(isset($errors['availability'])){
                            echo '<p class="text-danger">'.$errors['availability'].'</p>';
                        }
                    ?>
                </div>
                
        
                <div class="form-group col-md-3">
                   
                <select class="form-control custom-select <?php echo isset($errors['asidedc']) ? 'is-invalid' : '';?>" name="location_id">
                            <option value="">Data Center</option>
                            <?php
                            if ($stmt = $con->prepare("SELECT l.id as locid, l.alias,l.companyname,l.suite,l.city,s.statename FROM locations as l LEFT JOIN states as s ON  s.id =l.state_id ")) {
                                $stmt->execute();

                                $stmt->bind_result($locid, $alias,$companyname,$suite,$city,$statename);
                                while ($stmt->fetch()) {
                                    if(isset($location_id) && $location_id == $locid ){
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
                    if(isset($errors['location_id'])){
                        echo '<p class="text-danger m-0">'.$errors['location_id'].'</p>';
                    }
                    ?>
                </div>
                <div class="form-group col-md-3">
                        <select class="form-control custom-select <?php echo isset($errors['status']) ? 'is-invalid' : '';?>" name="status">
                             <option value=" ">Select Status</option> 
                            <option value="enable" <?php echo (isset($status) && $status == 'enable') ? 'selected="selected"' : '';?>>Enable</option>
                            <option value="disable" <?php echo (isset($status) && $status == 'disable') ? 'selected="selected"' : '';?>>Disable</option>
                            
                    </select>
                    <?php 
                        if(isset($errors['status'])){
                        echo '<p class="text-danger m-0">'.$errors['status'].'</p>';
                        }
                    ?>    
                    </div>  
                    <div class="form-group col-md-3">
                        <select class="form-control custom-select <?php echo isset($errors['stock']) ? 'is-invalid' : '';?>" name="stock">
                             <option value=" ">Select Stock Type</option> 
                            <option value="in stock" <?php echo (isset($stock) && $stock == 'in stock') ? 'selected="selected"' : '';?>>In Stock</option>
                            <option value="out of stock" <?php echo (isset($stock) && $stock == 'out of stock') ? 'selected="selected"' : '';?>>Out of Stock</option>
                            
                    </select>
                    <?php 
                        if(isset($errors['stock'])){
                        echo '<p class="text-danger m-0">'.$errors['stock'].'</p>';
                        }
                    ?>    
                    </div>        
                    </div>
                </div>  
    </div> 
    <div class="row mb-4">
        <div class="col-md-12 text-right mt-3">
            <button type="reset" class="btn btn-secondary mr-2">Clear</button>
            <button type="submit" class="btn btn-primary"  name="addbaremetal" value="submit">Submit</button>
        </div>
    </div> 
    <div id="instant-configurations">   
        <div class="card">
            <div class="card-header"><h2 class="text-center mt-2 mb-2">Instant Configurations</h2></div>
            <div class="card-body">
            <?php 
                if(isset($errors['locationOption'])){
                 echo '<p class="text-danger">'.$errors['locationOption'].'</p>';
                }
            ?>
                   
                 <div class="accordion" id="accordion-datacenter">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="headingOne">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#datacenters" aria-expanded="true" aria-controls="datacenters">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark">Data Center Location:</span><br/>
                                        <span class="text-dark slt-option-text">None</span>
                                    </div> 
                                    <div class="col-md-6">    
                                        <p class="text-right text-dark">$<span class="slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                            </button>
                        </div>

                        <div id="datacenters" class="collapse show" aria-labelledby="headingOne"
                            data-parent="#accordion-datacenter">
                            <div class="card-body">
                                <div class="option-blk">
                                    <div class="row">
                                    

                                        <?php 
                                        $datacenters = array();
                                         $sql = 'SELECT l.id,l.alias,l.city,c.continentcode FROM locations l  LEFT JOIN continents c ON c.id = l.continent_id ORDER BY l.alias DESC ';

                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($locationId,$alias,$city,$continentcode);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 
                                                    echo '<div class="col-md-4 col-sm-6 col-6 mb-4"><div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option datacenter-option">
                                                <input class="form-check-input location-option rdo-option" type="radio" option-price="0" name="location-option" id="'.$locationId.'location" value ="'.$locationId.'" option-text="'.strtoupper($alias).' ( '.ucfirst($city).','.strtoupper($continentcode).')">
                                                <label class="form-check-label text-capitalize" for="'.$locationId.'location">'.strtoupper($alias).' ( '.ucfirst($city).','.strtoupper($continentcode).')</label>
                                                </div></div>';
                                                }
                                            } else {
                                                echo '<div class="col-md-12 col-sm-12"><p class="m-0 text-danger text-center">Datacenters not available..</p></div>';
                                            }  

                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 <?php 
                        if(isset($errors['processor'])){
                            echo '<p class="text-danger mt-3">'.$errors['processor'].'</p>';
                        }
                        ?>
                <div class="accordion mt-3 mb-3" id="accordionExample1">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="headingOne2">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#processors-block" aria-expanded="true" aria-controls="datacenters">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark">Processor:</span><br/>
                                        <span class="text-dark slt-option-text">NONE</span>
                                    </div> 
                                    <div class="col-md-6">    
                                       <p class="text-right text-dark">$<span class="slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                            </button>
                        </div>

                        <div id="processors-block" class="collapse" aria-labelledby="headingOne2"
                            data-parent="#accordionExample1">
                            <div class="card-body">
                                <h3 class="text-capitalize">Coffee Lake</h3>
                                 <div class="option-blk">
                                    <div class="row">
                                        <?php 
                                        
                                        $sltoptInc = 0;
                                            $sql = "SELECT id,title,price FROM processor  WHERE status = 'enable' ORDER BY title  ASC ";
                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($id,$title,$price);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 
                                                echo '<div class="col-md-4 col-sm-6 col-6 mb-4"><div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option processor-option">
                                                <input class="form-check-input processor-option rdo-option" type="radio" name="processor"  option-price="'.$price.'" id="'.$id.'processor"  value="'.$id.'" option-text="'.$title.'"';
                                                   /* if($sltoptInc == 0){
                                                        echo 'checked="checked"';
                                                    }*/
                                                echo '>
                                                <label class="form-check-label text-capitalize" for="'.$id.'processor">'.$title.'($'.$price.'/mo)</label>
                                                </div></div>';
                                                      

                                                      $sltoptInc++;
                                                }
                                            }    

                                        

                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                 <?php 
                        if(isset($errors['memoryblock'])){
                            echo '<p class="text-danger mt-3">'.$errors['memoryblock'].'</p>';
                        }
                        ?>
                 <div class="accordion mt-3 mb-3" id="accordionExample3">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="headingOne3">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#memory-block" aria-expanded="true" aria-controls="datacenters">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark">Memory:</span><br/>
                                        <span class="text-dark slt-option-text">DDR4 : 16BG</span>
                                    </div> 
                                    <div class="col-md-6">    
                                         <p class="text-right text-dark">$<span class="slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                            </button>
                        </div>

                        <div id="memory-block" class="collapse" aria-labelledby="headingOne3"
                            data-parent="#accordionExample3">
                            <div class="card-body">

                                <h3 class="text-capitalize">DDR4</h3>
                                 <div class="option-blk">
                                    <div class="row">
                                        <?php 
                                            $sql = 'SELECT id,title,price FROM memory  ORDER BY title  ASC ';
                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($id,$title,$price);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 
                                                echo '<div class="col-md-4 col-sm-6 col-6 mb-4"><div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option memory-option">
                                                <input class="form-check-input memory-option rdo-option" type="radio" name="memory-option"  option-price="'.$price.'" id="'.$id.'memory" value="'.$id.'" option-text="'.$title.'">
                                                <label class="form-check-label text-capitalize" for="'.$id.'memory">'.$title.'($'.$price.'/mo)</label>
                                                </div></div>';
                                                      
                                                }
                                            }    

                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 


                 <?php 

                    $harddrives = array(
                        'primary' => 'Primary hard drive',
                        'secondary' => 'Secondary hard drive',
                        'third' => 'Third hard drive',
                        'fourth' => 'Fourth hard drive',
                        'fifth' => 'Fifth hard drive',
                        'sixth' => 'Sixth hard drive',
                        'seventh' => 'Seventh hard drive',
                        'eight' => 'Eight hard drive',
                        'ninth' => 'Ninth hard drive',
                        'tenth' => 'Tenth hard drive',
                        'leventh' => 'Leventh hard drive',
                        'twelth' => 'Twelth hard drive'
                    );

                    $accordionLoop = 4;

                   foreach ($harddrives as $key => $value) {
                    echo ' <div class="accordion mt-3 mb-3" id="accordionExample'.$accordionLoop.'">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="heading'.$accordionLoop.'">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#'.$key.'-hdblock" aria-expanded="true" aria-controls="'.$key.'">
                                <div class="option-blk">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark hdd-heading-text">'.$value.' :</span><br/>
                                        <span class="text-dark slt-option-text">None</span>
                                    </div> 
                                    <div class="col-md-6">    
                                        <p class="text-right text-dark">$<span class="accordion-price slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                                </div>        
                            </button>
                        </div>

                        <div id="'.$key.'-hdblock" class="collapse" aria-labelledby="heading'.$accordionLoop.'"
                            data-parent="#accordionExample'.$accordionLoop.'">
                            <div class="card-body">
                            <div class="option-blk">
                                <h3 class="text-capitalize">None</h3>
                                   <div class="row">
                                    <div class="col-md-4 col-sm-6 col-6 mb-4">
                                        <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-hdd">
                                            <input class="form-check-input '.$key.'-hdd-option rdo-option" type="radio" name="harddrives['.$key.'-hdd]"  option-price="0" id="'.$key.'-none" value="0">
                                                <label class="form-check-label text-capitalize" for="'.$key.'-none">None</label>
                                                </div>
                                            </div>
                                </div></div><div class="option-blk ssd">
                                <h3 class="text-capitalize title">SSD</h3>
                                <div class="row">';
                                        $sql = 'SELECT id,title,price FROM ssd  ORDER BY title  ASC ';
                                        if($stmt = $con->prepare($sql)) {
                                            $stmt->bind_result($id,$title,$price);
                                            $stmt->execute();
                                            while ($stmt->fetch()) { 

                                                echo '<div class="col-md-4 col-sm-6 col-6 mb-4"><div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-hdd">
                                                <input class="form-check-input '.$key.'-hdd-option rdo-option" type="radio" name="harddrives['.$key.'-hdd]"  option-price="'.$price.'" id="'.$key.$id.'ssd" option-text="'.$title.'" value="ssd_'.$id.'" slt-type="SSD">
                                                <label class="form-check-label text-capitalize" for="'.$key.$id.'ssd">'.$title.'($'.$price.'/mo)</label>
                                                </div></div>';
                                            }
                                        }    

                                   
                                echo '</div></div><div class="option-blk nvme">
                                <h3 class="text-capitalize title">NVMe</h3>
                                <div class="row">';
                                        $sql = 'SELECT id,title,price FROM nvme  ORDER BY title  ASC ';
                                        if($stmt = $con->prepare($sql)) {
                                            $stmt->bind_result($id,$title,$price);
                                            $stmt->execute();
                                            while ($stmt->fetch()) { 

                                                echo '<div class="col-md-4 col-sm-6 col-6 mb-4"><div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-hdd">
                                                <input class="form-check-input '.$key.'-hdd-option rdo-option" type="radio" name="harddrives['.$key.'-hdd]"  option-price="'.$price.'" id="'.$key.$id.'nvme"  option-text="'.$title.'" value="Nvme_'.$id.'" slt-type="Nvme">
                                                <label class="form-check-label text-capitalize" for="'.$key.$id.'nvme">'.$title.'($'.$price.'/mo)</label>
                                                </div></div>';
                                            }
                                        }    

                                echo '</div></div><div class="option-blk sata">
                                 <h3 class="text-capitalize">Sata</h3>
                                <div class="row">';
                                        $sql = 'SELECT id,title,price FROM sata  ORDER BY title  ASC ';
                                        if($stmt = $con->prepare($sql)) {
                                            $stmt->bind_result($id,$title,$price);
                                            $stmt->execute();
                                            while ($stmt->fetch()) { 

                                                echo '<div class="col-md-4 col-sm-6 col-6 mb-4"><div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-hdd">
                                                <input class="form-check-input '.$key.'-hdd-option rdo-option" type="radio" name="harddrives['.$key.'-hdd]"  option-price="'.$price.'" id="'.$key.$id.'sata" value="sata_'.$id.'" option-text="'.$title.'" slt-type="SATA">
                                                <label class="form-check-label text-capitalize" for="'.$key.$id.'sata">'.$title.'($'.$price.'/mo)</label>
                                                </div></div>';
                                            }
                                        }  
                                echo '</div></div>
                            </div>
                        </div>
                    </div>
                </div> ';

                $accordionLoop++;
                       
                    } 
                 ?>   
              

                 <div class="accordion mt-3 mb-3" id="Chassis">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="headingOne8">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#chassis-block" aria-expanded="true" aria-controls="chassis">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark heading-text">Chassis Upgrade:</span><br/>
                                        <span class="text-dark  slt-option-text">None</span>
                                    </div> 
                                    <div class="col-md-6">    
                                          <p class="text-right text-dark">$<span class="slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                            </button>
                        </div>

                        <div id="chassis-block" class="collapse" aria-labelledby="headingOne8" data-parent="#chassis-block">
                            <div class="card-body">
                                <div class="option-blk">
                                <h3 class="text-capitalize">None</h3>
                                   <div class="row">
                                    <div class="col-md-4 col-sm-6 col-6 mb-4">
                                        <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option chassis-upgrade">
                                            <input class="form-check-input  chassis-option rdo-option" type="radio" name="chassis"  option-price="0" id="chassis-none" value="0">
                                                <label class="form-check-label text-capitalize" for="chassis-none">None</label>
                                                </div>
                                            </div>
                                </div></div>
                                 <div class="option-blk">
                                    <div class="row">
                                        <?php 
                                            $sql = 'SELECT id,title,price FROM chassis_upgrade  ORDER BY id  ASC ';
                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($id,$title,$price);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 

                                                    echo '<div class="col-md-4 col-sm-6 col-6 mb-4">
                                                    <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option chassis-upgrade">
                                                <input class="form-check-input chassis-option rdo-option" type="radio" name="chassis"  option-price="'.$price.'" id="'.$id.'chassis"  value="'.$id.'" option-text="'.$title.'">
                                                    <label class="form-check-label text-capitalize" for="'.$id.'chassis">'.$title.'($'.$price.'/mo)</label>
                                                    </div></div>';
                                                }
                                            }    

                                        ?>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>   


                   <div class="accordion mt-3 mb-4" id="raid">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="headingOne9">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#raid-block" aria-expanded="true" aria-controls="raid">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark heading-text">Raid:</span><br/>
                                        <span class="text-dark  slt-option-text">None</span>
                                    </div> 
                                    <div class="col-md-6">    
                                          <p class="text-right text-dark">$<span class="slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                            </button>
                        </div>

                        <div id="raid-block" class="collapse" aria-labelledby="headingOne9" data-parent="#raid-block">
                            <div class="card-body">
                                 <div class="option-blk">
                                <h3 class="text-capitalize">None</h3>
                                   <div class="row">
                                    <div class="col-md-4 col-sm-6 col-6 mb-4">
                                        <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option raid-select-option">
                                            <input class="form-check-input  raid-option rdo-option" type="radio" name="raid"  option-price="0" id="raid-none" value="0">
                                                <label class="form-check-label text-capitalize" for="raid-none">None</label>
                                                </div>
                                            </div>
                                </div></div>
                                 <div class="option-blk">
                                    <div class="row">
                                        <?php 
                                            $sql = 'SELECT id,title,price FROM raid  WHERE status="enable" ORDER BY id  ASC ';
                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($id,$title,$price);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 

                                                    echo '<div class="col-md-4 col-sm-6 col-6 mb-4">
                                                    <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option raid-select-option">
                                                <input class="form-check-input raid-option rdo-option raid-select-option" type="radio" name="raid"  option-price="'.$price.'" id="'.$id.'raid" value="'.$id.'" option-text="'.$title.'">
                                                    <label class="form-check-label text-capitalize" for="'.$id.'raid">'.$title.'($'.$price.'/mo)</label>
                                                    </div></div>';
                                                }
                                            }    

                                        ?>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div> 


                 <div class="accordion mt-3 mb-4" id="raidaddons">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="headingOne9">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#raidaddons-block" aria-expanded="true" aria-controls="raid">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark heading-text">Raid Addons:</span><br/>
                                        <span class="text-dark  slt-option-text">None</span>
                                    </div> 
                                    <div class="col-md-6">    
                                          <p class="text-right text-dark">$<span class="slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                            </button>
                        </div>

                        <div id="raidaddons-block" class="collapse" aria-labelledby="raidaddons" data-parent="#raidaddons-block">
                            <div class="card-body">
                                 <div class="option-blk">
                                <h3 class="text-capitalize">None</h3>
                                   <div class="row">
                                    <div class="col-md-4 col-sm-6 col-6 mb-4">
                                        <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option raidaddons-select-option">
                                            <input class="form-check-input  raidaddons-option rdo-option" type="radio" name="raidaddons"  option-price="0" id="raidaddons-none" value="0">
                                                <label class="form-check-label text-capitalize" for="raidaddons-none">None</label>
                                                </div>
                                            </div>
                                </div></div>
                                 <div class="option-blk">
                                    <div class="row">
                                        <?php 
                                            $sql = 'SELECT id,title,price FROM raid_addons   WHERE status="enable" ORDER BY id  ASC ';
                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($id,$title,$price);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 

                                                    echo '<div class="col-md-4 col-sm-6 col-6 mb-4">
                                                    <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option raidaddons-select-option">
                                                <input class="form-check-input raid-option rdo-option raidaddons-option" type="radio" name="raidaddons"  option-price="'.$price.'" id="'.$id.'raidaddons" value="'.$id.'" option-text="'.$title.'">
                                                    <label class="form-check-label text-capitalize" for="'.$id.'raidaddons">'.$title.'($'.$price.'/mo)</label>
                                                    </div></div>';
                                                }
                                            }    

                                        ?>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>  


                  <div class="accordion mt-3 mb-4" id="raidbackup">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="headingOne9">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#raidbackup-block" aria-expanded="true" aria-controls="raidbackup">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark heading-text">RAID Battery Backup Unit:</span><br/>
                                        <span class="text-dark  slt-option-text">None</span>
                                    </div> 
                                    <div class="col-md-6">    
                                          <p class="text-right text-dark">$<span class="slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                            </button>
                        </div>

                        <div id="raidbackup-block" class="collapse" aria-labelledby="raidbackup" data-parent="#raidbackup-block">
                            <div class="card-body">
                                 <div class="option-blk">
                                <h3 class="text-capitalize">None</h3>
                                   <div class="row">
                                    <div class="col-md-4 col-sm-6 col-6 mb-4">
                                        <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option raidbackup-select-option">
                                            <input class="form-check-input  raidbackup-option rdo-option" type="radio" name="raidbackup"  option-price="0" id="raidbackup-none" value="0">
                                                <label class="form-check-label text-capitalize" for="raidbackup-none">None</label>
                                                </div>
                                            </div>
                                </div></div>
                                 <div class="option-blk">
                                    <div class="row">
                                        <?php 
                                            $sql = 'SELECT id,title,price FROM raid_battery_backup WHERE status="enable" ORDER BY id  ASC ';
                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($id,$title,$price);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 

                                                    echo '<div class="col-md-4 col-sm-6 col-6 mb-4">
                                                    <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option raidbackup-select-option">
                                                <input class="form-check-input raid-option rdo-option raidbackup-option" type="radio" name="raidbackup"  option-price="'.$price.'" id="'.$id.'raidbackup" value="'.$id.'" option-text="'.$title.'">
                                                    <label class="form-check-label text-capitalize" for="'.$id.'raidbackup">'.$title.'($'.$price.'/mo)</label>
                                                    </div></div>';
                                                }
                                            }    

                                        ?>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>  



                <h1 class="text-center">Software</h1>
                     <?php 
                        if(isset($errors['os'])){
                            echo '<p class="text-danger mt-3">'.$errors['os'].'</p>';
                        }
                        ?>
                  <div class="accordion mt-3 mb-4" id="os">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="headingOne10">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#os-block" aria-expanded="true" aria-controls="os">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark ">Operating System:</span><br/>
                                        <span class="text-dark  slt-option-text">None</span>
                                    </div> 
                                    <div class="col-md-6">    
                                          <p class="text-right text-dark">$<span class="slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                            </button>
                        </div>

                        <div id="os-block" class="collapse" aria-labelledby="headingOne10" data-parent="#os-block">
                            <div class="card-body">
                                <h3 class="text-capitalize">Linux/Other</h3>
                                <div class="option-blk">
                                    <div class="row">

                                        <?php 
                                            $sql = 'SELECT id,title,price FROM operating_system  WHERE os_type="linux/other" ORDER BY id  ASC ';
                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($id,$title,$price);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 

                                                    echo '<div class="col-md-4 col-sm-6 col-6 mb-4">
                                                    <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option operating-system">
                                                <input class="form-check-input os-option rdo-option" type="radio" name="os"  option-price="'.$price.'" id="'.$id.'os" value="'.$id.'" option-text="'.$title.'">
                                                    <label class="form-check-label text-capitalize" for="'.$id.'os">'.$title.'($'.$price.'/mo)</label>
                                                    </div></div>';
                                                }
                                            }    

                                        ?>
                                    </div>
                                </div>
                                <h3 class="text-capitalize">windows</h3>
                                <div class="option-blk">
                                    <div class="row">

                                        <?php 
                                            $sql = 'SELECT id,title,price FROM operating_system  WHERE os_type="windows" ORDER BY id  ASC ';
                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($id,$title,$price);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 

                                                    echo '<div class="col-md-4 col-sm-6 col-6 mb-4">
                                                    <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option operating-system">
                                                <input class="form-check-input os-option rdo-option" type="radio" name="os"  option-price="'.$price.'" id="'.$id.'os" value="'.$id.'" option-text="'.$title.'">
                                                    <label class="form-check-label text-capitalize" for="'.$id.'os">'.$title.'($'.$price.'/mo)</label>
                                                    </div></div>';
                                                }
                                            }    

                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  



                <div class="accordion mt-3 mb-4" id="sqlserver">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="headingOne11">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#sqlserver-block" aria-expanded="true" aria-controls="sqlserver">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark heading-text">SQL Server License:</span><br/>
                                       <span class="text-dark  slt-option-text">None</span>
                                    </div> 
                                    <div class="col-md-6">    
                                          <p class="text-right text-dark">$<span class="slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                            </button>
                        </div>

                        <div id="sqlserver-block" class="collapse" aria-labelledby="headingOne11" data-parent="#sqlserver-block">
                            <div class="card-body">
                                <div class="option-blk">
                                    <h3 class="text-capitalize">None</h3>
                                   <div class="row">
                                    <div class="col-md-4 col-sm-6 col-6 mb-4">
                                        <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-sqlserver">
                                            <input class="form-check-input sqlserver-option rdo-option" type="radio" name="sqlserver"  option-price="0" id="sqlserver-none" value="0">
                                                <label class="form-check-label text-capitalize" for="sqlserver-none">None</label>
                                                </div>
                                            </div>
                                </div></div>
                                <div class="option-blk">
                                <div class="row">
                                    
                                        <?php 
                                            $sql = 'SELECT id,title,price FROM sql_server_licence  WHERE status="enable" ORDER BY id  ASC ';
                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($id,$title,$price);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 

                                                    echo '<div class="col-md-4 col-sm-6 col-6 mb-4">
                                                    <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-sqlserver">
                                                <input class="form-check-input sqlserver-option rdo-option" type="radio" name="sqlserver"  option-price="'.$price.'" id="'.$id.'sqlserver" value="'.$id.'" option-text="'.$title.'">
                                                    <label class="form-check-label text-capitalize" for="'.$id.'sqlserver">'.$title.'($'.$price.'/mo)</label>
                                                    </div></div>';
                                                }
                                            }    

                                        ?>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>  




                 <div class="accordion mt-3 mb-4" id="control-panel">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="headingOne11">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#cpanel-block" aria-expanded="true" aria-controls="controlpanel">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark heading-text">Control panel:</span><br/>
                                         <span class="text-dark  slt-option-text">None</span>
                                    </div> 
                                    <div class="col-md-6">    
                                          <p class="text-right text-dark">$<span class="slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                            </button>
                        </div>

                        <div id="cpanel-block" class="collapse" aria-labelledby="headingOne11" data-parent="#cpanel-block">
                            <div class="card-body">

                                <div class="option-blk">
                                    <h3 class="text-capitalize">None</h3>
                                   <div class="row">
                                    <div class="col-md-4 col-sm-6 col-6 mb-4">
                                        <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-controlPanel">
                                            <input class="form-check-input cpanel-option rdo-option" type="radio" name="cpanel"  option-price="0" id="cpanel-none" value="0">
                                                <label class="form-check-label text-capitalize" for="cpanel-none">None</label>
                                                </div>
                                            </div>
                                </div></div>
                                <h3 class="text-capitalize">Linux panels</h3>
                                <div class="option-blk">
                                    <div class="row">

                                        <?php 
                                            $sql = 'SELECT id,title,price FROM control_panel  WHERE panel_type="linux" ORDER BY id  ASC ';
                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($id,$title,$price);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 

                                                    echo '<div class="col-md-4 col-sm-6 col-6 mb-4">
                                                    <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-controlPanel">
                                                <input class="form-check-input cpanel-option rdo-option" type="radio" name="cpanel"  option-price="'.$price.'" id="'.$id.'cpanel" value="'.$id.'" option-text="'.$title.'">
                                                    <label class="form-check-label text-capitalize" for="'.$id.'cpanel">'.$title.'($'.$price.'/mo)</label>
                                                    </div></div>';
                                                }
                                            }    

                                        ?>
                                    </div>
                                </div>
                                    
                                <h3 class="text-capitalize">windows panels</h3>
                                <div class="option-blk">
                                    <div class="row">

                                        <?php 
                                            $sql = 'SELECT id,title,price FROM control_panel  WHERE panel_type="windows" ORDER BY id  ASC ';
                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($id,$title,$price);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 

                                                    echo '<div class="col-md-4 col-sm-6 col-6 mb-4">
                                                    <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-controlPanel">
                                                <input class="form-check-input cpanel-option rdo-option" type="radio" name="cpanel"  option-price="'.$price.'" id="'.$id.'cpanel" value="'.$id.'" option-text="'.$title.'">
                                                    <label class="form-check-label text-capitalize" for="'.$id.'cpanel">'.$title.'($'.$price.'/mo)</label>
                                                    </div></div>';
                                                }
                                            }    

                                        ?>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>  

                <?php 
                    if(isset($errors['servermanage'])){
                        echo '<p class="text-danger mt-3">'.$errors['servermanage'].'</p>';
                    }
                    ?>
                <div class="accordion mt-3 mb-4" id="servermanage">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="headingOne12">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#servermanage-block" aria-expanded="true" aria-controls="servermanage">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark">Managed Services:</span><br/>
                                        <span class="text-dark  slt-option-text">None</span>
                                    </div> 
                                    <div class="col-md-6">    
                                          <p class="text-right text-dark">$<span class="slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                            </button>
                        </div>

                        <div id="servermanage-block" class="collapse" aria-labelledby="headingOne12" data-parent="#servermanage-block">
                            <div class="card-body">
                                <h3 class="text-capitalize">Server Management</h3>
                                <div class="option-blk">
                                    <div class="row">

                                        <?php 
                                            $sql = 'SELECT id,title,price FROM server_management   ORDER BY id  ASC ';
                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($id,$title,$price);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 

                                                    echo '<div class="col-md-4 col-sm-6 col-6 mb-4">
                                                    <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option server-management">
                                                <input class="form-check-input servermanage-option rdo-option" type="radio" name="servermanage"  option-price="'.$price.'" id="'.$id.'servermanage" value="'.$id.'" option-text="'.$title.'">
                                                    <label class="form-check-label text-capitalize" for="'.$id.'servermanage">'.$title.'($'.$price.'/mo)</label>
                                                    </div></div>';
                                                }
                                            }    

                                        ?>
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                    </div>
                </div>  




                 <div class="accordion mt-3 mb-4" id="Softaculous">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="headingOne12">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#softaculous-block" aria-expanded="true" aria-controls="Softaculous">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark heading-text">Softaculous:</span><br/>
                                        <span class="text-dark  slt-option-text">None</span>
                                    </div> 
                                    <div class="col-md-6">    
                                          <p class="text-right text-dark">$<span class="slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                            </button>
                        </div>

                        <div id="softaculous-block" class="collapse" aria-labelledby="softaculous" data-parent="#softaculous-block">
                            <div class="card-body">
                                 <h3 class="text-capitalize">None</h3>
                                <div class="option-blk">
                                   <div class="row">
                                        <div class="col-md-4 col-sm-6 col-6 mb-4">
                                            <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-softaculous">
                                                <input class="form-check-input softaculous-option rdo-option" type="radio" name="softaculous"  option-price="0" id="softaculous-none" value="0">
                                                    <label class="form-check-label text-capitalize" for="softaculous-none">None</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="option-blk">
                                    <div class="row">
                                        <?php 
                                            $sql = 'SELECT id,title,price FROM softaculous ORDER BY id  ASC ';
                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($id,$title,$price);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 

                                                    echo '<div class="col-md-4 col-sm-6 col-6 mb-4">
                                                    <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-softaculous">
                                                <input class="form-check-input softaculous-option rdo-option" type="radio" name="softaculous"  option-price="'.$price.'" id="'.$id.'softaculous"  value="'.$id.'" option-text="'.$title.'">
                                                    <label class="form-check-label text-capitalize" for="'.$id.'softaculous">'.$title.'($'.$price.'/mo)</label>
                                                    </div></div>';
                                                }
                                            }    


                                        ?>
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                    </div>
                </div>  

 


                <div class="accordion mt-3 mb-4" id="kernalcare">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="headingOne14">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#kernalcare-block" aria-expanded="true" aria-controls="kernalcare">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark heading-text">Kernal care:</span><br/>
                                        <span class="text-dark  slt-option-text">None</span>
                                    </div> 
                                    <div class="col-md-6">    
                                          <p class="text-right text-dark">$<span class="slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                            </button>
                        </div>

                        <div id="kernalcare-block" class="collapse" aria-labelledby="headingOne14" data-parent="#kernalcare-block">
                            <div class="card-body">

                                <h3 class="text-capitalize">None</h3>
                                <div class="option-blk">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 col-6 mb-4">
                                            <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-kernalcare">
                                                <input class="form-check-input kernalcare-option rdo-option" type="radio" name="kernalcare"  option-price="0" id="kernalcare-none" value="0">
                                                    <label class="form-check-label text-capitalize" for="kernalcare-none">None</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="option-blk">
                                    <div class="row">
                                        <?php 
                                            $sql = 'SELECT id,title,price FROM kernel_care ORDER BY id  ASC ';
                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($id,$title,$price);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 

                                                    echo '<div class="col-md-4 col-sm-6 col-6 mb-4">
                                                    <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-kernalcare">
                                                <input class="form-check-input kernalcare-option rdo-option" type="radio" name="kernalcare"  option-price="'.$price.'" id="'.$id.'kernalcare" value="'.$id.'" option-text="'.$title.'">
                                                    <label class="form-check-label text-capitalize" for="'.$id.'kernalcare">'.$title.'($'.$price.'/mo)</label>
                                                    </div></div>';
                                                }
                                            }    

                                        ?>
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                    </div>
                </div>  

   
                  <div class="accordion mt-3 mb-4" id="litespeed">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="headingOne15">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#litespeed-block" aria-expanded="true" aria-controls="litespeed">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark heading-text">lite speed:</span><br/>
                                        <span class="text-dark  slt-option-text">None</span>
                                    </div> 
                                    <div class="col-md-6">    
                                          <p class="text-right text-dark">$<span class="slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                            </button>
                        </div>

                        <div id="litespeed-block" class="collapse" aria-labelledby="headingOne15" data-parent="#litespeed-block">
                            <div class="card-body">

                                <h3 class="text-capitalize">None</h3>
                                <div class="option-blk">
                                   <div class="row">
                                        <div class="col-md-4 col-sm-6 col-6 mb-4">
                                            <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-litespeed">
                                                <input class="form-check-input litespeed-option rdo-option" type="radio" name="litespeed"  option-price="0" id="litespeed-none" value="0">
                                                    <label class="form-check-label text-capitalize" for="litespeed-none">None</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="option-blk">
                                    <div class="row">
                                        <?php 
                                            $sql = 'SELECT id,title,price FROM lite_speed ORDER BY id  ASC ';
                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($id,$title,$price);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 

                                                    echo '<div class="col-md-4 col-sm-6 col-6 mb-4">
                                                    <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-litespeed">
                                                <input class="form-check-input litespeed-option rdo-option" type="radio" name="litespeed"  option-price="'.$price.'" id="'.$id.'litespeed"  value="'.$id.'" option-text="'.$title.'">
                                                    <label class="form-check-label text-capitalize" for="'.$id.'litespeed">'.$title.'($'.$price.'/mo)</label>
                                                    </div></div>';
                                                }
                                            }    

                                        ?>
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                    </div>
                </div>  
   

                <div class="accordion mt-3 mb-4" id="whmcs">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="headingOne16">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#whmcs-block" aria-expanded="true" aria-controls="whmcs">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark heading-text">whmcs:</span><br/>
                                        <span class="text-dark  slt-option-text">None</span>
                                    </div> 
                                    <div class="col-md-6">    
                                          <p class="text-right text-dark">$<span class="slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                            </button>
                        </div>

                        <div id="whmcs-block" class="collapse" aria-labelledby="headingOne16" data-parent="#whmcs-block">
                            <div class="card-body">

                                <h3 class="text-capitalize">None</h3>
                                <div class="option-blk">
                                   <div class="row">
                                    <div class="col-md-4 col-sm-6 col-6 mb-4">
                                        <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-whmcs">
                                            <input class="form-check-input whmcs-option rdo-option" type="radio" name="whmcs"  option-price="0" id="whmcs-none" value="0">
                                                <label class="form-check-label text-capitalize" for="whmcs-none">None</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="option-blk">
                                    <div class="row">
                                        <?php 
                                            $sql = 'SELECT id,title,price FROM whmcs ORDER BY id  ASC ';
                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($id,$title,$price);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 

                                                    echo '<div class="col-md-4 col-sm-6 col-6 mb-4">
                                                    <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-whmcs">
                                                <input class="form-check-input whmcs-option rdo-option" type="radio" name="whmcs"  option-price="'.$price.'" id="'.$id.'whmcs"  value="'.$id.'" option-text="'.$title.'">
                                                    <label class="form-check-label text-capitalize" for="'.$id.'whmcs">'.$title.'($'.$price.'/mo)</label>
                                                    </div></div>';
                                                }
                                            }    

                                        ?>
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                    </div>
                </div>  
                <h1 class="text-center">Network</h1> 

                <?php 
                    if(isset($errors['bandwidth'])){
                        echo '<p class="text-danger mt-3">'.$errors['bandwidth'].'</p>';
                    }
                    ?>
                 <div class="accordion mt-3 mb-4" id="networkBandwidth">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="headingOne17">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#bandwidth-block" aria-expanded="true" aria-controls="networkBandwidth">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark">bandwidth:</span><br/>
                                        <span class="text-dark  slt-option-text">None</span>
                                    </div> 
                                    <div class="col-md-6">    
                                          <p class="text-right text-dark">$<span class="slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                            </button>
                        </div>

                        <div id="bandwidth-block" class="collapse" aria-labelledby="headingOne17" data-parent="#bandwidth-block">
                            <div class="card-body">
                              <div class="option-blk">
                                    <div class="row">

                                        <?php 
                                            $sql = 'SELECT id,title,price FROM network_bandwidth ORDER BY id  ASC ';
                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($id,$title,$price);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 

                                                    echo '<div class="col-md-4 col-sm-6 col-6 mb-4">
                                                    <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-bandwidth">
                                                <input class="form-check-input bandwidth-option rdo-option" type="radio" name="bandwidth"  option-price="'.$price.'" id="'.$id.'bandwidth" value="'.$id.'" option-text="'.$title.'">
                                                    <label class="form-check-label text-capitalize" for="'.$id.'bandwidth">'.$title.'($'.$price.'/mo)</label>
                                                    </div></div>';
                                                }
                                            }    

                                        ?>
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                    </div>
                </div> 


                <?php 
                    if(isset($errors['internalnet'])){
                        echo '<p class="text-danger mt-3">'.$errors['internalnet'].'</p>';
                    }
                    ?>
                 <div class="accordion mt-3 mb-4" id="internalnet">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="headingOne17">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#internalnet-block" aria-expanded="true" aria-controls="internalnet">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark">internal network:</span><br/>
                                        <span class="text-dark  slt-option-text">None</span>
                                    </div> 
                                    <div class="col-md-6">    
                                          <p class="text-right text-dark">$<span class="slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                            </button>
                        </div>

                        <div id="internalnet-block" class="collapse" aria-labelledby="headingOne17" data-parent="#internalnet-block">
                            <div class="card-body">
                                <div class="option-blk">
                                    <div class="row">
                                        <?php 
                                            $sql = 'SELECT id,title,price FROM internal_network ORDER BY id  ASC ';
                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($id,$title,$price);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 

                                                    echo '<div class="col-md-4 col-sm-6 col-6 mb-4">
                                                    <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-internalnet">
                                                <input class="form-check-input internalnet-option rdo-option" type="radio" name="internalnet"  option-price="'.$price.'" id="'.$id.'internalnet" value="'.$id.'" option-text="'.$title.'">
                                                    <label class="form-check-label text-capitalize" for="'.$id.'internalnet">'.$title.'($'.$price.'/mo)</label>
                                                    </div></div>';
                                                }
                                            }    

                                        ?>
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                    </div>
                </div>


                 <div class="accordion mt-3 mb-4" id="loadbalancing">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="headingOne18">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#loadbalancing-block" aria-expanded="true" aria-controls="loadbalancing">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark heading-text">Load balancing:</span><br/>
                                       <span class="text-dark  slt-option-text">None</span>
                                    </div> 
                                    <div class="col-md-6">    
                                          <p class="text-right text-dark">$<span class="slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                            </button>
                        </div>

                        <div id="loadbalancing-block" class="collapse" aria-labelledby="headingOne18" data-parent="#loadbalancing-block">
                            <div class="card-body">

                                <h3 class="text-capitalize">None</h3>
                                <div class="option-blk">
                                   <div class="row">
                                    <div class="col-md-4 col-sm-6 col-6 mb-4">
                                        <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-loadbalancing">
                                            <input class="form-check-input loadbalancing-option rdo-option" type="radio" name="loadbalancing"  option-price="0" id="loadbalancing-none" value="0">
                                                <label class="form-check-label text-capitalize" for="loadbalancing-none">None</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="option-blk">
                                    <div class="row">
                                        <?php 
                                            $sql = 'SELECT id,title,price FROM network_loading_balance ORDER BY id  ASC ';
                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($id,$title,$price);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 

                                                    echo '<div class="col-md-4 col-sm-6 col-6 mb-4">
                                                    <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-loadbalancing">
                                                <input class="form-check-input loadbalancing-option rdo-option" type="radio" name="loadbalancing"  option-price="'.$price.'" id="'.$id.'loadbalancing" value="'.$id.'" option-text="'.$title.'">
                                                    <label class="form-check-label text-capitalize" for="'.$id.'loadbalancing">'.$title.'($'.$price.'/mo)</label>
                                                    </div></div>';
                                                }
                                            }    

                                        ?>
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                    </div>
                </div>
                 <?php 
                    if(isset($errors['networkddos'])){
                        echo '<p class="text-danger mt-3">'.$errors['networkddos'].'</p>';
                    }
                    ?>

                 <div class="accordion mt-3 mb-4" id="networkddos">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="headingOne19">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#networkddos-block" aria-expanded="true" aria-controls="networkddos">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark heading-text">ddos:</span><br/>
                                        <span class="text-dark  slt-option-text">None</span>
                                    </div> 
                                    <div class="col-md-6">    
                                          <p class="text-right text-dark">$<span class="slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                            </button>
                        </div>

                        <div id="networkddos-block" class="collapse" aria-labelledby="headingOne19" data-parent="#networkddos-block">
                            <div class="card-body">
                                <div class="option-blk">
                                    <div class="row">
                                        <?php 
                                            $sql = 'SELECT id,title,price FROM network_ddos ORDER BY id  ASC ';
                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($id,$title,$price);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 

                                                    echo '<div class="col-md-4 col-sm-6 col-6 mb-4">
                                                    <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-networkddos">
                                                <input class="form-check-input networkddos-option rdo-option" type="radio" name="networkddos"  option-price="'.$price.'" id="'.$id.'networkddos"  value="'.$id.'" option-text="'.$title.'">
                                                    <label class="form-check-label text-capitalize" for="'.$id.'networkddos">'.$title.'($'.$price.'/mo)</label>
                                                    </div></div>';
                                                }
                                            }    

                                        ?>
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                    </div>
                </div>
                <h1 class="text-center">Addons</h1>

                 <div class="accordion mt-3 mb-4" id="hardwarefirewall">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="headingOne20">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#hfirewall-block" aria-expanded="true" aria-controls="hfirewall">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark heading-text">Hardware Firewall:</span><br/>
                                        <span class="text-dark  slt-option-text">None</span>
                                    </div> 
                                    <div class="col-md-6">    
                                          <p class="text-right text-dark">$<span class="slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                            </button>
                        </div>

                        <div id="hfirewall-block" class="collapse" aria-labelledby="headingOne20" data-parent="#hfirewall-block">
                            <div class="card-body">
                                <h3 class="text-capitalize">None</h3>
                                 
                                <div class="option-blk">
                                     <div class="row">
                                        <div class="col-md-4 col-sm-6 col-6 mb-4">
                                            <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-hfirewall">
                                                <input class="form-check-input hfirewall-option rdo-option" type="radio" name="hfirewall"  option-price="0" id="hfirewall-none" value="0">
                                                    <label class="form-check-label text-capitalize" for="hfirewall-none">None</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="option-blk">
                                    <div class="row">
                                        <?php 
                                            $sql = 'SELECT id,title,price FROM hardware_firewall  ORDER BY id  ASC ';
                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($id,$title,$price);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 

                                                    echo '<div class="col-md-4 col-sm-6 col-6 mb-4">
                                                    <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-hfirewall">
                                                <input class="form-check-input hfirewall-option rdo-option" type="radio" name="hfirewall"  option-price="'.$price.'" id="'.$id.'hfirewall"  value="'.$id.'" option-text="'.$title.'">
                                                    <label class="form-check-label text-capitalize" for="'.$id.'hfirewall">'.$title.'($'.$price.'/mo)</label>
                                                    </div></div>';
                                                }
                                            }    

                                        ?>
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                    </div>
                </div>


                 <div class="accordion mt-3 mb-4" id="dailybackup">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="headingOne21">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#dailybackup-block" aria-expanded="true" aria-controls="dailybackup">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark heading-text">Daily Backup & Rapid Restore:</span><br/>
                                        <span class="text-dark  slt-option-text">None</span>
                                    </div> 
                                    <div class="col-md-6">    
                                          <p class="text-right text-dark">$<span class="slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                            </button>
                        </div>

                        <div id="dailybackup-block" class="collapse" aria-labelledby="headingOne21" data-parent="#dailybackup-block">
                            <div class="card-body">
                                 <h3 class="text-capitalize">None</h3>
                                 
                                <div class="option-blk">
                                     <div class="row">
                                        <div class="col-md-4 col-sm-6 col-6 mb-4">
                                            <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-dailybackup">
                                                <input class="form-check-input dailybackup-option rdo-option" type="radio" name="dailybackup"  option-price="0" id="dailybackup-none" value="0">
                                                    <label class="form-check-label text-capitalize" for="dailybackup-none">None</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="option-blk">
                                    <div class="row">
                                        <?php 
                                            $sql = 'SELECT id,title,price FROM daily_backcup ORDER BY id  ASC ';
                                            if($stmt = $con->prepare($sql)) {
                                                $stmt->bind_result($id,$title,$price);
                                                $stmt->execute();
                                                while ($stmt->fetch()) { 

                                                    echo '<div class="col-md-4 col-sm-6 col-6 mb-4">
                                                    <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-dailybackup">
                                                <input class="form-check-input dailybackup-option rdo-option" type="radio" name="dailybackup"  option-price="'.$price.'" id="'.$id.'dailybackup"  value="'.$id.'" option-text="'.$title.'">
                                                    <label class="form-check-label text-capitalize" for="'.$id.'dailybackup">'.$title.'($'.$price.'/mo)</label>
                                                    </div></div>';
                                                }
                                            }    

                                        ?>
                                    </div>
                                </div>
                             
                            </div>
                        </div>
                    </div>
                </div>


                 <div class="accordion mt-3 mb-4" id="datamigration">
                    <div class="card shadow-none bg-light">
                        <div class="card-header" id="headingOne22">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#datamigration-block" aria-expanded="true" aria-controls="datamigration">
                                <div class="row">
                                    <div class="col-md-6">    
                                        <span class="font-weight-bold text-dark heading-text">Data migration:</span><br/>
                                        <span class="text-dark  slt-option-text">None</span>
                                    </div> 
                                    <div class="col-md-6">    
                                          <p class="text-right text-dark">$<span class="slt-option-price">0</span>/mo.&nbsp<i class="fa fa-plus" aria-hidden="true"></i></p>
                                    </div>
                                </div>        
                            </button>
                        </div>

                        <div id="datamigration-block" class="collapse" aria-labelledby="headingOne22" data-parent="#datamigration-block">
                            <div class="card-body">
                                  <h3 class="text-capitalize">None</h3>
                                   <div class="row">
                                    <div class="col-md-4 col-sm-6 col-6 mb-4">
                                        <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-datamigration">
                                            <input class="form-check-input datamigration-option rdo-option" type="radio" name="datamigration"  option-price="0" id="datamigration-none" value="0">
                                                <label class="form-check-label text-capitalize" for="datamigration-none">None</label>
                                                </div>
                                            </div>
                                </div>
                                <div class="row">

                                
                                    <?php 
                                        $sql = 'SELECT id,title,price FROM data_migration ORDER BY id  ASC ';
                                        if($stmt = $con->prepare($sql)) {
                                            $stmt->bind_result($id,$title,$price);
                                            $stmt->execute();
                                            while ($stmt->fetch()) { 

                                                echo '<div class="col-md-4 col-sm-6 col-6 mb-4">
                                                <div class="form-check form-check-inline bg-white border p-2 w-100 m-0 select-option select-datamigration">
                                            <input class="form-check-input datamigration-option rdo-option" type="radio" name="datamigration"  option-price="'.$price.'" id="'.$id.'datamigration"  value="'.$id.'" option-text="'.$title.'">
                                                <label class="form-check-label text-capitalize" for="'.$id.'datamigration">'.$title.'($'.$price.'/mo)</label>
                                                </div></div>';
                                            }
                                        }    

                                    ?>
                                </div>
                             
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>    
		<div class="row">
                <div class="col-md-12 text-right mt-3">
                    <button type="reset" class="btn btn-secondary mr-2">Clear</button>
                    <button type="submit" class="btn btn-primary"  name="addbaremetal" value="submit">Submit</button>
            </div>
        </div>    
	</form>

</div>
<script type="text/javascript">
    $('document').ready(function(){


         $('.card-header').click(function() {
            $(this).find('i').toggleClass('fas fa-plus fas fa-minus');
        });

        //Js  to select hard drives
        $('.select-hdd').click(function(){
            //$(this).toggleClass('selected');
           $(this).parents('.collapse').find('.select-hdd').removeClass('rdo-selected');
           $(this).parents('.collapse').find('.rdo-option').attr('checked', false);
           let hddText = $(this).parents('.accordion').find('.hdd-heading-text').text();
           let accordianTarget = $(this).parents('.accordion').attr('id');
           let value = $(this).find('.rdo-option').val();
           let driveTarget = $(this).parents('.accordion').find('.card-header .btn').attr('aria-controls');

           //rdo-option
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
                let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                //let text = $(this).parents('.option-blk').find('.title').val();

                if(value == 0){
                   $(this).parents('.card').find('.slt-option-price').text('0');
                    $('#order-hdd').find('#'+driveTarget).remove();
                    //calculate_orderAmount();
                } else {
                    if(price == ''){
                        price = 0;
                    }

                     $(this).parents('.card').find('.slt-option-price').text(price);
                    $('#order-hdd').find('#'+driveTarget).remove();
                    $('#order-hdd').append('<p class="mb-1" id="'+driveTarget+'">'+hddText+'<span class="selected-item font-weight-bold"><a href="#'+accordianTarget+'">'+text+'</a></span> <span class="selected-item-price float-right">$<span class="order-item-price">'+price+'</span></span></p>');
                    //calculate_orderAmount();

                }
            }
        });


//Data center js

        $('.datacenter-option').click(function(){
            //$(this).toggleClass('selected');
           $(this).parents('.collapse').find('.datacenter-option').removeClass('rdo-selected');
           $(this).parents('.collapse').find('.rdo-option').attr('checked', false);
           //let hddText = $(this).parents('.accordion').find('.hdd-heading-text').text();
           let accordianTarget = $(this).parents('.accordion').attr('id');
           let blockTarget = $(this).parents('.accordion').find('.card-header .btn').attr('aria-controls');

           /*console.log('accordianTarget:'+accordianTarget+'=> blockTarget:'+blockTarget);
           return;*/

           //rdo-option
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
                let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                //let text = $(this).parents('.option-blk').find('.title').val();
                console.log(text);
console.log('price::'+price);
              /*  if(text == 0){
                   $(this).parents('.card').find('.slt-option-price').text('0');
                } else {
                    if(price == ''){
                        price = 0;
                    }*/

                     $(this).parents('.card').find('.slt-option-price').text(price);
                     $(this).parents('.card').find('.slt-option-text').text(text);
                    //$('#order-hdd').find('#'+driveTarget).remove();
                    $('#orderdatacenter-name a').attr("href", "#"+blockTarget);
                    $('#orderdatacenter-name a').text(text);
                    $('#orderdatacenter-price').text(price);
                    

                /*}*/
            }
           //calculate_orderAmount();
        });




        //Processor js

        $('.processor-option').click(function(){
            //$(this).toggleClass('selected');
           $(this).parents('.collapse').find('.processor-option').removeClass('rdo-selected');
           $(this).parents('.collapse').find('.rdo-option').attr('checked', false);
           //let hddText = $(this).parents('.accordion').find('.hdd-heading-text').text();
           let accordianTarget = $(this).parents('.accordion').attr('id');
           let blockTarget = $(this).parents('.accordion').find('.card-header .btn').attr('aria-controls');

           /*console.log('accordianTarget:'+accordianTarget+'=> blockTarget:'+blockTarget);
           return;*/

           //rdo-option
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
                let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                //let text = $(this).parents('.option-blk').find('.title').val();
console.log('text::'+text);
                if(text == 0){
                   $(this).parents('.card').find('.slt-option-price').text('0');
                } else {
                    if(price == ''){
                        price = 0;
                    }

                     $(this).parents('.card').find('.slt-option-price').text(price);
                     $(this).parents('.card').find('.slt-option-text').text(text);
                    //$('#order-hdd').find('#'+driveTarget).remove();
                    $('#processor-name a').attr("href", "#"+blockTarget);
                    $('#processor-name a').text(text);
                    $('#processor-price').text(price);
                    

                }
            }
           //calculate_orderAmount();
        });


         //Processor js

        $('.memory-option').click(function(){
            //$(this).toggleClass('selected');
           $(this).parents('.collapse').find('.memory-option').removeClass('rdo-selected');
           $(this).parents('.collapse').find('.rdo-option').attr('checked', false);
           //let hddText = $(this).parents('.accordion').find('.hdd-heading-text').text();
           let accordianTarget = $(this).parents('.accordion').attr('id');
           let blockTarget = $(this).parents('.accordion').find('.card-header .btn').attr('aria-controls');

           /*console.log('accordianTarget:'+accordianTarget+'=> blockTarget:'+blockTarget);
           return;*/

           //rdo-option
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
                let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                //let text = $(this).parents('.option-blk').find('.title').val();
console.log('text::'+text);
                if(text == 0){
                   $(this).parents('.card').find('.slt-option-price').text('0');
                } else {
                    if(price == ''){
                        price = 0;
                    }

                     $(this).parents('.card').find('.slt-option-price').text(price);
                     $(this).parents('.card').find('.slt-option-text').text(text);
                    //$('#order-hdd').find('#'+driveTarget).remove();
                    $('#memoryr-name a').attr("href", "#"+blockTarget);
                    $('#memory-name a').text(text);
                    $('#memory-price').text(price);
                    

                }
            }
           //calculate_orderAmount();
        });


         //Chassis upgrade js

        $('.chassis-upgrade').click(function(){
            //$(this).toggleClass('selected');
           $(this).parents('.collapse').find('.chassis-upgrade').removeClass('rdo-selected');
           $(this).parents('.collapse').find('.rdo-option').attr('checked', false);
           let headText = $(this).parents('.accordion').find('.heading-text').text();
           let accordianTarget = $(this).parents('.accordion').attr('id');
           let blockTarget = $(this).parents('.accordion').find('.card-header .btn').attr('aria-controls');

           /*console.log('accordianTarget:'+accordianTarget+'=> blockTarget:'+blockTarget);
           return;*/

           //rdo-option
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
                let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                let value = $(this).find('.rdo-option').val();
console.log('accordianTarget::'+accordianTarget+'value:'+value);
                if(value == 0){
                   $(this).parents('.card').find('.slt-option-price').text('0');
                   $(this).parents('.card').find('.slt-option-text').text('None');
                   $('#order-chassis').find('#'+accordianTarget).remove();
                } else {
                    if(price == ''){
                        price = 0;
                    }

                     $(this).parents('.card').find('.slt-option-price').text(price);
                     $(this).parents('.card').find('.slt-option-text').text(text);
                    $('#order-chassis').find('#'+accordianTarget).remove();
                    $('#order-chassis').append('<p class="mb-1" id="'+accordianTarget+'">'+headText+'<span class="selected-item font-weight-bold"><a href="#'+accordianTarget+'">'+text+'</a></span> <span class="selected-item-price float-right">$<span class="order-item-price">'+price+'</span></span></p>');
                    //calculate_orderAmount();
                    

                }
            }
           //calculate_orderAmount();
        });


        

        //Raid js

        $('.raid-select-option').click(function(){
            //$(this).toggleClass('selected');
           $(this).parents('.collapse').find('.raid-select-option').removeClass('rdo-selected');
           $(this).parents('.collapse').find('.rdo-option').attr('checked', false);
           let headText = $(this).parents('.accordion').find('.heading-text').text();
           let accordianTarget = $(this).parents('.accordion').attr('id');
           let blockTarget = $(this).parents('.accordion').find('.card-header .btn').attr('aria-controls');

           /*console.log('accordianTarget:'+accordianTarget+'=> blockTarget:'+blockTarget);
           return;*/

           //rdo-option
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
               // let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                let value = $(this).find('.rdo-option').val();
                //let text = $(this).parents('.option-blk').find('.title').val();
console.log('accordianTarget::'+accordianTarget);
                if(value == 0){
                   $(this).parents('.card').find('.slt-option-price').text('0');
                   $(this).parents('.card').find('.slt-option-text').text('None');
                   $('#order-raid').find('#'+accordianTarget).remove();
                } else {
                    if(price == ''){
                        price = 0;
                    }

                     $(this).parents('.card').find('.slt-option-price').text(price);
                     $(this).parents('.card').find('.slt-option-text').text(text);
                    //$('#order-hdd').find('#'+driveTarget).remove();
                   /* $('#chassis-upgrade-name a').attr("href", "#"+blockTarget);
                    $('#chassis-upgrade-name a').text(text);
                    $('#chassis-upgrade-price').text(price);*/

                    $('#order-raid').find('#'+accordianTarget).remove();
                    $('#order-raid').append('<p class="mb-1" id="'+accordianTarget+'">'+headText+'<span class="selected-item font-weight-bold"><a href="#'+accordianTarget+'">'+text+'</a></span> <span class="selected-item-price float-right">$<span class="order-item-price">'+price+'</span></span></p>');
                    //calculate_orderAmount();
                    

                }
            }
           //calculate_orderAmount();
        });



        //Raid addons  js

        $('.raidaddons-select-option').click(function(){
            //$(this).toggleClass('selected');
           $(this).parents('.collapse').find('.raidaddons-select-option').removeClass('rdo-selected');
           $(this).parents('.collapse').find('.rdo-option').attr('checked', false);
           let headText = $(this).parents('.accordion').find('.heading-text').text();
           let accordianTarget = $(this).parents('.accordion').attr('id');
           let blockTarget = $(this).parents('.accordion').find('.card-header .btn').attr('aria-controls');

           /*console.log('accordianTarget:'+accordianTarget+'=> blockTarget:'+blockTarget);
           return;*/

           //rdo-option
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
               // let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                let value = $(this).find('.rdo-option').val();
                //let text = $(this).parents('.option-blk').find('.title').val();
console.log('accordianTarget::'+accordianTarget);
                if(value == 0){
                   $(this).parents('.card').find('.slt-option-price').text('0');
                   $(this).parents('.card').find('.slt-option-text').text('None');
                   $('#order-raidaddons').find('#'+accordianTarget).remove();
                } else {
                    if(price == ''){
                        price = 0;
                    }

                     $(this).parents('.card').find('.slt-option-price').text(price);
                     $(this).parents('.card').find('.slt-option-text').text(text);
                    //$('#order-hdd').find('#'+driveTarget).remove();
                   /* $('#chassis-upgrade-name a').attr("href", "#"+blockTarget);
                    $('#chassis-upgrade-name a').text(text);
                    $('#chassis-upgrade-price').text(price);*/

                    $('#order-raidaddons').find('#'+accordianTarget).remove();
                    $('#order-raidaddons').append('<p class="mb-1" id="'+accordianTarget+'">'+headText+'<span class="selected-item font-weight-bold"><a href="#'+accordianTarget+'">'+text+'</a></span> <span class="selected-item-price float-right">$<span class="order-item-price">'+price+'</span></span></p>');
                    //calculate_orderAmount();
                    

                }
            }
           //calculate_orderAmount();
        });



         //Raid addons  js

        $('.raidbackup-select-option').click(function(){
            //$(this).toggleClass('selected');
           $(this).parents('.collapse').find('.raidbackup-select-option').removeClass('rdo-selected');
           $(this).parents('.collapse').find('.rdo-option').attr('checked', false);
           let headText = $(this).parents('.accordion').find('.heading-text').text();
           let accordianTarget = $(this).parents('.accordion').attr('id');
           let blockTarget = $(this).parents('.accordion').find('.card-header .btn').attr('aria-controls');

           /*console.log('accordianTarget:'+accordianTarget+'=> blockTarget:'+blockTarget);
           return;*/

           //rdo-option
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
               // let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                let value = $(this).find('.rdo-option').val();
                //let text = $(this).parents('.option-blk').find('.title').val();
console.log('accordianTarget::'+accordianTarget);
                if(value == 0){
                   $(this).parents('.card').find('.slt-option-price').text('0');
                   $(this).parents('.card').find('.slt-option-text').text('None');
                   $('#order-raidbackup').find('#'+accordianTarget).remove();
                } else {
                    if(price == ''){
                        price = 0;
                    }

                     $(this).parents('.card').find('.slt-option-price').text(price);
                     $(this).parents('.card').find('.slt-option-text').text(text);
                    //$('#order-hdd').find('#'+driveTarget).remove();
                   /* $('#chassis-upgrade-name a').attr("href", "#"+blockTarget);
                    $('#chassis-upgrade-name a').text(text);
                    $('#chassis-upgrade-price').text(price);*/

                    $('#order-raidbackup').find('#'+accordianTarget).remove();
                    $('#order-raidbackup').append('<p class="mb-1" id="'+accordianTarget+'">Raid BBU: <span class="selected-item font-weight-bold"><a href="#'+accordianTarget+'">'+text+'</a></span> <span class="selected-item-price float-right">$<span class="order-item-price">'+price+'</span></span></p><div class="clearfix"></div>');
                    //calculate_orderAmount();
                    

                }
            }
           //calculate_orderAmount();
        });


  //Operating system

        $('.operating-system').click(function(){
            //$(this).toggleClass('selected');
           $(this).parents('.collapse').find('.operating-system').removeClass('rdo-selected');
           $(this).parents('.collapse').find('.rdo-option').attr('checked', false);
           let headText = $(this).parents('.accordion').find('.heading-text').text();
           let accordianTarget = $(this).parents('.accordion').attr('id');
           let blockTarget = $(this).parents('.accordion').find('.card-header .btn').attr('aria-controls');

           /*console.log('accordianTarget:'+accordianTarget+'=> blockTarget:'+blockTarget);
           return;*/

           //rdo-option
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
               // let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                let value = $(this).find('.rdo-option').val();
                //let text = $(this).parents('.option-blk').find('.title').val();
console.log('accordianTarget::'+accordianTarget);
                if(value == 0){
                   $(this).parents('.card').find('.slt-option-price').text('0');
                   $(this).parents('.card').find('.slt-option-text').text('None');
                   $('#order-raidbackup').find('#'+accordianTarget).remove();
                } else {
                    if(price == ''){
                        price = 0;
                    }

                     $(this).parents('.card').find('.slt-option-price').text(price);
                     $(this).parents('.card').find('.slt-option-text').text(text);
                    //$('#order-hdd').find('#'+driveTarget).remove();
                    $('#os-name a').attr("href", "#"+blockTarget);
                    $('#os-name a').text(text);
                    $('#os-price').text(price);

                    //calculate_orderAmount();
                    

                }
            }
          
        });



          //SQL SERVER  js

        $('.select-sqlserver').click(function(){
            //$(this).toggleClass('selected');
           $(this).parents('.collapse').find('.select-sqlserver').removeClass('rdo-selected');
           $(this).parents('.collapse').find('.rdo-option').attr('checked', false);
           let headText = $(this).parents('.accordion').find('.heading-text').text();
           let accordianTarget = $(this).parents('.accordion').attr('id');
           let blockTarget = $(this).parents('.accordion').find('.card-header .btn').attr('aria-controls');

           /*console.log('accordianTarget:'+accordianTarget+'=> blockTarget:'+blockTarget);
           return;*/

           //rdo-option
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
               // let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                let value = $(this).find('.rdo-option').val();
                //let text = $(this).parents('.option-blk').find('.title').val();
console.log('accordianTarget::'+accordianTarget);
                if(value == 0){
                   $(this).parents('.card').find('.slt-option-price').text('0');
                   $(this).parents('.card').find('.slt-option-text').text('None');
                   $('#order-sqlserver').find('#'+accordianTarget).remove();
                } else {
                    if(price == ''){
                        price = 0;
                    }

                     $(this).parents('.card').find('.slt-option-price').text(price);
                     $(this).parents('.card').find('.slt-option-text').text(text);
                    //$('#order-hdd').find('#'+driveTarget).remove();
                   /* $('#chassis-upgrade-name a').attr("href", "#"+blockTarget);
                    $('#chassis-upgrade-name a').text(text);
                    $('#chassis-upgrade-price').text(price);*/

                    $('#order-sqlserver').find('#'+accordianTarget).remove();
                    $('#order-sqlserver').append('<p class="mb-1" id="'+accordianTarget+'">'+headText+': <span class="selected-item font-weight-bold"><a href="#'+accordianTarget+'">'+text+'</a></span> <span class="selected-item-price float-right">$<span class="order-item-price">'+price+'</span></span></p><div class="clearfix"></div>');
                   // //calculate_orderAmount();
                    

                }
            }
           //calculate_orderAmount();
        });


         //Control panel  js

        $('.select-controlPanel').click(function(){
            //$(this).toggleClass('selected');
           $(this).parents('.collapse').find('.select-controlPanel').removeClass('rdo-selected');
           $(this).parents('.collapse').find('.rdo-option').attr('checked', false);
           let headText = $(this).parents('.accordion').find('.heading-text').text();
           let accordianTarget = $(this).parents('.accordion').attr('id');
           let blockTarget = $(this).parents('.accordion').find('.card-header .btn').attr('aria-controls');

           /*console.log('accordianTarget:'+accordianTarget+'=> blockTarget:'+blockTarget);
           return;*/

           //rdo-option
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
               // let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                let value = $(this).find('.rdo-option').val();
                //let text = $(this).parents('.option-blk').find('.title').val();
console.log('accordianTarget::'+accordianTarget);
                if(value == 0){
                   $(this).parents('.card').find('.slt-option-price').text('0');
                   $(this).parents('.card').find('.slt-option-text').text('None');
                   $('#order-controlPanel').find('#'+accordianTarget).remove();
                } else {
                    if(price == ''){
                        price = 0;
                    }

                     $(this).parents('.card').find('.slt-option-price').text(price);
                     $(this).parents('.card').find('.slt-option-text').text(text);
                    //$('#order-hdd').find('#'+driveTarget).remove();
                   /* $('#chassis-upgrade-name a').attr("href", "#"+blockTarget);
                    $('#chassis-upgrade-name a').text(text);
                    $('#chassis-upgrade-price').text(price);*/

                    $('#order-controlPanel').find('#'+accordianTarget).remove();
                    $('#order-controlPanel').append('<p class="mb-1" id="'+accordianTarget+'">'+headText+': <span class="selected-item font-weight-bold"><a href="#'+accordianTarget+'">'+text+'</a></span> <span class="selected-item-price float-right">$<span class="order-item-price">'+price+'</span></span></p><div class="clearfix"></div>');
                   // //calculate_orderAmount();
                    

                }
            }
           //calculate_orderAmount();
        });

  //Server management  js

  $('.server-management').click(function(){
            //$(this).toggleClass('selected');
           $(this).parents('.collapse').find('.server-management').removeClass('rdo-selected');
           $(this).parents('.collapse').find('.rdo-option').attr('checked', false);
           let headText = $(this).parents('.accordion').find('.heading-text').text();
           let accordianTarget = $(this).parents('.accordion').attr('id');
           let blockTarget = $(this).parents('.accordion').find('.card-header .btn').attr('aria-controls');

           /*console.log('accordianTarget:'+accordianTarget+'=> blockTarget:'+blockTarget);
           return;*/

           //rdo-option
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
               // let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                let value = $(this).find('.rdo-option').val();
                //let text = $(this).parents('.option-blk').find('.title').val();
console.log('accordianTarget::'+accordianTarget);
                if(value == 0){
                   $(this).parents('.card').find('.slt-option-price').text('0');
                   $(this).parents('.card').find('.slt-option-text').text('None');
                   $('#order-serverManagement').find('#'+accordianTarget).remove();
                } else {
                    if(price == ''){
                        price = 0;
                    }

                     $(this).parents('.card').find('.slt-option-price').text(price);
                     $(this).parents('.card').find('.slt-option-text').text(text);
                    //$('#order-hdd').find('#'+driveTarget).remove();
                    $('#serverm-name a').attr("href", "#"+blockTarget);
                    $('#serverm-name a').text(text);
                    $('#serverm-price').text(price);

                    //calculate_orderAmount();
                    

                }
            }
          
        });


   //Softaculous  js 

    $('.select-softaculous').click(function(){
            //$(this).toggleClass('selected');
           $(this).parents('.collapse').find('.select-softaculous').removeClass('rdo-selected');
           $(this).parents('.collapse').find('.rdo-option').attr('checked', false);
           let headText = $(this).parents('.accordion').find('.heading-text').text();
           let accordianTarget = $(this).parents('.accordion').attr('id');
           let blockTarget = $(this).parents('.accordion').find('.card-header .btn').attr('aria-controls');

           /*console.log('accordianTarget:'+accordianTarget+'=> blockTarget:'+blockTarget);
           return;*/

           //rdo-option
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
               // let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                let value = $(this).find('.rdo-option').val();
                //let text = $(this).parents('.option-blk').find('.title').val();
console.log('accordianTarget::'+accordianTarget);
                if(value == 0){
                   $(this).parents('.card').find('.slt-option-price').text('0');
                   $(this).parents('.card').find('.slt-option-text').text('None');
                   $('#order-softaculous').find('#'+accordianTarget).remove();
                } else {
                    if(price == ''){
                        price = 0;
                    }

                     $(this).parents('.card').find('.slt-option-price').text(price);
                     $(this).parents('.card').find('.slt-option-text').text(text);

                    $('#order-softaculous').find('#'+accordianTarget).remove();
                    $('#order-softaculous').append('<p class="mb-1" id="'+accordianTarget+'">'+headText+': <span class="selected-item font-weight-bold"><a href="#'+accordianTarget+'">'+text+'</a></span> <span class="selected-item-price float-right">$<span class="order-item-price">'+price+'</span></span></p><div class="clearfix"></div>');
                   // //calculate_orderAmount();
                    

                }
            }
           //calculate_orderAmount();
        });


     //Softaculous  js 

    $('.select-kernalcare').click(function(){
            //$(this).toggleClass('selected');
           $(this).parents('.collapse').find('.select-kernalcare').removeClass('rdo-selected');
           $(this).parents('.collapse').find('.rdo-option').attr('checked', false);
           let headText = $(this).parents('.accordion').find('.heading-text').text();
           let accordianTarget = $(this).parents('.accordion').attr('id');
           let blockTarget = $(this).parents('.accordion').find('.card-header .btn').attr('aria-controls');
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
               // let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                let value = $(this).find('.rdo-option').val();
                //let text = $(this).parents('.option-blk').find('.title').val();
console.log('accordianTarget::'+accordianTarget);
                if(value == 0){
                   $(this).parents('.card').find('.slt-option-price').text('0');
                   $(this).parents('.card').find('.slt-option-text').text('None');
                   $('#order-kernalcare').find('#'+accordianTarget).remove();
                } else {
                    if(price == ''){
                        price = 0;
                    }

                     $(this).parents('.card').find('.slt-option-price').text(price);
                     $(this).parents('.card').find('.slt-option-text').text(text);

                    $('#order-kernalcare').find('#'+accordianTarget).remove();
                    $('#order-kernalcare').append('<p class="mb-1" id="'+accordianTarget+'">'+headText+' <span class="selected-item font-weight-bold"><a href="#'+accordianTarget+'">'+text+'</a></span> <span class="selected-item-price float-right">$<span class="order-item-price">'+price+'</span></span></p><div class="clearfix"></div>');
                   // //calculate_orderAmount();
                    

                }
            }
           //calculate_orderAmount();
        });

//LiteSpeed js
    $('.select-litespeed').click(function(){
            //$(this).toggleClass('selected');
           $(this).parents('.collapse').find('.select-litespeed').removeClass('rdo-selected');
           $(this).parents('.collapse').find('.rdo-option').attr('checked', false);
           let headText = $(this).parents('.accordion').find('.heading-text').text();
           let accordianTarget = $(this).parents('.accordion').attr('id');
           let blockTarget = $(this).parents('.accordion').find('.card-header .btn').attr('aria-controls');
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
               // let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                let value = $(this).find('.rdo-option').val();
                //let text = $(this).parents('.option-blk').find('.title').val();
console.log('accordianTarget::'+accordianTarget);
                if(value == 0){
                   $(this).parents('.card').find('.slt-option-price').text('0');
                   $(this).parents('.card').find('.slt-option-text').text('None');
                   $('#order-litespeed').find('#'+accordianTarget).remove();
                } else {
                    if(price == ''){
                        price = 0;
                    }

                     $(this).parents('.card').find('.slt-option-price').text(price);
                     $(this).parents('.card').find('.slt-option-text').text(text);

                    $('#order-litespeed').find('#'+accordianTarget).remove();
                    $('#order-litespeed').append('<p class="mb-1" id="'+accordianTarget+'">'+headText+' <span class="selected-item font-weight-bold"><a href="#'+accordianTarget+'">'+text+'</a></span> <span class="selected-item-price float-right">$<span class="order-item-price">'+price+'</span></span></p><div class="clearfix"></div>');
                   // //calculate_orderAmount();
                    

                }
            }
           //calculate_orderAmount();
        });

    //whmsc js
    $('.select-whmcs').click(function(){
            //$(this).toggleClass('selected');
           $(this).parents('.collapse').find('.select-whmcs').removeClass('rdo-selected');
           $(this).parents('.collapse').find('.rdo-option').attr('checked', false);
           let headText = $(this).parents('.accordion').find('.heading-text').text();
           let accordianTarget = $(this).parents('.accordion').attr('id');
           let blockTarget = $(this).parents('.accordion').find('.card-header .btn').attr('aria-controls');
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
               // let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                let value = $(this).find('.rdo-option').val();
                //let text = $(this).parents('.option-blk').find('.title').val();
console.log('accordianTarget::'+accordianTarget);
                if(value == 0){
                   $(this).parents('.card').find('.slt-option-price').text('0');
                   $(this).parents('.card').find('.slt-option-text').text('None');
                   $('#order-whmcs').find('#'+accordianTarget).remove();
                } else {
                    if(price == ''){
                        price = 0;
                    }

                     $(this).parents('.card').find('.slt-option-price').text(price);
                     $(this).parents('.card').find('.slt-option-text').text(text);

                    $('#order-whmcs').find('#'+accordianTarget).remove();
                    $('#order-whmcs').append('<p class="mb-1" id="'+accordianTarget+'">'+headText+' <span class="selected-item font-weight-bold"><a href="#'+accordianTarget+'">'+text+'</a></span> <span class="selected-item-price float-right">$<span class="order-item-price">'+price+'</span></span></p><div class="clearfix"></div>');
                   // //calculate_orderAmount();
                    

                }
            }
           //calculate_orderAmount();
        });


//Bandwidth network

$('.select-bandwidth').click(function(){
            //$(this).toggleClass('selected');
           $(this).parents('.collapse').find('.select-bandwidth').removeClass('rdo-selected');
           $(this).parents('.collapse').find('.rdo-option').attr('checked', false);
           let headText = $(this).parents('.accordion').find('.heading-text').text();
           let accordianTarget = $(this).parents('.accordion').attr('id');
           let blockTarget = $(this).parents('.accordion').find('.card-header .btn').attr('aria-controls');

           /*console.log('accordianTarget:'+accordianTarget+'=> blockTarget:'+blockTarget);
           return;*/

           //rdo-option
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
               // let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                let value = $(this).find('.rdo-option').val();
                //let text = $(this).parents('.option-blk').find('.title').val();
console.log('accordianTarget::'+accordianTarget);
                if(value == 0){
                   $(this).parents('.card').find('.slt-option-price').text('0');
                   $(this).parents('.card').find('.slt-option-text').text('None');
                } else {
                    if(price == ''){
                        price = 0;
                    }

                     $(this).parents('.card').find('.slt-option-price').text(price);
                     $(this).parents('.card').find('.slt-option-text').text(text);
                    //$('#order-hdd').find('#'+driveTarget).remove();
                    $('#bandwidth-name a').attr("href", "#"+blockTarget);
                    $('#bandwidth-name a').text(text);
                    $('#bandwidth-price').text(price);

                    //calculate_orderAmount();
                    

                }
            }
          
        });

//Internal network js

    $('.select-internalnet').click(function(){
            //$(this).toggleClass('selected');
           $(this).parents('.collapse').find('.select-internalnet').removeClass('rdo-selected');
           $(this).parents('.collapse').find('.rdo-option').attr('checked', false);
           let headText = $(this).parents('.accordion').find('.heading-text').text();
           let accordianTarget = $(this).parents('.accordion').attr('id');
           let blockTarget = $(this).parents('.accordion').find('.card-header .btn').attr('aria-controls');

           /*console.log('accordianTarget:'+accordianTarget+'=> blockTarget:'+blockTarget);
           return;*/

           //rdo-option
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
               // let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                let value = $(this).find('.rdo-option').val();
                //let text = $(this).parents('.option-blk').find('.title').val();
console.log('accordianTarget::'+accordianTarget);
                if(value == 0){
                   $(this).parents('.card').find('.slt-option-price').text('0');
                   $(this).parents('.card').find('.slt-option-text').text('None');
                } else {
                    if(price == ''){
                        price = 0;
                    }

                     $(this).parents('.card').find('.slt-option-price').text(price);
                     $(this).parents('.card').find('.slt-option-text').text(text);
                    //$('#order-hdd').find('#'+driveTarget).remove();
                    $('#internalNetwork-name a').attr("href", "#"+blockTarget);
                    $('#internalNetwork-name a').text(text);
                    $('#internalNetwork-price').text(price);

                    //calculate_orderAmount();
                    

                }
            }
          
        });

        
 //whmsc js
    $('.select-loadbalancing').click(function(){
            //$(this).toggleClass('selected');
           $(this).parents('.collapse').find('.select-loadbalancing').removeClass('rdo-selected');
           $(this).parents('.collapse').find('.rdo-option').attr('checked', false);
           let headText = $(this).parents('.accordion').find('.heading-text').text();
           let accordianTarget = $(this).parents('.accordion').attr('id');
           let blockTarget = $(this).parents('.accordion').find('.card-header .btn').attr('aria-controls');
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
               // let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                let value = $(this).find('.rdo-option').val();
                //let text = $(this).parents('.option-blk').find('.title').val();
console.log('accordianTarget::'+accordianTarget);
                if(value == 0){
                   $(this).parents('.card').find('.slt-option-price').text('0');
                   $(this).parents('.card').find('.slt-option-text').text('None');
                   $('#order-loadbalancing').find('#'+accordianTarget).remove();
                } else {
                    if(price == ''){
                        price = 0;
                    }

                     $(this).parents('.card').find('.slt-option-price').text(price);
                     $(this).parents('.card').find('.slt-option-text').text(text);

                    $('#order-loadbalancing').find('#'+accordianTarget).remove();
                    $('#order-loadbalancing').append('<p class="mb-1" id="'+accordianTarget+'">'+headText+' <span class="selected-item font-weight-bold"><a href="#'+accordianTarget+'">'+text+'</a></span> <span class="selected-item-price float-right">$<span class="order-item-price">'+price+'</span></span></p><div class="clearfix"></div>');
                   // //calculate_orderAmount();
                    

                }
            }
           //calculate_orderAmount();
        });



//DDOS js

        $('.select-networkddos').click(function(){
            //$(this).toggleClass('selected');
           $(this).parents('.collapse').find('.select-networkddos').removeClass('rdo-selected');
           $(this).parents('.collapse').find('.rdo-option').attr('checked', false);
           let headText = $(this).parents('.accordion').find('.heading-text').text();
           let accordianTarget = $(this).parents('.accordion').attr('id');
           let blockTarget = $(this).parents('.accordion').find('.card-header .btn').attr('aria-controls');
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
               // let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                let value = $(this).find('.rdo-option').val();
                //let text = $(this).parents('.option-blk').find('.title').val();
console.log('accordianTarget::'+accordianTarget);
                if(value == 0){
                   $(this).parents('.card').find('.slt-option-price').text('0');
                   $(this).parents('.card').find('.slt-option-text').text('None');
                   $('#order-networkddos').find('#'+accordianTarget).remove();
                } else {
                    if(price == ''){
                        price = 0;
                    }

                     $(this).parents('.card').find('.slt-option-price').text(price);
                     $(this).parents('.card').find('.slt-option-text').text(text);
                    //$('#order-hdd').find('#'+driveTarget).remove();
                    $('#networkddos-name a').attr("href", "#"+blockTarget);
                    $('#networkddos-name a').text(text);
                    $('#networkddos-price').text(price);

                    //calculate_orderAmount();
                    

                }
            }
          
        });





//Hardware filewall js


 $('.select-hfirewall').click(function(){
            //$(this).toggleClass('selected');
           $(this).parents('.collapse').find('.select-hfirewall').removeClass('rdo-selected');
           $(this).parents('.collapse').find('.rdo-option').attr('checked', false);
           let headText = $(this).parents('.accordion').find('.heading-text').text();
           let accordianTarget = $(this).parents('.accordion').attr('id');
           let blockTarget = $(this).parents('.accordion').find('.card-header .btn').attr('aria-controls');

           /*console.log('accordianTarget:'+accordianTarget+'=> blockTarget:'+blockTarget);
           return;*/

           //rdo-option
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
                let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                let value = $(this).find('.rdo-option').val();
console.log('accordianTarget::'+accordianTarget+'value:'+value);
                if(value == 0){
                   $(this).parents('.card').find('.slt-option-price').text('0');
                   $(this).parents('.card').find('.slt-option-text').text('None');
                   $('#order-hardwarefirewall').find('#'+accordianTarget).remove();
                } else {
                    if(price == ''){
                        price = 0;
                    }

                     $(this).parents('.card').find('.slt-option-price').text(price);
                     $(this).parents('.card').find('.slt-option-text').text(text);
                    $('#order-hardwarefirewall').find('#'+accordianTarget).remove();
                    $('#order-hardwarefirewall').append('<p class="mb-1" id="'+accordianTarget+'">'+headText+'<span class="selected-item font-weight-bold"><a href="#'+accordianTarget+'">'+text+'</a></span> <span class="selected-item-price float-right">$<span class="order-item-price">'+price+'</span></span></p>');
                    //calculate_orderAmount();
                    

                }
            }
           //calculate_orderAmount();
        });


//dailybackup js


 $('.select-dailybackup').click(function(){
            //$(this).toggleClass('selected');
           $(this).parents('.collapse').find('.select-dailybackup').removeClass('rdo-selected');
           $(this).parents('.collapse').find('.rdo-option').attr('checked', false);
           let headText = $(this).parents('.accordion').find('.heading-text').text();
           let accordianTarget = $(this).parents('.accordion').attr('id');
           let blockTarget = $(this).parents('.accordion').find('.card-header .btn').attr('aria-controls');

           /*console.log('accordianTarget:'+accordianTarget+'=> blockTarget:'+blockTarget);
           return;*/

           //rdo-option
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
                let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                let value = $(this).find('.rdo-option').val();
console.log('accordianTarget::'+accordianTarget+'value:'+value);
                if(value == 0){
                   $(this).parents('.card').find('.slt-option-price').text('0');
                   $(this).parents('.card').find('.slt-option-text').text('None');
                   $('#order-dailybackup').find('#'+accordianTarget).remove();
                } else {
                    if(price == ''){
                        price = 0;
                    }

                     $(this).parents('.card').find('.slt-option-price').text(price);
                     $(this).parents('.card').find('.slt-option-text').text(text);
                    $('#order-dailybackup').find('#'+accordianTarget).remove();
                    $('#order-dailybackup').append('<p class="mb-1" id="'+accordianTarget+'">'+headText+'<span class="selected-item font-weight-bold"><a href="#'+accordianTarget+'">'+text+'</a></span> <span class="selected-item-price float-right">$<span class="order-item-price">'+price+'</span></span></p>');
                    //calculate_orderAmount();
                    

                }
            }
           //calculate_orderAmount();
        });



 //Data migration
 $('.select-datamigration').click(function(){
            //$(this).toggleClass('selected');
           $(this).closest('.accordion').find('.select-datamigration').removeClass('rdo-selected');
           $(this).closest('.accordion').find('.rdo-option').attr('checked', false);
           let headText = $(this).closest('.accordion').find('.heading-text').text();
           let accordianTarget = $(this).closest('.accordion').attr('id');
           let blockTarget = $(this).closest('.accordion').find('.card-header .btn').attr('aria-controls');

           /*console.log('accordianTarget:'+accordianTarget+'=> blockTarget:'+blockTarget);
           return;*/

           //rdo-option
            if($(this).hasClass('rdo-selected')){
                $(this).removeClass('rdo-selected');
                 $(this).find('.rdo-option').attr('checked', false);

            } else {

                $(this).addClass('rdo-selected');
                $(this).find('.rdo-option').attr('checked', true);
                let price = $(this).find('.rdo-option').attr('option-price');
                let sltText = $(this).find('.rdo-option').attr('slt-type');
                let text = $(this).find('.rdo-option').attr('option-text');
                let value = $(this).find('.rdo-option').val();
                    if(price == ''){
                        price = 0;
                    }

                     $(this).parents('.card').find('.slt-option-price').text(price);
                     $(this).parents('.card').find('.slt-option-text').text(text);
                    

                }
        });



    });
    </script>

    <?php 
        require_once('templates/footer.php'); 
    ?>
