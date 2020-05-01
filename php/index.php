<?php

try{
	$con = new PDO("mysql:host=192.168.0.5:6033;dbname=test_db","ranjit","dbpass");
	
	if(isset($_POST['signup'])){
		$name = $_POST['name'];
		$email = $_POST['email'];
		$pass = $_POST['pass'];
		$date = $_POST['date'];
		$month = $_POST['month'];
		$year = $_POST['year'];

		$insert = $con->prepare( "INSERT INTO user (name,email,pass,date,month,year) value(:name,:email,:pass,:date,:month,:year) ");
		$insert->bindParam(':name',$name);
		$insert->bindParam(':email',$email);
		$insert->bindParam(':pass',$pass);
		$insert->bindParam(':date',$date);
		$insert->bindParam(':month',$month);
		$insert->bindParam(':year',$year);
		$insert->execute();
	
	}elseif(isset($_POST['signin'])){
                
                $email = $_POST['email'];
		$pass = $_POST['pass'];
		$select = $con->prepare("SELECT * FROM user WHERE email='$email' and pass='$pass'");
		$select->setFetchMode(PDO::FETCH_ASSOC);
		$select->execute();
		$data = $select->fetch();
		if($data['email']!=$email and $data['pass']!=$pass){
			echo "Invalid email or password!!";
		}
		elseif($data['email']==$email and $data['pass']==$pass){
			$_SESSION['email']=$data['email'];
			$_SESSION['name']=$data['name'];

			header("location:profile.php");

		}


	}
}catch(PDOException $e){
	echo "error".$e->getMessage();
}

?>

<div style="width:500px ; float:left ; height:600px;">
<div style="padding:85px;">
<h1>Create Account</h1>
<form method="post">
<input type="text" name="name" placeholder="User Name"><br><br>
<input type="text" name="email" placeholder="example@example.com"><br><br>
<input type="text" name="pass" placeholder="*********"><br><br>
<select name="date">
<option value="DATE">DATE</option>
<option value="01">01</option>
<option value="02">02</option>
<option value="03">03</option>
</select>
<select name="month">
<option value="MONTH">MONTH</option>
<option value="JAN">JAN</option>
<option value="FEB">FEB</option>
<option value="MAR">MAR</option>
</select>
<select name="year">
<option value="YEAR">YEAR</option>
<option value="2020">2020</option>
<option value="2019">2019</option>
<option value="2018">2018</option>
</select>
<br><br>
<input type="submit" name="signup" value="SIGN UP">

</form>
</div>
</div>

<div style="width:500px ; float:right ; height:600px;">
<div style="padding:85px ; padding-right:200px;">

<h1>Log In</h1>
<form method="post">

<input type="text" name="email" placeholder="example@example.com"><br><br>
<input type="text" name="pass" placeholder="*********"><br><br>
<input type="submit" name="signin" value="SIGN IN">

</form>
</div>
</div>

