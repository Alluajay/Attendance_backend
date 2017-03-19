<?php
include_once 'config.php';
include_once 'tableconfig.php';
$db_name=DB_NAME;
$response=array();

/*
updating attendance
$date = "6/06/2017";
  		$period = 1;
  		$year = 1;
  		$dept = "IT";
  		$rno = "allu";
 		$filename = "data/$dept/$year/$rno.json";
  		$data = json_decode(file_get_contents($filename),true);
  		if($data==null){
  			$data=array();
  		}
  		if(!isset($data[$date])){
  			$periods=array();
  			for($i = 0;$i < 7;$i++){
  				$periods[$i]=0;
  			}
  		}else{
  			$periods = $data[$date];
  		}
  		$periods[$period-1]=1;
  		$data[$date] = $periods;
  		file_put_contents($filename,json_encode($data));*/



/*$postdata = json_decode(file_get_contents("php://input"));

$dept = "IT";
$year = 1;
$name = "allu";

$filename = "$dept/$year/$name.json";

echo $filename;
//$option = $postdata->option;

$data = array();
$data["1"] = 1;
$data["2"] = 1;
$data["3"] = 1;
$data["4"] = 1;
$data["5"] = 1;
$data["6"] = 1;
$data["7"] = 1;

$response[] = $data;
$response[] = $data;

$directory = "data/$dept/$year";
if (!is_dir($directory)) {
 	// dir doesn't exist, make it
 	mkdir($directory,0777,true);
}
$filename = "$directory/$name.json";
file_put_contents($filename,null);
echo "data stored";
*/
/*$data = json_decode(file_get_contents("data/Stud1.json",true));
foreach ($data as $key => $value) {
	foreach ($value as $key1 => $value1) {
			echo $value1	;
		}	
}
*/
?>