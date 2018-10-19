<?php

    $challenge = $_REQUEST['hub_challenge'];
    $verify_token = $_REQUEST['hub_verify_token'];

    if ($verify_token === 'abcd1234') {
        echo $challenge;
    }

    $input = json_decode(file_get_contents('php://input'), true);
    error_log(print_r($input, true));
    error_log(print_r('Below is the leadgen_id that I will need to use to call the facebook graph API using this and my Page Acess Token ', true));
    $leadgen_id = $input['entry'][0]['changes'][0]['value']['leadgen_id'];
    error_log(print_r($leadgen_id, true));


    //CURL CALL TO FACEBOOK GRAPH API WITH THE LEADGEN_ID FROM THE WEBHOOK
    //THIS TOKEN BELOW WILL NEVER EXPIRE AS LONG AS BRAD GOLDSMITH DOES NOT CHANGE HIS FACEBOOK PASSWORD OR DOES NOT LEAVE THE PROLEADS APP AS A DEVELOPER
    //IF HE DOES GO HERE: https://medium.com/@Jenananthan/how-to-create-non-expiry-facebook-page-token-6505c642d0b1 for instructions on how to get a user token and page access token that are linked and never expire.  
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL,            "https://graph.facebook.com/v3.1/".$leadgen_id."/");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,   1 );
    curl_setopt($curl, CURLOPT_HTTPGET,          1 );
    curl_setopt($curl, CURLOPT_HTTPHEADER,     array('Authorization: Bearer EAADz1RkPiV0BACHPqZBUrGdqWZAap24s2ovbNMPelxoOKCzQY0s6dxZB6TMZCb9TBSZBT2giGW7UJzpk19tnx1leeZB00BnO6G4KWBAtTxDWdZAEJHigrQvXvycD12lI7hvpnZA3Rr1qRSX4jVajRdj5hyxzvUxjSjlFZBTLaE2Jr8gZDZD')); 
    $leadgenResults=json_decode(curl_exec($curl));
    
    $leadData = $leadgenResults->field_data;

    // $jsonArrayForAcculynx = json_encode([
    //     'firstName'     => $leadData[2]->values[0],
    //     'phoneNumber1'  => $leadData[3]->values[0],
    //     'street'        => $leadData[4]->values[0],
    //     'zip'           => $leadData[5]->values[0],
    //     'emailAddress'  => $leadData[1]->values[0],
    //     'notes'         => $leadData[0]->values[0],
    // ]);

    //  CURL CALL TO ACCULLYNX to Store my lead data into my clients CRM
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,            "https://api.acculynx.com/api/v1/leads");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($ch, CURLOPT_POST,           1 );
    // curl_setopt($ch, CURLOPT_POSTFIELDS,     $jsonArrayForAcculynx); 
    curl_setopt($ch, CURLOPT_POSTFIELDS,         json_encode([
        'firstName'     => $leadgenResults->field_data[2]->values[0],
        'phoneNumber1'  => $leadgenResults->field_data[3]->values[0],
        'street'        => $leadgenResults->field_data[4]->values[0],
        'zip'           => $leadgenResults->field_data[5]->values[0],
        'emailAddress'  => $leadgenResults->field_data[1]->values[0],
        'notes'         => $leadgenResults->field_data[0]->values[0],
    ])); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer Y2FkNzQ0ZGEtMjBmOC00YzJkLWExMzMtOGU5YTkxNGFhNTZmMGZkYzUyOTYtZWI5Zi00NDk4LWJkYWQtZDJmN2Q4MzEzZjU4', 'Content-Type: application/json'));
    $results=curl_exec($ch);
    error_log(print_r('Below should be a response of 200 and Ill have to check acculynx to see if it went through', true));
    error_log(print_r($results, true));
  
    ?>