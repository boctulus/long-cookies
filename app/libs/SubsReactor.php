<?php

namespace boctulus\LongCookies\libs;

use boctulus\LongCookies\core\libs\Logger;
use boctulus\LongCookies\core\libs\Reactor;
use boctulus\LongCookies\core\libs\TutorLMS;
use boctulus\LongCookies\core\libs\WCSubscriptions;

/**
 * Utilizzando il Reactor, crea o elimina iscrizioni ai corsi in base alla attivazione delle sottoscrizioni per l'utente.
 * 
 * @author Pablo Bozzolo < boctulus@gmail.com >
 * 
 * Elimina:    __onUpdate()
 * Ripristina: __onUpdate()
 * 
 * Note: it works until version 5.1.2 of "WooCommerce Subscriptions" but for newest versions it's not triggered
 * like if the CPT is not used
 */
class SubsReactor extends Reactor
{
    /**
     * Quando viene creato un nuovo elemento.
     * 
     * @param int $pid L'ID dell'elemento creato.
     */
    protected function __when_create($pid)
    {
        Logger::log("ENROLLING ...");

        $s       = new WCSubscriptions();
        
        $user_id = $s->getUserSubscriptor($pid);

        $courses = TutorLMS::getCourses();

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
    }

    /**
     * Quando viene eliminato un elemento.
     * 
     * @param int $pid L'ID dell'elemento eliminato.
     */
    protected function __when_delete($pid)
    {
        Logger::log("CANCELLING ENROLLMENTS ...");

        $s       = new WCSubscriptions();
        
        $user_id = $s->getUserSubscriptor($pid);

        $courses = TutorLMS::getCourses();

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

    /**
     * Quando viene ripristinato un elemento.
     * 
     * @param int $pid L'ID dell'elemento ripristinato.
     */
    protected function __when_restore($pid){
        $s       = new WCSubscriptions();
        $user_id = $s->getUserSubscriptor($pid);

        if ($s->hasActive($user_id)){
            $this->__when_create($pid);
        }
    }

    /*
        Eventos
    */

    /**
     * Evento onCreate.
     * 
     * @param int $pid L'ID dell'elemento creato.
     */
    function __onCreate($pid)
    {
        $this->__when_create($pid);
    }

    /**
     * Evento onUpdate (triggerato anche da CREATE).
     * 
     * @param int $pid L'ID dell'elemento aggiornato.
     */
    function __onUpdate($pid)
    {
        $s       = new WCSubscriptions();
        $user_id = $s->getUserSubscriptor($pid);

        if ($s->hasActive($user_id)){
            $this->__when_create($pid);
        } else {
            $this->__when_delete($pid);
        }
    }

    /**
     * Evento onDelete.
     * 
     * @param int $pid L'ID dell'elemento eliminato.
     */
    function __onDelete($pid)
    {
        $this->__when_delete($pid);
    }

    /**
     * Evento onRestore.
     * 
     * @param int $pid L'ID dell'elemento ripristinato.
     */
    function __onRestore($pid)
    {
        $this->__when_restore($pid);        
    }

}
