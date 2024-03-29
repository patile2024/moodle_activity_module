<?php

class exercise_material {
    public $id;
    public $exerciseid;
    public $name;
    public $image;

    public function save() {
        global $DB;
        $data = array(
            'id' => $this->id,
            'exerciseid' => $this->exerciseid,
            'name' => $this->name,
            'image' => $this->image,
        );
        $DB->insert_record('exercise_materials', $data);
    }
}