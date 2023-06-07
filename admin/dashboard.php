<?php
session_start();
if (isset ($_SESSION ['username'])){
    $pageTitle = 'Dashboard';
    include 'init.php';
    //start dashboard 
?>

   <div class="home-stats">
			<div class="container text-center">
				<h1>Dashboard</h1>
				<div class="row">
					<div class="col-md-3">
						<div class="stat st-members">
							<i class="fa fa-users"></i>
							<div class="info">
								Members
								<span><a href="members.php">
									<?php echo countItems('UID', 'users'); ?>
								    </a></span>
							</div>
						</div>
					</div>
                    <div class="col-md-3">
						<div class="stat st-pending">
							<i class="fa-solid fa-pause"></i>
							<div class="info">
								Pending Members
								<span>
								<a href="members.php?do=Manage&page=Pending">
                                    <?php echo checkItem("RegStatus", "users", 0) ?>
                                </a>
								</span>
							</div>
						</div>
					</div>
                    <div class="col-md-3">
						<div class="stat st-items">
							<i class="fa-solid fa-cart-shopping"></i>
							<div class="info">
								Total Items
								<span>
									<a href="members.php">
									<?php echo countItems('iID', 'items'); ?>
								    </a>
								</span>
							</div>
						</div>
					</div>
                    <div class="col-md-3">
						<div class="stat st-comments">
							<i class="fa-solid fa-comment"></i>
							<div class="info">
								Total Comments
								<span>
									254
								</span>
							</div>
						</div>
					</div>
                </div>
            </div>
    </div>  
    <div class="latest">
         <div class="container latest">
          <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
					
					<?php $latesetUser = 4 ?>
                    <div class="panel-heading">
                        <i class="fa fa-users"></i> Latest <?php echo $latesetUser ?> Users
                    </div>
                    <div class="panel-body">
						<ul class="list-unstyled latest-users">
                        <?php 
							$theLatest = getLatest("*", "users", "FullName",$latesetUser);
							foreach($theLatest as $user){
								echo '<li> <a href="members.php">' . $user ['FullName'].  ' </li> </a>';
								echo "<hr>";
							}
						 ?>
						 </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-headingg">
                        <i class="fa fa-tag"></i> Latest Items
                    </div>
                    <div class="panel-body">
                        test
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <?php                
    //end dashboard
    include $tpl . 'footer.php';
    
} else {
    header ('location: index.php');
    exit();

}