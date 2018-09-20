<?php

    $challenge = $_REQUEST['hub_challenge'];
    $verify_token = $_REQUEST['hub_verify_token'];

    if ($verify_token === 'abcd1234') {
        echo $challenge;
    }

    $input = json_decode(file_get_contents('php://input'), true);
    error_log(print_r($input, true));
    // print_r($input, true);







    //  CURL CALL
    // $ch = curl_init();

    // curl_setopt($ch, CURLOPT_URL,            "https://api.acculynx.com/api/v1/leads");
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
    // curl_setopt($ch, CURLOPT_POST,           1 );
    // curl_setopt($ch, CURLOPT_POSTFIELDS,     "body goes here" ); 
    // curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Authorization': 'Bearer <ACCESS_TOKEN>', 'Content-Type: application/json'));  
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
    <script>
        console.log('webhook is being hit');    
        console.log("<?php print_r($input); ?>");
        console.log('webhook should have printed the input');
    </script>