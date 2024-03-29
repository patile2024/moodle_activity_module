<!--<?php-->
<!--require('../../config.php');-->
<!--require_once('./classes/form/exercise_form.php');-->
<!---->
<!--global $USER, $PAGE, $DB, $OUTPUT;-->
<!---->
<!--$id = required_param('id', PARAM_INT);-->
<!---->
<!--$instance = $DB->get_record('exercise', ['id'=> $id], '*', MUST_EXIST);-->
<!---->
<!--if(!$instance = $DB->get_record('exercise', ['id'=> $id], '*', MUST_EXIST)) {-->
<!--    throw new \moodle_exception('invalidcourseid');-->
<!--}-->
<!---->
<!--//require_login();-->
<!---->
<!--$PAGE->set_url("/mod/exercise/index.php?id=$id");-->
<!---->
<!--// Set page layout.-->
<!--$PAGE->set_pagelayout('incourse');-->
<!---->
<!--$PAGE->set_title('Exercise');-->
<!--$PAGE->set_heading('Creat new material for ' . $instance->title);-->
<!---->
<!--$mform = new exercise_form();-->
<!---->
<!--//echo $instance->title;-->
<!---->
<!--echo $OUTPUT->header();-->
<!---->
<!--if ($mform->is_cancelled()) {-->
<!--    redirect(new $PAGE->set_url("/mod/exercise/index.php?id=$id"));-->
<!--} else if ($data = $mform->get_data()) {-->
<!--    $exercise_material = new exercise_material();-->
<!--    $data = (array) $data;-->
<!--    $exercise_material->id = $USER->id;-->
<!--    $exercise_material->exerciseid = $id;-->
<!--    $exercise_material->name = $data['name'];-->
<!--    $exercise_material->save();-->
<!--    echo $OUTPUT->notification(get_string('submitted', 'exercise'), 'success');-->
<!--    echo $OUTPUT->continue_button(new moodle_url("/mod/exercise/index.php?id=$id"));-->
<!--} else {-->
<!--    $defaultdata = array(-->
<!--        'id' => $USER->id,-->
<!--        'exerciseid' => $id,-->
<!--        'name' => $instance->title,-->
<!--    );-->
<!--    $mform->set_data($defaultdata);-->
<!--    $mform->display();-->
<!--}-->
<!---->
<!--echo $OUTPUT->footer();-->


<?php
require_once('../../config.php');
require_once('lib.php');
require_once($CFG->libdir . '/formslib.php');

class yourmodule_form extends moodleform
{
    // Define the form elements and their properties
    public function definition()
    {
        $mform = $this->_form;

        $mform->addElement('text', 'field1', 'Field 1');
        $mform->setType('field1', PARAM_TEXT);
        $mform->addRule('field1', 'Please enter a value', 'required', null, 'client');

        $mform->addElement('textarea', 'field2', 'Field 2');
        $mform->setType('field2', PARAM_TEXT);
        $mform->addRule('field2', 'Please enter a value', 'required', null, 'client');

        $this->add_action_buttons();
    }

    // Add custom validation if needed
    public function validation($data, $files)
    {
        $errors = parent::validation($data, $files);
        return $errors;
    }
}

$id = required_param('id', PARAM_INT);

$PAGE->set_url('/mod/exercise/index.php', array('id' => $id));
$PAGE->set_title(get_string('pluginname', 'exercise'));
$PAGE->set_heading(get_string('pluginname', 'exercise'));
$PAGE->set_context(context_module::instance($id));

echo $OUTPUT->header();

// Create an instance of your form
$form = new yourmodule_form();

if ($form->is_cancelled()) {
    // Handle form cancellation
} else if ($data = $form->get_data()) {
    // Form submitted, process the data here
    // $data contains the submitted form data
} else {
    // Display the form
    $form->display();
}

echo $OUTPUT->footer();

