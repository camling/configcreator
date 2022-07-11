<?php
$data = $_POST;

echo "<pre>";
var_dump($data);
echo "</pre>";

$json_data = json_encode($data);

echo "<pre>";
var_dump($json_data);
echo "</pre>";

$bytes = file_put_contents("config_file.json", $json_data); 
echo "The number of bytes written are $bytes.";
?>