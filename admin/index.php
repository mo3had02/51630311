<?php
session_start();
$nonavbar = '';
$pageTitle = 'Login';
if (isset ($_SESSION ['username'])){
    header ('Location: dashboard.php'); // Redirect to dashboard
}

include "init.php";


//check if user coming from http post request 

if($_SERVER['REQUEST_METHOD']== 'POST'){
    $username = $_POST ['username'];
    $password = $_POST ['password'];
    $hashedpass= sha1 ($password);

    //check if the user exist in database
    $stmt = $con-> prepare("SELECT
							UID, username, pass 
							FROM 
								users
						 	WHERE 
								username = ? 
							AND 
								pass = ? 
							AND 
								GroupID = 1 
								LIMIT 1 ");
    $stmt ->execute(array ($username, $hashedpass));
	$row = $stmt -> fetch();
    $count = $stmt -> rowCount();
    
    //if count>0 => database contain record about this username
    if ($count >0){
		
       $_SESSION ['username'] = $username; // Register Session Name
	   $_SESSION ['ID'] = $row	 ['UID'];  // Register Session
        header ('Location: dashboard.php'); // Redirect to dashboard
        exit();         
    }


 

}
?>
<br>
   <section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					<div class="card shadow-lg">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4">Admin Login</h1>
							<form class="login" action="<?php echo $_SERVER ['PHP_SELF']?>" method="POST">
								<div class="mb-3">
									<label class="mb-2 text-muted" for="username">Username</label>
									<input id="username" type="username" class="form-control" name="username" value="" required autofocus autocomplete="off">
									<div class="invalid-feedback">
										Username is invalid
									</div>
								</div>

								<div class="mb-3">
									<div class="mb-2 w-100">
										<label class="text-muted" for="password">Password</label>
									</div>
									<input id="password" type="password" class="form-control" name="password" required autocomplete="off">
								    <div class="invalid-feedback">
								    	Password is required
							    	</div>
								</div class="text-center">
									<button type="submit" class="text-center btn btn-success ms-auto">
										Login
									</button>
								</div>
							</form>
						</div>
				
				</div>
			</div>
		</div>


<?php
include $tpl . 'footer.php';

?>
