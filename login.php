<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php');
ob_start();
if(!isset($_SESSION['system'])){
	$system = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach($system as $k => $v){
		$_SESSION['system'][$k] = $v;
	}
}
ob_end_flush();
?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $_SESSION['system']['name'] ?></title>
 	

<?php include('./header.php'); ?>
<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>

</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    /*background: #007bff;*/
	}
	main#main{
		width:100%;
		height: calc(100%);
		background: white;
	}

	#login-left::before {
		content: "";
		position: absolute;
		width: 100%;
		height: 100%;
		background-color: rgba(0, 0, 0, 0.6); /* Dark overlay */
		z-index: 1;
	}

	#login-left{
		position: absolute;
		left: 0;
		width: 100%;
		height: 100%;
		background: url(assets/img/bg1.jpg);
	    background-repeat: no-repeat;
	    background-size: cover;
	    z-index: 0;
	}

	#login-right{
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		width: 50%;
		z-index: 2;
		
	}
	
	#login-right .card {
		position: relative;
		top: 0%;
		left: 17%;
		backdrop-filter: blur(1px);
		background: rgba(255, 255, 255, 0.2);
		border-radius: 15px;
		border: 1px solid rgba(255, 255, 255, 0.3);
		padding: 2em;
		box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
		color: gold;
	}

	.head-text{
		color: white;
		font-size: 3em;
		text-align: center;
	}
	button{
		background-color: gold;
	}
</style>

<body>

  <main id="main" class=" bg-light">
  		<div id="login-left" class="bg-dark">
  		</div>

  		<div id="login-right">
  			<div class="w-100">
			<h4 class="head-text"><b><?php echo $_SESSION['system']['name'] ?></b></h4>
			<br>
			<br>
  			<div class="card col-md-8">
  				<div class="card-body">
  					<form id="login-form" >
						<h3 style="text-align: center; "> Admin Login</h3>
  						<div class="form-group">
  							<label for="username" class="control-label">Username</label>
  							<input type="text" id="username" name="username" class="form-control">
  						</div>
  						<div class="form-group">
  							<label for="password" class="control-label">Password</label>
  							<input type="password" id="password" name="password" class="form-control">
  						</div>
  						<center><button class="btn-sm btn-block btn-wave col-md-4 btn-primary">Login</button></center>
  					</form>
  				</div>
  			</div>
  			</div>
  		</div>
  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>
<script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='index.php?page=home';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>	
</html>