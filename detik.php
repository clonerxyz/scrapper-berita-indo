<?php
require 'vendor/autoload.php';
$httpClient = new \GuzzleHttp\Client();
$response = $httpClient->get('https://www.detik.com/terpopuler');
$htmlString = (string) $response->getBody();
//add this line to suppress any warnings
libxml_use_internal_errors(true);
$doc = new DOMDocument();
$doc->loadHTML($htmlString);
$xpath = new DOMXPath($doc);
$titles = $xpath->evaluate('//article//h3/a');
$links = $xpath->evaluate('//article//h3/a/@href');
//$img = $xpath->evaluate('//article//span/img/@src');
    foreach ($titles as $key => $title) {
        $title = $title->textContent;
        $url = $links[$key]->textContent;
        //$img = $img[$key]->textContent;
        //$output = array("title"=>$title->textContent, "links"=>$links[$key]->textContent);
        $output[] = array(
            'result' => array(
            'title' => $title,
            'url' => $url,
            //'image' => $img
            ),
            );
            $ress = json_encode($output, JSON_PRETTY_PRINT).PHP_EOL;
    }
    echo $ress.PHP_EOL;
?>