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


$pageName = $input['entry'][0]['changes'][0]['value']['from']['name'];
error_log(print_r($pageName, true));
$pageId = $input['entry'][0]['changes'][0]['value']['from']['id'];
error_log(print_r($pageId, true));
$postId = $input['entry'][0]['changes'][0]['value']['post_id'];
error_log(print_r($postId, true));
$message = $input['entry'][0]['changes'][0]['value']['message'];
error_log(print_r($message, true));





?>