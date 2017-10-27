<?php
/**
 * Created by PhpStorm.
 * User: tanvir
 * Date: 10/23/17
 * Time: 11:28 AM
 */

namespace Scraping;


class PageController
{
    /*
     * Handle the Dashboard's functionality
     * Return array of status code and required data for the page
     * */
    public function Dashboard()
    {
        $validation = null;

        $code = 200;

        if (!Helper::loginCheck()) {


            $extra = 'login';

            $this->redirectPage($extra);
        }

        if (!empty($_POST)) {
            $data = $_POST;
            $code = 201;
            $validation = false;

            if(!Helper::isValid($data['url'], 'URL'))
            {
                $validation = true;

            }elseif (!Helper::isValid($data['emails'], 'EMAIL')){

                $validation = true;

            }elseif (!strlen($data['password']) > 0){

                $validation = true;
            }


            if ($validation == false && Helper::checkCsrfToken($data['CSRF_TOKEN']))
            {
                $code = 202;
                Helper::saveToJson('url', $data['url']) ;
                Helper::saveToJson('emails', $data['emails']) ;


                $data['process'] = isset($_POST['process']) ? true : false;
                Helper::saveToJson('process', $data['process']);


                $data['mail-status'] = isset($_POST['mail-status']) ? true : false;
                Helper::saveToJson('mail-status', $data['mail-status']);


            }
        }

        $data['url']=Helper::getFromJson('url') ;
        $data['emails']=Helper::getFromJson('emails') ;
        $data['process']=Helper::getFromJson('process')?'checked':'' ;
        $data['mail-status']=Helper::getFromJson('mail-status')?'checked':'' ;

        $data['password']=Helper::getFromJson('password') ;


        return ['status'=>$code,'data'=>$data];
    }

    /*
     * Handle the functionality of Login page
     * Return true of ShowNotice variable for failed attempt
     * */
    public function Login()
    {
        $showNotice = false;

        if (!empty($_POST)) {
            $status = Helper::login($_POST['password']);

            if ($status == true) {

                $this->redirectPage('dashboard');

            } else {
                $showNotice = true;
            }

        }
        return $showNotice;
    }

    public function Logout()
    {
        Helper::logout();
    }

    /**
     * @param $extra
     */
    public function redirectPage($extra)
    {
        $host = $_SERVER['HTTP_HOST'];

        header("Location: http://$host/$extra.php");
        exit;
    }


}