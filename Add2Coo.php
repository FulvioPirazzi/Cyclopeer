<?php
function Add2Coo($address)  //solution from http://nazcalabs.com
    {
      $address = urlencode($address);
      $url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=".$address;
      $response = file_get_contents($url);
      $json = json_decode($response,true);
      $lat = $json['results'][0]['geometry']['location']['lat'];
      $lng = $json['results'][0]['geometry']['location']['lng'];
      $Address = $json['results'][0]['formatted_address'];

      return array($lat,$lng,$Address );
    }
?>
