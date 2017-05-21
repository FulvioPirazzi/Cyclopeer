<?php
/*
 * Function for parsing a message
 * from user
*/
function parseMsg($message, $servername, $username, $password, $dbname) {
  if (isset($message['text']))
    $text = $message['text'];
  $User_Id = $message['from']['id'];
  // some todo??
  $conn = connDatabase($servername, $username, $password, $dbname);
  $sql0 = "SELECT ref,State_Id,Step,Task
              FROM State
              WHERE State_Id IN
              (SELECT State_Id FROM Todo
              WHERE User_Id='$User_Id')
              ";

  $result = $conn->query($sql0);
  if ($result->num_rows > 0){
    echo "result  > 0 \\n";
    while($row = $result->fetch_assoc()) {
       $ref = $row["ref"];
       $stateid = $row["State_Id"];
       $task = $row["Task"];
       $step = $row["Step"];
       echo " --> ". $task . " \n";
    }
    if ($task == 1){
      echo "calling newbike()" ;
      $answer = newBike($servername, $username, $password, $dbname,$message);
    }
    else if ($task == 2){
      echo "calling sharebike()" ;
      $answer = shareBike($servername, $username, $password, $dbname,$message);
    }
    else if ($task == 11){
      echo "calling srcbike()" ;
      $answer = srcbike($servername, $username, $password, $dbname,$message);
    }
  }
  else{
    // we got a problem do a bit...

    $text = $message['text'];
    $User_Id = $message['from']['id'];
    //$Name = $message['from']['first_name'];
    //$Surname = $message['from']['last_name'];
  include('menu.php');

$answer =" Could you please rephrase that?".
         " I'm not sure I understand what you mean.".
         $menu;

    if (strpos($text, "/start") === 0 ||
        strpos($text, "start") === 0 ||
        strpos($text, "/menu") === 0 ||
        strpos($text, "menu") === 0)
    {
      echo 'Received /start command!';
      $answer = $menu;
    }
    else if (strpos($text, "/newbike") === 0 ||
             strpos($text, "newbike") === 0 ||
             strpos($text, "new bike") === 0)
    {
      $answer = newbike ($servername, $username, $password, $dbname, $message);
      //$answer = "new bike";
    }
    else if (strpos($text, "/sharebike") === 0 ||
             strpos($text, "sharebike") === 0 ||
             strpos($text, "share bike") === 0)
    {
      $answer = sharebike ($servername, $username, $password, $dbname, $message);
      //$answer = "new bike";
    }
    else if (strpos($text, "/srcbike") === 0 ||
             strpos($text, "srcbike") === 0 ||
             strpos($text, "search bike") === 0)
    {
      $answer = srcbike($servername, $username, $password, $dbname, $message);
      //$answer = "new bike";
    }


  }
  return $answer;
}
?>
