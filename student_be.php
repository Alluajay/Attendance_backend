<?php
include_once 'config.php';
include_once 'tableconfig.php';
$db_name=DB_NAME;
$response=array();

$postdata = json_decode(file_get_contents("php://input"));
$option = $postdata->option;

$table_name = Table_student;
$table_atten = Table_atten;

$conn=mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
if($conn){
	switch ($option) {
	case 'create':
			$name = $postdata->name;
			$rno = $postdata->rno;
			$year = $postdata->year;
			$dept = $postdata->dept;
			$sql = "INSERT INTO $db_name.$table_name (`sid`, `rno`, `name`, `dept`, `year`, `created`) VALUES (NULL , '$rno' , '$name' , '$dept' , $year , CURRENT_TIMESTAMP)";
			$result = mysqli_query($conn,$sql);
			if($result){
				$response["status"] = "success";
				$response["message"] = "Student created successfully";
			}else{
				$response["status"] = "error";
				$response["message"] = "Error in creating student";
			}
		break;

	case 'login_student':
		$rno = $postdata->rno;
		$sql = "SELECT * FROM $db_name.$table_name WHERE $table_name.rno = '$rno'";
		$result = mysqli_query($conn,$sql);
		if($result){
			if(mysqli_num_rows($result) == 1){
				$row = mysqli_fetch_assoc($result);
				$response["status"] = "success";
				$response["message"] = "Student login success";
				$response["name"] = $row["name"];
				$response["rno"] = $row["rno"];
				$response["dept"] = $row["dept"];
				$response["year"] = $row["year"];
				$response["id"] = $row["sid"];
				$response["code"] = 200;
			}else{
				$response["status"] = "error";
				$response["code"] = 150;
				$response["message"] = "data not found";
			}
		}else{
			$response["status"] = "error";
			$response["message"] = "Error in fetching data";
		}
		break;
	
	case 'get_students':
			$dept = $postdata->dept;
			$year = $postdata->year;
			$sql = "SELECT * FROM $db_name.$table_name WHERE year = $year AND dept = '$dept'";
			$result = mysqli_query($conn,$sql);
			$data = array();
			if($result){
				if(mysqli_num_rows($result)>0){
					while($row = mysqli_fetch_assoc($result)){
						$stud = array();
						$stud['id'] = $row['sid'];
						$stud['rno'] = $row['rno'];
						$stud['name'] = $row['name'];
						$stud['dept'] = $row['dept'];
						$stud['year'] = $row['year'];
						$stud['created'] = $row['created'];
						$data[] = $stud;					
					}
					$response["status"] = "success";
					$response["records"] = $data;
					$response["message"] = "Student data fetched successfully";
				}else{
					$response["status"] = "error";
					$response["message"] = "No records found in the table";
				}
			}else{
				$response["status"] = "error";
				$response["message"] = "Error in fetching data";
			}
		break;
	case 'getdept':
			$dept = $postdata->dept;
			$sql = "SELECT * FROM $db_name.$table_name WHERE dept = '$dept'";
			$result = mysqli_query($conn,$sql);
			$data = array();
			if($result){
				if(mysqli_num_rows($result)>0){
					while($row = mysqli_fetch_assoc($result)){
						$stud = array();
						$stud['id'] = $row['sid'];
						$stud['rno'] = $row['rno'];
						$stud['name'] = $row['name'];
						$stud['dept'] = $row['dept'];
						$stud['year'] = $row['year'];
						$stud['created'] = $row['created'];
						$data[] = $stud;					
					}
					$response["status"] = "sucess";
					$response["records"] = $data;
					$response["message"] = "Student data fetched successfully";
				}else{
					$response["status"] = "error";
					$response["message"] = "No records found in the table";
				}
			}else{
				$response["status"] = "error";
				$response["message"] = "Error in fetching data";
			}
			break;
		case 'getyear':
			$year = $postdata->year;
			$sql = "SELECT * FROM $db_name.$table_name WHERE year = $year";
			$result = mysqli_query($conn,$sql);
			$data = array();
			if($result){
				if(mysqli_num_rows($result)>0){
					while($row = mysqli_fetch_assoc($result)){
						$stud = array();
						$stud['id'] = $row['sid'];
						$stud['rno'] = $row['rno'];
						$stud['name'] = $row['name'];
						$stud['dept'] = $row['dept'];
						$stud['year'] = $row['year'];
						$stud['created'] = $row['created'];
						$data[] = $stud;					
					}
					$response["status"] = "success";
					$response["records"] = $data;
					$response["message"] = "Student data fetched successfully";
				}else{
					$response["status"] = "error";
					$response["message"] = "No records found in the table";
				}
			}else{
				$response["status"] = "error";
				$response["message"] = "Error in fetching data";
			}
			break;

	case 'atten':
		$rno = $postdata->rno;
		$date = $postdata->date;
		$period = $postdata->period;
		$atten = $postdata->atten;
		$sql = "SELECT * FROM $db_name.$table_atten WHERE $table_atten.rno = $rno AND $table_atten.date_ = '$date'";
		$result = mysqli_query($conn,$sql);
		if($result){
			if(mysqli_num_rows($result)!=1){
				$sql1 = "INSERT INTO $db_name.$table_atten (`id`, `rno`, `date_`, `1`, `2`, `3`, `4`, `5`, `6`, `7`) VALUES (NULL,$rno,'$date',0,0,0,0,0,0,0)";
				$result1 = mysqli_query($conn,$sql1);
				if(!$result1){
					$response["error"] = "error";
					$response["message"] = "error in creating new row";
				}
			}
			if($atten == 0){
				$to = "alludajay@gmail.com";
				$subject = "Attendance System";

				$message = "<b>Student with roll no $rno is absent on period:$period date:$date </b><br>";

				$header = "From:p.saranya.abi@gmail.com \r\n";
				$header .= "MIME-Version: 1.0\r\n";
				$header .= "Content-type: text/html\r\n";

				$retval = mail($to,$subject,$message,$header);
				if($retval){
					$response["message"] = "absent mail sent";
				}
			}
			$sql2 = "UPDATE $db_name.$table_atten SET `$period` = '$atten' WHERE $table_atten.rno = $rno AND $table_atten.date_ = '$date'";
			$result2 = mysqli_query($conn,$sql2);
			if($result2){
				$response["status"] = "success";
				$response["message"].= "attendance updated successfully";
			}else{
				$response["error"] = "error";
				$response["message"].= "error in updating data2";
			}
		}else{
			$response["error"] = "error";
			$response["message"] = "error in updating data1";
		}
		break;
	case 'get_net':
		$rno = $postdata->rno;
		$sql = "SELECT * FROM $db_name.$table_atten WHERE $table_atten.rno = $rno";
		$result = mysqli_query($conn,$sql);
		if($result){
			$count = mysqli_num_rows($result);
			if($count>0){
				$atten = 0;
				while ($row = mysqli_fetch_assoc($result)) {
					$att_count = 0;
					for ($i=1; $i < 8; $i++) { 
						if($row["$i"] == 1){
							$att_count++;
						}	
					}					
					$att_count = $att_count/7;
					$atten = $atten + $att_count;
				}
				$percent = $atten/$count;
				$response["status"] = "success";
				$response["message"] = "percentage fetched successfully";
				$response["percent"] = $percent;
			}else{
				$response["error"] = "error";
				$response["message"] = "error no data found";
			}
		}else{
			$response["error"] = "error";
			$response["message"] = "error in fetching data";
		}
		
		break;

	case 'get_atten':
		$rno = $postdata->rno;
		$sql = "SELECT * FROM $table_atten WHERE rno=$rno ORDER BY $table_atten.date_ DESC";
		$result = mysqli_query($conn,$sql);
		if($result){
			$net_val = array();
			if(mysqli_num_rows($result)>0){
				while($row = mysqli_fetch_assoc($result)){
					$values = array();
					$values['1'] = $row['1'];
					$values['2'] = $row['2'];
					$values['3'] = $row['3'];
					$values['4'] = $row['4'];
					$values['5'] = $row['5'];
					$values['6'] = $row['6'];
					$values['7'] = $row['7'];
					$values['date'] = $row['date_'];
					$net_val[] = $values;
				}
				$response["records"] = $net_val;
				$response["status"] = "success";
				$response["message"] = "records successfully created";
			}else{
				$response["error"] = "error";
				$response["message"] = "data unavailable";
			}
		}
		break;
	case 'get_all_atten':
		$sql = "SELECT * FROM $table_atten";
		$result = mysqli_query($conn,$sql);
		if($result){
			$net_val = array();
			if(mysqli_num_rows($result)>0){
				while($row = mysqli_fetch_assoc($result)){
					$values = array();
					$values['1'] = $row['1'];
					$values['2'] = $row['2'];
					$values['3'] = $row['3'];
					$values['4'] = $row['4'];
					$values['5'] = $row['5'];
					$values['6'] = $row['6'];
					$values['7'] = $row['7'];
					$date1 = $row['date_'];
					$net_val[$date1] = $values;
				}
				$response["records"] = $net_val;
				$response["status"] = "success";
				$response["message"] = "records successfully created";
			}else{
				$response["error"] = "error";
				$response["message"] = "data unavailable";
			}
		}
		break;
	case 'getall':
			$sql = "SELECT * FROM $db_name.$table_name";
			$result = mysqli_query($conn,$sql);
			$data = array();
			if($result){
				if(mysqli_num_rows($result)>0){
					while($row = mysqli_fetch_assoc($result)){
						$stud = array();
						$stud['id'] = $row['sid'];
						$stud['rno'] = $row['rno'];
						$stud['name'] = $row['name'];
						$stud['dept'] = $row['dept'];
						$stud['year'] = $row['year'];
						$stud['created'] = $row['created'];
						$data[] = $stud;					
					}
					$response["status"] = "sucess";
					$response["records"] = $data;
					$response["message"] = "Student data fetched successfully";
				}else{
					$response["status"] = "error";
					$response["message"] = "No records found in the table";
				}
			}else{
				$response["status"] = "error";
				$response["message"] = "Error in fetching data";
			}
			break;

	default:
		$response["status"] = "error";
		$response["message"] = "Error in request";
			break;
	}
}else{
	$response["status"] = "error";
	$response["message"] = "Error in connection";
}

echo json_encode($response);
mysqli_close($conn);
?>