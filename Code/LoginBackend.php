<?php
	session_start();//Xekinaei to session stin php 
	
	function alertBox($message) { 
		
		echo "<script>alert('$message');</script>"; 
	} 
	
	
	
	//connect to db	
	include 'debug.php';
	
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		
		$Lusername=$_POST["username"];	
		$Lpassword1=$_POST["password"];	   
		$username= mysqli_real_escape_string($db,$Lusername);//Katalili morfi gia SQL
		$password= mysqli_real_escape_string($db,$Lpassword1);
		
		
		//Get User's id 
		$login = "SELECT UsersId FROM users WHERE Usersusername = '$username' ";
		$login_result = mysqli_query($db,$login);
		$lr = mysqli_fetch_array($login_result);
		$client_id = $lr['UsersId'];//Pairnoyme mono to UserId
		$_SESSION['client_id'] = $client_id;//APothikevoume ston global pinaka session . Etsi oste se kathe session start na lamvanontai ipopsi ta stoixeia toy sigekrimenou xristi
		
		
		//check pass and do the login 
		$query = "SELECT * FROM users WHERE Usersusername ='$username' ";// AND Userspwd='$passwordHash'	
		$result = mysqli_query($db, $query);
		$numRows=mysqli_num_rows($result);//number of rows returned. If a result is returned then the User exists in the Database
		
		
		if ($numRows === 1){
			$row = mysqli_fetch_assoc($result);//fetch a result row as an associative array
			if(password_verify($password,$row['Userspwd'])){//Verify toy apotelesmatos tis formas me auto sti vasi dedomenwn
				$_SESSION['loggedin'] = true;
				$_SESSION['Id'] = $login;			
				$role_result = mysqli_query($db,"SELECT role_id FROM user_roles WHERE user_id = '$client_id'");
				$role = mysqli_fetch_array($role_result);
				if($role['role_id'] == 0){					
					header('location:index.php');
				}
				else{
					header('location:index_admin.php');
				}
			}
			else{
				alertBox("Wrong password. Type the right one");
				echo "Wrong password. Type the right one";
			}
			
			
		}else
		{
			alertBox("No User found. You must Register first dude!!!");
			echo "No User found. You must Register first dude!!!";
		}
	}
?>