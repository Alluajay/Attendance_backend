<?php
include_once 'config.php';
include_once 'tableconfig.php';
$db_name=DB_NAME;
$response=array();

$postdata = json_decode(file_get_contents("php://input"));
$option = $postdata->option;


$table_name = Table_feed;
$conn=mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($conn){
	switch ($option) {
	case 'create':
		$uid = $postdata->uid;
		$title = $postdata->title;
		$feed = $postdata->feed;

		$sql = "INSERT INTO $db_name.$table_name (`id`, `uid`, `title`, `feed`, `created`) VALUES(NULL, '$uid' , '$title', '$feed', CURRENT_TIMESTAMP)";
		$result = mysqli_query($conn,$sql);
		if($result){
			$response["status"] = "success";
			$response["message"] = "feed successfully created";
		}else{
			$response["status"] = "error";
			$response["message"] = "Error in creating new feed";
		}
		break;
	case 'getall':
		$sql = "SELECT * FROM $db_name.$table_name ORDER BY $table_name.id DESC";
		$result = mysqli_query($conn,$sql);
		if($result){
			$data = array();
			if(mysqli_num_rows($result)>0){
				while($row = mysqli_fetch_assoc($result)){
					$value = array();
					$value['id'] = $row['id'];
					$value['uid'] = $row['uid'];
					$value['title'] = $row['title'];
					$value['feed'] = $row['feed'];
					$value['created'] = $row['created'];
					$data[] = $value;
				}
				$response['records'] = $data;
				$response["status"] = "success";
				$response["message"] = "feeds successfully fetched";
			}else{
				$response["status"] = "error";
				$response["message"] = "no feeds found";
			}
		}else{
			$response["status"] = "error";
			$response["message"] = "error in fetching data";
		}
		break;
	default:
			$response["status"] = "error";
			$response["message"] = "url not found";
			break;
	}
}else{
	$response["status"] = "error";
	$response["message"] = "Error in db connection";
}
echo json_encode($response);
mysqli_close($conn);

?>