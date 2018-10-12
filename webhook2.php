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

//this file will eventually catch the promotable post from the facebook page in which our use has admin access too
//from here will will take the post_id and convert the post into an "ad" into a predefined campaign/adset(targeting)
//this newly created add will run form the specs our user entered with the budget in which they entered as well.  
//The budget will be linked to the credit card for that users selected ad account in which they created their campaign for.  
//the logic in here will be to serach our DB for the pageid# that came up and that will link everything together.  



?>