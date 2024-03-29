<?php

require_once("$CFG->libdir/formslib.php");
class exercise_form extends moodleform {

    public function definition()
    {
        $mform = $this->_form;
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

        $mform->addElement('hidden', 'exerciseid');
        $mform->setType('exerciseid', PARAM_INT);

        $mform->addElement('header', 'general', get_string('general', 'form'));
        $mform->addElement('text', 'name', get_string('title', 'exercise'), array('size' => '64'));
        $mform->addRule('name', null, 'required', null, 'exercise');
        $maxbytes = get_max_upload_sizes();


        $mform->addElement(
            'filemanager',
            'attachments',
            get_string('file', 'exercise'),
            null,
            [
                'subdirs' => 0,
                'maxbytes' => $maxbytes,
                'areamaxbytes' => 10485760,
                'maxfiles' => 50,
                'accepted_types' => '*',
                'return_types' => FILE_INTERNAL | FILE_EXTERNAL,
            ]
        );



        $this->add_action_buttons();
    }

    public function validation($data, $files) {
        $errors = [];
        if (strlen($data['name']) > 1024) {
            $errors['name'] = get_string('nametoolong', 'exercise');
        }
        return $errors;
    }
}