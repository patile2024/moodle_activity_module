<?php

class helper {
    public static function common_table_info(array $obj) {
        global $USER;
        $now = time();
        if (!is_array($obj)) $obj = (array) $obj;
        $obj['usermodified'] = $USER->id;
        $obj['timemodified'] = $now;
        $obj['timecreated'] = $now;
        return $obj;
    }
}