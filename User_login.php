<?php
include_once 'config.php';
include_once 'tableconfig.php';
$db_name=DB_NAME;
$response=array();

$postdata = json_decode(file_get_contents("php://input"));
$option = $postdata->option;

$table_name = Table_user;

$conn=mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($conn){
	switch ($option) {
		case 'create':
			$uname = $postdata->name;
			$email = $postdata->email;
			$password = $postdata->pass;
			$sql = "INSERT INTO $db_name.$table_name ('uid','name','email','password','created') VALUES (NULL , '$uname' , '$email' , '$password' , CURRENT_TIMESTAMP )";
			$result = mysqli_query($conn,$sql);
			if($result){
				$response["status"]="success";
				$response["message"]="New user created";			
			}else{
				$response["status"]="error";
				$response["message"]="Failed to create user.query not valid";
			}
			break;

		case 'login':
			$name = $postdata->name;
			$password = $postdata->pass;
			$sql = "SELECT uid,password from $db_name.$table_name WHERE name='$name'";
			$result = mysqli_query($conn,$sql);
			if($result){
				$row = mysqli_fetch_assoc($result);
				if($password == $row['password']){
					$response["status"] = "success";
					$response["uid"] = $row["uid"];
					$response["code"] = 200;
					$response["message"] = "User login successful";
				}else{
					$response["status"] = "error";
					$response["code"] = 150;
					$response["message"] = "User login failed";
				}
			}else{
				$response["status"]="error";
				$response["message"]="Failed to validate user.query not valid";
			}
			break;
		
		default:
			$response["status"] = "error";
			$response["message"] = "invalid request";
			break;
	}

}else{
	$response["status"]="error";
	$response["code"]=404;
	$response["message"]="Unable to connect to the DB";
}
echo json_encode($response);
mysqli_close($conn);

?>