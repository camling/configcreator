<?php

$library_id = $_POST['library_id'];
$library_name = $_POST['library_name'];

$event_types_url = "https://".$library_id.".evanced.info/api/signup/eventtypes";
$locations_url = "https://".$library_id.".evanced.info/api/signup/locations";
$age_url = "https://".$library_id.".evanced.info/api/signup/agegroups";
$date = date('Y-m-d');
$year = date('Y');

function get_calendar_data($url)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    
    $headers = array(
       "Accept: application/xml",
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    
    $resp = curl_exec($curl);
    curl_close($curl);

    return $resp;
}



function events_checkboxes($event_types_url)
{
   $events_data = get_calendar_data($event_types_url);
   $xml = simplexml_load_string($events_data);

   if(count($xml) > 1)
    {
        foreach($xml as $event)
        {
            echo '<input type="checkbox" name="event_type_ids[]" value="'.$event->Id.'" id="'.$event->Id.'">';
            echo '<label for="'.$event->Id.'">'.$event->Name.'</label><br>';
        }
    } 
    else{
        echo "No Event Types available";
    }  

}

function locations_checkboxes($locations_url)
{
   $location_data = get_calendar_data($locations_url);
   $xml = simplexml_load_string($location_data);

   if(count($xml) > 1)
   {
    foreach($xml as $location)
    {
        echo '<input type="checkbox" name="locations[]" value="'.$location->LocationId.'" id="'.$location->LocationId.'">';
        echo '<label for="'.$location->LocationId.'">'.$location->Name.'</label><br>';
    }
    }
    else
    {
        echo "No Locations available";
    }

}

function age_checkboxes($age_url)
{
   $age_data = get_calendar_data($age_url);
   $xml = simplexml_load_string($age_data);
   if(count($xml) > 1)
   {
    foreach($xml as $age)
    {
     echo '<input type="checkbox" name="age_type[]" value="'.$age->Id.'" id="'.$age->Id.'">';
     echo '<label for="'.$age->Id.'">'.$age->Name.'</label><br>';
    }
   }
   else{
    echo "No Age Groups available";
   }


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Slideshow Config File</title>
</head>
<body>
    <h1>Create Slideshow Config File</h1>
    
    <div class="container">
        <form method="POST" action="create_config.php">
            <input type="hidden" id="library_id" name="library_id" value="<?php echo $library_id; ?>"/>
            <input type="hidden" id="library_name" name="name" value="<?php echo $library_name;?>"/>
            
            <div class="input_elements">

                <fieldset id="color_picker_group">
                    <label>Choose your Colors</label>
                    <br>
                    <label>Main Color : <input type="color" name="body_colors[]" value="#1d666c"/></label>
                    <label>Text Color : <input type="color" name="text_colors[]" value="black"/></label>
                    <br>
                    
                </fieldset>
                <button id="add_color">Add A Color</button>
                <button id="remove_color" disabled>Remove A Color</button>
                <fieldset>
                    <label for="rotation_speed">Enter slide rotation speed in seconds</label>
                    <input type="number" id="rotation_speed" name="rotation_speed" value="30" required/>
                </fieldset>
                <fieldset>
                    <label for="font">Enter fonts with a comma between each</label>
                    <input type="text" id="font" name="font" value="Arial"/>
                </fieldset>
                <fieldset>
                    <label for="alert">Enter an alert if desired</label>
                    <input type="text" id="alert" name="alert" value=""/>
                </fieldset>
                <fieldset>
                    <label for="start">Start date:</label>
                    <input type="date" id="start" name="start_date" value="<?php echo $date;?>"  min="<?php echo $year.'-01-01';?>" max="<?php echo $year.'-12-31'?>"/>
                        <label for="end">End date:</label>
                        <input type="date" id="end" name="end_date"
                        value="<?php echo $date;?>" 
                        min="<?php echo $year.'-01-01';?>" max="<?php echo $year.'-12-31'?>"/>
                        <input type="button" id="setday" name="setday" value="Day"/>
                        <input type="button" id="setweek" name="setweek" value="Week"/>
                        <input type="button" id="setnextweek" name="setnextweek" value="Next Week"/>
                        <input type="button" id="setmonth" name="setmonth" value="Month"/>
                </fieldset>
                <fieldset>  
                    <legend>Choose Event Types</legend>  
                    <?php events_checkboxes($event_types_url);?>    
                </fieldset>
                <fieldset>  
                    <legend>Choose Locations</legend>  
                    <?php locations_checkboxes($locations_url)?> 
                </fieldset>
                <fieldset>  
                    <legend>Choose Age Group</legend>  
                    <?php age_checkboxes($age_url)?> 
                </fieldset>
                <fieldset>  
                    <label for="featured">Show Only Featured Events</label>
                    <input type="checkbox" name="featured" id="featured"  class="form-control">
                </fieldset>
                <fieldset>  
                    <label for="logo">URL to logo image</label>
                    <input type="url" id="logo" name="logo">
                </fieldset>

                <fieldset>  
                    <label for="ongoing">Include Ongoing Events</label>
                    <input type="checkbox" name="ongoing" id="ongoing"  checked="true" class="form-control">
                </fieldset>
                <fieldset>  
                    <label for="qr_codes">Add QR codes</label>
                    <input type="checkbox" name="show_qr_codes" id="qr_codes"  checked="true" class="form-control">
                </fieldset>
                
            </div>
            <input type="submit" name="create" value="Create Config File"/>
        </form>
    </div>
    <script>

        function getLastDayOfMonth(d) {
            let lastday= new Date(d.getFullYear(), d.getMonth()+1, 0);
            return formatDate(lastday);
        }

        function getFirstDayOfMonth(d) {
            let firstday = new Date( d.getFullYear(),  d.getMonth(), 1);
            return formatDate(firstday);
        }

        function getMonday(d) {
            let day = d.getDay(),
            diff = d.getDate() - day + (day == 0 ? -6:1); // adjust when day is sunday
            let monday = new Date(d.setDate(diff));
            return formatDate(monday);
        }

        function getNextMonday(d) {
            let nextWeek = new Date(d. getFullYear(), d. getMonth(), d. getDate()+7);
            let day = nextWeek.getDay();
            console.log(nextWeek.getDate());
            diff = nextWeek.getDate() - day + (day == 0 ? -6:1); // adjust when day is sunday  24 - 2 + 1 = 23
            let monday = new Date(nextWeek.setDate(diff)); // set the date to 23
            return formatDate(monday);
        }

        function getSunday(d)
        {
            var lastday = d.getDate() - (d.getDay() - 1) + 6;
            let sunday = new Date(d.setDate(lastday));
            return formatDate(sunday);
        }

        function getNextSunday(d)
        {
            var lastday = d.getDate() - (d.getDay() - 1) + 6 + 7;
            let sunday = new Date(d.setDate(lastday));
            return formatDate(sunday);
        }

        function formatDate(day)
        {
            var dd = String(day.getDate()).padStart(2, '0');
            var mm = String(day.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = day.getFullYear();
            day = yyyy + '-' + mm + '-' + dd; // input needs this format.
            //day = mm + '/' + dd + '/' + yyyy;
            return day;
        }

        function setDates(input){
           
            var today = new Date();
            if(input.target.id === "setday")
            {
            
                today = formatDate(today);
                STARTDATE.value = today;
                ENDDATE.value = today;    
                
            }
            else if(input.target.id === "setweek")
            {
                STARTDATE.value = getMonday(today);
                ENDDATE.value = getSunday(today); 
            }
            else if(input.target.id === "setnextweek")
            {
                STARTDATE.value = getNextMonday(today);
                ENDDATE.value = getNextSunday(today); 
            }
            else if(input.target.id === "setmonth")
            {
                STARTDATE.value = getFirstDayOfMonth(today);
                ENDDATE.value =  getLastDayOfMonth(today); 
            }

        
           
        }

        function addColors()
        {
            let color_group = document.createElement("div");
            let label_element_body = document.createElement("label");
            let label_text_body = document.createTextNode(" Main Color: ");
            let label_element_text = document.createElement("label");
            let label_text_text = document.createTextNode(" Text Color: ");
            let input_element_body = document.createElement("input");
            let input_element_text = document.createElement("input");


            color_group.classList.add("color_group");
            input_element_body.type = "color";
            input_element_body.name = "body_colors[]";
            input_element_text.type = "color";
            input_element_text.name = "text_colors[]";

            label_element_body.appendChild(label_text_body);
            label_element_text.appendChild(label_text_text);
            label_element_body.appendChild(input_element_body);
            label_element_text.appendChild(input_element_text);
            color_group.appendChild(label_element_body);
            color_group.appendChild(label_element_text);
            COLORPICKERGROUP.appendChild(color_group);

            REMOVECOLORBTN.disabled = false;

        }

        function removeColors()
        {
            let color_group_array = COLORPICKERGROUP.querySelectorAll(".color_group");
            let last_color = color_group_array.length - 1;
        
            COLORPICKERGROUP.removeChild(COLORPICKERGROUP.lastChild);
            if(color_group_array.length == 1)
            {
                REMOVECOLORBTN.disabled = true;
            }
        }


        const STARTDATE = document.getElementById("start");
        const ENDDATE = document.getElementById("end");
        const SETDAY = document.getElementById("setday");
        const SETWEEK = document.getElementById("setweek");
        const SETNEXTWEEK = document.getElementById("setnextweek");
        const SETMONTH = document.getElementById("setmonth");
        const ADDCOLORBTN = document.getElementById("add_color");
        const REMOVECOLORBTN = document.getElementById("remove_color");
        const COLORPICKERGROUP = document.getElementById("color_picker_group");
   
        SETDAY.addEventListener("click", setDates);
        SETWEEK.addEventListener("click", setDates);
        SETNEXTWEEK.addEventListener("click", setDates);
        SETMONTH.addEventListener("click", setDates);
        ADDCOLORBTN.addEventListener("click", (e) => 
        {   e.preventDefault(); 
            addColors();  
        });

        REMOVECOLORBTN.addEventListener("click", (e) => 
        {   e.preventDefault(); 
            removeColors();  
        });



    </script>
</body>
</html>