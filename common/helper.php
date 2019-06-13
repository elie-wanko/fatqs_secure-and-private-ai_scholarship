<?php
function sort_lessons($lessons){
    $sorted_lessons = [];
    foreach($lessons as $lesson) {
        $pos = strrpos($lesson->title, ":");
        $index = substr($lesson->title, $pos-1, 1);
        $sorted_lessons[$index] = [$lesson->id, $lesson->title];
    }
    ksort($sorted_lessons);
    return $sorted_lessons;
}