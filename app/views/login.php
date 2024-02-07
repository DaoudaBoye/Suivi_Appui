

<!DOCTYPE html>
<html>
<head>
	<title>multi-user role-based-login-system</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<link rel="stylesheet" href="../public/style.css">

	<style>
        body {
            background-image: url('R.jpg'); /* Remplacez 'chemin_vers_votre_image.jpg' par le chemin de votre image */
            background-size: cover;
            background-position: center;
            /* Autres styles pour ajuster l'apparence du fond */
        }

		.border{
			background-color: #fff;
		}
    </style>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   

</head>
<body>
<div class="container d-flex justify-content-center align-items-center"
      style="min-height: 100vh">
	 
      	<form class="border shadow p-3 rounded"
      	      action="http://localhost:81/demande/app/views/check-login.php" 
      	      method="post" 
      	      style="width: 450px;">
      	      <h1 class="text-center p-3">LOGIN</h1>
				<div class="container text-center mt-4">
					<img src="Logo_FIMF.png" alt="Description de l'image" style="max-width: 200px; height: auto;">
				</div>
							<?php if (isset($_GET['error'])) { ?>
      	      <div class="alert alert-danger" role="alert">
				  <?=$_GET['error']?>
			  </div>
			  <?php } ?>
		  <div class="mb-3">
		  <div class="nice-form-group">
		    <label for="username" 
		           class="form-label">User name</label>
		    <input type="text" 
		           class="form-control" 
		           name="username" 
		           id="username">
		  </div>
		  </div> 
		  <div class="nice-form-group">
		  <div class="mb-3">
		    <label for="password" 
		           class="form-label">Password</label>
		    <input type="password" 
		           name="password" 
		           class="form-control" 
		           id="password">
		  </div>
		  </div> 
		  <button type="submit" 
		          class="btn btn-primary">LOGIN</button>
		</form>
      </div> 
	  
</body>
</html>
