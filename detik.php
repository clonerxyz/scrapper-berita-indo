<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$httpClient = new Client();
$response = $httpClient->get('https://www.detik.com/terpopuler');
$htmlString = (string) $response->getBody();

// Suppress any warnings
libxml_use_internal_errors(true);

// Parse the HTML content
$doc = new DOMDocument();
$doc->loadHTML($htmlString);
$xpath = new DOMXPath($doc);

// Extract titles, links, and images
$titles = $xpath->query('//article//h3/a');
$links = $xpath->query('//article//h3/a/@href');
$images = $xpath->query('//article//span/img/@src');

$output = [];

foreach ($titles as $key => $titleNode) {
    // Check if link and image nodes exist for the current title
    $urlNode = $links->item($key);
    $imgNode = $images->item($key);

    $title = $titleNode->textContent;
    $url = $urlNode ? $urlNode->textContent : null;
    $image = $imgNode ? $imgNode->textContent : null;

    $output[] = [
        'title' => $title,
        'url' => $url,
        'image' => $image
    ];
}

// Pretty-print the JSON output
header('Content-Type: application/json');
echo json_encode($output, JSON_PRETTY_PRINT);
