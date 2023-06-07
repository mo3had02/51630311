<?php 
ob_start(); // Output Buffering Start

	session_start();

	$pageTitle = 'Items';

	if (isset($_SESSION['username'])) {

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if ($do == 'Manage') {
            //Start manage page 
        $query ='';
     
			// Select All Users Except Admin 

			$stmt = $con->prepare("SELECT 
										items.*, 
										categories.name AS category_name, 
										users.FullName 
									FROM 
										items
									INNER JOIN 
										categories 
									ON 
										categories.catID = items.CAT_ID 
									INNER JOIN 
										users 
									ON 
										users.UID = items.mem_ID
									ORDER BY 
										iID DESC");


			// Execute The Statement

			$stmt->execute();

			// Assign To Variable 

			$items = $stmt->fetchAll();
     ?>
        <h1 class="text-center">Manage Items</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table manage-members text-center table table-striped table-bordered">
						<tr >
							<td>#ID</td>
							<td>Name</td>
							<td>Model</td>
							<td>Description</td>
                            <td>Price $</td>
                            <td>Category</td>
                            <td>Member</td> 
							<td>Control</td>
						</tr>
                        		<?php
							foreach($items as $item) {
								echo "<tr>";
									echo "<td>" . $item['iID'] . "</td>";
                                    echo "<td>" . $item['name'] . "</td>";
									echo "<td>" . $item['Model'] . "</td>";
									echo "<td>" . $item['Descreption'] . "</td>";
                                    echo "<td>" . $item['price'] . '$'."</td>";
                                    echo "<td>" . $item['category_name'] . "</td>";
                                    echo "<td>" . $item['FullName'] . "</td>";
									//echo "<td>" . $item['Date'] . "</td>";
									echo "<td>
										<a href='items.php?do=Edit&iID=" . $item['iID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
										<a href='items.php?do=Delete&iID=" . $item['iID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
								/*		if ($item['RegStatus'] == 0) {
											echo "<a 
													href='members.php?do=Activate&UID=" . $item['iID'] . "' 
													class='btn btn-info activate'>
													<i class='fa fa-check'></i> Active</a>";
										}*/
									echo "</td>";
								echo "</tr>";
							}
						?>
                        
                    </table>
                    <a href="items.php?do=Add" class="btn btn-primary">
					<i class="fa fa-plus"></i> New Item
				</a>




        
        
    <?php


		} elseif ($do == 'Add') { ?>
        
        <h1 class ="text-center"> Add Item </h1>
        

         <section class="h-100">
		<div class="container h-100">
            <form class="form-horizontal" action="?do=Insert" method="POST">
            
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="card shadow-lg">
						<div class="card-body p-5">        
                <!-- Start name Field -->
                <div class="form-group">
                    <label class="col-sm-10 control-label" >Name</label>
                    <div class=" col-sm-12s ">
                        <input type="text" name="name" class="form-control"  required ="required">
                    </div>
                </div>
                <!-- End name Field -->
                <!-- Start name Field -->
                <div class="form-group">
                    <label class="col-sm-10 control-label" >Model</label>
                    <div class=" col-sm-12s ">
                        <input type="text" name="model" class="form-control"  required ="required">
                    </div>
                </div>
                <!-- End name Field -->

                <!-- Start Descreption Field -->
                 <div class="form-group">
                    <label class="col-sm-10 control-label" >Descreption </label>
                    <div class=" col-sm-12">
                        
                     <textarea name="descreption"  cols="10" row="4" class="form-control" required ="required"> </textarea> 
                        
                    </div>
                </div>
                <!-- End Descreption Field -->
                <!-- Start Descreption Field -->
                 <div class="form-group">
                    <label class="col-sm-10 control-label"  >Price</label> 
                    <div class=" col-sm-8">
                        
                        <input type="text" name="price" class="form-control" required ="required">
                        
                    </div>
                </div>
                <!-- End Descreption Field -->
                 <!-- Start Status Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-10 control-label">Category</label>
						<div class="col-sm-10 col-md-6">
							<select class="form-select form-select-lg mb-6" name="category" required ="required">
								
								<?php
                                $stmt2=$con->prepare ("SELECT * FROM categories");
                                $stmt2->execute();
                                $cats = $stmt2->fetchAll();
                                foreach($cats as $cat){
                                    
                                    echo "<option value='" . $cat['catID'] . "'>" . $cat['name'] . "</option>";
                                
								
                                }
									
                                 ?>
							</select>
						</div>
					</div>
					<!-- End Status Field -->
                <!-- Start Status Field -->
					<div class="form-group form-group-lg">
						<label class="col-sm-10 control-label">Member</label>
						<div class="col-sm-10 col-md-6">
							<select class="form-select form-select-lg mb-6" name="member" required ="required" >
								
								<?php
                                $stmt=$con->prepare ("SELECT * FROM users");
                                $stmt->execute();
                                $users = $stmt->fetchAll();
                                foreach($users as $user){
                                    
                                    echo "<option value='" . $user['UID'] . "'>" . $user['username'] . "</option>";
                                
								
                                }
									
                                 ?>
							</select>
						</div>
					</div>
					<!-- End Status Field -->
        

               
                <!-- Start Save Button -->
                 
                    <div class=" text-center col-sm-offset-4 col-sm-12 ">
                        <input type="Submit" name="value" class="btn btn-success">
                    </div>
                
                <!-- End Save Button -->


     </div>
     </div>
     </div>
     </form>
        </div>
     </section>


			<?php


		} elseif ($do == 'Insert') {
             if($_SERVER['REQUEST_METHOD']=='POST'){
                    echo "<h1 class ='text-center'> Insert Items </h1>";
                    echo "<div class = 'container'>";
                    // Get variable from the form
                    $name = $_POST['name'];
                    $model = $_POST['model'];
                    $desc = $_POST['descreption'];
                    $price = $_POST['price'];
                    $categ = $_POST['category'];
                    $member = $_POST['member'];
                   // $hashPass = sha1( $_POST['Password']);
                

                    //validate the form
                    $formErrors = array();
                    if (strlen($name)<2){
                        $formErrors[] = 'name cant be less than </strong>2 Characters</strong>';
                    }

                    if (empty($name)){
                        $formErrors[]= 'Name cannot be Empty ';
                        
                    }
                    if (empty($model)){
                        $formErrors[]= 'model cannot be Empty ';
                    }
                    if (empty($desc)){
                        $formErrors[]= 'Descreption cannot be Empty ';
                    }
                    if (empty($price)){
                        $formErrors[] = 'Price cannot be Empty ';
                    }
                    if (empty($categ)){
                      $formErrors[] = 'Category cannot be Empty';
                    }
                   if (empty($member)){
                      $formErrors[] = 'Member cannot be Empty';
                    }
                    
                    //loop into error array
                    foreach($formErrors as $error){
                        $errorMsg= '<div class="alert alert-danger">' . $error . '</div>' ;
                        redirectHome($errorMsg,4, 'items.php?do=Add');
                    }

                    // check if there are no error
                    if (empty($formErrors)){

                        //check if user info exist in database


                                    $stmt = $con-> prepare ("INSERT INTO items(name, Model, Descreption, price, CAT_ID, mem_ID)
                                    VALUES(:zname, :zmodel, :zdesc, :zprice, :zcat, :zmem) ");
                                    $stmt->execute(array(

                                        'zname' 	=> $name,
                                        'zmodel'    => $model,
                                        'zdesc' 	=> $desc,
                                        'zprice' 	=> $price,
                                        'zcat'  	=> $categ,
                                        'zmem'      => $member,
                                        

                                    ));

                            
                                //echo success message

                                 $theMsg =  '<div class="alert alert-success">' .  $stmt -> rowCount() . ' Record Inserted</div>';
                                 redirectHome($theMsg,2,'items.php');
                                
                            }


                }else{
                    $errorMsg =  '<div class ="alert alert-danger"> Sorry, You cant bitemse this page directly </div>';
                    redirectHome($errorMsg, 2, 'items.php' );
                }
                echo "</div>";


        
 


		} elseif ($do == 'Edit') { 
        //Start Edit Page 

        //check if get rqst itemid is numeric & get the in value of it

        $iID = isset($_GET ['iID']) && is_numeric ($_GET['iID'])? intval ($_GET['iID']) : 0;

        //select all data depend on this id
         $stmt = $con-> prepare("SELECT * FROM items WHERE iID = ?");

        //Execute query
          $stmt ->execute(array ($iID));

        // fetch the data
	    $item = $stmt -> fetch();

        //the row count
        $count = $stmt -> rowCount();

        // if there's such ID ===> Show the form
        if ($stmt -> rowCount() >0){ ?>
            <h1 class ="text-center">Edit Item </h1>
        

            <section class="h-100">
            <div class="container h-100">
                <form class="form-horizontal" action="?do=Update" method="POST">
                <input type="hidden" name="iID" value="<?php echo $iID ?>">
                <div class="row justify-content-sm-center h-100">
                    <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                        <div class="card shadow-lg">
                            <div class="card-body p-5">        
                    <!-- Start name Field -->
                    <div class="form-group">
                        <label class="col-sm-10 control-label" >Name</label>
                        <div class=" col-sm-12s ">
                            <input type="text" name="name" class="form-control"  required ="required" value="<?php echo $item['name'] ?>">
                        </div>
                    </div>
                    <!-- End name Field -->
                    <!-- Start name Field -->
                    <div class="form-group">
                        <label class="col-sm-10 control-label" >Model</label>
                        <div class=" col-sm-12s ">
                            <input type="text" name="model" class="form-control"  required ="required"  value="<?php echo $item['Model'] ?>">
                        </div>
                    </div>
                    <!-- End name Field -->

                    <!-- Start Descreption Field -->
                    <div class="form-group">
                        <label class="col-sm-10 control-label" >Descreption </label>
                        <div class=" col-sm-12">
                        
                    <textarea class="form-control" name="descreption" rows="3" required ="required"  value="<?php echo $item['Descreption']; ?>"> </textarea>
                            
                        </div>
                    </div>
                    <!-- End Descreption Field -->
                    <!-- Start Descreption Field -->
                    <div class="form-group">
                        <label class="col-sm-10 control-label" >Price</label> 
                        <div class=" col-sm-8">
                            
                            <input type="text" name="price" class="form-control" required ="required"  value="<?php echo $item['price'] ?> ">
                            
                        </div>
                    </div>
                    <!-- End Descreption Field -->
                    <!-- Start Status Field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-10 control-label">Category</label>
                            <div class="col-sm-10 col-md-6">
                                <select class="form-select form-select-lg mb-6" name="category" required ="required">
                                    
                                    <?php
                                    $stmt2=$con->prepare ("SELECT * FROM categories");
                                    $stmt2->execute();
                                    $cats = $stmt2->fetchAll();
                                    foreach($cats as $cat){
                                        
                                        echo "<option value='" . $cat['catID'] . "'";
                                        if($item['CAT_ID']==$cat['catID']){echo'selected';}
                                        echo ">" . $cat['name'] . "</option>";
                                    
                                    
                                    }
                                        
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Status Field -->
                    <!-- Start Status Field -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-10 control-label">Member</label>
                            <div class="col-sm-10 col-md-6">
                                <select class="form-select form-select-lg mb-6" name="member" required ="required" >
                                    
                                    <?php
                                    $stmt=$con->prepare ("SELECT * FROM users");
                                    $stmt->execute();
                                    $users = $stmt->fetchAll();
                                    foreach($users as $user){
                                        
                                        echo "<option value='" . $user['UID'] . "'";
                                        if($item['mem_ID']==$user['UID']){echo'selected';}
                                        echo ">". $user['FullName']. "</option>";
                                         
                                    
                                    
                                    }
                                        
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Status Field -->
            

                
                    <!-- Start Save Button -->
                    
                        <div class=" text-center col-sm-offset-4 col-sm-12 ">
                            <input type="Submit" name="value" class="btn btn-success">
                        </div>
                    
                    <!-- End Save Button -->


        </div>
        </div>
        </div>
        </form>
            </div>
        </section>


                <?php } 
                // error message
                                  else{
                   $errorMsg = ' <div class="alert alert-danger"> Error! there are no ID! </div>';
                   redirectHome($errorMsg, 2, 'members.php');
                     } 


		} elseif ($do == 'Update') { //update page
                if($_SERVER['REQUEST_METHOD']=='POST'){
                     echo "<h1 class ='text-center'> Update Item </h1>";
                     echo "<div class = 'container'>";
                    // Get variable from the form
                    $id = $_POST['iID'];
                    $name = $_POST['name'];
                    $model = $_POST['model'];
                    $descreption = $_POST['descreption'];
                    $price = $_POST['price'];
                    $category = $_POST['category'];
                    $member = $_POST['member'];


                    //validate the form
                    $formErrors = array();
                    if (strlen($name)<2){
                        $formErrors[] = '<div class="alert alert-danger">Name cant be less than </strong>2 Characters</strong></div>';
                    }
                    if (strlen($name)>20){
                        $formErrors[] = '<div class="alert alert-danger">Name cant be more than </strong> 20 Characters</strong></div>';
                    }
                    if (empty($model)){
                        $formErrors[]= '<div class="alert alert-danger">Model cannot be Empty </div>';
                    }
                    if (empty($descreption)){
                        $formErrors[] = '<div class="alert alert-danger">Description cannot be Empty </div>';
                    }
                     if (empty($price)){
                        $formErrors[] = '<div class="alert alert-danger">Price cannot be Empty </div>';
                    }
                       if (empty($category)){
                        $formErrors[] = '<div class="alert alert-danger">Category cannot be Empty </div>';
                    }
                        if (empty($member)){
                        $formErrors[] = '<div class="alert alert-danger">Member cannot be Empty </div>';
                    }
                    
                    //loop into error array
                    foreach($formErrors as $error){
                        redirectHome($error,2, 'items.php'); ;

                    }

                    // check if there are no error
                    if (empty($formErrors)){

                    //Update the database

                   $stmt = $con -> prepare("UPDATE items SET name=?, Model = ?, Descreption = ?, price =?, CAT_ID=?, mem_ID=?   WHERE  iID = ? ");
                   $stmt -> execute (array($name, $model, $descreption, $price, $category, $member, $id));

                    //echo success message

                    $theMsj= '<div class="alert alert-success">' .  $stmt -> rowCount() . ' Item Updated</div>';
                    redirectHome($theMsj, 2, 'items.php');
                    }


                }else{
                    $errorMsg = '<div class="alert alert-danger"> Sorry, You cant browse this page directly </div>';
                    redirectHome($errorMsg, 2, 'dashboard.php');
                }
                echo "</div>";



		} elseif ($do == 'Delete') {  //Start Delete Page
                echo "<h1 class='text-center'>Delete Item</h1>";
                echo "<div class='container'>";
                

                //check if get rqst userid is numeric & get the in value of it

                $iID = isset($_GET ['iID']) && is_numeric ($_GET['iID'])? intval ($_GET['iID']) : 0;

                //select all data depend on this id
                $stmt = $con-> prepare("SELECT * FROM items WHERE iID = ?");

                //Execute query
                $stmt ->execute(array ($iID));

                //the row count
                $count = $stmt -> rowCount();

                // if there's such ID ===> Show the form
                if ($stmt -> rowCount() >0){
                $stmt = $con->prepare("DELETE FROM items WHERE iID = :zid");
                $stmt->bindParam(":zid", $iID);
                $stmt->execute();
                $theMsg =  '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Deleted</div>';
                redirectHome($theMsg, 2, 'items.php');
                }
                    



		} elseif ($do == 'Approve') {


		}

		include $tpl . 'footer.php';

	} else {

		header('Location: index.php');

		exit();
	}

	ob_end_flush(); // Release The Output

?>