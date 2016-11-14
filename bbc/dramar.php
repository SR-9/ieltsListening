<?php
require "simple_html_dom.php";

$url= "http://www.bbc.co.uk/learningenglish/english/features/english-at-university";

$html= file_get_html($url);
$first= $html->find("div[class=widget widget-bbcle-coursecontentlist widget-bbcle-coursecontentlist-featured widget-progress-enabled]",0);

 $mang=  array();
$item= getItem($first);
array_push($mang, $item);
$itemcollection= $html->find("li[class=course-content-item active]");

foreach ($itemcollection as $key ) {
  $i= getItem($key);

  array_push($mang, $i);
}



$result=json_encode($mang);
echo "$result";
$myfile=fopen('university.json', 'w') or die('unable open file');
fwrite($myfile, $result);
fclose($myfile);



 function getItem($tt)
{
  $base_url="http://www.bbc.co.uk";
$tt->find("div.text",0);
$title=   $tt->find("h2",0)->find("a",0)->plaintext;
$link =$base_url. $tt->find("a",0)->href;
$date= $tt->find("div.text",0)->find("div.details",0)->find("h3",0)->plaintext;
$des= $tt->find("div.text",0)->find("div.details",0)->find("p",0)->plaintext;
//$date= str_replace('\t', '', $date);
$img= $tt->find("img",0)->src;
$item=new bbcItem($title, $date, $des, $link, $img);
return $item;
}





class bbcItem
{
   var $title;
   var $date;
   var $des;
   var $link;
   var $img;
   function bbcItem($title,$date,$des,$link,$img)
   {
     $this->title=$title;

     $this->date=$date;
     $this->des=$des;
     $this->link=$link;
     $this->img=$img;

   }

}

 ?>
