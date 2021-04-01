<?php
// This file is designed by Bryant Baumgartner and Matthew Mukai
// as part of our capstone project for IT undergraduate.
//
// This program may be freely manipulated in any way, but
// original credit should be kept to the original design.

require_once("../../config.php");
$PAGE->set_url('/mod/print/print_course.php', array('id' => $cm->id));
$lines = array();

$cmid = required_param('id', PARAM_INT);
$cm = get_coursemodule_from_id('print', $cmid, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
require_login($course, true, $cm);

//Run SQL on the database to get a list of users
$sql = 'select u.id,firstname,lastname from {user} as u join {user_enrolments} as e on e.userid=u.id join {course} as c on c.id=e.modifierid where c.id=?';
//$sql = 'SELECT * FROM {user}';
$results = $DB->get_records_sql($sql, array($cmid));

foreach($results as $r) {
    array_push($lines, $r->firstname);
}

//Download the file after creating it
$coursename = $course->fullname;

header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=".$coursename.".doc");
echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
echo "<body>";

//Main bulk for the Word file
echo "<center><font size=60>".$coursename."</font></center>";

echo "</body>";
echo "</html>";
