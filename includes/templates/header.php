<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/46a1a96604.js" crossorigin="anonymous"></script> 
    <link rel="stylesheet" href="http://localhost/megaplus/admin/Designe/CSS/bootstrap.min.css"/>
    <link rel="stylesheet" href="http://localhost/megaplus/admin/Designe/CSS/backend.css"/>
    
    
    <title><?php getTitle() ?></title>
 
</head>
<body>
    <div class="upper-bar">
        upper bar
    </div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="http://localhost/megaplus/mega_plus.png" alt="mega plus" style="width:280px;height:50px;" >
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" aria-controls="app-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="app-nav">
            <ul class="nav navbar-nav navbar-right">
	      <?php
	      	$allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID", "ASC");
			foreach ($allCats as $cat) {
				echo 
				'<li>
					<a href="categories.php?pageid=' . $cat['ID'] . '">
						' . $cat['Name'] . '
					</a>
				</li>';
            }
            ?>
 
        </div>
    </div>
</nav>

</body>