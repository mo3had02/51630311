<?php 
session_start();
$pageTitle = 'Members';
if (isset ($_SESSION ['username'])){
    $pageTitle = 'Members';
    include 'init.php';
            // Condition ['']? True : False
     $do = isset ($_GET ['do'])? $_GET ['do'] : 'Manage';

     if ($do == 'Manage'){//Start manage page 
        $query ='';
     

			if (isset($_GET['page']) && $_GET['page'] == 'Pending') {

				$query = 'AND RegStatus = 0';

			}

			// Select All Users Except Admin 

			$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER BY UID DESC");

			// Execute The Statement

			$stmt->execute();

			// Assign To Variable 

			$rows = $stmt->fetchAll();
     ?>
        <h1 class="text-center">Manage Members</h1>
			<div class="container">
				<div class="table-responsive">
					<table class="main-table manage-members text-center table table-striped table-bordered">
						<tr >
							<td>#ID</td>
							<td>Username</td>
							<td>Email</td>
							<td>Full Name</td>
                            <td>Address</td>
                            <td>Registered Date</td> 
							<td>Control</td>
						</tr>
                        		<?php
							foreach($rows as $row) {
								echo "<tr>";
									echo "<td>" . $row['UID'] . "</td>";
                                    echo "<td>" . $row['username'] . "</td>";
									echo "<td>" . $row['Email'] . "</td>";
									echo "<td>" . $row['FullName'] . "</td>";
                                    echo "<td>" . $row['Address'] . "</td>";
									echo "<td>" . $row['Date'] . "</td>";
									echo "<td>
										<a href='members.php?do=Edit&UID=" . $row['UID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
										<a href='members.php?do=Delete&UID=" . $row['UID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
										if ($row['RegStatus'] == 0) {
											echo "<a 
													href='members.php?do=Activate&UID=" . $row['UID'] . "' 
													class='btn btn-info activate'>
													<i class='fa fa-check'></i> Active</a>";
										}
									echo "</td>";
								echo "</tr>";
							}
						?>
                        
                    </table>
                    <a href="members.php?do=add" class="btn btn-primary">
					<i class="fa fa-plus"></i> New Member
				</a>




        
        
    <?php   } elseif( $do== 'add'){
            //start add members
            ?>
       <h1 class ="text-center"> Add Member </h1>
        

         <section class="h-100">
		<div class="container h-100">
            <form class="form-horizontal" action="?do=Insert" method="POST">
            
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="card shadow-lg">
						<div class="card-body p-5">        
                <!-- Start Username Field -->
                <div class="form-group">
                    <label class="col-sm-10 control-label" > Username</label>
                    <div class=" col-sm-12s ">
                        <input type="text" name="Username" class="form-control" autocomplete="off" required ="required">
                    </div>
                </div>
                <!-- End Username Field -->

                <!-- Start Password Field -->
                 <div class="form-group">
                    <label class="col-sm-10 control-label" > Password</label>
                    <div class=" col-sm-12">
                        
                        <input type="password" name="Password" class=" password form-control" autocomplete="newpassword" required ="required">
                        <i class="show-pass fa fa-eye "></i>
                    </div>
                </div>
                <!-- End Password Field -->

                <!-- Start  Field -->
                 <div class="form-group">
                    <label class="col-sm-10 control-label" > E-mail</label>
                    <div class=" col-sm-12 ">
                        <input type="email" name="Email" class="form-control" required ="required" >
                    </div>
                </div>
                <!-- End E-mail -->

                <!-- Start Full name Field -->
                 <div class="form-group">
                    <label class="col-sm-10 control-label" > Full Name </label>
                    <div class=" col-sm-12 ">
                        <input type="text" name="FullName" class="form-control"  required ="required" >
                    </div>
                </div>
                <!-- End Full name Field -->
                <!-- Start Full name Field -->
                 <div class="form-group">
                    <label class="col-sm-10 control-label" > Address </label>
                    <div class=" col-sm-12 ">
                        <textarea class="form-control" name="address" required ="required" ></textarea>
                    </div>
                </div>
                <!-- End Full name Field -->
                <br>
                <!-- Start Save Button -->
                 
                    <div class=" text-center col-sm-offset-4 col-sm-12 ">
                        <input type="submit" name="value" class="btn btn-success">
                    </div>
                
                <!-- End Save Button -->


     </div>
     </div>
     </div>
     </form>
        </div>
     </section>
        
     <?php

        } elseif($do== 'Insert') {

        //Start insert Page
         
                
                if($_SERVER['REQUEST_METHOD']=='POST'){
                    echo "<h1 class ='text-center'> ADD Member </h1>";
                    echo "<div class = 'container'>";
                    // Get variable from the form
                    $user = $_POST['Username'];
                    $pass = $_POST['Password'];
                    $email = $_POST['Email'];
                    $name = $_POST['FullName'];
                    $address = $_POST['address'];
                    $hashPass = sha1( $_POST['Password']);
                

                    //validate the form
                    $formErrors = array();
                    if (strlen($user)<6){
                        $formErrors[] = 'Username cant be less than </strong>6 Characters</strong>';
                    }
                    if (strlen($user)>20){
                        $formErrors[] = 'Username cant be more than </strong> 20 Characters</strong>';
                    }
                    if (empty($user)){
                        $formErrors[]= 'Username cannot be Empty ';
                    }
                    if (empty($pass)){
                        $formErrors[]= 'Password cannot be Empty ';
                    }
                    if (empty($email)){
                        $formErrors[] = 'Email cannot be Empty ';
                    }
                     if (empty($name)){
                        $formErrors[] = 'Full Name cannot be Empty';
                    }
                    if (empty($address)){
                        $formErrors[] = 'Address cannot be Empty';
                    }
                    
                    //loop into error array
                    foreach($formErrors as $error){
                        $errorMsg= '<div class="alert alert-danger">' . $error . '</div>' ;
                        redirectHome($errorMsg,4, 'http://localhost/megaplus/admin/members.php?do=add');
                    }

                    // check if there are no error
                    if (empty($formErrors)){

                        //check if user info exist in database

                        $check = checkItem("username", "users", $user);
                        $check2 = checkItem("Email", "users", $email);
                        if ($check == 1 || $check2 == 1){
                            $errorMsg =  '<div class="alert alert-danger">Sorry! User Exist. </br>
                            check the username or email </div>';
                            redirectHome($errorMsg,4, 'http://localhost/megaplus/admin/members.php?do=add');
                        }else{


                                    $stmt = $con-> prepare ("INSERT INTO users(username, pass, Email, RegStatus, FullName, Date, Address)
                                    VALUES(:zuser, :zpass, :zmail, 1, :zname, now(), :zaddress) ");
                                    $stmt->execute(array(

                                        'zuser' 	=> $user,
                                        'zpass' 	=> $hashPass,
                                        'zmail' 	=> $email,
                                        'zname' 	=> $name,
                                        'zaddress'  => $address,
                                        

                                    ));

                            
                                //echo success message

                                 $theMsg =  '<div class="alert alert-success">' .  $stmt -> rowCount() . ' Record Inserted</div>';
                                 redirectHome($theMsg,2,'members.php');
                                }
                            }


                }else{
                    $errorMsg =  '<div class ="alert alert-danger"> Sorry, You cant browse this page directly </div>';
                    redirectHome($errorMsg, 2 );
                }
                echo "</div>";


        }
        elseif ($do == 'Edit'){ 
        //Start Edit Page 

        //check if get rqst userid is numeric & get the in value of it

        $UID = isset($_GET ['UID']) && is_numeric ($_GET['UID'])? intval ($_GET['UID']) : 0;

        //select all data depend on this id
         $stmt = $con-> prepare("SELECT * FROM users WHERE UID = ? LIMIT 1 ");

        //Execute query
          $stmt ->execute(array ($UID));

        // fetch the data
	    $row = $stmt -> fetch();

        //the row count
        $count = $stmt -> rowCount();

        // if there's such ID ===> Show the form
        if ($stmt -> rowCount() >0){ ?>
       <h1 class ="text-center"> Edit Member </h1>
        

         <section class="h-100">
		<div class="container h-100">
            <form class="form-horizontal" action="?do=Update" method="POST">
                <input type="hidden" name="userid" value="<?php echo $UID ?>">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="card shadow-lg">
						<div class="card-body p-5">        
                <!-- Start Username Field -->
                <div class="form-group">
                    <label class="col-sm-10 control-label" > Username</label>
                    <div class=" col-sm-12s ">
                        <input type="text" name="Username" class="form-control" autocomplete="off"  value ="<?php echo $row ['username'];?>" required ="required">
                    </div>
                </div>
                <!-- End Username Field -->

                <!-- Start Password Field -->
                 <div class="form-group">
                    <label class="col-sm-10 control-label" > Password</label>
                    <div class=" col-sm-12">
                        <input type="hidden" name="oldPassword" value="<?php echo $row ['pass']  ?>">
                        <input type="password" name="newPassword" class="password form-control" autocomplete="newpassword">
                        <i class="show-pass fa fa-eye "></i>
                    </div>
                </div>
                <!-- End Password Field -->

                <!-- Start Password E-mail -->
                 <div class="form-group">
                    <label class="col-sm-10 control-label" > E-mail</label>
                    <div class=" col-sm-12 ">
                        <input type="email" name="Email" class="form-control" value ="<?php echo $row ['Email'];?>" required ="required" >
                    </div>
                </div>
                <!-- End Password E-mail -->

                <!-- Start Full name Field -->
                 <div class="form-group">
                    <label class="col-sm-10 control-label" > Full Name </label>
                    <div class=" col-sm-12 ">
                        <input type="text" name="FullName" class="form-control" value ="<?php echo $row ['FullName'];?>" required ="required" >
                    </div>
                </div>
                <!-- End Full name Field -->
                <br>
                <!-- Start Save Button -->
                 
                    <div class=" text-center col-sm-offset-4 col-sm-12 ">
                        <input type="submit" name="value" class="btn btn-success">
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

             }
             elseif ($do == 'Update'){ //update page
                if($_SERVER['REQUEST_METHOD']=='POST'){
                     echo "<h1 class ='text-center'> Update Member </h1>";
                     echo "<div class = 'container'>";
                    // Get variable from the form
                    $id = $_POST['userid'];
                    $user = $_POST['Username'];
                    $email = $_POST['Email'];
                    $name = $_POST['FullName'];

                   //Password trick
                    if(empty($_POST['newPassword'])){
                        $passw = $_POST['oldPassword'];
                    } else{
                        $passw = sha1( $_POST ['newPassword']);
                    }

                    //validate the form
                    $formErrors = array();
                    if (strlen($user)<6){
                        $formErrors[] = '<div class="alert alert-danger">Username cant be less than </strong>6 Characters</strong></div>';
                    }
                    if (strlen($user)>20){
                        $formErrors[] = '<div class="alert alert-danger">Username cant be more than </strong> 20 Characters</strong></div>';
                    }
                    if (empty($user)){
                        $formErrors[]= '<div class="alert alert-danger">Username cannot be Empty </div>';
                    }
                    if (empty($email)){
                        $formErrors[] = '<div class="alert alert-danger">Email cannot be Empty </div>';
                    }
                     if (empty($name)){
                        $formErrors[] = '<div class="alert alert-danger">Full Name cannot be Empty </div>';
                    }
                    
                    //loop into error array
                    foreach($formErrors as $error){
                        redirectHome($error,2, 'members.php'); ;

                    }

                    // check if there are no error
                    if (empty($formErrors)){

                    //Update the database

                   $stmt = $con -> prepare("UPDATE users SET Username=?, Email = ?, FullName = ?, pass =?   WHERE  UID = ? ");
                   $stmt -> execute (array($user, $email, $name, $passw, $id));

                    //echo success message

                    $theMsj= '<div class="alert alert-success">' .  $stmt -> rowCount() . ' Record Updated</div>';
                    redirectHome($theMsj, 2, 'members.php');
                    }


                }else{
                    $errorMsg = '<div class="alert alert-danger"> Sorry, You cant browse this page directly </div>';
                    redirectHome($errorMsg, 2);
                }
                echo "</div>";


             } elseif ($do == 'Delete') {         //Start Delete Page
                echo "<h1 class='text-center'>Delete Member</h1>";
                echo "<div class='container'>";
                

                //check if get rqst userid is numeric & get the in value of it

                $UID = isset($_GET ['UID']) && is_numeric ($_GET['UID'])? intval ($_GET['UID']) : 0;

                //select all data depend on this id
                $stmt = $con-> prepare("SELECT * FROM users WHERE UID = ? LIMIT 1 ");

                //Execute query
                $stmt ->execute(array ($UID));

                //the row count
                $count = $stmt -> rowCount();

                // if there's such ID ===> Show the form
                if ($stmt -> rowCount() >0){
                $stmt = $con->prepare("DELETE FROM users WHERE UID = :zuser");
                $stmt->bindParam(":zuser", $UID);
                $stmt->execute();
                $theMsg =  '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Deleted</div>';
                redirectHome($theMsg, 2, 'members.php');
                
                    

                } else {
                    $errorMsg ='id not exist';
                    redirectHome($errorMsg, 2, 'members.php');
                }
                echo '</div>';
            } elseif($do== 'Activate'){
                echo "<h1 class='text-center'>Activate Member</h1>";
			echo "<div class='container'>";

				// Check If Get Request userid Is Numeric & Get The Integer Value Of It

				$userid = isset($_GET['UID']) && is_numeric($_GET['UID']) ? intval($_GET['UID']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('UID', 'users', $userid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UID = ?");

					$stmt->execute(array($userid));

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';

					redirectHome($theMsg);

				} else {

					$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';

					redirectHome($theMsg);

				}

			echo '</div>';


            }

            include $tpl . 'footer.php';

        

            
        } else {
    header ('location: index.php');
    exit();

}

