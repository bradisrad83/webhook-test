`<?php

    $challenge = $_REQUEST['hub_challenge'];
    $verify_token = $_REQUEST['hub_verify_token'];

    if ($verify_token === 'abcd1234') {
        echo $challenge;
    }

    $input = json_decode(file_get_contents('php://input'), true);
    error_log(print_r($input, true));
    error_log(print_r('-------------------------------', true));
    $leadgen_id = $input['entry'][0]['changes'][0]['value']['leadgen_id'];
    error_log(print_r($leadgen_id, true));

        
    //CURL CALL TO FACEBOOK GRAPH API WITH THE LEADGEN_ID FROM THE WEBHOOK
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL,            "https://graph.facebook.com/v3.1/".$leadgen_id."/");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($curl, CURLOPT_POST,           1 );
    curl_setopt($curl, CURLOPT_POSTFIELDS, array("access_token: 268096574032221|9pjh-YlsC8q_Mq6WXujVMC75yvo")); 
    curl_setopt($curl, CURLOPT_HTTPHEADER,     array('Content-Type: application/json'));  
    $leadgenResults=curl_exec($curl);
    error_log(print_r('-------------------------------', true));
    error_log(print_r($leadgenResults, true));

    
    
    
    
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
//     add_action('wpcf7_before_send_mail', 'acculynx_cf7');

// function acculynx_cf7($WPCF7_ContactForm) {
// 	$submission = WPCF7_Submission::get_instance();
// 	if ( $submission ) {
// 		$posted_data = $submission->get_posted_data();
// 	}

// 	wp_remote_request('https://api.acculynx.com/api/v1/leads', array(
// 			'method' 			=> 'POST',
// 			'timeout'			=> 45,
// 			'headers'			=> array('Authrization' => 'Bearer Y2FkNzQ0ZGEtMjBmOC00YzJkLWExMzMtOGU5YTkxNGFhNTZmMGZkYzUyOTYtZWI5Zi00NDk4LWJkYWQtZDJmN2Q4MzEzZjU4',
// 										 'Accept'		=> 'application/json'
// 										),
// 			'body'				=> array( json_encode([
// 														"firstName" 	=> sanitize_text_field($posted_data['your-name']),
// 														"emailAddress"	=> sanitize_text_field($posted_data['your-email']),
// 														"phoneNumber1"	=> sanitize_text_field($posted_data['your-phone-number']),
// 														"street"		=> sanitize_text_field($posted_data['your-address']),
// 														"notes"			=> sanitize_text_field($posted_data['service_inquiry'])
// 													  ]) 
										
// 										),
// 		)
// 	);
// }
    ?>