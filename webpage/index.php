<?php
include('connection.php');
session_start();
$message='';
$id=0;
if(isset($_SESSION["user"])){
	$query = "SELECT id FROM users WHERE username = '".$_SESSION["user"]."';";
	$result = mysqli_query($conn, $query);  
	if(mysqli_num_rows($result) > 0 ){
	  $row = mysqli_fetch_assoc($result);
	  $user_id = $row["id"];
	  $id= $user_id;
	}

	$sql = "SELECT * FROM posts";
$result_posts = $conn->query($sql);
}



if(isset($_REQUEST["logout"])){
	if($_REQUEST["logout"]==1){
		session_destroy(); 
		header("location: index.php"); 
		exit();
	}
}

if(isset($_POST["username"])){
	
	$username = $_POST['username'];  
    $password = $_POST['pwd'];  
      
        //to prevent from mysqli injection  
        $username = stripcslashes($username);  
        $password = stripcslashes($password);  
        $username = mysqli_real_escape_string($conn, $username);  
        $password = mysqli_real_escape_string($conn, $password);  
      
        $sql = "select *from users where username = '$username' and password = '$password'";  
        $result = mysqli_query($conn, $sql);  
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  
          
        if($count == 1){   
			session_start();
      	$_SESSION["user"]=$username;
		header("location: index.php");
        }  
        else{  
            $message="<h3 style='color:red'> Login failed. Invalid username or password.</h3>";  
        }     
}

if(isset($_POST["title"])){
	
	$title = $_POST['title'];  
    $body = $_POST['body'];  
	$userId=$id;
	$publishedAt= date('Y-m-d H:i:s');
      
	$sqlfile="INSERT INTO posts (title,body,userId,publishDate) VALUES ('$title','$body','$userId','$publishedAt')";
	if ($conn->query($sqlfile) === TRUE) {
		header("location: index.php");
	}else{ echo "Something wrong!";}  
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>My Personal Page</title>
		<link href="style.css" type="text/css" rel="stylesheet" />
	</head>
	
	<body>

		<?php include('header.php'); ?>
		<!-- Show this part if user is not signed in yet -->
		<?php
		if(!isset($_SESSION["user"])){
			?>
		<div class="twocols">
			<form action="index.php" method="post" class="twocols_col">
			<?php echo $message ?>
				<ul class="form">
					<li>
						<label for="username">Username</label>
						<input type="text" name="username" id="username" />
					</li>
					<li>
						<label for="pwd">Password</label>
						<input type="password" name="pwd" id="pwd" />
					</li>
					<li>
						<label for="remember">Remember Me</label>
						<input type="checkbox" name="remember" id="remember" checked />
					</li>
					<li>
						<input type="submit" value="Submit" /> &nbsp; Not registered? <a href="register.php">Register</a>
					</li>
				</ul>
			</form>
			<div class="twocols_col">
				<h2>About Us</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur libero nostrum consequatur dolor. Nesciunt eos dolorem enim accusantium libero impedit ipsa perspiciatis vel dolore reiciendis ratione quam, non sequi sit! Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio nobis vero ullam quae. Repellendus dolores quis tenetur enim distinctio, optio vero, cupiditate commodi eligendi similique laboriosam maxime corporis quasi labore!</p>
			</div>
		</div>

		<?php
		}else{
		?>
		
		<!-- Show this part after user signed in successfully -->
		<div class="logout_panel"><a href="register.php">My Profile</a>&nbsp;|&nbsp;<a href="index.php?logout=1">Log Out</a></div>
		<h2>New Post</h2>
		<form action="index.php" method="post">
			<ul class="form">
				<li>
					<label for="title">Title</label>
					<input type="text" name="title" id="title" />
				</li>
				<li>
					<label for="body">Body</label>
					<textarea name="body" id="body" cols="30" rows="10"></textarea>
				</li>
				<li>
					<input type="submit" value="Post" />
				</li>
			</ul>
		</form>
		<div class="onecol">
		<?php
if ($result_posts->num_rows > 0) {
	// output data of each row
	while($row = $result_posts->fetch_assoc()) {

		$query = "SELECT username FROM users WHERE id = ".$row["userId"].";";
	$result = mysqli_query($conn, $query);  
	if(mysqli_num_rows($result) > 0 ){
	  $row22 = mysqli_fetch_assoc($result);
	  $userName= $row22["username"];
	}

		?>
<div class="card">
				<h2><?php echo $row["title"] ?></h2>
				<h5><?php echo $userName ?>, <?php echo $row["publishDate"] ?></h5>
				<p>Some text..</p>
				<p><?php echo $row["body"] ?></p>
			</div>

		<?php
	}
  } else {
	echo "<h2>No Posts!</h2>";
  }
		?>
		
			
			
		</div>
		<?php
		}
		?>
	</body>
</html>