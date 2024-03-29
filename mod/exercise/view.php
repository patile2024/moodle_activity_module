<?php
require('../../config.php');
require_once('./classes/form/exercise_form.php');

global $USER, $PAGE, $DB, $OUTPUT;

$id = required_param('id', PARAM_INT);
[$course, $cm] = get_course_and_cm_from_cmid($id, 'exercise');
$instance = $DB->get_record('exercise', ['id' => $cm->instance], '*', MUST_EXIST);
//
//if ($id = required_param('id', PARAM_INT)) {
//    throw new \moodle_exception('invalidcourseid');
//}

require_login();
$PAGE->set_title(get_string('pluginname', 'exercise'));
$PAGE->set_heading(get_string('pluginname', 'exercise'));
$PAGE->set_context(context_module::instance($id));
$PAGE->set_url('/mod/exercise/view.php', array('id' => $id));
$PAGE->set_pagelayout('incourse');

$PAGE->set_title('Exercise');
$PAGE->set_heading('Creat new material for ' . $instance->title);

echo $OUTPUT->header();
$link = new moodle_url('/mod/exercise/view.php', array('id' => $id));


echo $OUTPUT->continue_button(new moodle_url('/mod/exercise/add_exercise_material.php', array('id' => $id)));

echo $OUTPUT->footer();