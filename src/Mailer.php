<?php
/**
 * Created by PhpStorm.
 * User: tanvir
 * Date: 10/23/17
 * Time: 11:28 AM
 */

namespace Scraping;


use Mailgun\Mailgun;


class Mailer
{

    /*
     * Send email to the recipients mentioned in the status.json file.
     * Returns the log for each recipient's response from Mailgun's API
     * */
    public function sendEmail($isAvailable)
    {
        $mailer = Mailgun::create(getenv('MAILGUN_API'));

        $mailList = Helper::getArrayFromString( Helper::getFromJson('emails'));

        $resultSet =[];

        foreach ($mailList as $email) {

            $result = $mailer->sendMessage(getenv('DOMAIN'),
                $this->formatMail($isAvailable, $email)
            );

            array_push($resultSet,$result);

        }
        
        return $resultSet;
    }

    /*
     * Format the Email
     * Returns formatted Email with Subject,Body,To & From
     * */
    public function formatMail($isAvailable,$email)
    {
        $now = new \DateTime();

        $text = $isAvailable?'Available':'Not Available';

        return [
            'text' => 'Item '.$text,
            'subject' => 'Item Is '.$text.' - Time:'.$now->format('Y/M/d H:i:s'),
            'from' => getenv('FROM_EMAIL'),
            'to' => $email
        ];
    }


}