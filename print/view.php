<?php
require('../../config.php');
$cmid = required_param('id', PARAM_INT);
$cm = get_coursemodule_from_id('print', $cmid, 0, false, MUST_EXIST);
$course = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
$id = "?id=".$cmid;

require_login($course, true, $cm);
$PAGE->set_url('/mod/print/view.php', array('id' => $cm->id));
$PAGE->set_title('Print Course Module');

echo $OUTPUT->header();

echo '<h1>Print Course Module</h1><br>';
echo '<p1>Download the contents of '.$course->shortname.' into a printable formatted file.<p1><br /><br />';
echo '<form method="post" action="../print/print_course.php'.$id.'">';
echo '<button type="submit">Print '.$COURSE->shortname.'</button>';
echo '</form>';
echo $OUTPUT->footer();
