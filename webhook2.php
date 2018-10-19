<?php

$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === 'abcd1234') {
    echo $challenge;
}


//the below code is proof of concept that we will be linking Squiblib (our APP) to this webook.
$input = json_decode(file_get_contents('php://input'), true);
error_log(print_r($input, true));
error_log(print_r('the above code is proof of concept that we will be linking Squiblib (our APP) to this webook.', true));


// $pageName = $input['entry'][0]['changes'][0]['value']['from']['name'];
// error_log(print_r($pageName, true));
// $pageId = $input['entry'][0]['changes'][0]['value']['from']['id'];
// error_log(print_r($pageId, true));
// $postId = $input['entry'][0]['changes'][0]['value']['post_id'];
// error_log(print_r($postId, true));
// $message = $input['entry'][0]['changes'][0]['value']['message'];
// error_log(print_r($message, true));
$status = $input['entry'][0]['changes'][0]['value']['item'];
error_log(print_r($status, true));
// $fields = $input['entry'][0]['changes'][0]['value'];
error_log(print_r($fields, true));


if($status = 'status') {
    //  CURL CALL TO SQUIBLIB TO ALLOW FOR BOOSTABLE POST TO BECOME A NEW AD
    $squibCurl = curl_init();

    // curl_setopt($squibCurl, CURLOPT_URL,            "https://squiblib.dev/boostpost");
    curl_setopt($squibCurl, CURLOPT_URL,               "https://96f6001e.ngrok.io/boostpost");
    curl_setopt($squibCurl, CURLOPT_RETURNTRANSFER,                                      1 );
    curl_setopt($squibCurl, CURLOPT_POST,                                                1 );
    curl_setopt($squibCurl, CURLOPT_POSTFIELDS,                                     json_encode([
        'page_id'       => $input['entry'][0]['changes'][0]['value']['from']['id'],
        'page_name'     => $input['entry'][0]['changes'][0]['value']['from']['name'],
        'post_id'       => $input['entry'][0]['changes'][0]['value']['post_id'],
        'message'       => $input['entry'][0]['changes'][0]['value']['message'],
        'access_token'  => 'EAADz1RkPiV0BACHPqZBUrGdqWZAap24s2ovbNMPelxoOKCzQY0s6dxZB6TMZCb9TBSZBT2giGW7UJzpk19tnx1leeZB00BnO6G4KWBAtTxDWdZAEJHigrQvXvycD12lI7hvpnZA3Rr1qRSX4jVajRdj5hyxzvUxjSjlFZBTLaE2Jr8gZDZD'
    ]));
    curl_setopt($squibCurl, CURLOPT_HTTPHEADER,     array('Content-Type: application/json'));
    $results = curl_exec($squibCurl);
    error_log(print_r('--------------------------------------------------------------------------------------------------------------------------------------------------', true));
    error_log(print_r($results, true));

}

?>