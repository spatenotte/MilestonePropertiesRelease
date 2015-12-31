<?php include_once'functions.php';
  require_once("WalkScore.php");
  

$temp = get_lat_long('1119 208th Ave S, Seattle, WA');
echo $temp['lat'];
echo $temp['long'];
  $w = new WalkScore('dbd8b3f251a2ea4b4a6be60beae80642');
  // WalkScore example
  // Example data from http://www.walkscore.com/professional/api.php
  $options = array(
    'address' => '1119 208th Ave S, Seattle, WA',
    'lat'=>47.416022,
    'lon'=>-122.320273,
  );
  var_dump($options);
  printf("\n");
  //printf("WalkScore for %s:\n", $options['address']);
  //$score = $w->WalkScore($options)->walkscore;
  //var_dump($w);
    print_r($w->WalkScore($options));
?>