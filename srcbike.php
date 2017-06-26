
<?php
function srcBike($servername, $username, $password, $dbname, $message) {
  echo "share bike ...\n";
  $User_Id = $message['from']['id'];

  if (isset($message['text'])){
    $text = $message['text'];
    $txt = $message['text'];
  }
  else
  $txt = "";
  $answer = "3 You said  ".$txt." default reply ";
  // check status
  $conn = connDatabase($servername, $username, $password, $dbname);
  $sql0 = "SELECT ref,State_Id,Step,Task
           FROM State
           WHERE Task=11 AND State_Id IN
           (SELECT State_Id FROM Todo
           WHERE User_Id='$User_Id')
           ";
  $result = $conn->query($sql0);
  var_dump($result);
  if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
      $ref = $row["ref"];
      $stateid = $row["State_Id"];
      $task = $row["Task"];
      $step = $row["Step"];
    }
    if ($step == 1){    // register  location ask a day
      $flagLoc = 0;
      echo "step 1 on the task 11";
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
          $flagLoc = 1;
          // ($lat,$lng,$number,$Street,$Cyty,$Zip );
          // get location from addresse
          // it means  the number was provided
          $latitude=$json[0];
          $longitude=$json[1];
          echo "lt".$latitude."\nln".$longitude."\n";
          $answer = "ShowLoc@".$latitude."@".$longitude;
        }
      }
      else{
        $answer = "GetLoc";
        echo "no button pressed or proper  add  provided";
      }
      if ($flagLoc > 0){
        $sql0 = "UPDATE GeoPosition
                 SET Lat = $latitude, Lon =$longitude
                 WHERE Geo_Id IN
                (SELECT Geo_Id FROM Search
                 WHERE Src_Id='$ref')";

        if ($conn->query($sql0) === TRUE){
            $sql1 = "UPDATE State
                   SET Step = Step + 1
                   WHERE State_Id = $stateid";
          if ($conn->query($sql1) === TRUE){
            $answer = "When do you like to use the bike in the next 15 days\n"; 
            $date = strtotime('Today');
            for ($i=0;$i<15;$i++){
              $answer .= "/".date('M_d', $date)." ";
              $date = strtotime(' + 1 day', $date);
            }
          }
        }
      }
    }
    else  if ($step == 2){  // pick a  bike to share
      $answer = "Please select the day When do you like to use the bike \n";
      $date = strtotime('Today');
      for ($i=0;$i<15;$i++){
        $answer .= "/".date('M_d', $date)." ";
        $date = strtotime(' + 1 day', $date);
      }
      if (strpos($text, "/") === 0){
        echo "got a command step 2 \n";
        $text = ltrim($text, '/');
        $dayChoice = str_replace("_"," ",$text,$n);   // $$
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
                   (SELECT Period_Id FROM Search
                   WHERE Src_Id='$ref')
                  ";
          if ($conn->query($sql0) === TRUE){
            $sql1 = "UPDATE State
                     SET Step = Step + 1
                     WHERE State_Id = $stateid";
            if ($conn->query($sql1) === TRUE){
              $answer = "Please  select the time when you  want collect the bike\n";
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
            }
          }
        }
      }
    }
    else if ($step == 3){
      $answer = "Please select the starting time of the sharing window \n";
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
        $timeChoice = str_replace("h",":",$text,$n);   // $n needs to  be 1
        $timeChoice = str_replace("m","",$timeChoice,$n);   // $n needs to  be 1
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
          $answer = " I dont recognize  the time";
        }
        else{
          $sql0 = "UPDATE Period
                   SET Start = DATE_ADD(Start, INTERVAL '$timeChoice' HOUR_MINUTE)
                   WHERE Per_Id IN
                   (SELECT Period_Id FROM Search
                   WHERE Src_Id='$ref')
                  ";
          if ($conn->query($sql0) === TRUE){
            $sql2 = "UPDATE State
                     SET Step = Step + 1
                     WHERE State_Id = $stateid";
            if ($conn->query($sql2) === TRUE){
              $answer = "For how long are you willing to take the bike ? \n";
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
    } // end of step 3
    else if ($step == 4){
      echo "@@ step 4 @@";
      $answer = "Please try again.\n For how long are you willing to share your bike \n";
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
                   SET End = DATE_ADD(Start, INTERVAL '$interChoice' HOUR)
                   WHERE Per_Id IN
                   (SELECT Period_Id FROM Search
                   WHERE Src_Id='$ref')
                  ";
          if ($conn->query($sql0) === TRUE){
            $sql2 = "UPDATE State
                     SET Step = Step + 1
                     WHERE State_Id = $stateid";
            if ($conn->query($sql2) === TRUE){
              $sql4 = "SELECT Lat, Lon
                        FROM GeoPosition
                        WHERE Geo_Id IN
                        (SELECT Geo_Id FROM Search
                        WHERE Src_Id='$ref')
                        ";
              $result = $conn->query($sql4);
              var_dump($result);
              if ($result->num_rows > 0){
                 while($row = $result->fetch_assoc()) {
                   $centrelat = $row["Lat"];
                   $centrelon = $row["Lon"];
                 }
                 echo "lat -->".$centrelat."\n";
                 echo "lon -->".$centrelon."\n";
                 $sql3 = "SELECT Per_Id,Start,End
                      FROM Period
                      WHERE Per_Id IN
                     (SELECT Period_Id FROM Search
                      WHERE Src_Id='$ref')
                     ";

                $result = $conn->query($sql3);
                var_dump($result);
                if ($result->num_rows > 0){
                  while($row = $result->fetch_assoc()) {
                    $per_Id = $row["Per_Id"];
                    $start = $row["Start"];
                    $end = $row["End"];
                  }
                  echo "start".$start."\n";
                  echo "end".$end."\n";
                  $sql4 = "SELECT Aval_Id
                          FROM Availability
                          WHERE Per_Id IN
                          (SELECT Per_Id FROM Period
                          WHERE start <= '$start'
                          AND End >= '$end')";
                  $result3 = $conn->query($sql4);
                  if ($result3->num_rows > 0){
                    $k = 0;
                    $markbike = array();
                    include('distance.php');
                    while($row = $result3->fetch_assoc()) {
                      $av_Id = $row["Aval_Id"];
                      echo "aval id --> ".$row["Aval_Id"]."\n";
                      echo "aval id --> ".$av_Id."\n";
                      $sql5 = "SELECT Lat, Lon
                              FROM GeoPosition
                              WHERE Geo_Id IN
                              (SELECT Geo_Id FROM IsWhere
                              WHERE Aval_Id='$av_Id')
                              ";
                      $result4 = $conn->query($sql5);
                      if ($result4->num_rows > 0){
                        while($row = $result4->fetch_assoc()) {
                          // calc distance
                          echo "bike  lat --> ".$row["Lat"]."\n";
                          echo "bike  lon --> ".$row["Lon"]."\n";
                          $bikelat = $row["Lat"];
                          $bikelon = $row["Lon"];
                          $dist = Distance($bikelat,
                                           $bikelon,
                                           $centrelat,
                                           $centrelon,
                                           6371);
                          echo "distance -->". $dist."\n";
                          if ($dist<6 && $k<5){
                            $markbike[$k] = array(
                                  $av_Id,
                                  $bikelat,
                                  $bikelon
                                  );
                            $k++;
                          }
                        }
                      }
                    }

$answer = <<<'EOD'
<a href="https://maps.googleapis.com/maps/api/staticmap?center=
EOD;
$answer .= $centrelat.",".$centrelon."%26zoom=12%26size=600x600%26maptype=roadmap";

$color = array("red", "green", "yellow", "blue", "orange");
$n = 1;
foreach ($markbike as $row) {
                      echo $row[0]."\n";
                      echo $row[1]."\n";
                      echo $row[2],"\n";
$answer .= "%26markers=color:".$color[$n%5]."|label:".$n."|".$row[1].",".$row[2];
$n++;
                    }
include('circle.php');
var_dump($answer);
$answer .= "%26path=color:0xff0000ff|weight:5";
$radius = .05;
foreach ($circle as $row) {
$plat = $row[0]*$radius + $centrelat;
$plon = $row[1]*$radius*1.5 + $centrelon;
$answer .= "|".$plat.",".$plon;
}
$answer .= <<<'EOD'
%26key=AIzaSyAVfMEd2vXGTt6qT11pW7I8B0sOVhhE0n8">Enlarge the map</a>
EOD;
$n=1;
$answer .= "\n<b>Please select a bike</b>\n";
foreach ($markbike as $row) {
                      echo $row[0]."\n";
                      echo $row[1]."\n";
                      echo $row[2],"\n";
$answer .= " /".$n."_bike \n";
$n++;
$answer .= " /Abort the search \n";
}
                  }
                }
              }
            }
          }
        }
      }
    } // end 4
    else if ($step == 5){
      $answer = "No bike available or Search aborted.  \n".
                "Try to search again a bike /srcbike \n".
                "Or visualize other option /menu \n";
      echo "step 5";
      $sql3 = "DELETE FROM Todo
             WHERE User_Id = '$User_Id'";
      if ($conn->query($sql3) === TRUE){
        $sql4 = "DELETE FROM State
                 WHERE State_Id = $stateid";
        if ($conn->query($sql4) === TRUE){
          echo "state and todo set to zero ";
        }
      }
      if (strpos($text, "/") === 0 && strpos($text, "_bike") === 2){
        echo "/ detect \n";
        $option = filter_var($text, FILTER_SANITIZE_NUMBER_INT);
        echo "OPTION-->".$option;
    //@@
        $sql4 = "SELECT Lat, Lon
                        FROM GeoPosition
                        WHERE Geo_Id IN
                        (SELECT Geo_Id FROM Search
                        WHERE Src_Id='$ref')
                        ";
        $result = $conn->query($sql4);
        var_dump($result);
        if ($result->num_rows > 0){
          while($row = $result->fetch_assoc()) {
            $centrelat = $row["Lat"];
            $centrelon = $row["Lon"];
          }
          echo "lat -->".$centrelat."\n";
          echo "lon -->".$centrelon."\n";
          $sql3 = "SELECT Per_Id,Start,End
                   FROM Period
                   WHERE Per_Id IN
                  (SELECT Period_Id FROM Search
                   WHERE Src_Id='$ref')
                   ";
          $result = $conn->query($sql3);
          var_dump($result);
          if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
              $per_Id = $row["Per_Id"];
              $start = $row["Start"];
              $end = $row["End"];
            }
            echo "start".$start."\n";
            echo "end".$end."\n";
            $sql4 = "SELECT Aval_Id, Byke_Id
                     FROM Availability
                     WHERE Per_Id IN
                     (SELECT Per_Id FROM Period
                     WHERE start <= '$start'
                     AND End >= '$end')";
            $result3 = $conn->query($sql4);
            if ($result3->num_rows > 0){
              $k = 0;
              $markbike = array();
              include('distance.php');
              while($row = $result3->fetch_assoc()) {
                $av_Id = $row["Aval_Id"];
                $bike_Id = $row["Byke_Id"];
                echo "aval id --> ".$row["Aval_Id"]."\n";
                echo "aval id --> ".$av_Id."\n";
                $sql5 = "SELECT Lat, Lon
                         FROM GeoPosition
                         WHERE Geo_Id IN
                         (SELECT Geo_Id FROM IsWhere
                         WHERE Aval_Id='$av_Id')
                         ";
                $result4 = $conn->query($sql5);
                if ($result4->num_rows > 0){
                  while($row = $result4->fetch_assoc()) {
                    // calc distance
                    echo "bike  lat --> ".$row["Lat"]."\n";
                    echo "bike  lon --> ".$row["Lon"]."\n";
                    $bikelat = $row["Lat"];
                    $bikelon = $row["Lon"];
                    $dist = Distance($bikelat,
                                     $bikelon,
                                     $centrelat,
                                     $centrelon,
                                     6371);
                    echo "distance -->". $dist."\n";
                    if ($dist<6 && $k<5){
                      $markbike[$k] = array(
                                 $av_Id,
                                 $bikelat,
                                 $bikelon
                                 );
                      $k++;
                    }
                  }
                }
              }
            }
          }
        }
    //@@
        //use $option
        echo "\n you chose\n".$option."\n";
        echo "aval Id -->".$markbike[$option][0]."\n";
        echo "lat bike-->".$markbike[$option][1]."\n";
        echo "lon bike-->".$markbike[$option][2]."\n";
        echo "dist ----->".$dist."\n";
        echo "user id--->".$User_Id."\n";
        echo "per Id---->".$per_Id."\n";
        echo "start ---->".$start."\n";
        echo "end   ---->".$end."\n";
        echo "bike id--->".$bike_Id."\n";
        
      }
      $aval_Id = $markbike[$option][0];
      echo "\n".$aval_Id."\n";
      $sql4 = "INSERT INTO PickUp (User_Id, Per_Id,Byke_Id)
               VALUES ('$User_Id', '$per_Id', '$bike_Id')";
      if ($conn->query($sql4) === TRUE){
        $sql5 = "DELETE FROM IsWhere
                 WHERE Aval_Id = '$aval_Id'";
        if ($conn->query($sql5) === TRUE){
          $sql6 = "DELETE FROM Availability
                   WHERE Aval_Id = '$aval_Id'";
          if ($conn->query($sql6) === TRUE){
            echo " Pick up registred!! ";
            $answer = "pick up registred";
          }
        }
      }

    // parse command

    // register in data base 

    // provide  QR CODE

    }
  }
  else   // step 0 no step previously set
  {
    echo "Step 0 of task 11! \n";
    echo "user Id --> ". $User_Id;

    // $answer = "Where would you like a bike?\n".
    //          "Please use the locate  button\n".
    //          " or write an address ";
    $latitude = 0;
    $longitude = 0;
    $sql0 = "INSERT INTO GeoPosition (Lat,Lon)
            VALUES ($latitude,$longitude)";
    if ($conn->query($sql0) === TRUE){
      $geo_Id = $conn->insert_id;
      $sql1 = "INSERT INTO Period (Start, End)
             VALUES (NOW(),NOW())";
      if ($conn->query($sql1) === TRUE){
        $per_Id = $conn->insert_id;
        $sql2 = "INSERT INTO Search (User_Id,Geo_Id,Period_Id)
                VALUES ($User_Id,$geo_Id,$per_Id)";
        if ($conn->query($sql2) === TRUE){
          $ref = $conn->insert_id;
          $sql3 = "INSERT INTO State (Task, Step, ref)
                   VALUES (11, 1, $ref)";
          if ($conn->query($sql3) === TRUE){
            $stateid = $conn->insert_id;
            $err = "<br> able  to add the new state <br>";
            $sql4 = "INSERT INTO Todo (State_Id, User_Id)
                    VALUES ($stateid, '$User_Id')";
            if ($conn->query($sql4) === TRUE){
              echo " get loc on 11 step 0 ";
              $answer = "GetLoc";
            }
          }
        }
      }
    }
  }
  return $answer;
}
?>


