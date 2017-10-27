<?php
require_once 'src/Boot.php';


$val = new \Scraping\Scraper(new \Scraping\Mailer());

echo "<br/> ======== Mail Status ======= <br/>";
print_r($val->ExecuteProcess());
