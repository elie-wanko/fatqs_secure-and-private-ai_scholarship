<?php
function sort_lessons($lessons){
    $sorted_lessons = [];
    foreach($lessons as $lesson) {
        $pos = strrpos($lesson->name, ":");
        $index = substr($lesson->name, $pos-1, 1);
        $sorted_lessons[$index] = [$lesson->id, $lesson->name];
    }
    ksort($sorted_lessons);
    return $sorted_lessons;
}
