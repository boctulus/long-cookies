<?php

namespace boctulus\LongCookies\libs;

use boctulus\LongCookies\core\libs\Posts;
use boctulus\LongCookies\core\libs\Logger;
use boctulus\LongCookies\core\libs\Strings;
use boctulus\LongCookies\core\libs\TutorLMS;
use boctulus\LongCookies\core\libs\WCSubscriptions;

class TutorLMSWooSubsAutomation
{
    /*
        Retorna lista de estudiantes "VIP" en lista agregada como
        metabox en cada curso
    */
    static function getVipStudentListFromCourse($course_id){
        $str_emails = Posts::getMeta($course_id, 'students_allowed_to_enroll');

        return Strings::getEmails($str_emails);
    }

    static function hasVipAccess($course_id, $user_email = null){
        // Logger::dd($course_id, "COURSE_ID");

        if (!empty($user_email)){
            $emails = TutorLMSWooSubsAutomation::getVipStudentListFromCourse($course_id);

            return in_array($user_email, $emails);
        }

        if (is_user_logged_in()) {
            // Obtener el correo electrónico del usuario actual
            $user_email = wp_get_current_user()->user_email;

            // Logger::dd($user_email, "USER EMAIL");
            
            $post_status = get_post_status($course_id);

            if ($post_status == 'publish'){
                return true;
            }

            // Obtener la lista de correos VIP del metadato
            $emails = TutorLMSWooSubsAutomation::getVipStudentListFromCourse($course_id);

            // Logger::dd($emails, "EMAILS ADMITIDOS");
            
            // Verificar si la lista de correos VIP no está vacía
            if (empty($emails)) {
                return false;               
            }
            
            return in_array($user_email, $emails);

        } else {
            // Logger::dd("NO ESTA LOGUEADO");
            return false;
        }
    }

    static function run($user_id){
        $s       = new WCSubscriptions();

        $courses = TutorLMS::getCourses();

        if ($s->hasActive($user_id)){
            $enrolled_inv_list = [];

            foreach ($courses as $course){
                $course_id = $course['ID'];

                if (!TutorLMS::isUserEnrolled($user_id, $course_id)){
                    $enrolled_inv_list[] = $course_id;
                }
            }

            foreach ($enrolled_inv_list as $course_id){
                Logger::log("Enrrolando para user_id=$user_id y course_id=$course_id"); // 
                TutorLMS::enrollUser($user_id, $course_id);
            }
        } else {
            $enrolled_list = [];

            foreach ($courses as $course){
                $course_id = $course['ID'];

                if (TutorLMS::isUserEnrolled($user_id, $course_id)){
                    $enrolled_list[] = $course_id;
                }
            }

            foreach ($enrolled_list as $course_id){
                Logger::log("Cancelando (x) enrrolmente para user_id=$user_id y course_id=$course_id"); 
                TutorLMS::cancelEnrollment($user_id, $course_id);
            }
        }
    }


}

