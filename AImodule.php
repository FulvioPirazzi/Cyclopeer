<?php

include('Mylib.php');
// AI module
// Def  answer

$User_Id = $message['from']['id'];
$Name = $message['from']['first_name'];
if (isset($message['from']['username']))
  $UserNameTel = $message['from']['username'];// need a if set
if (isset($message['from']['last_name']))
  $Surname = $message['from']['last_name'];// need if set

$conn = connDatabase($servername, $username, $password, $dbname);

$sql0 = "SELECT User_Id,UserName, Name, Surname
         FROM User
         WHERE User_Id='$User_Id'
         ";
$result = $conn->query($sql0);
if ($result->num_rows === 0)
{
  echo "\n A new Guest! welcome!";
  $answer = "A new Guest! welcome!\n I will remember you. ";
  $sql0 = "INSERT INTO User (User_id, UserName, Name, Surname)
           VALUES ('$User_Id','$UserNameTel', '$Name', '$Surname')";
  if ($conn->query($sql0) === TRUE)
    $err = "<br> new user added correctly <br>";
  else
   $err = "<br> unable  to add the new user <br>";
}
if (isset($message['text']))
$text = $message['text'];

$answer = parseMsg($message,$servername, $username, $password, $dbname);

if (strpos($answer, "GetLoc") === 0){
  echo "try  to make a button+".$answer."+\n";
$urlTel = <<<'EOD'
https://api.telegram.org/bot352864011:AAHOdYGwzJUOpWeHo3b6kRW0VGigcnsdQpc/sendmessage?chat_id=
EOD;
  $urlTel .= $from_id;
  $urlTel .= "&text="."Please use the button (SEND LOCATION) or try /setLocation";
$urlTel .= <<<'EOD'
&reply_markup= {"one_time_keyboard":true,"keyboard":[[{"text": " menu ", "callback_data": "A1"},{"text":"send location","request_location":true}, {"text": "newbike","callback_data": "newbike"}]]}
EOD;
//https://api.telegram.org/bot352864011:AAHOdYGwzJUOpWeHo3b6kRW0VGigcnsdQpc/sendmessage?chat_id=304160054&text=rtyu&reply_markup= {"one_time_keyboard":true,"keyboard":[[{"text": "CHIARA", "callback_data": "A1"},{"text":"send location","request_location":true},{"text": "newbike","callback_data": "newbike"}]]}

//EOD;

$params = array(
    //"text" => $answer,
           // "chat_id" => "304160054",

    //"chat_id" => $from_id,
    //"parse_mode" => "HTML"
  );
}
else if (strpos($answer, "ShowLoc") === 0){

$locate = explode("@", $answer);

$answer = <<<'EOD'
<a href="http://maps.google.com/maps?q=loc:
EOD;
$answer .= $locate[1].",";
$answer .= $locate[2];
$answer .= <<<'EOD'
">Open to check the location</a>
EOD;

$params = array(
    "text" => $answer,
    // "chat_id" => "304160054",
    "chat_id" => $from_id,
    "parse_mode" => "HTML"
  );
$urlTel = "https://api.telegram.org/bot352864011:AAHOdYGwzJUOpWeHo3b6kRW0VGigcnsdQpc/sendmessage";

}
else{
echo "\n HTML ON \n";
$params = array(
    "text" => $answer,
     // "chat_id" => "304160054",
    "chat_id" => $from_id,
    "parse_mode" => "HTML"
  );
$urlTel = "https://api.telegram.org/bot352864011:AAHOdYGwzJUOpWeHo3b6kRW0VGigcnsdQpc/sendmessage";
}

httpPost($urlTel,$params);

?>
