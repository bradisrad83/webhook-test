<?php

    $challenge = $_REQUEST['hub_challenge'];
    $verify_token = $_REQUEST['hub_verify_token'];

    if ($verify_token === 'abcd1234') {
        echo $challenge;
    }

    $input = json_decode(file_get_contents('php://input'), true);
    error_log(print_r($input, true));
    // error_log(print_r('-------------------------------', true));
    // $leadgen_id = $input['entry'][0]['changes'][0]['value']['leadgen_id'];
    // error_log(print_r($leadgen_id, true));

        
    //CURL CALL TO FACEBOOK GRAPH API WITH THE LEADGEN_ID FROM THE WEBHOOK
    // $curl = curl_init();

    // curl_setopt($curl, CURLOPT_URL,            "https://graph.facebook.com/v3.1/".$leadgen_id."/");
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1 );
    // curl_setopt($curl, CURLOPT_POST,           1 );
    // curl_setopt($curl, CURLOPT_POSTFIELDS, array("access_token: 268096574032221|9pjh-YlsC8q_Mq6WXujVMC75yvo")); 
    // curl_setopt($curl, CURLOPT_HTTPHEADER,     array('Content-Type: application/json'));  
    // $leadgenResults=curl_exec($curl);
    
    
    
    
    //  CURL CALL TO ACCULLYNX
    // $ch = curl_init();

    // curl_setopt($ch, CURLOPT_URL,            "https://api.acculynx.com/api/v1/leads");
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
    // curl_setopt($ch, CURLOPT_POST,           1 );
    // curl_setopt($ch, CURLOPT_POSTFIELDS,     "body goes here" ); 
    // curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Authorization': 'Bearer N2QyMDFjZGYtNmE5ZS00MDE5LWFjNTgtZWQ5ODljZTU3Y2E1ODJiMzQzMzctZDQ0ZC00MTZkLWI5MDAtNjVlNDZlN2U1MDRh', 'Content-Type: application/json'));  
    // $result=curl_exec($ch);
    // curl_close($ch);
  
   
   
    //  most likeley the body of the form
    // {
    //     'firstName': 'form_full_name',
    //     'emailAddress': 'form_email_address',
    //     'phoneNumber1': 'form_phone_number',
    //     'street': 'form_address',
    //     'notes': 'service_inquiry_form',
    // }
    ?>