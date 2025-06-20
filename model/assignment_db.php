<?php

function get_assignment_by_course($course_id) {
    global $db;

    if ($course_id) {
        $query = 'SELECT A.id, A.description, C.courseName 
                  FROM assignment A 
                  LEFT JOIN courses C ON A.course_ID = C.course_ID 
                  WHERE A.course_ID = :course_id 
                  ORDER BY A.ID';
    } else {
        $query = 'SELECT A.id, A.description, C.courseName 
                  FROM assignment A 
                  LEFT JOIN courses C ON A.course_ID = C.course_ID 
                  ORDER BY C.course_ID';
    }

    $statement = $db->prepare($query);
    
    if ($course_id) {
        $statement->bindValue(':course_id', $course_id);
    }

    $statement->execute();
    $assignment = $statement->fetchAll();
    $statement->closeCursor();

    return $assignment; 
}

function delete_assignment($assignment_id) {
    global $db;
    $query = 'DELETE FROM assignment WHERE id = :assign_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':assign_id', $assignment_id);
    $statement->execute();
    $statement->closeCursor();
}

function add_assignment($course_id, $description) {
    global $db;
    $query = 'INSERT INTO assignment (description, course_ID) VALUES (:descr, :courseID)';
    $statement = $db->prepare($query);
    $statement->bindValue(':descr', $description);
    $statement->bindValue(':courseID', $course_id);
    $statement->execute();
    $statement->closeCursor();
}
