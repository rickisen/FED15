<!DOCTYPE html>
<?php 
  // set up the needed superglobals and handle POST messages ==============================
  session_start();
  // Actions to take depending on which POST message we get 
  if (isset($_POST['newTodo'])) {
    // if we get a new "to do" item
    // add it to the persistent array
    $_SESSION['TodoListAr'][] =  $_POST['newTodo'];
  }
  elseif ( isset($_POST['remove']) ) {
    // if we get a remove message 
    // remove an item from the persistent array
    $_SESSION['TodoListAr'] = removeItemFromArr($_POST['remove'], $_SESSION['TodoListAr']);
  }   
  
  // load the now potentially updated persistent array
  // into a local array, or create a fresh array 
  // if there is no session array.
  if (isset($_SESSION['TodoListAr']))
    $TodoListAr = $_SESSION['TodoListAr'];
  else 
    $TodoListAr = array();
?>

<html>
<head>
  <meta charset="UTF8" name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
  <link type="text/css" rel="stylesheet" href="stylesheet.css">

  <?php // change bg-color depending on day
    echo '
      <style>
        body{background-color:'.dailyColor().';}
      </style>';
  ?>
</head>
<body>
  <div class="container wrapper mainWindow" >
   <div class="row">

    <div class="col-xs-12 headLine" >
      <h1>TODO-List</h1>
    </div>

    <!-- input forms to supply "to do" items --> 
    <div class="col-xs-12 inputForm" >
        <form method="POST">
          <div class="input-group col-xs-12">
            <input type="text" name="newTodo" class="form-control" 
              placeholder="Write something you aim to get done!">
            <span class="input-group-btn">
              <input value="Submit" type="submit" class="btn btn-default">
            </span>
          </div>
          <div class="input-group col-xs-12 advancedOptions">
            <label class="form-control wide"> Deadline: </label>
            <select name="weekDay" class="wide form-control">
                <option value="Tod">Today</option>
                <option value="Mon">Monday</option>
                <option value="Tue">Tueday</option>
                <option value="Wed">Wednesday</option>
                <option value="Thurs">Thursday</option>
                <option value="Fri">Friday</option>
                <option value="Satur">Saturday</option>
                <option value="Sun">Sunday</option>
            </select>
            <select name="hour" class="smaller form-control">
                <option value="9" >09</option>
                <option value="8" >08</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
                <option value="15">15</option>
                <option value="16">16</option>
                <option value="17">17</option>
                <option value="18" selected="selected">18</option>
            </select>
            <select name="minute" class="smaller form-control">
                <option value="00">00</option>
                <option value="15">15</option>
                <option value="30">30</option>
                <option value="45">45</option>
            </select>
            <label for="important" class=" wider form-control"> 
              <input type="checkbox" id="important" value="TRUE"> Important!  
            </label>
          </div>
        </form>
    </div>

    <div class="col-xs-12 info" >
      <div class="infoz">
      <?php // Show hours left on the workday and print how many objects are in the list
        if (hToHome() > 0 ) {
          echo '<p> It is now '.hToHome().' hours left until 
            you can go home and you have '.count($TodoListAr).' thing(s) left to do.</p>';
        } else {
          echo '<p> The workday is officially over, but you 
            still have '.count($TodoListAr).' things left to do!</p>';
        }
      ?>
      </div>
    </div>

    <div class="col-xs-12 toDoItems" >
      <?php // generate the list of items to do 
        echo formsFromArr($TodoListAr);
      ?>
    </div>

   </div>
  </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>

<?php 
  // functions to be used above ====================================

  // copy all objects in an array into a new array
  // except an unwanted object (index or label)
  function removeItemFromArr($unwantedLabel, $Arr){
    // the new array that will soon hold one less item
    $ret = array(); 

    // go through every item in the 
    // original array, and only copy the
    // items that do not have the unwanted label
    foreach ($Arr as $label => $value) {
     if ($label != $unwantedLabel) 
       $ret[]= $value;
    }
    return $ret;
  }

  // Convert day to color
  function dailyColor(){
    switch (date("D")) {
      case "Mon" :
        $color= "grey";
      break;
      case "Tue" :
        $color= "lightblue";
      break;
      case "Wed" :
        $color= "maroon";
      break;
      case "Thu" :
        $color= "orange";
      break;
      case "Fri" :
        $color= "yellow";
      break;
      case "Sat" :
        $color= "blue";
      break;
      case "Sun" :
        $color= "red";
      break;
      default:
        $color= "white";
    }
    return $color;
  }

  // hours left until 17:00
  function hToHome(){
    $currentTime = time();
    $homeTime = mktime(17,00,00);
    $hoursLeft = ceil( ($homeTime - $currentTime)/60/60 );

    return $hoursLeft;
  }

  // generate forms from an array
  function formsFromArr($Arr){
    $ret=""; // object to hold what we will return
    for ($i = 0 ; $i != count($Arr); ++$i){
      // Add the next form to all the others
      $ret = $ret.' 
        <form method="POST" class="">
          <input name="remove" value="'.$i.'" type="hidden">
          <input type="submit" value="X" >
          '.$Arr[$i].'
        </form>';
    }
    return $ret;
  }
?>


