<?php

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    //  It must be included from a Moodle page.
}

require_once($CFG->dirroot.'/course/moodleform_mod.php');

class mod_exercise_mod_form extends moodleform_mod {

    /**
     * Define the chat activity settings form
     */
    public function definition() {
        global $CFG;

        $mform = $this->_form;

        $mform->addElement('header', 'general', get_string('general', 'form'));


        $mform->addElement('text', 'title', get_string('title', 'exercise'), array('size' => '64'));
        $mform->addRule('title', null, 'required', null, 'exercise');

        $mform->addElement('text', 'name', get_string('name', 'exercise'), array('size' => '64'));
        $mform->addRule('name', null, 'required', null, 'exercise');



        $this->standard_coursemodule_elements();

        $this->add_action_buttons();
    }
}
