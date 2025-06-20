<?php

require('model/database.php');
require('model/assignment_db.php');
require('model/course_db.php');

$assignment_id = filter_input(INPUT_POST, 'assignment_id', FILTER_VALIDATE_INT);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS); // updated for PHP 8+
$course_name = filter_input(INPUT_POST, 'course_name', FILTER_SANITIZE_SPECIAL_CHARS); // removed extra space

$course_id = filter_input(INPUT_POST, 'course_id', FILTER_VALIDATE_INT);
if (!$course_id) {
    $course_id = filter_input(INPUT_GET, 'course_id', FILTER_VALIDATE_INT);
}

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
if (!$action) {
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
    if (!$action) {
        $action = 'list_assignments';  
    }
}

switch($action) {
    case 'list_assignments':
        $course_name = get_course_name($course_id);
        $courses = get_course(); // match your function name in course_db.php
        $assignment = get_assignment_by_course($course_id);
        include('view/assignment_list.php');
        break;

    // You can add more actions like these:
    case 'add_assignment':
        add_assignment($course_id, $description);
        header("Location: .?course_id=$course_id");
        break;

    case 'delete_assignment':
        delete_assignment($assignment_id);
        header("Location: .?course_id=$course_id");
        break;

    default:
        echo "Unknown action: " . htmlspecialchars($action);
        break;
}
