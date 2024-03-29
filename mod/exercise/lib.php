<?php

defined('MOODLE_INTERNAL') || die();

function exercise_supports($feature) {
    switch ($feature) {
        case FEATURE_MOD_INTRO: return true;
        default: return null;
    }
}

function exercise_add_instance($exercise) {
    global $DB;

    $exercise->timemodified = time();
    $exercise->id = $DB->insert_record('exercise', $exercise);

    return $exercise->id;
}

function exercise_update_instance($exercise) {
    global $DB;

    $exercise->timemodified = time();
    $exercise->id = $exercise->instance;

    $DB->update_record('exercise', $exercise);

    return true;
}

function create_exercise_material($exerciseid, $name, $file) {
    global $DB;
    $exercise_material = new stdClass();
    $exercise_material->exerciseid = $exerciseid;
    $exercise_material->name = $name;
    $exercise_material->image = $file;
    $DB->insert_record('exercise_materials', $exercise_material);
}

function exercise_delete_instance($id) {
    global $DB;

    $DB->delete_records('exercise', array('id' => $id));

    return true;
}

function exercise_user_outline($course, $user, $mod, $exercise) {
    return null; // No user-specific information to display
}

function exercise_user_complete($course, $user, $mod, $exercise) {
    return true; // Completion always true
}

function exercise_get_participation_record($exercise, $userid) {
    return null; // No participation records for this activity
}

function exercise_get_view_actions() {
    return array('view');
}

function exercise_get_post_actions() {
    return array('add', 'update', 'delete');
}
