<?php
//$weather_url = 'http://www.meteoalarm.eu/documents/rss/de/DE006.rss';
if(isset($_GET['country'])) {
  $country = $_GET['country'];
} else {
  $country = 'nl';
}
$weather_url = 'http://www.meteoalarm.eu/documents/rss/' . $country . '.rss';

$xml = simplexml_load_file($weather_url);

$items = array();

foreach($xml->channel->item as $id => $item) {
  $channel_item = array();
  $channel_item['xml'] = $item;
  $channel_item['content'] = (string) $item->description;
  $channel_item['content']  = explode('><',str_replace("&nbsp;", "", $channel_item['content']));
  
  foreach($channel_item['content'] as $content_id => $content_item) {
    $content_item= strip_html($content_item);
    $content_item_items = explode(" ", $content_item);

    $channel_item['content'][$content_id] = $content_item_items;
  }
  
  $region['name'] = (string) $item->title;
  $region['conditions'] = strip_codes($channel_item['content'] );
  $items[] = $region;
}

function strip_html($content) {
    $content= '<' . $content . '>';
    $content= str_replace("<<", "<", $content);
    $content= str_replace(">>", ">", $content);
    $content= str_replace("<", " ", $content);
    $content= str_replace(">", " ", $content);
  return $content;
}

function strip_codes($content) {
  $day = "";
  $items = [];
  foreach($content as $item) {
      foreach($item as $tag) {
          if($tag == "Today") {
            $day = "today";
            $items[$day] = [];
          } elseif($tag == "Tomorrow") {
            $day = "tomorrow";
            $items[$day] = [];
          } elseif(substr( $tag, 0, 5 ) === 'src="') {
            $items[$day][] = strip_data_wflag($tag);
          }
      }
  }
  return $items['today'];
}

function strip_html_src($content) {
   $content= str_replace('src=', '', $content);
  $content= str_replace('"', '', $content);
   return $content;
}

function strip_data_wflag($content) {
  $content= strip_html_src($content);
  $content= str_replace('http://web.meteoalarm.eu/documents/rss/wflag-', '', $content);
  $content= str_replace('.jpg', '', $content);
  $content= explode('-',$content);
  foreach($content as $id => $content_item) {
    $content[$id] = substr($content_item, 1, 2);
  }
 
  /*
  $grades[0] = '';
  $grades[1] = 'Groen';
  $grades[2] = 'Geel';
  $grades[3] = 'Oranje';
  $grades[4] = 'Rood';

  $types[0] = '';
  $types[1] = 'Windstoten en hozen';
  $types[2] = 'Sneeuw en gladheid';
  $types[3] = 'Onweersbuien';
  $types[4] = 'Slecht zicht';
  $types[5] = 'Hitte';
  $types[6] = 'Koude';
  $types[7] = 'Kustbedreiging';
  $types[8] = 'Bos- en heidebranden';
  $types[9] = 'Lawines';
  $types[10] = 'Regen';
  $types[11] = 'Onbekend';
  $types[12] = 'Overstroming';
  $types[13] = 'Regenoverstroming';
  */

  
  //$result['grade'] = strtolower($grades[$content[0]]);
  $result['grade'] = $content[1];
  if($result['grade'] != 1) {
    //$result['type'] = strtolower($types[$content[1]]);
    $result['type'] = $content[2];
  }
  return $result;
}


unset($items[0]);

if(isset($_GET['region']) && $items[$_GET['region']]) {
  $result = $items[$_GET['region']];
} else {
  $result = $items;
}

//print_r($result);
header('Content-Type: application/json');
echo json_encode($result);

//echo "\n";
//echo $code[1];
/*
1. Windstoten en hozen
2. Sneeuw en gladheid
3. Onweersbuien
4. Slecht zicht
5. Hitte
6. Koude
7. Kustbedreiging
8. Bos- en heidebranden
9. Lawines
10.Regen
11.Overstroming
12.Regenoverstroming
*/
?>