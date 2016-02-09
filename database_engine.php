<?php

//Start session
session_start();

//Open database
include("db/openDbConn.php");

//Retrieve data from form and create variables
$name = Trim(stripslashes($_POST['name']));
$email = Trim(stripslashes($_POST['email']));
$associate = Trim(stripslashes($_POST['s']));
$rating = Trim(stripslashes($_POST['rating']));

if (empty($name) || empty($email) || empty($associate) ) {
    header("Location: error.html");
    exit;
} else {

	//Place into database
	$sql = "INSERT INTO Submissions(Customer, Email, Associate, Rating) VALUES('".$name."', '".$email."','".$associate."', '".$rating."')";

	//Run query and get result back; shouldn't return anything
	$result = mysql_query($sql);

	//Close database
	include("db/closeDbConn.php");

	//////////// START EMAIL ////////////

	require 'PHPMailerAutoload.php';

	$mail = new PHPMailer;

	$mail->isSMTP();										// Set mailer to use SMTP
	$mail->Host = 'smtp.gmail.com';							// Specify main and backup server
	$mail->SMTPAuth = true;									// Enable SMTP authentication
	$mail->Username = '[USERNAME]';							// SMTP username
	$mail->Password = '[PASSWORD]';							// SMTP password
	$mail->SMTPSecure = 'tls';								// Enable encryption, 'ssl' also accepted
	$mail->Port = 587;										//Set the SMTP port number - 587 for authenticated TLS
	$mail->setFrom('[noreply@domain.com]', 'COMPANY NAME');	//Set who the message is to be sent from//Set an alternative reply-to address
	$mail->addAddress('recipient@domain.com', 'John Doe');	// Add a recipient
	$mail->WordWrap = 50;									// Set word wrap to 50 characters
	$mail->isHTML(false);									// Set email format to HTML

	// prepare email body text
	$Body = "";
	$Body .= "Name: ";
	$Body .= $name;
	$Body .= "\n";
	$Body .= "Email: ";
	$Body .= $email;
	$Body .= "\n";
	$Body .= "Customer Service Rep: ";
	$Body .= $associate;
	$Body .= "\n";
	$Body .= "Rating: ";
	$Body .= $rating;
	$Body .= "\n";

	$mail->Subject = 'Customer Review Submission';
	$mail->Body    = $Body;

	//Read an HTML message body from an external file, convert referenced images to embedded,
	//convert HTML into a basic plain-text alternative body

}

//CleanUp function
CleanUp();

//Redirect user to thank you page
if ($mail->send()){
	print "<meta http-equiv=\"refresh\" content=\"0;URL=thanks.html\">";
	exit;
}
else{
	print "<meta http-equiv=\"refresh\" content=\"0;URL=error.html\">";
	exit;
}

//CleanUp function to free up memory
function CleanUp() {
	$name = "";
	$email = "";
	$associate = "";
	$rating = "";
}

?>