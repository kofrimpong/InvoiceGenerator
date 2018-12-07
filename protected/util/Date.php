<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Date
 *
 * @author Rontiki
 */
class Date {

    private $time;

    /**
     * @deprecated since version number
     */
    const PATTERN_TIME = 'H:i:s';

    /**
     * @deprecated since version number
     * YYYY-MM-DD HH:MM:SS
     */
    const PATTERN_DATETIME = 'Y-m-d H:i:s';

    /**
     * @deprecated since version number
     * YYYY-MM-DD
     */
    const PATTERN_DATETIME_SHORT = 'Y-m-d';

    /**
     * 20 JANUARY 2011
     */
    const PATTERN_ENGLISH = 'l, d F, Y';

    /**
     * 20 Jan 2011
     */
    const PATTERN_ENGLISH_SHORT = 'd M, Y';

    /**
     * 
     */
    const PATTERN_ENGLISH_DATETIME = 'd M, Y H:i:s';

    /**
     * YYYY-MM-DD
     */
    const PATTERN_ISO_8601_DATE = 'Y-m-d';
    /**
     * YYYY-MM-DD HH:MM:SS
     */
    const PATTERN_ISO_8601_DATETIME = 'Y-m-d H:i:s';
    
    /**
     * HH:MM:SS
     */
    const PATTERN_ISO_8601_TIME = 'H:i:s';
    
    const PATTERN_YEAR = 'Y';
    /**
     * Args: year,month,day,hours,minutes,seconds If one argument is supplied, it is assumed to be time (or string format). 0 arguments will generate
     * default time
     */
    public function __construct() {
        $num_args = func_num_args();
        if ($num_args > 0) {
            $args = func_get_args();
        }
        if ($num_args > 1) {
            $seconds = $minutes = $hours = $day = $month = $year = 0;
        }
        switch ($num_args) {
            case 6:
                $seconds = $args[5];
            case 5:
                $minutes = $args[4];
            case 4:
                $hours = $args[3];
            case 3:
                $day = $args[2];
            case 2:
                $month = $args[1];
                $year = $args[0];
                $this->time = mktime($hours, $minutes, $seconds, ($month + 1), $day, $year);
                break;
            case 1:
                if (is_int($args[0])) {
                    $this->time = $args[0];
                }
                elseif (is_string($args[0])) {
                    $this->time = strtotime($args[0]);
                }
                break;
            case 0:
                $this->time = mktime();
                break;
        }
    }

    public function instance() {
        return new Date(func_get_args());
    }

    public function formatTime($format) {
        return self::format($this->time, $format);
    }

    /**
     * Format an integer time to string time using the specified format
     * @param integer $time
     * @param string $format
     * @param type $addTime
     * @return string
     */
    public static function format($time, $format, $addTime = false) {
        if ($time) {
            try {
                return $addTime ? @date($format . ' ' . self::PATTERN_TIME, $time) : @date($format, $time);
            }
            catch (Exception $e) {
                return '';
            }
        }
        return '';
    }

    /**
     * Formats a string date using the format supplied
     * @param string $date
     * @param string $format
     * @return string the new string date
     */
    public static function formatDateTime($date, $format) {
        if ($date) {
            try {
                return @date_format(date_create(str_replace(',', '', $date)), $format); //date($format, strtotime($data))
            }
            catch (Exception $e) {
                return '';
            }
        }
        return '';
    }

    public static function getCurrentTime($pattern) {
        return date($pattern, time());
    }

    public static function convertDaysToTime($days) {
        return $days * 24 * 60 * 60;
    }

    public static function convertTimeToDays($timestamp) {
        return (int) ceil($timestamp / 24 * 60 * 60);
    }

    public static function timezones() {
        $regions = DateTimeZone::listIdentifiers();
        $list = array();
        foreach ($regions as $i => $name) {
            $list[$name] = $name;
        }
        return $list;
    }

    public static function datePatterns() {
        $time = time();
        $format = array(
            'd F, Y' => date('d F, Y', $time), // 02 March, 2008
            'd M, Y' => date('d M, Y', $time), // 02 Mar, 2008 
            'd/m/Y' => date('d-m-Y', $time), // 02-03-2008 , d/m/Y will be recognized by strtotime as American version
            'F d, Y' => date('F d, Y', $time), // March 02, 2008
            'M d, Y' => date('M d, Y', $time), // Mar 02, 2008 ,           
            'm/d/Y' => date('m/d/Y', $time), // 03/02/2008 ,
        );
        return $format;
    }

    public static function convertToJavascript($format) {
        return strtr($format, array(
            'F' => 'MM', 'm' => 'mm', 'd' => 'dd', 'Y' => 'yy'
        ));
    }

    /**
     * Takes an RFC-1123 date as its argument and returns a timestamp (in seconds).
     * Eg. 05-01-25, 05-1-5, and 2005-1-05 are all interpreted as January 5, 2005
     * both 24 Sep 1990 and 24 September 1990 will be interpreted correctly.
     */
    public static function parse($date) {
        $t = strtotime($date);
        return $t === false ? '' : $t;
    }

// returns day of month (1-31)
    public function getDate() {
        return (int) date("j", $this->time);
    }

// returns day of week (0=Sunday, 6=Saturday)
    public function getDay() {
        return (int) date("w", $this->time);
    }

// returns 4-digit year
// JS 1.0 defined a getYear() method as well, but it has been deprecated
// in favor of this one because it was not defined or implemented very well
    public function getFullYear() {
        return (int) date("Y", $this->time);
    }

// returns hours field (0-23)
    public function getHours() {
        return (int) date("H", $this->time);
    }

// returns minutes field (0-59)
    public function getMinutes() {
        return (int) date("i", $this->time);
    }

// returns month (0=January, 11=December)
    public function getMonth() {
        $temp = (int) date("n", $this->time);
        return --$temp;
    }

// returns seconds field (0-59)
    public function getSeconds() {
        return (int) date("s", $this->time);
    }

// returns a complete Date as elapsed seconds
// since the Unix epoch (midnight on January 1, 1970, UTC)
// note that this is not actually ECMA-compliant since
// it returns seconds and not milliseconds
    public function getTime() {
        return $this->time;
    }
    
    /**
     * 
     * @param string $datetime
     * @return string
     */
    public static function getAge($datetime){
        $now = new DatTime('now');
        $date = new DateTime($datetime);
        $interval = $now->diff($date);
        return $interval->format("%y years %m months and %d days");
    }

}
