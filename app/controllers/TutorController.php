<?php

namespace boctulus\LongCookies\controllers;

use boctulus\LongCookies\core\libs\DB;
use boctulus\LongCookies\core\libs\Users;
use boctulus\LongCookies\core\libs\TutorLMS;

/*
    Este controlador es para demostrar capacidades de una libreria

    Se limita su uso a usuarios con rol de Adminr por seguridad
*/
class TutorController
{
    function __construct()
    {   
        // Users::restrictAccess();
    }

    function courses(){
        response()->send([
            'courses' => TutorLMS::getCourses()
        ]);
    }

    // Puede evitarse usando el router y apuntando a cada uno de los metodos
    function enrollment()
    {
        switch ($_SERVER['REQUEST_METHOD']){
            case 'GET':
                $this->get_enrollment();
            break;

            case 'POST':
                $this->new_enrollment();
            break;

            case 'DELETE':
                $this->cancel_enrollment();
            break;

            default:
                return 'Not implemented';
        }
    }

    // Get Enrollment status
    function get_enrollment()
    { 
        $student_id = $_GET['student_id'] ?? $_GET['user_id'] ?? null;
        $course_id  = $_GET['course_id']  ?? null;
        
        $posts = TutorLMS::getEnrollments($student_id, $course_id);

        response()->send([
            'enrollments' => $posts
        ]);
    }

    // New Enroll
    function new_enrollment()
    {
        $student_id = $_GET['student_id'] ?? $_GET['user_id'] ?? null;
        $course_id  = $_GET['course_id']  ?? null;

        if (empty($course_id)){
            response()->error([
                "'course_id' is required"
            ]);
        }

        if (empty($student_id)){
            response()->error([
                "'student_id' is required"
            ]);
        }

        TutorLMS::enrollUser($student_id, $course_id);

        response()->send([
            'message' => 'User enrolled'
        ]);
    }

    // Delete Enrollment
    function cancel_enrollment()
    {
        $student_id = $_GET['student_id'] ?? $_GET['user_id'] ?? null;
        $course_id  = $_GET['course_id']  ?? null;

        if (empty($course_id)){
            error(
                "'course_id' is required"
            );
        }

        if (empty($student_id)){
            error(
                "'student_id' is required"
            );
        }

        TutorLMS::cancelEnrollment($student_id, $course_id);

        response()->send([
            'message' => 'Some enrollments were cancelled'
        ]);
    }
}

