<?php

for ($i=6;$i<48;$i++){
$h = intval($i / 2);
$m =($i % 2) *30;
if ($i<20)
  $str = "  /";
else
  $str = " /";
echo $str.$h.":".$m;
if (($i+1)%6==0) echo "\n";
}

$date = strtotime('Today');
for ($i=0;$i<5;$i++){
echo "/".date('M_d', $date)." ";
if (($i+1)%3==0) echo "\n";
$date = strtotime(' + 1 day', $date);

}
?>
