<?php

/*
 * Function for sharing a  bike
 * in the database
*/
function shareBike($servername, $username, $password, $dbname,$message) {
  echo "share bike ...\n";
  $User_Id = $message['from']['id'];
  //$textType = $message['entities']['0']['type'];
  if (isset($message['text'])){
    $text = $message['text'];
    $txt = $message['text'];
  }
  else
    $txt = "";
  $answer = "2 You said  ".$txt." do you ha a bike? if not /newbike ";
  // check status
  $conn = connDatabase($servername, $username, $password, $dbname);
  $sql0 = "SELECT ref,State_Id,Step,Task
           FROM State
           WHERE Task=2 AND State_Id IN
           (SELECT State_Id FROM Todo
           WHERE User_Id='$User_Id')
           ";
  $result = $conn->query($sql0);
  if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
         $ref = $row["ref"];
         $stateid = $row["State_Id"]; 
         $task = $row["Task"];
         $step = $row["Step"];
    }
    if ($step == 1){    // pick a bike to share
      $answer = "You said ".$text." please select a bike. ";
      if (strpos($text, "/") === 0){
        echo "got a command \n";
        $text = ltrim($text, '/');
        $bikeChoice = intval($text);
        echo "your choice --> ".$bikeChoice;
        // check that a bike number exist 
        $sql0 = "SELECT Byke_Id, Type
           FROM Bike
           WHERE Byke_Id = '$bikeChoice'";
        $result2 = $conn->query($sql0);
        if ($result2->num_rows > 0){
          //update bike number
          $sql0 = "UPDATE Availability
                   SET byke_Id = $bikeChoice
                   WHERE Aval_Id = $ref";
          if ($conn->query($sql0) === TRUE){
            // done well
            $sql1 = "UPDATE State
                 SET Step = Step + 1
                 WHERE State_Id = $stateid";
            if ($conn->query($sql1) === TRUE){
              // stete step ++ done
              $answer = "When do you like to share in the next 15 days\n ";
              $date = strtotime('Today');
              for ($i=0;$i<15;$i++){
                $answer .= "/".date('M_d', $date)." ";
                if (($i+1)%3==0) echo "\n";
                $date = strtotime(' + 1 day', $date);
              }
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
    }
    else if ($step == 2){    //create  select  the start 
      $answer = "Please  select a proper day \n";
      // check the input day
      if (strpos($text, "/") === 0){
        echo "got a command step 2 \n";
        $text = ltrim($text, '/');
        $dayChoice = str_replace("_"," ",$text,$n);   // $n need to  be 1
        echo "your choice 2--> ".$dayChoice."\n";
        $flag = 0;
        $date = strtotime('Today');
        for ($i=0;$i<15;$i++){
          echo "+".$dayChoice."+ <> +".date('M d', $date)."+\n";
          if (strpos($dayChoice, date('M d', $date)) === 0){
            echo "I confirm ".$dayChoice." stp ".$i."\n";
            $day = $date;
            $flag = 1;
          }
          $date = strtotime(' + 1 day', $date);
        }
        if ($flag == 0)
          $answer = "Wrong date !!!!";
        else{
          //echo "day ".$day." \n";
          $dayF = date("Y-m-d H:i:s", $day);
          //echo "dayF ".$dayF." \n";

          $sql0 = "UPDATE Period
                   SET Start = '$dayF'
                   WHERE Per_Id IN
                   (SELECT Per_Id FROM Availability
                   WHERE Aval_Id='$ref')
                  ";
          if ($conn->query($sql0) === TRUE){
            $sql2 = "UPDATE State
                     SET Step = Step + 1
                     WHERE State_Id = $stateid";
            if ($conn->query($sql2) === TRUE){
              $answer = "Please  select the starting time of the sharing window\n";
              for ($i=6;$i<48;$i++){
                $h = intval($i / 2);
                $m =($i % 2) *30;
                if ($i<20)
                  $str = "   /";
                else
                  $str = " /";
                $answer .= $str.$h."h".$m."m";
                if (($i+1)%6==0) $answer .= "\n";
              }
              // set todo  to zer
            }
          }
        }
      }
      else{
        //  problem
      }
      echo "type chose!!";
      //$answer = "well done  yor byke is done";
    }
    //@@@@@@@@@
    else if ($step == 3){    //create  select  the start 
      $answer = "Please select the starting time of the sharing window\n";
      for ($i=6;$i<48;$i++){
        $h = intval($i / 2);
        $m =($i % 2) *30;
        if ($i<20)
          $str = "   /";
        else
          $str = " /";
        $answer .= $str.$h."h".$m."m";
        if (($i+1)%6==0) $answer .= "\n";
      }
      if (strpos($text, "/") === 0){
        echo "got a command step 3 \n";
        $text = ltrim($text, '/');
        $timeChoice = str_replace("h",":",$text,$n);   // $n need to  be 1
        $timeChoice = str_replace("m","",$timeChoice,$n);   // $n need to  be 1
        //$timeChoice .=":00";
        echo "your choice 2--> ".$timeChoice."\n";
        $flag = 0;
        $date = strtotime('Today');

        for ($i=6;$i<48;$i++){
          $h = intval($i / 2);
          $m =($i % 2) *30;
          echo "+".$h.":".$m."+ <> +".$timeChoice."+\n";
          if (strpos($timeChoice, $h.":".$m) === 0){
            echo "got it \n";
            $flag = 1;
          }
        }
        if  ($flag = 0){
          $answer = " i dont recognize  the time";
        }
        else{

          //echo "day ".$day." \n";
          //$timeF = date("Y-m-d H:i:s", $day);
          //echo "timeF ".$timeF." \n";
//SELECT DATE_ADD('2014-02-13 08:44:21', INTERVAL '1:03:12' HOUR_MINUTE);
          $sql0 = "UPDATE Period
    SET Start = DATE_ADD(Start, INTERVAL '$timeChoice' HOUR_MINUTE)
                   WHERE Per_Id IN
                   (SELECT Per_Id FROM Availability
                   WHERE Aval_Id='$ref')
                  ";
          if ($conn->query($sql0) === TRUE){
            $sql2 = "UPDATE State
                     SET Step = Step + 1
                     WHERE State_Id = $stateid";
            if ($conn->query($sql2) === TRUE){
              $answer = " How long  are  you willing to share your bike";
              for ($i=1;$i<21;$i++){
                if ($i<10)
                  $str = "h    ";
                else
                  $str = "h  ";
                $answer .= "/".$i.$str;
                if ($i % 5 == 0)
                $answer .= "\n";
              }
            }
          }
        }
      }
    }
    // hhhhhhhhhhh
    else if ($step == 4){
      $answer = " How long  are  you willing to share your bike \n";
      for ($i=1;$i<21;$i++){
        if ($i<10)
          $str = "h    ";
        else
          $str = "h  ";
        $answer .= "/".$i.$str;
        if ($i % 5 == 0)
          $answer .= "\n";
      }
      echo "\n";
      echo "step 4 \n";
      //$answer = "step 4";
      if (strpos($text, "/") === 0){
        echo "#4 I got command ";
        $text = ltrim($text, '/');
        $interChoice = intval(str_replace("h","",$text,$n));
        echo "int -> ".$interChoice;
        if ($interChoice > 0 && $interChoice < 21){
          $sql0 = "UPDATE Period
    SET end = DATE_ADD(Start, INTERVAL '$interChoice' HOUR)
                   WHERE Per_Id IN
                   (SELECT Per_Id FROM Availability
                   WHERE Aval_Id='$ref')
                  ";
          if ($conn->query($sql0) === TRUE){
            $sql2 = "UPDATE State
                     SET Step = Step + 1
                     WHERE State_Id = $stateid";
            if ($conn->query($sql2) === TRUE){
              $answer = "GetLoc";
              //  }
              //}
            }
          }
        }
      }
    } // end 4
    else if ($step == 5){
      $flagLoc = 0;
      if (isset($message['location']['latitude']) &&
          isset($message['location']['longitude'])){
        $latitude = $message['location']['latitude'];
        $longitude = $message['location']['longitude'];
        echo "this is lat-->".$latitude." long-->".$longitude;
        // register in  data base
        $flagLoc = 1;
      }
      else if (isset ($text))
      {
        if (strpos($text, "/") === 0){
          //  clearly is not an address
        }
        else{
          echo "try  to convert ".$text."\n";
          include('Add2Coo.php');
          $json = Add2Coo($text);
          // ($lat,$lng,$number,$Street,$Cyty,$Zip );
          // get location from addresse
          $flagLoc = 2;
          // it means  the number was provided
          $latitude=$json[0];
          $longitude=$json[1];
          $address=$json[2];
          echo "lt".$latitude."\nln".$longitude."\nad".$address."\nSt";
          $answer = "ShowLoc@".$latitude."@".$longitude;
        }
      }
      else{
        $answer = "GetLoc";
        echo "no button pressed or proper add  provided";
      }
      if ($flagLoc > 0){
        $sql0 = "INSERT INTO GeoPosition (Lat,Lon)
                VALUES ($latitude,$longitude)";
        // json array($lat,$lng,$number,$Street,$Cyty,$Zip );
        if ($flagLoc == 2){
          if ($conn->query($sql0) === TRUE){
            $geo_Id = $conn->insert_id;
            $sql1 = "INSERT INTO Address (FormAdd)
                     VALUES ('$address')";
          }
        }
        else{
          if ($conn->query($sql0) === TRUE){
            $geo_Id = $conn->insert_id;
            $sql1 = "INSERT INTO Address (FormAdd)
                     VALUES ('NA')";
          }
        }
        if ($conn->query($sql1) === TRUE){
          echo "added @@@@@@\n";
          $add_Id = $conn->insert_id;
          $sql1 = "INSERT INTO IsWhere (Aval_Id,Add_Id,Geo_Id)
                 VALUES ($ref,$add_Id,$geo_Id)";
        }
        if ($conn->query($sql1) === TRUE){
          $sql3 = "DELETE FROM Todo
                   WHERE User_Id = '$User_Id'";
          if ($conn->query($sql3) === TRUE){
            $sql4 = "DELETE FROM State
                     WHERE State_Id = $stateid";
            if ($conn->query($sql4) === TRUE){
              include('menu.php');
              $answer= "Your location has been recorded \n\n".$menu;
            }
          }
        }
      }
    }
  }
  else // step 0
  {
    $answer = "Please, Select a bike that you like to share.\n\n";
    $sql0 = "SELECT Byke_Id,Description,Type
            FROM Bike
            WHERE Byke_Id IN
            (SELECT Byke_Id FROM Share
            WHERE User_Id='$User_Id')
            ";
    $result = $conn->query($sql0);
    if ($result->num_rows > 0){  // no result = no bike  to share
      echo "bike to share";
      while($row = $result->fetch_assoc()) {
         $Byke_Id = $row["Byke_Id"];
         $Description = $row["Description"];
         $Type = $row["Type"];
         $answer .= "/".$Byke_Id." ".$Description." ".$Type."\n";
      }
      $sql1 = "INSERT INTO Period (Start, End)
               VALUES (NOW(),NOW())";
      if ($conn->query($sql1) === TRUE){
        echo "period done";
        $Per_Id = $conn->insert_id;
        $sql2 = "INSERT INTO Availability (Byke_Id, Per_Id)
                 VALUES ($Byke_Id, $Per_Id)";
        if ($conn->query($sql2) === TRUE){
          $ref = $conn->insert_id;
          $sql3 = "INSERT INTO State (Task, Step, ref)
                   VALUES (2, 1, $ref)";
          if ($conn->query($sql3) === TRUE){
            $stateid = $conn->insert_id;
            $err = "<br> able  to add the new state <br>";
            $sql4 = "INSERT INTO Todo (State_Id, User_Id)
                     VALUES ($stateid, '$User_Id')";
            if ($conn->query($sql4) === TRUE){
              $err = "<br> new todo added <br>"; 
            }
            else{
              $err = "<br> unable  to add the new todo <br>";
            }
          }
        }
      }
    }
    else{
      $answer = "Sorry, you have to describe a /newbike first.\n";
    }
  }
  return $answer;
}
?>
