<?php

	/*
	================================================
	== Category Page
	================================================
	*/

	ob_start(); // Output Buffering Start

	session_start();

	$pageTitle = 'Categories';

	if (isset($_SESSION['username'])) {

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if ($do == 'Manage') {
            $stmt2=$con ->prepare("SELECT * FROM categories");
            $stmt2 -> execute();
            $cats = $stmt2-> fetchAll();?>
            <h1 class="text-center"> Manage Categories</h1>
            <div class="container .categories">
                <div class="panel panel-default">
                    <div class="panel-heading panel-h1">Manage Categories</div>
                    <div class="panel-body bo1">
                        <?php
                        foreach($cats as $cat){
                            echo "<div class='cat'>";
                            echo"</div>";
                            echo "<h3>" . $cat ['name'] . '</h3>';
                            echo "<p>" ; if($cat ['Descreption']== ''){ echo 'No descreption for this category';} else {echo  $cat ['Descreption'];} echo '</p>';
                            if($cat ['Visibility']== 1 ){ echo'<span> Category is: Hidden  | </span>';} else { echo '<span> Category is: Visible  |  </span>';};
                            if($cat ['Allow_comment']== 1 ){ echo'<span> Comment is: Disable   </span>';} else { echo '<span> Comment is: Enable    </span>';};
                            echo "<div class='hidden-buttons'>";
                            echo "<a href='categories.php?do=Edit&catID=" .$cat ['catID']."' class='btn btn-xs btn-primary '><i class='fa fa-edit'></i> Edit </a>";
                            echo "<a href='categories.php?do=Delete&catID=" .$cat ['catID']."'class=' confirm btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete </a>";
                            echo "</div>";
                            echo "<hr>";
                        }
                         ?>
                         
                    </div>
                                                <a href="categories.php?do=Add" class="btn btn-primary">
					<i class="fa fa-plus"></i> New Category
				</a>
                </div>

            </div>
             
            
            
            
            <?php


		} elseif ($do == 'Add') {?>

        <h1 class ="text-center"> Add Category </h1>
        

         <section class="h-100">
		<div class="container h-100">
            <form class="form-horizontal" action="?do=Insert" method="POST">
            
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="card shadow-lg">
						<div class="card-body p-5">        
                <!-- Start name Field -->
                <div class="form-group">
                    <label class="col-sm-10 control-label" > Name</label>
                    <div class=" col-sm-12s ">
                        <input type="text" name="name" class="form-control"  required ="required">
                    </div>
                </div>
                <!-- End name Field -->

                <!-- Start Descreption Field -->
                 <div class="form-group">
                    <label class="col-sm-10 control-label" > Descreption </label>
                    <div class=" col-sm-12">
                        
                        <input type="text" name="descreption" class="form-control">
                        
                    </div>
                </div>
                <!-- End Descreption Field -->
        

                <!-- Start Visibility Field -->
                 <div class="form-group">
                    <label class="col-sm-10 control-label" > Visible </label>
                    <div class=" col-sm-10 col-md-6 ">
                        
                            <input id="vis=yes" type="radio" name="Visibility" Value="0" checked>
                            <label for="vis-yes">yes</label>
                        
                         <div>
                            <input id="vis-no" type="radio" name="Visibility" Value="1" >
                            <label for="vis-no">No</label>
                        </div>
                </div>
                <!-- End Visibility Field -->
                 <!-- Start comment Field -->
                 <div class="form-group">
                    <label class="col-sm-10 control-label" > Allow Commenting </label>
                    <div class=" col-sm-10 col-md-6 ">
                        
                            <input id="com-yes" type="radio" name="Commenting" Value="0" checked>
                            <label for="com-yes">yes</label>
                        
                         <div>
                            <input id="com-no" type="radio" name="Commenting" Value="1" >
                            <label for="com-no">No</label>
                        </div>
                </div>
                <!-- End Visibility Field -->
                

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
		} elseif ($do == 'Insert') {

            //Start insert Page
         
                
                if($_SERVER['REQUEST_METHOD']=='POST'){
                    echo "<h1 class ='text-center'> Insert Category </h1>";
                    echo "<div class = 'container'>";
                    // Get variable from the form
                    $name= $_POST['name'];
                    $desc = $_POST['descreption'];
                    $vis = $_POST['Visibility'];
                    $cmnt = $_POST['Commenting'];

                        //check if category exist in database

                        $check = checkItem("name", "categories", $name);
                        
                        if ($check == 1){
                            $errorMsg =  '<div class="alert alert-danger">Sorry! category Exist. </div>';
                            redirectHome($errorMsg,4, 'categories.php?do=Add');
                        }else{


                                    $stmt = $con-> prepare ("INSERT INTO categories(name, Descreption, Visibility, Allow_comment)
                                    VALUES(:zname, :zdesc, :zvis,:zcmnt) ");
                                    $stmt->execute(array(

                                        'zname' 	=> $name,
                                        'zdesc' 	=> $desc,
                                        'zvis'  	=> $vis,
                                        'zcmnt'     => $cmnt,
                                        

                                    ));

                            
                                //echo success message

                                 $theMsg =  '<div class="alert alert-success">' .  $stmt -> rowCount() . ' Record Inserted</div>';
                                 redirectHome($theMsg,2,'categories.php');
                                }
                            


                }else{
                    $errorMsg =  '<div class ="alert alert-danger"> Sorry, You cant browse this page directly </div>';
                    redirectHome($errorMsg, 2 );
                }
                echo "</div>";



		} elseif ($do == 'Edit') {
                    //Start Edit Page 

        //check if get rqst catid is numeric & get the in value of it

        $catID = isset($_GET ['catID']) && is_numeric ($_GET['catID'])? intval ($_GET['catID']) : 0;

        //select all data depend on this id
         $stmt = $con-> prepare("SELECT * FROM categories WHERE catID = ?");

        //Execute query
          $stmt ->execute(array ($catID));

        // fetch the data
	    $cat = $stmt -> fetch();

        //the row count
        $count = $stmt -> rowCount();

        // if there's such ID ===> Show the form
        if ($count >0){ ?>
         <h1 class ="text-center"> Edit Category </h1>
        

         <section class="h-100">
		<div class="container h-100">
            <form class="form-horizontal" action="?do=Update" method="POST">
                <input type="hidden" name="catID" value="<?php echo $catID ?>">
            
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="card shadow-lg">
						<div class="card-body p-5">        
                <!-- Start name Field -->
                <div class="form-group">
                    <label class="col-sm-10 control-label" > Name</label>
                    <div class=" col-sm-12s ">
                        <input type="text" name="name" class="form-control" autocomplete="off" required ="required" Value="<?php echo $cat ['name']; ?>">
                    </div>
                </div>
                <!-- End name Field -->

                <!-- Start Descreption Field -->
                 <div class="form-group">
                    <label class="col-sm-10 control-label" > Descreption </label>
                    <div class=" col-sm-12">
                        
                        <input type="text" name="descreption" class="form-control" Value="<?php echo $cat ['Descreption']; ?>">
                        
                    </div>
                </div>
                <!-- End Descreption Field -->
            

                <!-- Start Visibility Field -->
                 <div class="form-group">
                    <label class="col-sm-10 control-label" > Visible </label>
                    <div class=" col-sm-10 col-md-6 ">
                        
                            <input id="vis=yes" type="radio" name="Visibility" Value="0" <?php if ($cat ['Visibility']==0){ echo 'checked';}  ?>>
                            <label for="vis-yes">yes</label>
                        
                         <div>
                            <input id="vis-no" type="radio" name="Visibility" Value="1" <?php if ($cat ['Visibility']==1){ echo 'checked';}  ?> >
                            <label for="vis-no">No</label>
                        </div>
                </div>
                <!-- End Visibility Field -->
                 <!-- Start comment Field -->
                 <div class="form-group">
                    <label class="col-sm-10 control-label" > Allow Commenting </label>
                    <div class=" col-sm-10 col-md-6 ">
                        
                            <input id="com-yes" type="radio" name="Commenting" Value="0"  <?php if ($cat ['Allow_comment']==0){ echo 'checked';}  ?> >
                            <label for="com-yes">yes</label>
                        
                         <div>
                            <input id="com-no" type="radio" name="Commenting" Value="1" <?php if ($cat ['Allow_comment']==1){ echo 'checked';}  ?> >
                            <label for="com-no">No</label>
                        </div>
                </div>
                <!-- End Visibility Field -->
                

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
                   redirectHome($errorMsg, 2, 'categories.php');
                     } 

             


		} elseif ($do == 'Update') {
             if($_SERVER['REQUEST_METHOD']=='POST'){
                     echo "<h1 class ='text-center'> Update Category </h1>";
                     echo "<div class = 'container'>";
                    // Get variable from the form
                    $id = $_POST['catID'];
                    $name = $_POST['name'];
                    $descreption = $_POST['descreption'];
                    $visible = $_POST['Visibility'];
                    $comment = $_POST['Commenting'];

                    //Update the database

                   $stmt = $con -> prepare("UPDATE categories SET name=?, Descreption = ?, Visibility = ?, Allow_comment =?   WHERE  catID = ? ");
                   $stmt -> execute (array($name, $descreption, $visible, $comment, $id));

                    //echo success message

                    $theMsj= '<div class="alert alert-success">' .  $stmt -> rowCount() . ' Record Updated</div>';
                    redirectHome($theMsj, 2, 'categories.php');
                   


                }else{
                    $errorMsg = '<div class="alert alert-danger"> Sorry, You cant browse this page directly </div>';
                    redirectHome($errorMsg, 2);
                }
                echo "</div>";


              

		        }elseif ($do == 'Delete') {

			echo "<h1 class='text-center'>Delete Category</h1>";
			echo "<div class='container'>";

				// Check If Get Request Catid Is Numeric & Get The Integer Value Of It

				$catid = isset($_GET['catID']) && is_numeric($_GET['catID']) ? intval($_GET['catID']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('catID', 'categories', $catid);

				// If There's Such ID Show The Form

				if ($check > 0) {

					$stmt = $con->prepare("DELETE FROM categories WHERE catID = :zid");

					$stmt->bindParam(":zid", $catid);

					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

					
					redirectHome($theMsg,2,'categories.php');


				} else {

					$errorMsg ='id not exist';
                    redirectHome($errorMsg, 2, 'categories.php');

				}

			echo '</div>';

		}



		include $tpl . 'footer.php';

	} else {

		header('Location: index.php');

		exit();
	}

	ob_end_flush(); // Release The Output
    
?>