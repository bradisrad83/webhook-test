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
    curl_setopt($curl, CURLOPT_HTTPHEADER,     array('Authorization: Bearer EAADz1RkPiV0BALYBt3BhDhG9QD6n5pctydxvczCeCdQjNPZBHKqzs2vgUMFWmLbKUK0mZAkTAuxsXZBfHHZCyb3oYFs9rMtv34ypvXpbQRfdxoma7ZBdCw3iZCWXxnSH6uPaskAC7HCULtKIFAVRigW3VHnFJ5fhgZD')); 
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
  




//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
//WHAT A PERSON IN PIPEDRIVE LOOKS LIKE (SHOWS CUSTOM FIELDS/HOW TO WORK WITH THEIR API)

    // {  
    //     "success":true,
    //     "data":[  
    //        {  
    //           "id":1,
    //           "company_id":4604421,
    //           "owner_id":{  
    //              "id":7249027,
    //              "name":"Sorensen M&S",
    //              "email":"info@sorensenmayflower.com",
    //              "has_pic":false,
    //              "pic_hash":null,
    //              "active_flag":true,
    //              "value":7249027
    //           },
    //           "org_id":{  
    //              "name":"321-test-321",
    //              "people_count":1,
    //              "owner_id":7249027,
    //              "address":null,
    //              "cc_email":"sorensenms-6b43be@pipedrivemail.com",
    //              "value":1
    //           },
    //           "name":"321-Test",
    //           "first_name":null,
    //           "last_name":"321-Test",
    //           "open_deals_count":0,
    //           "related_open_deals_count":0,
    //           "closed_deals_count":0,
    //           "related_closed_deals_count":0,
    //           "participant_open_deals_count":0,
    //           "participant_closed_deals_count":0,
    //           "email_messages_count":0,
    //           "activities_count":0,
    //           "done_activities_count":0,
    //           "undone_activities_count":0,
    //           "reference_activities_count":0,
    //           "files_count":0,
    //           "notes_count":0,
    //           "followers_count":1,
    //           "won_deals_count":0,
    //           "related_won_deals_count":0,
    //           "lost_deals_count":0,
    //           "related_lost_deals_count":0,
    //           "active_flag":true,
    //           "phone":[  
    //              {  
    //                 "label":"work",
    //                 "value":"3213213211",
    //                 "primary":true
    //              }
    //           ],
    //           "email":[  
    //              {  
    //                 "label":"work",
    //                 "value":"321@321.com",
    //                 "primary":true
    //              }
    //           ],
    //           "first_char":"3",
    //           "update_time":"2018-12-05 17:49:23",
    //           "add_time":"2018-12-05 17:49:23",
    //           "visible_to":"3",
    //           "picture_id":null,
    //           "next_activity_date":null,
    //           "next_activity_time":null,
    //           "next_activity_id":null,
    //           "last_activity_id":null,
    //           "last_activity_date":null,
    //           "last_incoming_mail_time":null,
    //           "last_outgoing_mail_time":null,
    //           "label":1,
    //           "73295998bf5b6b54da7303482a8023ac9a99b927":"2018-12-01",   `               move date
    //           "63b603ebb30f5efb182350f390d6f2ed23707138":33333,                          current zip/postal code
    //           "5871de81dd0fb7982232434c67a61a936b833138":44444,                          new zip/postal code
    //           "7261d86664ddc37402895b17ad0b447cfdd558c6":"9",
    //           "1a819b1b483ec277f858d26863552d1a923c338c":"14",
    //           "org_name":"321-test-321",
    //           "owner_name":"Sorensen M&S",
    //           "cc_email":"sorensenms-6b43be@pipedrivemail.com"
    //        }
    //     ],
    //     "additional_data":{  
    //        "pagination":{  
    //           "start":0,
    //           "limit":100,
    //           "more_items_in_collection":false
    //        }
    //     },
    //     "related_objects":{  
    //        "organization":{  
    //           "1":{  
    //              "id":1,
    //              "name":"321-test-321",
    //              "people_count":1,
    //              "owner_id":7249027,
    //              "address":null,
    //              "cc_email":"sorensenms-6b43be@pipedrivemail.com"
    //           }
    //        },
    //        "user":{  
    //           "7249027":{  
    //              "id":7249027,
    //              "name":"Sorensen M&S",
    //              "email":"info@sorensenmayflower.com",
    //              "has_pic":false,
    //              "pic_hash":null,
    //              "active_flag":true
    //           }
    //        }
    //     }
    //  }    






///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//all personFields
    // {  
    //     "success":true,
    //     "data":[  
    //        {  
    //           "id":9038,
    //           "key":"name",
    //           "name":"Name",
    //           "order_nr":1,
    //           "picklist_data":null,
    //           "field_type":"varchar",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":false,
    //           "add_visible_flag":true,
    //           "important_flag":false,
    //           "bulk_edit_allowed":true,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "use_field":"id",
    //           "link":"/person/",
    //           "mandatory_flag":true
    //        },
    //        {  
    //           "id":9040,
    //           "key":"phone",
    //           "name":"Phone",
    //           "order_nr":2,
    //           "picklist_data":null,
    //           "field_type":"phone",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":true,
    //           "add_visible_flag":true,
    //           "important_flag":false,
    //           "bulk_edit_allowed":true,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "mandatory_flag":false
    //        },
    //        {  
    //           "id":9041,
    //           "key":"email",
    //           "name":"Email",
    //           "order_nr":3,
    //           "picklist_data":null,
    //           "field_type":"varchar",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":true,
    //           "add_visible_flag":true,
    //           "important_flag":false,
    //           "bulk_edit_allowed":true,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "mandatory_flag":false
    //        },
    //        {  
    //           "id":9061,
    //           "key":"73295998bf5b6b54da7303482a8023ac9a99b927",
    //           "name":"Move Date",
    //           "order_nr":4,
    //           "field_type":"date",
    //           "add_time":"2018-12-04 16:40:48",
    //           "update_time":"2018-12-04 16:40:47",
    //           "active_flag":true,
    //           "edit_flag":true,
    //           "index_visible_flag":true,
    //           "details_visible_flag":true,
    //           "add_visible_flag":true,
    //           "important_flag":false,
    //           "bulk_edit_allowed":true,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "mandatory_flag":false
    //        },
    //        {  
    //           "id":9062,
    //           "key":"63b603ebb30f5efb182350f390d6f2ed23707138",
    //           "name":"Current ZIP/Postal Code",
    //           "order_nr":5,
    //           "field_type":"double",
    //           "add_time":"2018-12-04 16:41:30",
    //           "update_time":"2018-12-04 16:41:30",
    //           "active_flag":true,
    //           "edit_flag":true,
    //           "index_visible_flag":true,
    //           "details_visible_flag":true,
    //           "add_visible_flag":true,
    //           "important_flag":false,
    //           "bulk_edit_allowed":true,
    //           "searchable_flag":true,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "mandatory_flag":false
    //        },
    //        {  
    //           "id":9063,
    //           "key":"5871de81dd0fb7982232434c67a61a936b833138",
    //           "name":"New ZIP/Postal Code",
    //           "order_nr":6,
    //           "field_type":"double",
    //           "add_time":"2018-12-04 16:41:44",
    //           "update_time":"2018-12-04 16:41:44",
    //           "active_flag":true,
    //           "edit_flag":true,
    //           "index_visible_flag":true,
    //           "details_visible_flag":true,
    //           "add_visible_flag":true,
    //           "important_flag":false,
    //           "bulk_edit_allowed":true,
    //           "searchable_flag":true,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "mandatory_flag":false
    //        },
    //        {  
    //           "id":9064,
    //           "key":"7261d86664ddc37402895b17ad0b447cfdd558c6",
    //           "name":"How Can We Serve You?",
    //           "order_nr":7,
    //           "field_type":"enum",
    //           "add_time":"2018-12-04 16:42:46",
    //           "update_time":"2018-12-04 16:42:45",
    //           "active_flag":true,
    //           "edit_flag":true,
    //           "index_visible_flag":true,
    //           "details_visible_flag":true,
    //           "add_visible_flag":true,
    //           "important_flag":false,
    //           "bulk_edit_allowed":true,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "options":[  
    //              {  
    //                 "label":"Residential",
    //                 "id":9
    //              },
    //              {  
    //                 "label":"Commercial",
    //                 "id":10
    //              },
    //              {  
    //                 "label":"Corporate",
    //                 "id":11
    //              },
    //              {  
    //                 "label":"Logistics",
    //                 "id":12
    //              },
    //              {  
    //                 "label":"General Interest",
    //                 "id":13
    //              }
    //           ],
    //           "mandatory_flag":false
    //        },
    //        {  
    //           "id":9065,
    //           "key":"1a819b1b483ec277f858d26863552d1a923c338c",
    //           "name":"Quote Type",
    //           "order_nr":8,
    //           "field_type":"enum",
    //           "add_time":"2018-12-04 16:43:33",
    //           "update_time":"2018-12-04 16:43:32",
    //           "active_flag":true,
    //           "edit_flag":true,
    //           "index_visible_flag":true,
    //           "details_visible_flag":true,
    //           "add_visible_flag":true,
    //           "important_flag":false,
    //           "bulk_edit_allowed":true,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "options":[  
    //              {  
    //                 "label":"Virtual Quote",
    //                 "id":14
    //              },
    //              {  
    //                 "label":"In-Home Quote",
    //                 "id":15
    //              }
    //           ],
    //           "mandatory_flag":false
    //        },
    //        {  
    //           "id":9039,
    //           "key":"label",
    //           "name":"Label",
    //           "order_nr":9,
    //           "field_type":"enum",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":true,
    //           "add_visible_flag":true,
    //           "important_flag":false,
    //           "bulk_edit_allowed":true,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "options":[  
    //              {  
    //                 "color":"green",
    //                 "label":"Customer",
    //                 "id":1
    //              },
    //              {  
    //                 "color":"red",
    //                 "label":"Hot lead",
    //                 "id":2
    //              },
    //              {  
    //                 "color":"yellow",
    //                 "label":"Warm lead",
    //                 "id":3
    //              },
    //              {  
    //                 "color":"blue",
    //                 "label":"Cold lead",
    //                 "id":4
    //              }
    //           ],
    //           "mandatory_flag":false
    //        },
    //        {  
    //           "id":9042,
    //           "key":"add_time",
    //           "name":"Person created",
    //           "order_nr":10,
    //           "picklist_data":null,
    //           "field_type":"date",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":false,
    //           "add_visible_flag":false,
    //           "important_flag":false,
    //           "bulk_edit_allowed":false,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "mandatory_flag":true
    //        },
    //        {  
    //           "id":9043,
    //           "key":"update_time",
    //           "name":"Update time",
    //           "order_nr":11,
    //           "picklist_data":null,
    //           "field_type":"date",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":false,
    //           "add_visible_flag":false,
    //           "important_flag":false,
    //           "bulk_edit_allowed":false,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "mandatory_flag":true
    //        },
    //        {  
    //           "id":9044,
    //           "key":"org_id",
    //           "name":"Organization",
    //           "order_nr":12,
    //           "picklist_data":null,
    //           "field_type":"org",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":true,
    //           "add_visible_flag":true,
    //           "important_flag":false,
    //           "bulk_edit_allowed":true,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "use_field":"org_id",
    //           "display_field":"org_name",
    //           "link":"/organization/",
    //           "autocomplete":"org_autocomplete",
    //           "mandatory_flag":false
    //        },
    //        {  
    //           "id":9045,
    //           "key":"owner_id",
    //           "name":"Owner",
    //           "order_nr":13,
    //           "picklist_data":null,
    //           "field_type":"user",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":true,
    //           "add_visible_flag":true,
    //           "important_flag":false,
    //           "bulk_edit_allowed":true,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "use_field":"owner_id",
    //           "display_field":"owner_name",
    //           "mandatory_flag":true
    //        },
    //        {  
    //           "id":9046,
    //           "key":"open_deals_count",
    //           "name":"Open deals",
    //           "order_nr":14,
    //           "picklist_data":null,
    //           "field_type":"double",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":false,
    //           "add_visible_flag":false,
    //           "important_flag":false,
    //           "bulk_edit_allowed":false,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "mandatory_flag":true
    //        },
    //        {  
    //           "id":9047,
    //           "key":"visible_to",
    //           "name":"Visible to",
    //           "order_nr":15,
    //           "field_type":"visible_to",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":true,
    //           "add_visible_flag":false,
    //           "important_flag":false,
    //           "bulk_edit_allowed":true,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "options":[  
    //              {  
    //                 "id":1,
    //                 "label":"Owner & followers"
    //              },
    //              {  
    //                 "id":3,
    //                 "label":"Entire company"
    //              }
    //           ],
    //           "mandatory_flag":true
    //        },
    //        {  
    //           "id":9048,
    //           "key":"next_activity_date",
    //           "name":"Next activity date",
    //           "order_nr":16,
    //           "picklist_data":null,
    //           "field_type":"date",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":false,
    //           "add_visible_flag":false,
    //           "important_flag":false,
    //           "bulk_edit_allowed":false,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "mandatory_flag":true
    //        },
    //        {  
    //           "id":9049,
    //           "key":"last_activity_date",
    //           "name":"Last activity date",
    //           "order_nr":17,
    //           "picklist_data":null,
    //           "field_type":"date",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":false,
    //           "add_visible_flag":false,
    //           "important_flag":false,
    //           "bulk_edit_allowed":false,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "mandatory_flag":true
    //        },
    //        {  
    //           "id":9050,
    //           "key":"id",
    //           "name":"ID",
    //           "order_nr":18,
    //           "picklist_data":null,
    //           "field_type":"int",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":false,
    //           "add_visible_flag":false,
    //           "important_flag":false,
    //           "bulk_edit_allowed":false,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "mandatory_flag":true
    //        },
    //        {  
    //           "id":9051,
    //           "key":"won_deals_count",
    //           "name":"Won deals",
    //           "order_nr":19,
    //           "picklist_data":null,
    //           "field_type":"int",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":false,
    //           "add_visible_flag":false,
    //           "important_flag":false,
    //           "bulk_edit_allowed":false,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "mandatory_flag":true
    //        },
    //        {  
    //           "id":9052,
    //           "key":"lost_deals_count",
    //           "name":"Lost deals",
    //           "order_nr":20,
    //           "picklist_data":null,
    //           "field_type":"int",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":false,
    //           "add_visible_flag":false,
    //           "important_flag":false,
    //           "bulk_edit_allowed":false,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "mandatory_flag":true
    //        },
    //        {  
    //           "id":9053,
    //           "key":"closed_deals_count",
    //           "name":"Closed deals",
    //           "order_nr":21,
    //           "picklist_data":null,
    //           "field_type":"int",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":false,
    //           "add_visible_flag":false,
    //           "important_flag":false,
    //           "bulk_edit_allowed":false,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "mandatory_flag":true
    //        },
    //        {  
    //           "id":9054,
    //           "key":"activities_count",
    //           "name":"Total activities",
    //           "order_nr":22,
    //           "picklist_data":null,
    //           "field_type":"int",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":false,
    //           "add_visible_flag":false,
    //           "important_flag":false,
    //           "bulk_edit_allowed":false,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "mandatory_flag":true
    //        },
    //        {  
    //           "id":9055,
    //           "key":"done_activities_count",
    //           "name":"Done activities",
    //           "order_nr":23,
    //           "picklist_data":null,
    //           "field_type":"int",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":false,
    //           "add_visible_flag":false,
    //           "important_flag":false,
    //           "bulk_edit_allowed":false,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "mandatory_flag":true
    //        },
    //        {  
    //           "id":9056,
    //           "key":"undone_activities_count",
    //           "name":"Activities to do",
    //           "order_nr":24,
    //           "picklist_data":null,
    //           "field_type":"int",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":false,
    //           "add_visible_flag":false,
    //           "important_flag":false,
    //           "bulk_edit_allowed":false,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "mandatory_flag":true
    //        },
    //        {  
    //           "id":9057,
    //           "key":"email_messages_count",
    //           "name":"Email messages count",
    //           "order_nr":25,
    //           "picklist_data":null,
    //           "field_type":"int",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":false,
    //           "add_visible_flag":false,
    //           "important_flag":false,
    //           "bulk_edit_allowed":false,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "mandatory_flag":true
    //        },
    //        {  
    //           "id":9058,
    //           "key":"picture_id",
    //           "name":"Profile picture",
    //           "order_nr":26,
    //           "picklist_data":null,
    //           "field_type":"picture",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":false,
    //           "add_visible_flag":false,
    //           "important_flag":false,
    //           "bulk_edit_allowed":false,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "mandatory_flag":true
    //        },
    //        {  
    //           "id":9059,
    //           "key":"last_incoming_mail_time",
    //           "name":"Last email received",
    //           "order_nr":26,
    //           "picklist_data":null,
    //           "field_type":"date",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":false,
    //           "add_visible_flag":false,
    //           "important_flag":false,
    //           "bulk_edit_allowed":false,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "mandatory_flag":true
    //        },
    //        {  
    //           "id":9060,
    //           "key":"last_outgoing_mail_time",
    //           "name":"Last email sent",
    //           "order_nr":27,
    //           "picklist_data":null,
    //           "field_type":"date",
    //           "add_time":"2018-12-01 03:40:52",
    //           "update_time":"2018-12-01 03:40:52",
    //           "active_flag":true,
    //           "edit_flag":false,
    //           "index_visible_flag":true,
    //           "details_visible_flag":false,
    //           "add_visible_flag":false,
    //           "important_flag":false,
    //           "bulk_edit_allowed":false,
    //           "searchable_flag":false,
    //           "filtering_allowed":true,
    //           "sortable_flag":true,
    //           "mandatory_flag":true
    //        }
    //     ],
    //     "additional_data":{  
    //        "pagination":{  
    //           "start":0,
    //           "limit":100,
    //           "more_items_in_collection":false
    //        }
    //     }
    //  }





    
    ?>