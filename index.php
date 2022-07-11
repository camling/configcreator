<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evanced Calendar PDF Creator by Chris Amling</title>
</head>
<body>
<form method="POST" action="first.php">
        
            <div class="input_elements">
                <fieldset>
                    <label for="maincolor">Enter your library id</label>
                    <input type="text" id="library_id" name="library_id" value=""/>
                </fieldset>
                <fieldset>
                    <label for="maincolor">Enter your library name</label>
                    <input type="text" id="library_name" name="library_name" value=""/>
                </fieldset>
            </div>
        <input type="submit" name="create" id="submit_library" value="Start"/>
</form>

<script>

let submit_library = document.getElementById("submit_library");
let library_id = document.getElementById("library_id");
let library_name = document.getElementById("library_name");

library_id.value = localStorage.getItem("library_id");
library_name.value = localStorage.getItem("library_name");

submit_library.addEventListener("click", ()=> {
    localStorage.setItem("library_id", library_id.value);
    localStorage.setItem("library_name",library_name.value);
});


</script>
</body>
</html>



