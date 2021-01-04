<?php

function checkip(string $cip){
   // Input your options for this query including your optional API Key and query flags.
$proxycheck_options = array(
  'API_KEY' => '', // Your API Key.
  'VPN_DETECTION' => 1, // Check for both VPN's and Proxies instead of just Proxies.
);

$result_array = \proxycheck\proxycheck::check($cip, $proxycheck_options);


if ( $result_array['block'] == "yes" ) {

  // Example of a block and the reason why.
  return $result_array['block_reason'];
  exit;

} else {

  // No Proxy / VPN / Blocked Country detected.
   return "clean";
}}

?>
