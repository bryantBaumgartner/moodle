<?php
// This file is designed by Bryant Baumgartner and Matthew Mukai
// as part of our capstone project for IT undergraduate.
//
// This program may be freely manipulated in any way, but
// original credit should be kept to our original design.
	
$servername = 'localhost';
$username   = 'root';
$password   = '';
$dbname     = 'moodle';
$course     = 'CSC642';
$conn       = new mysqli($servername, $username, $password, $dbname);
$lines      = array();

//Get participants in the class
array_push($lines,'Participants In The Course:'."\n");
$sql       = 'select u.id,firstname,lastname from mdl_user as u join mdl_user_enrolments as e on e.userid=u.id join mdl_course as c on c.id=e.modifierid where c.idnumber="'.$course.'";';
$entry     = 'id,firstname,lastname';
$result    = $conn->query($sql);
$DB->get_record("course", array("id"=>$cm->course)
while($row = $result->fetch_assoc())
{
	$line = $row[explode(',',$entry)[0]].' | '.$row[explode(',',$entry)[1]].' '.$row[explode(',',$entry)[2]];
	print("| ".$line.nl2br(" |\n\r",false));
	array_push($lines, "  | ".$line." |\n");
}
print(nl2br("\n\r",false));
array_push($lines,"\n");

//Get assignments in the class
array_push($lines,'Assignments In The Course:'."\n");
$sql       = 'select a.id,a.name,intro from mdl_assign as a join mdl_course as c on a.course=c.id where c.idnumber="'.$course.'";';
$entry     = 'id,name,intro';
$result    = $conn->query($sql);
while($row = $result->fetch_assoc())
{
	$line = $row[explode(',',$entry)[0]].' | '.$row[explode(',',$entry)[1]].' | '.$row[explode(',',$entry)[2]];
	print("| ".$line.nl2br(" |\n\r",false));
	array_push($lines, "  | ".$line." |\n");
}

$conn->close();

file_put_contents('output.txt', $lines);
$file = 'output.txt';
if (file_exists($file)) {
	header('Content-Description: File Transfer');
	header('Content-Disposition: attachment; filename="'.basename($file).'"');
	readfile($file);
	exit;
}

header('location://moodle');