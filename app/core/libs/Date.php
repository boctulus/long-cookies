<?php

/*
    @author  Pablo Bozzolo boctulus@gmail.com
*/

namespace boctulus\LongCookies\core\libs;

use boctulus\LongCookies\core\libs\Strings;
use boctulus\LongCookies\core\libs\Arrays;

/*
    @author Pablo Bozzolo
*/
class Date
{   
    protected static function add(string $date, $diff, $unit, $format = 'Y-m-d'){
        $do = new \DateTime($date);
        $do->add(new \DateInterval("P{$diff}{$unit}"));

        return $do->format($format);
    }

    protected static function sub(string $date, $diff, $unit, $format = 'Y-m-d'){
        $do = new \DateTime($date);
        $do->sub(new \DateInterval("P{$diff}{$unit}"));

        return $do->format($format);
    }
 
    static function format(string $date, string $new_format = 'd-m'){
        $do = new \DateTime($date);
        return $do->format($new_format);
    }

    /*
        Substre dias a una fecha
    */
    static function subDays(string $date, int $diff, $format = 'Y-m-d'){    
        return static::sub($date, $diff, 'D', $format);
    }

    static function addDays(string $date, int $diff, $format = 'Y-m-d'){    
        return static::add($date, $diff, 'D', $format);
    }

    static function addMonths(string $date, int $diff, $format = 'Y-m-d'){    
        return static::add($date, $diff, 'M', $format);
    }

    static function subMonths(string $date, int $diff, $format = 'Y-m-d'){    
        return static::sub($date, $diff, 'M', $format);
    }

    static function randomTime(bool $include_seconds = false){
        $time = str_pad((string) mt_rand(0,23), 2, "0", STR_PAD_LEFT).  ":" . str_pad((string) mt_rand(0,59), 2, "0", STR_PAD_LEFT);

        if ($include_seconds){
            $time .= ':' . str_pad((string) mt_rand(0,59), 2, "0", STR_PAD_LEFT);
        }

        return $time;
    }

    static function datetime(string $format = 'Y-m-d H:i:s', $timezone = null){
        if ($timezone === null){    
            $timezone = new \DateTimeZone( date_default_timezone_get() );
        } else {
            if (is_string($timezone)){
                $timezone = new \DateTimeZone($timezone);
            }
        }

        $d  = new \DateTime('', $timezone);
        $at = $d->format($format); // ok

        return $at;
    }

    static function date($timezone = null){
        return datetime('Y-m-d', $timezone);
    }

    static function time($timezone = null){
        return datetime('H:i:s', $timezone);
    }

    static function getYear(string $date = '', bool $all_digits = true) : string {
        $do = new \DateTime($date);
        return $all_digits ? $do->format('Y') : $do->format('y');
    }

    static function getMonth(string $date = '', bool $leading_zeros = false) : string {
        $do = new \DateTime($date);
        return $leading_zeros ? $do->format('m') : $do->format('n');
    }

    static function getDay(string $date = '', bool $leading_zeros = false) : string {
        $do = new \DateTime($date);
        return $leading_zeros ? $do->format('d') : $do->format('j');
    }

    static function getDayOfWeek(string $date = '') : string {
        $do = new \DateTime($date);
        return $do->format('w');
    }

    static function isMonday(string $date = '') : bool {
        return static::getDayOfWeek($date) == 1;
    }

    static function isTuesday(string $date = '') : bool {
        return static::getDayOfWeek($date) == 2;
    }
    
    static function isWednesday(string $date = '') : bool {
        return static::getDayOfWeek($date) == 3; // ok
    }
    
    static function isThursday(string $date = '') : bool {
        return static::getDayOfWeek($date) == 4;
    }

    static function isFriday(string $date = '') : bool {
        return static::getDayOfWeek($date) == 5;
    }

    static function isSaturday(string $date = '') : bool {
        return static::getDayOfWeek($date) == 6;
    }

    static function isSunday(string $date = '') : bool {
        return static::getDayOfWeek($date) == 7;
    }

    static function diffInSeconds(string $date2, string $date1 = '') : int {
        $d1 = new \DateTime($date1);
        $d2 = new \DateTime($date2);
    
        return $d2->getTimestamp() - $d1->getTimestamp();
    }
    
    static function nextYearFirstDay(string $date = '', string $format = 'Y-m-d') : string {
        $d = new \DateTime($date);
        $d->modify('first day of next year');   
        return $d->format($format);
    }

    static function nextMonthFirstDay(string $date = '', string $format = 'Y-m-d') : string {
        $d = new \DateTime($date);
        $d->modify('first day of next month');   
        return $d->format($format);
    }

    static function nextMonth(string $date = '', string $format = 'Y-m-d') : string { 
        $d = new \DateTime($date);
        $d->modify('+1 month');   
        return $d->format($format);
    }


    static function nextWeek(string $date = '', string $format = 'Y-m-d') : string {
        $d = new \DateTime($date);
        $d->modify('+1 week');
        return $d->format($format);
    }

    // Next day, same hour
    static function nextDay(string $date = '', string $format = 'Y-m-d') : string {
        $d = new \DateTime($date);
        $d->modify('+1 day');
        return $d->format($format);
    }

    static function nextDays(string $date, int $days = 5, bool $include_start = false, bool $working_days_only = true){
        $dates = [];

        if ($include_start){
            $dates[] = $date;
            $days--;
        }

        for ($i=0; $i<$days; $i++){
            $date = static::nextDay($date);

            if ($working_days_only){
                if (static::isSaturday($date) || static::isSunday($date)){
                    continue;
                }
            }

            $dates[] = $date;
        }

        return $dates;
    }

    /*
        salta sábados y domingos
    */ 
    static function nextWorkingDay(string $date, string $format = 'Y-m-d') : string {
        $d = new \DateTime($date);
        $d->modify('+1 weekday');
        return $d->format($format);
    }

    static function nextHour(string $date = '', string $format = 'Y-m-d') : string {
        $d = new \DateTime($date);
        $d->modify('+1 hour');
        return $d->format($format);
    }

    static function nextNthMonthFirstDay(int $month, string $date = '', string $format = 'Y-m-d') : string {
        $d = new \DateTime($date);
        $y = (int) $d->format('Y');
        $m = (int) $d->format('n');

        /*
            Si es el mismo mes, entrego el del siguiente año
        */
        if ($month <= $m){
            $y++;
            $strdate = "$y-$month-01";
        } else {
            if ($month > $m){
                $strdate = "$y-$month-01";
            }    
        }

        $d = new \DateTime($strdate);       
        return $d->format($format);
    }

    static function nextNthMonthDay(int $day, string $date = '', string $format = 'Y-m-d') : string {
        $_date = new \DateTime($date);
        $d = (int) $_date->format('j');
        $m = (int) $_date->format('n');
        $y = (int) $_date->format('Y');

        if ($day <= $d){
            $m++;
            if ($m>12){
                $m = 1;
            }

            $strdate = "$y-$m-$day";
        } else if ($day > $d){
            $strdate = "$y-$m-$day";
        } 


        $_date = new \DateTime($strdate);       
        return $_date->format($format);
    }

    static function nextNthWeekDay(int $weekday, string $date = '', string $format = 'Y-m-d') : string {
        $d1 = new \DateTime();
        $w1 = (int) $d1->format('w');

        if ($weekday == $w1){
            return $d1->modify('+1 week')->format($format);
        }

        if ($weekday < $w1){
            $diff = 7 - $w1 + $weekday;
            return $d1->modify("+$diff days")->format($format);
        }

        if ($weekday > $w1){
            $diff = $weekday - $w1;
            return $d1->modify("+$diff days")->format($format);
        }
    }

    // https://stackoverflow.com/a/14505065
    static function isValid($date, string $format = 'Y-m-d', $strict = true)
    {
        $dateTime = \DateTime::createFromFormat($format, $date);
        if ($strict) {
            $errors = \DateTime::getLastErrors();
            if (!empty($errors['warning_count'])) {
                return false;
            }
        }
        return $dateTime !== false;
    }
}