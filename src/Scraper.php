<?php
/**
 * Created by PhpStorm.
 * User: tanvir
 * Date: 10/23/17
 * Time: 11:28 AM
 */

namespace Scraping;



class Scraper
{
    /*
     * Initialize Mailer class as DI
     * */
    public function __construct(Mailer $mailer = null)
    {
        $this->mailer = $mailer;
    }

    /*
     * Check item's availability by id
     * return true when item is available or else false
     * */
    public function isItemAvailable($url, $flag = null)
    {

        $id = empty(explode("=", $url)[1])?'':explode("=", $url)[1];

        $flag = empty($flag) ? getenv('FLAG') : $flag;

        return $this->ScrapePage($url, $id) == $flag ? false : true;

    }

    /*
     * Scrap Page
     * return the value of id after scrapping the page
     */
    public function ScrapePage($url, $id)
    {

        @$html = file_get_contents($url);
        $dom = new \DomDocument();
        @$dom->loadHTML($html);

        $sellStatus = $dom->getElementById($id)->getAttribute('value');

        return $sellStatus;
    }

    /*
     * Execute Process for cron
     * Send email to recipients as per logic
     * */
    public function ExecuteProcess()
    {
       
        $isProcessOn = Helper::getFromJson('process');

        if ($isProcessOn) {
            $url = Helper::getFromJson('url');

            $isItemAvailable = self::isItemAvailable($url);

            if (Helper::getFromJson('mail-status')) {
                 if($isItemAvailable) {
               return $this->mailer->sendEmail($isItemAvailable);
                 }

            } else{
                return $this->mailer->sendEmail($isItemAvailable);
            }

        }
    }


}