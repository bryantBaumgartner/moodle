<?php
// This file is designed by Bryant Baumgartner and Matthew Mukai
// as part of our capstone project for IT undergraduate.
//
// This program may be freely manipulated in any way, but
// original credit should be kept to the original design.

require_once("../../config.php");

$students = array();
$cmid = required_param('id', PARAM_INT);
$cm = get_coursemodule_from_id('print', $cmid, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
require_login($course, true, $cm);
$PAGE->set_url('/mod/print/print_course.php', array('id' => $cm->id));

//Run SQL on the database to get a list of users
$sql = 'select u.id,firstname,lastname from {user} as u join {user_enrolments} as e on e.userid=u.id join {enrol} as r on e.enrolid=r.id join {course} as c on c.id=r.courseid where c.id=?';
$results = $DB->get_records_sql($sql, array($course->id));

foreach($results as $r) {
    array_push($students, $r->lastname.", ".$r->firstname);
}

//Download the file after creating it
$coursename = $course->fullname;

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=".$coursename.".doc");
echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";

//Main bulk for the Word file
echo "<center><p style='font-size:30px'>".$coursename."</p></center><br>";
echo "<p style='font-size:20'><u>Enrolled Students</u></p>";

echo "<ul>";
foreach($students as $s) {
    echo "<li style='font-size:15'>".$s."</li>";
}
echo "</ul>";

echo "</body>";
echo "</html>";
