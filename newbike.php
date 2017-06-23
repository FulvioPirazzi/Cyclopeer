<?php
/*
 * Function for creating a new bike
 * in the database
*/
function newBike($servername, $username, $password, $dbname,$message) {
  echo "new bike ...";
  $User_Id = $message['from']['id'];
  $text = $message['text'];
  // check status
  $conn = connDatabase($servername, $username, $password, $dbname);
  $sql0 = "SELECT ref,State_Id,Step,Task
              FROM State
              WHERE Task=1 AND State_Id IN
              (SELECT State_Id FROM Todo
              WHERE User_Id='$User_Id')
              ";
  $result = $conn->query($sql0);
  if ($result->num_rows > 0){
    //$answer = "old todo";
    while($row = $result->fetch_assoc()) {
         $ref = $row["ref"];
         $stateid = $row["State_Id"]; 
         $task = $row["Task"];
         $step = $row["Step"];
    }
    if ($step == 1){    // register description
      //echo "@@@@@@";
      $sql0 = "UPDATE Bike
               SET Description = '$text'
               WHERE Byke_Id = $ref";
      if ($conn->query($sql0) === TRUE){
        // done well
        $sql1 = "UPDATE State
                 SET Step = Step + 1
                 WHERE State_Id = $stateid";
        if ($conn->query($sql1) === TRUE){
          // stete step ++ done
          $answer = "Chose a type of bike";
        } 
        else{
          // stete step ++ OOPS!
        }
      }
      else{
        //  problem
      }
    }
    else if ($step == 2){    // register tipe of  bike
      //echo "@@@@@@";
      $sql0 = "UPDATE Bike
               SET Type = '$text'
               WHERE Byke_Id = $ref";
      if ($conn->query($sql0) === TRUE){
        $sql1 = "INSERT INTO Share (Byke_Id, User_Id)
                 VALUES ($ref, '$User_Id')";
        if ($conn->query($sql1) === TRUE){
          $sql2 = "DELETE FROM Todo
                   WHERE User_Id = '$User_Id'";
          if ($conn->query($sql2) === TRUE){
            $sql3 = "DELETE FROM State
                     WHERE State_Id = $stateid";
            if ($conn->query($sql3) === TRUE){
              include('menu.php');
              $answer = "new bike is set \n".$menu;
              // set todo  to zer
            }
          }
        }
        else{
          // stete step ++ OOPS!
        }
      }
      else{
        //  problem
      }
      echo "type chose!!";
      //$answer = "well done  yor byke is done";
    }
  }
  else
  {
    // step 0
    $answer = "Please, insert a description for your bike.";
    $sql0 = "INSERT INTO Bike (Description, Type)
             VALUES ( 'ND', 'ND')";
    if ($conn->query($sql0) === TRUE){
      $err = "<br> new user added correctly <br>";
      $ref = $conn->insert_id;
      $sql1 = "INSERT INTO State (Task, Step, ref)
             VALUES (1, 1, $ref)";
      if ($conn->query($sql1) === TRUE){
        $stateid = $conn->insert_id;
        $err = "<br> unable  to add the new user <br>";
        $sql2 = "INSERT INTO Todo (State_Id, User_Id)
                 VALUES ($stateid, '$User_Id')";
        if ($conn->query($sql2) === TRUE){
          $err = "<br> new user added correctly <br>"; 
        }
        else{
          $err = "<br> unable  to add the new user <br>";
        }
      }
      else{
        $err = "<br> unable  to add the new user <br>";
      }
    }
    else{
      $err = "<br> unable  to add the new user <br>";
    }
  }
  return $answer;
}
?>
