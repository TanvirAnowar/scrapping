<?php
/**
 * Created by PhpStorm.
 * User: tanvir
 * Date: 10/25/17
 * Time: 9:55 PM
 */
namespace Scraping;

class Helper
{
    /*
     * Login function
     * Set session variable and return true only for valid password
     * */
    public static function login($password)
    {
        $savedPassword = $validToken = self::getFromJson('password');

        if ($password == $savedPassword) {

            if (session_id() == '')
                session_start();

            $_SESSION['LOGIN_STATUS'] = true;

            return true;
        }
    }

    /*
     * Check Login Status
     * Return true for valid login or else false
     * */
    public static function loginCheck()
    {
        if (session_id() == '')
            session_start();
        return empty($_SESSION['LOGIN_STATUS']) ? false : true;
    }

    /*
     * Logout functionality
     * Destroy session
     * */
    public static function logout()
    {
        if (session_id() == '')
            session_start();
        session_destroy();
    }


    /*
     * CSRF Token Generator to protect cross site scripting
     * Return random generated token
     * */
    public static function csrfTokeGenerator()
    {
        $random = rand(700, 999);
        $csrfToken = md5($random);
        //$validToken = self::getFromJson('CSRF_TOKEN');
       // self::saveToJson('CSRF_VALID_TOKEN', $validToken);
        self::saveToJson('CSRF_TOKEN', $csrfToken);

        return $csrfToken;
    }

    /*
     * Validate CSRF token
     * Return true only for valid CSRF token
     * */
    public static function checkCsrfToken($token)
    {
        $validToken = self::getFromJson('CSRF_TOKEN');

        return $validToken == $token ? true : false;
    }

    /*
     * Save value JSON file with key value pair
     *
     * */
    public static function saveToJson($key, $value)
    {
        $jsonData = self::arrayUpdate($key, $value);


        file_put_contents(getenv('STATUS_JSON'), json_encode($jsonData));
    }

    /*
     * Get value of the key from JSON file
     * Return value of the given key
     * */
    public static function getFromJson($key)
    {
        $jsonData = self::getJsonFeed();

        return empty($jsonData[$key]) ? null : $jsonData[$key];
    }

    /*
     * Get values for JSON file
     * Return all saved values
     * */
    public static function getJsonFeed()
    {
        $jsonData = json_decode(file_get_contents(getenv('STATUS_JSON')), true);
        return $jsonData;
    }

    /*
     * Get value for JSON file
     * Return value of the given key
     * */
    public static function arrayUpdate($arrayKey, $arrayValue)
    {
        $jsonData = self::getJsonFeed();
        if (!empty($jsonData[$arrayKey]))
            unset($jsonData[$arrayKey]);

        $jsonData[$arrayKey] = $arrayValue;
        return $jsonData;
    }

    /*
     * Input validator
     * Return true for the valid URL/Email
     * */
    public static function isValid($data, $type)
    {
        $result = null;
        switch ($type) {
            case 'EMAIL':
                $emailList = self::getArrayFromString($data);
                foreach ($emailList as $email) {
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $result = false;
                        break;
                    } else {
                        $result = true;
                    }
                }

                break;
            case 'URL':
                if (filter_var($data, FILTER_VALIDATE_URL))
                    $result = true;
        }

        return $result;
    }

    /*
     * Generate array from string separated by ","
     * Return array
     * */
    public static function getArrayFromString($listString)
    {
        return explode(",", $listString);
    }
}