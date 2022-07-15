<?php
header('Content-Type: application/json');
$data = $_POST;

class Colors {
    public $body;
    public $text;

    function __construct($body, $text)
    {
        $this->body = $body;
        $this->text = $text;
    }
}

class ConfigObj {

    public $library_id;
    public $name;
    public $colors;
    public $rotation_speed;
    public $font;
    public $logo;
    public $alert;
    public $show_qr_code;
    public $event_type_ids;
    public $start_date;
    public $end_date;
    public $locations;
    public $age_groups;
    public $is_ongoing;
    public $only_featured_events;

    function __construct($data)
    {
        $this->library_id = $data['library_id'];
        $this->name = $data['name'];
        $this->colors = $this->make_colors($data);
        $this->rotation_speed = $data['rotation_speed'];
        $this->font = $data['font'];
        $this->logo = $data['logo'];
        $this->alert = $data['alert'];
        $this->show_qr_code = filter_var($data['show_qr_codes'], FILTER_VALIDATE_BOOLEAN);
        $this->event_type_ids = $this->empty_array_check($data['event_type_ids']);
        $this->start_date = $data['start_date'];
        $this->end_date = $data['end_date'];
        $this->locations = $this->empty_array_check($data['locations']);
        $this->age_groups = $this->empty_array_check($data['age_type']);
        $this->is_ongoing = filter_var($data['ongoing'], FILTER_VALIDATE_BOOLEAN);
        $this->only_featured_events = filter_var($data['only_featured_events'], FILTER_VALIDATE_BOOLEAN);
    }

    protected function empty_array_check($array)
    {
        if(is_array($array))
        {
            if(!empty($array))
            {
                return $array;
            }

            return [];
        }
        else
        {
            return [];
        }
    }


    protected function make_colors($data)
    {
        $colors_array = [];

        for($i = 0; $i < count($data['body_colors']); $i++)
        {
            array_push($colors_array, new Colors($data['body_colors'][$i], $data['text_colors'][$i]));
        }

        return $colors_array;

    }

}

$config_obj = new ConfigObj($data);


// echo "<pre>";
// var_dump($config_obj);
// echo "</pre>";

$json_data = json_encode($config_obj,JSON_PRETTY_PRINT);

print_r($json_data);

$bytes = file_put_contents("main.json", $json_data); 

?>