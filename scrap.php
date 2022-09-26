<?php

// author : mfadly.n@gmail.com

execute('https://www.WPwebsite.com/wp-json/wp/v2/posts/?_fields=author,id,title,date,content&per_page=10&page=1','5','WPwebsite.com');

function execute($link,$idcat,$desc)
{

$username = 'yourapiusername'; // your wp username
$password = 'yourapipassword';
$rest_api_url = "https://yourWPsite.com/wp-json/wp/v2/posts";
$json = file_get_contents($link);
$data = json_decode($json,true);
$i=0;$count=0;

foreach($data as $item) { 


if (date('Y-m-d') == substr($data[$i]['date'],0,10)) 
{
$count=$count+1;

$judul = $data[$i]['title']['rendered'];
$tanggal = substr($data[$i]['date'],0,10).'<br>';
$konten = $data[$i]['content']['rendered'];
$data_string = json_encode([
    'title'    => $judul,
    'content'  => $konten,
    'status'   => 'publish',
    'categories'=> $idcat,
    'featured_image_url'  => '',
]);

//echo date('Y-m-d')." | ".$judul;
//echo substr($data[$i]['date'],0,10)."<br>";


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $rest_api_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string),
    'Authorization: Basic ' . base64_encode($username . ':' . $password),
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
}

$i=$i+1; if ($i == 20) {   break;  }

}

echo "service succesfully run <b>".$count."</b> data on  <b>".$desc."</b> already posted<br>";
}

?>
