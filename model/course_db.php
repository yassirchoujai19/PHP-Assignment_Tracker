<?php

function get_course() {
    global $db;
    $query = 'SELECT * FROM courses ORDER BY courseName';
    $statement = $db->prepare($query);
    $statement->execute();
    $courses = $statement->fetchAll();
    $statement->closeCursor();
    return $courses; 
}

function get_course_name($course_id) {
    if (!$course_id) {
        return "All Courses";
    }

    global $db;
    $query = 'SELECT * FROM courses WHERE courseID = :course_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':course_id', $course_id);
    $statement->execute();
    $course = $statement->fetch(); // fetch a single course
    $statement->closeCursor();

    return $course ? $course['courseName'] : "Unknown Course"; 
}

function delete_course($course_id) {
    global $db;
    $query = 'DELETE FROM courses WHERE courseID = :course_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':course_id', $course_id);
    $statement->execute();
    $statement->closeCursor();
}

function add_course($course_name) {
    global $db;
    $query = 'INSERT INTO courses (courseName) VALUES (:courseName)';
    $statement = $db->prepare($query);
    $statement->bindValue(':courseName', $course_name);
    $statement->execute();
    $statement->closeCursor();
}
