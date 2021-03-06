<?php
include_once 'config.php';
include_once 'tableconfig.php';
$db_name=DB_NAME;
$response=array();

$postdata = json_decode(file_get_contents("php://input"));
$option = $postdata->option;

$table_user = Table_user;
$table_lender = Table_lender;
$table_bene = Table_beneficiary;

$conn=mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($conn){
	switch ($option) {
		
		case 'login':
			$email = $postdata->email;
			$pass = $postdata->pass;
			$sql = "SELECT * FROM $table_user WHERE $table_user.email = '$email' AND $table_user.pass = '$pass'";
			$result = mysqli_query($conn,$sql);
			if($result){
				if(mysqli_num_rows($result) == 1){
					$response["status"] = "success";
					$response["message"] = "login successful";
					$row = mysqli_fetch_assoc(result);
					$response["uid"] = $row["id"];
					$response["name"] = $row["name"];
				}else{
					$response["status"] = "error";
					$response["message"] = "error in authenticating user";
				}
			}else{
				$response["status"] = "error";
				$response["message"] = "error in executing query";
			}
			break;

		case 'lend':
			$uid = $postdata->uid;
			$food = $postdata->food;
			$quan = $postdata->quantity;
			$location = $postdata->location;
			$sql = "INSERT INTO $table_lender(`id` , `uid` , `name` , `quantity` , `locaiton` , `created`) VALUES(NULL, $uid , '$food' , '$quan' , '$locaiton' , CURRENT_TIMESTAMP)";
			$result = mysqli_query($conn , $sql);
			if($result){
				$response["status"] = "success";
				$response["message"] = "data successfully inserted";
			}else{
				$response["status"] = "error";
				$response["message"] = "error in inserting query";
			}
			break;

		case 'bene':
			$uid = $postdata->uid;
			$quantity = $postdata->quantity;
			$sql = "INSERT INTO $table_bene(`id` , `uid` , `quantity` , `created` ) VALUES(NULL , $uid ,$quantity , CURRENT_TIMESTAMP)";
			$result = mysqli_query($conn, $sql);
			if($result){
				$response["status"] = "success";
				$response["message"] = "data successfully inserted";
			}else{
				$response["status"] = "error";
				$response["message"] = "error in inserting query";
			}
			break;
		
		default:
				$response["status"] = "error";
				$response["message"] = "error in url";
			break;
	}
}else{
	$response["status"] = "error";
	$response["message"] = "error in connecting the db";
}

echo json_encode($response);
mysqli_close($conn);

?>