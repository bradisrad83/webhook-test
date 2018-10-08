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
    //PLEASE NOTE FOR NOW I AM HARD CODING AN ACCESS TOKEN IN THAT I GOT FROM THE GRAPH EXPLORER API JUST SO I MAY TEST THIS CALL
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL,            "https://graph.facebook.com/v3.1/".$leadgen_id."/");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,   1 );
    curl_setopt($curl, CURLOPT_HTTPGET,          1 );
    curl_setopt($curl, CURLOPT_HTTPHEADER,     array('Authorization: Bearer EAADz1RkPiV0BACHPqZBUrGdqWZAap24s2ovbNMPelxoOKCzQY0s6dxZB6TMZCb9TBSZBT2giGW7UJzpk19tnx1leeZB00BnO6G4KWBAtTxDWdZAEJHigrQvXvycD12lI7hvpnZA3Rr1qRSX4jVajRdj5hyxzvUxjSjlFZBTLaE2Jr8gZDZD')); 
    $leadgenResults=json_decode(curl_exec($curl));
    // $leadgenResults=curl_exec($curl);
    error_log(print_r('this should be the results from the facebook graph API call but I do not currently have permissions (lead_retrieval)', true));
    error_log(print_r($leadgenResults, true));
    error_log(print_r('--------------------------------------------------------------------------------------', true));
    $leadData = $leadgenResults->field_data;
    // error_log(print_r($leadData, true));
    // error_log(print_r('00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000', true));
    // error_log(print_r($leadData[0]->values[0], true));
    // error_log(print_r('11111111111111111111111111111111111111111111111111111111111111111111111111111111111111111', true));
    // error_log(print_r($leadData[1]->values[0], true));
    // error_log(print_r('22222222222222222222222222222222222222222222222222222222222222222222222222222222222222222', true));
    // error_log(print_r($leadData[2]->values[0], true));
    // error_log(print_r('33333333333333333333333333333333333333333333333333333333333333333333333333333333333333333', true));
    // error_log(print_r($leadData[3]->values[0], true));
    // error_log(print_r('44444444444444444444444444444444444444444444444444444444444444444444444444444444444444444', true));
    // error_log(print_r($leadData[4]->values[0], true));
    // error_log(print_r('55555555555555555555555555555555555555555555555555555555555555555555555555555555555555555', true));
    // error_log(print_r($leadData[5]->values[0], true));
    // error_log(print_r('--------------------------------------------------------------------------------------', true));

    $notes = $leadData[0]->values[0];
    $email = $leadData[1]->values[0];
    $name = $leadData[2]->values[0];
    $phone = $leadData[3]->values[0];
    $address = $leadData[4]->values[0];
    $zip = $leadData[5]->values[0];

    $jsonArrayForAcculynx = json_encode([
        'firstName'     => $name,
        'phoneNumber1'  => $phone,
        'street'        => $address,
        'zip'           => $zip,
        'emailAddress'  => $email,
        'notes'         => $notes
    ]);



    //THIS TOKEN BELOW WILL NEVER EXPIRE AS LONG AS BRAD GOLDSMITH DOES NOT CHANGE HIS FACEBOOK PASSWORD OR DOES NOT LEAVE THE PROLEADS APP AS A DEVELOPER
    //IF HE DOES GO HERE: https://medium.com/@Jenananthan/how-to-create-non-expiry-facebook-page-token-6505c642d0b1 for instructions on how to get a user token and page access token that are linked and never expire.  
    // $token = 'EAADz1RkPiV0BACHPqZBUrGdqWZAap24s2ovbNMPelxoOKCzQY0s6dxZB6TMZCb9TBSZBT2giGW7UJzpk19tnx1leeZB00BnO6G4KWBAtTxDWdZAEJHigrQvXvycD12lI7hvpnZA3Rr1qRSX4jVajRdj5hyxzvUxjSjlFZBTLaE2Jr8gZDZD';


    //  CURL CALL TO ACCULLYNX to Store my lead data into my clients CRM
    //  I AM NOT 100% SURE HOW THE GRAPH DATA WILL RETURN THIS DATA BUT THE "body goes here" portions will be a raw json object of the previous calls return data.
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,            "https://api.acculynx.com/api/v1/leads");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($ch, CURLOPT_POST,           1 );
    curl_setopt($ch, CURLOPT_POSTFIELDS,     $jsonArrayForAcculynx); 
    curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Authorization: Bearer N2QyMDFjZGYtNmE5ZS00MDE5LWFjNTgtZWQ5ODljZTU3Y2E1ODJiMzQzMzctZDQ0ZC00MTZkLWI5MDAtNjVlNDZlN2U1MDRh', 'Content-Type: application/json'));  
    $results=curl_exec($ch);
    error_log(print_r('Below should be a response of 200 and Ill have to check acculynx to see if it went through', true));
    error_log(print_r($results, true));
  
   
   
    //  most likeley the body of the form and they should be the body of the previous curl call if I have permissions:
    // {
    //     'firstName': 'form_full_name',
    //     'emailAddress': 'form_email_address',
    //     'phoneNumber1': 'form_phone_number',
    //     'street': 'form_address',
    //     'notes': 'service_inquiry_form',
    // }
    ?>