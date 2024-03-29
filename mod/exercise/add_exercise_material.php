<?php
require_once('../../config.php');
require_once('lib.php');
require_once('./classes/form/exercise_form.php');
require_once($CFG->libdir . '/formslib.php');
require_once('./classes/exercise_material.php');

global $PAGE, $OUTPUT, $DB;


$id = optional_param('id', 0,PARAM_INT);
[$course, $cm] = get_course_and_cm_from_cmid($id, 'exercise');
$instance = $DB->get_record('exercise', ['id' => $cm->instance], '*', MUST_EXIST);
$name = optional_param('name', '', PARAM_CLEANHTML);
$context = get_system_context();
$entry = new stdClass();

if (!$id = required_param('id', PARAM_INT)) {
    throw new \moodle_exception('invalidcourseid');
}
$PAGE->set_url('/mod/exercise/add_exercise_material.php', array('id' => $id));
$PAGE->set_title(get_string('pluginname', 'exercise'));
$PAGE->set_heading(get_string('pluginname', 'exercise'));
$PAGE->set_context(context_module::instance($id));

echo $OUTPUT->header();

echo $OUTPUT->heading(get_string('pluginname', 'exercise'), 3);

$params = array('exerciseid' => $instance->id);

$mform = new exercise_form(null, array('id' => $id));
$mform->set_data(array('id' => $id, 'exerciseid' => $instance->id, 'name' => '', 'image' => ''));


$allexercisematerials = $DB->get_records_select("exercise_materials",
    "exerciseid = :exerciseid", $params);

$maxbytes = get_max_upload_sizes();
if ($mform->is_cancelled()) {

} else if ($data = $mform->get_data()) {
    $exercise_material = new exercise_material();

    $file = $mform->get_file_content('image');
    $name = $mform->get_new_filename('image');

    file_save_draft_area_files(
        $data->attachments,
        $context->id,
        'mod_exercise',
        'exercise_attachment',
        $instance->id,
        [
            'subdirs' => 0,
            'maxbytes' => $maxbytes,
            'maxfiles' => 50,
        ]
    );


    $fileuploaded = $DB->get_record_sql("select * from {files} where component = ? and filearea = ? and itemid = ? and filename != '.'", array(
        'mod_exercise', 'exercise_attachment', $instance->id
    ));
    $fullpath = $CFG->wwwroot."/pluginfile.php/$context->id/$fileuploaded->component/$fileuploaded->filearea/$instance->id/$fileuploaded->filename";

    var_dump($fullpath);

    $exercise_material->id = $data->id;
    $exercise_material->exerciseid = $data->exerciseid;
    $exercise_material->name = $data->name;
    $exercise_material->image = $fullpath;

    $insertId = $DB->insert_record('exercise_materials', $exercise_material);
    redirect(new moodle_url('/mod/exercise/add_exercise_material.php', array('id' => $id)));
} else {
    $mform->display();
}


echo '<table class="generaltable"><tbody>';
echo '<tr>
        <th scope="col" class="cell">' . get_string('exerciseid', 'exercise') . '</th>
        <th scope="col" class="cell">' . get_string('name', 'exercise') . '</th>
        <th scope="col" class="cell">' . get_string('file', 'exercise') . '</th>
      </tr>';
if (empty($allexercisematerials)) {
    echo get_string('noexercisematerialfound', 'exercise');
} else {
    foreach ($allexercisematerials as $exercise_material) {
        echo '<tr>
                <td>
                   ' . $exercise_material->exerciseid . '
                </td>
                <td>
                  ' . $exercise_material->name . '
                </td>
                <td>
                    <img src="<?php echo $exercise_material->image; ?>" alt="Ảnh lỗi">
                </td>
              </tr>';
    }
}

echo $OUTPUT->footer();

