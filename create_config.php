<?php
$data = $_POST;


// echo "<pre>";
// var_dump($data['colors_object']);
// echo "</pre>";

// $data['colors_object'] = explode("|", $data['colors_object']);
// foreach($data['colors_object'] as $colors)
// {
//     $colors = json_decode($colors);
//     echo "<pre>";
//     var_dump($colors);
//     echo "</pre>";

// }

echo "<pre>";
var_dump($data);
echo "</pre>";

$json_data = json_encode($data,JSON_UNESCAPED_SLASHES);

echo "<pre>";
var_dump($json_data);
echo "</pre>";

$bytes = file_put_contents("config_file.json", $json_data); 
echo "The number of bytes written are $bytes.";
?>