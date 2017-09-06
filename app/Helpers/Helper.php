<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;
use Illuminate\Database\QueryException;
use App;
use DateTime;

class Helper
{

    /**
     * Method that check if the menu option is active
     * @param type $routeNames
     * @return string
     */
    public static function active_if($routeNames)
    {
        $routeNames = (array)$routeNames;

        foreach ($routeNames as $routeName) {
            if (Route::is($routeName)) {
                return ' class=active';
            }
        }

        return '';
    }

    /**
     * Method that extracts the name of the month from a given date
     * @param Datetime $date
     * @return string
     */
    public static function getMonth($date)
    {
        return $date->format('M');
    }

    /**
     * Method that extracts the year from a given date
     * @param Datetime $date
     * @return string
     */
    public static function getYear($date)
    {
        return $date->format('Y');
    }

    /**
     * @param $avatar
     * @return string
     */
    public static function getAvatarUser($avatar){
        $img = '/uploads/avatars/'.$avatar;
        $default = "/assets/dist/img/default.png";
        return file_exists(public_path($img)) ? asset($img) : asset($default);
    }

    public static function logExceptionSql(QueryException $ex)
    {
        $error = [
            'sql' => $ex->getSql(),
            'bindings' => $ex->getBindings(),
            'message' => $ex->getMessage()
        ];

        \Log::error('QueryException: ' . print_r($error, 1));
    }

    public static function setFormatDate($js = null)
    {
        if (App::isLocale('es')) {
            $format = is_null($js) ? 'd/m/Y' : array('datepicker' => 'dd/mm/yyyy', 'moment' => 'DD/MM/YYYY');
        } else {
            $format = is_null($js) ? 'm/d/Y' : array('datepicker' => 'mm/dd/yyyy', 'moment' => 'MM/DD/YYYY');
        }

        return $format;
    }

    public static function formatDate($date)
    {
        $result = '';
        if(!empty($date)){
            $newDate = new DateTime($date);
            $result = $newDate->format(Helper::setFormatDate() . ' H:i');
        }
        return $result;
    }

    public static function formatDateWithoutHour($date)
    {
        $result = '';
        if (!empty($date)) {
            $newDate = new DateTime($date);
            $result = $newDate->format(Helper::setFormatDate());
        }
        return $result;
    }

    public static function formatHour($date)
    {
        $result = '';
        if (!empty($date)) {
            $newDate = new DateTime($date);
            $result = $newDate->format('H:i');
        }
        return $result;
    }

    public static function getReferer()
    {
        return request()->server('HTTP_REFERER');
    }

    public static function getRecipients($owner = true)
    {
        $to = request()->input('to');
        $recipients = array_map('intval', explode(',', $to));
        if ($owner) {
            array_push($recipients, \Auth::user()->id);
        }
        $recipients = array_filter($recipients);
        return array_unique($recipients);
    }

    public static function getFormatLocale(){
        return self::setFormatDate()." H:i";
    }
}
