<?php

namespace PhucTran\Core\Libraries;

use Illuminate\Support\Facades\App;

/**
 * Created by PhpStorm.
 * Account: phuctran
 * Date: 23/01/2017
 * Time: 11:11
 */
class Helpers
{
    /**
     * Get value for the object or array with default value
     *
     * @author Binh pham
     *
     * @param object|array $object Object to get value
     * @param string $value key value
     * @param null $defaultValue default value if object's key not exist
     * @param callable $callback function callback
     *
     * @return object|array|string|null value of key in the object
     */
    public static function get($object, $value, $defaultValue = null, $callback = null)
    {
        $value = explode('.', $value);

        $dataReturn = self::getRecursive($object, $value, $defaultValue);

        if (is_callable($callback) && $dataReturn !== null && $dataReturn != '') {
            $callback($dataReturn);
        }

        return $dataReturn;

    }

    /**
     * Get value for the object or array with default value
     *
     * @author Binh pham
     *
     * @param object|array $object Object to get value
     * @param string $value key value
     * @param null $defaultValue default value if object's key not exist
     *
     * @return object|array|string|null value of key in the object
     */
    private static function getRecursive($object, $value, $defaultValue = null)
    {
        if (is_array($value)) {
            $tmpValue = $object;
            for ($i = 0, $len = count($value); $i < $len; $i++) {
                $tmpValue = self::getRecursive($tmpValue, $value[$i], $defaultValue);
            }

            return $tmpValue;
        }
        else {
            if (!isset($object)) {
                return $defaultValue;
            }
            elseif (is_array($object)) {
                return isset($object[$value]) ?
                    $object[$value] : $defaultValue;
            }
            elseif (is_object($object)) {
                return isset($object->$value) ?
                    $object->$value : $defaultValue;
            }
        }
    }

    /**
     * Check string is ASCII
     *
     * @author Phuc Tran
     *
     * @param string $string
     *
     * @return bool
     */
    public static function isAscii($string)
    {
        return mb_check_encoding($string, 'ASCII');
    }

    public static function convertDateToDefaultTimeZone(string $dateTime, \DateTimeZone $timeZone) : \DateTime
    {
        return self::convertDateTimeZone($dateTime, $timeZone, new \DateTimeZone(date_default_timezone_get()));
    }

    public static function convertDateTimeZone(string $dateTime, \DateTimeZone $from, \DateTimeZone $to) : \DateTime
    {
        $date = new \DateTime($dateTime, $from);
        $date->setTimezone($to);

        return $date;
    }

    public static function runningInConsole() : bool
    {
        return App::runningInConsole();
    }

    public static function route($name, $parameters = [], $secure = null) : string
    {
        $url = route($name, $parameters, $secure);
        if (self::runningInConsole()) {
            $domain = env('APP_URL');
            $urlTemp = preg_replace("/http:\/\/:\//", "{$domain}/", $url);
            if (strcmp($urlTemp, $url) == 0) {
                $urlTemp = preg_replace("/https:\/\/:\//", "{$domain}/", $url);
            }
            $url = $urlTemp;
        }

        return $url;
    }

    /**
     * @param $array
     *
     * @return bool
     */
    public static function isConsecutive($array) {
        $array = array_unique($array);
        return ((int)max($array)-(int)min($array) == (count($array)-1));
    }

    public static function getDateTimeNow($time = null, $timeZone = null) {
        if ( !is_null($timeZone) ) date_default_timezone_set($timeZone);
        return is_null($time) ? getdate() : getdate($time);
    }

    public static function logFile ($data, $fileName = 'log_test', $option = []) {
        $timeNow = self::getDateTimeNow(null, env('TIME_ZONE_TEST'));
        $timeDetail = (count($timeNow) > 0) ? '[' .
            $timeNow['mday'] . '/' .
            $timeNow['mon'] . '/' .
            $timeNow['year'] . ' ' .
            $timeNow['hours'] . ':' .
            $timeNow['minutes'] . ':' .
            $timeNow['seconds'] . ']' : date("Y-m-d H:i:s");
        $logName = $fileName . '_' . date("Y-m-d") . '.txt';
        $data = is_string($data) ? $data : json_encode($data);
        file_put_contents(storage_path('logs/' . $logName), $timeDetail . ' : ' . $data . "\n", FILE_APPEND);
    }


    /**
     * Get real IP from client
     *
     * @return string
     */
    public static function getRealClientIP()
    {
        $headers = [
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'HTTP_VIA',
            'HTTP_X_COMING_FROM',
            'HTTP_COMING_FROM',
            'HTTP_CLIENT_IP'
        ];

        foreach ($headers as $header) {
            if (isset ($_SERVER [$header])) {
                //Check server
                if (($pos = strpos($_SERVER [$header], ',')) != false) {
                    $ip = substr($_SERVER [$header], 0, $pos);//True
                }
                else {
                    $ip = $_SERVER [$header]; //False
                }
                $ipnumber = ip2long($ip);
                if ($ipnumber !== -1 && $ipnumber !== false && (long2ip($ipnumber) === $ip)) {
                    if (($ipnumber - 184549375) && // Not in 10.0.0.0/8
                        ($ipnumber - 1407188993) && // Not in 172.16.0.0/12
                        ($ipnumber - 1062666241)
                    ) // Not in 192.168.0.0/16
                        if (($pos = strpos($_SERVER [$header], ',')) != false) {
                            $ip = substr($_SERVER [$header], 0, $pos);
                        }
                        else {
                            $ip = $_SERVER [$header];
                        }
                    return $ip;
                }
            }

        }
        return $_SERVER ['REMOTE_ADDR'];
    }
}