`<?php

    $challenge = $_REQUEST['hub_challenge'];
    $verify_token = $_REQUEST['hub_verify_token'];

    if ($verify_token === 'abcd1234') {
        echo $challenge;
    }

    //CURL CALL TO GET ACCESS TOKEN
    $ch1 = curl_init();
    curl_setopt($ch1, CURLOPT_URL,            "https://graph.facebook.com/oauth/access_token?client_id=268096574032221&client_secret=273603e7fba3283b9d8b2a58ebb6f77a&redirect_uri=https://321theagency.com/&grant_type=client_credentials");
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER,    1 );
    curl_setopt($ch1, CURLOPT_HTTPGET,           1 );
    curl_setopt($ch1, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain')); 
     $accessToken=curl_exec($ch1);

     error_log(print_r($accessToken, true));
     error_log(print_r('---------------------------------------------------------------------', true));



    //CURL CALL TO GET ACCESS TOKEN
    $ch2 = curl_init();
    curl_setopt($ch2, CURLOPT_URL,            "https://graph.facebook.com/563763967129243?key=value&access_token=268096574032221|273603e7fba3283b9d8b2a58ebb6f77a");
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER,    1 );
    curl_setopt($ch2, CURLOPT_HTTPGET,           1 );
    curl_setopt($ch2, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain')); 
     $test=curl_exec($ch2);

     error_log(print_r($test, true));
     error_log(print_r('{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}{}', true));

    // //CURL CALL TO GET PAGE ACCESS TOKEN USING PREVIOUS ACCESS TOKEN
    // $pageId = '563763967129243';
    // $ch2 = curl_init();
    // curl_setopt($ch2, CURLOPT_URL,            "https://graph.facebook.com/".$pageId."?fields=".$accessToken->access_token);
    // curl_setopt($ch2, CURLOPT_RETURNTRANSFER,    1 );
    // curl_setopt($ch2, CURLOPT_HTTPGET,           1 );
    // curl_setopt($ch2, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain')); 
    // $pageAccessToken=curl_exec($ch2);

    // error_log(print_r($pageAccessToken, true));
    // error_log(print_r('|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||', true));
   
   
   
    // $input = json_decode(file_get_contents('php://input'), true);
    // error_log(print_r($input, true));
    // error_log(print_r('Below is the leadgen_id that I will need to use to call the facebook graph API using this and my Page Acess Token ', true));
    // $leadgen_id = $input['entry'][0]['changes'][0]['value']['leadgen_id'];
    // error_log(print_r($leadgen_id, true));

        
    //CURL CALL TO FACEBOOK GRAPH API WITH THE LEADGEN_ID FROM THE WEBHOOK
    //PLEASE NOTE FOR NOW I AM HARD CODING AN ACCESS TOKEN IN THAT I GOT FROM THE GRAPH EXPLORER API JUST SO I MAY TEST THIS CALL
    // $curl = curl_init();

    // curl_setopt($curl, CURLOPT_URL,            "https://graph.facebook.com/v3.1/".$leadgen_id."/");
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1 );
    // curl_setopt($ch, CURLOPT_POST,             1 );
    // curl_setopt($curl, CURLOPT_POSTFIELDS, array("access_token: EAADz1RkPiV0BAMZCjc1AaC4OkpXkGjyDE9FJlmT88Q6ithc1bU3L5GU1un3UNEYr4rICrbXfZC2ZAb86UECjOAy8ZBjzgZCZAbSeBjumujZA8YRXYem223ZC53SIj5BlzuODW0FkKLRurrhZBjuMbvlV7cfzRb3OKIRKO0K8xmSfbTua5uEjsr6e8OeIYpwodHpdZCsrW65IOvTQZDZD")); 
    // curl_setopt($curl, CURLOPT_HTTPHEADER,     array('Content-Type: application/json')); 
    // $leadgenResults=curl_exec($curl);
    // error_log(print_r('this should be the results from the facebook graph API call but I do not currently have permissions (lead_retrieval)', true));
    // error_log(print_r($leadgenResults, true));
    

    
    
    
    
    //  CURL CALL TO ACCULLYNX to Store my lead data into my clients CRM
    //  I AM NOT 100% SURE HOW THE GRAPH DATA WILL RETURN THIS DATA BUT THE "body goes here" portions will be a raw json object of the previous calls return data.
    // $ch = curl_init();

    // curl_setopt($ch, CURLOPT_URL,            "https://api.acculynx.com/api/v1/leads");
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
    // curl_setopt($ch, CURLOPT_POST,           1 );
    // curl_setopt($ch, CURLOPT_POSTFIELDS,     "body goes here" ); 
    // curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Authorization': 'Bearer N2QyMDFjZGYtNmE5ZS00MDE5LWFjNTgtZWQ5ODljZTU3Y2E1ODJiMzQzMzctZDQ0ZC00MTZkLWI5MDAtNjVlNDZlN2U1MDRh', 'Content-Type: application/json'));  
    // $result=curl_exec($ch);
    // curl_close($ch);
  
   
   
    //  most likeley the body of the form and they should be the body of the previous curl call if I have permissions:
    // {
    //     'firstName': 'form_full_name',
    //     'emailAddress': 'form_email_address',
    //     'phoneNumber1': 'form_phone_number',
    //     'street': 'form_address',
    //     'notes': 'service_inquiry_form',
    // }
    ?>