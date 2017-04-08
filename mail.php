<?php

	
         $subject = "Attendance system";
         
         $message = "<b>Student REG NO </b>: 153";
         $message .= "<br><b>Student name </b>: Shenba B";
         $message .= "<br><b>Dept </b>: M.Sc CS an";
         $message .= "<br><b>This mail is to inform you that the student is absent on 22/03/2017<b>";
         
         $header = "From:Attendance system\r\n";
         $header .= "MIME-Version: 1.0\r\n";
         $header .= "Content-type: text/html\r\n";
         
         $emailid1 = "alludajay@gmail.com";
         $emailid2 = "p.saranya.abi@gmail.com";
         $retval1 = mail($emailid1,$subject,$message,$header);
			$retval2 = mail($emailid2,$subject,$message,$header);
         
         if( $retval1 == true || $retval2 == true) {
            setResponse("success",1,"mail sent successfully..");
         }else {
            setResponse("error",0,"error in sending mail..");
         }



         function setResponse($status,$code,$message){
	$response["status"]=$status;
	$response["code"]=$code;
	$response["message"]=$message;
	echo json_encode($response);
}

function setResponse1($status,$code,$message,$verificationcode){
	$response["status"]=$status;
	$response["code"]=$code;
	$response["verify"]=$verificationcode;
	$response["message"]=$message;
	echo json_encode($response);
}

?>