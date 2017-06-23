<?php
function httpPost($url,$params)
{
  $postData = '';
   //create name value pairs seperated by &
   foreach($params as $k => $v) 
   { 
      $postData .= $k . '='.$v.'&'; 
   }
   $postData = rtrim($postData, '&');

    $ch = curl_init();  

    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false); 
    curl_setopt($ch, CURLOPT_POST, count($postData));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    

    $output=curl_exec($ch);

    curl_close($ch);
    return $output;
}

$message_id = $message['message_id'];
$chat_id = $message['chat']['id'];
$from_id = $message['from']['id'];

/*
$params = array(
   "text" => "Hi",
   // "chat_id" => "304160054",
   "chat_id" => $from_id
);
*/

//$urlTel = "https://api.telegram.org/bot352864011:AAHOdYGwzJUOpWeHo3b6kRW0VGigcnsdQpc/sendmessage";
//httpPost($urlTel,$params)

?>
