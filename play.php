<?php
  include_once 'drinkdar.php';
?>
<!DOCTYPE html>
<html>
 <head>
  <title>Drinks at Darlington</title>
  <meta charset = "UTF 8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="play.css">
 </head>
 <body>
  <h1>Drinks at Darlington</h1>
  <!--<form id="startgame" action="" method="post">
    <div id="form-container">
     <p id="placeholdertext">Click 'Go' to start the game. When you would like to stop, click 'Finish'</p>
     <input type="submit" name="gameready" value="Ok" />
    </div>
  </form>-->
  <h3 id="placeholdertext">Click 'Go' to start the game. When you would like to stop, click 'Finish'</h3>
  <form id="play" action="" method="post">
    <div id="form-container">
<?php
 if(isset($_POST['getTask'])){
  $playername = " ";
  $playertask = [];
  $maxplaynum = " ";
  $firstplayer = [];

  //$selectplayer = mysqli_query($conn,"SELECT Player_Name, Player_Type FROM Players ORDER BY RAND() LIMIT 1");
  $maxplayers = mysqli_query($conn,"SELECT MAX(Player_ID) as a FROM Players");
  while($max = mysqli_fetch_array($maxplayers)){
    $maxplaynum = $max['a'];
  }

  $sessionid = mysqli_query($conn,"SELECT Session_ID FROM Session LIMIT 1");
  while($ses = mysqli_fetch_array($sessionid)){
    $sesnum = $ses['Session_ID'];
    if($sesnum <= $maxplaynum){
    $selectplayer = mysqli_query($conn,"SELECT Player_Name, Player_Type FROM Players WHERE Player_ID = '$sesnum'");
    $sessionincrement = mysqli_query($conn,"UPDATE Session SET Session_ID = Session_ID + 1");
    $conn->query($sessionincrement);
    $firstplayer = $selectplayer;
  } else {
    $sessionset = mysqli_query($conn,"UPDATE Session SET Session_ID = 1");
    $conn->query($sessionset);
    $selectplayer = mysqli_query($conn,"SELECT Session_Round as Player_Name, Session_NoTask as Player_Type FROM Session WHERE Session_ID = 1");
    $firstplayer = $selectplayer;
  }
  }

  while($row = mysqli_fetch_array($firstplayer)){
    echo "<p id=\"chosenplayer\">";
    $playername = $row['Player_Name'] . " ";
    echo $playername . "</p><p id\"chosentask\"> ";
    if(in_array("Start a new round?",$row)){
      $selecttask = mysqli_query($conn,"SELECT Session_NoTask as Task_Desc, Session_NoSips as Task_Sips FROM Session WHERE Session_ID = 1");
      $playertask = $selecttask;
    } else {
     if(in_array("Yes",$row)){
       $selecttask = mysqli_query($conn,"SELECT Task_Desc, Task_Sips FROM Tasks WHERE Task_Desc NOT LIKE '%funnel' AND Task_Desc NOT LIKE '%down%' ORDER BY RAND() LIMIT 1");
       $playertask = $selecttask;
     } else {
       $selecttask = mysqli_query($conn,"SELECT Task_Desc, Task_Sips FROM Tasks ORDER BY RAND() LIMIT 1");
       $playertask = $selecttask;
     }
   }
 }

  while($row = mysqli_fetch_array($playertask)){
   if(in_array(NULL,$row)){
    $otherplayername = " ";
    $selectotherplayer = mysqli_query($conn,"SELECT Player_Name FROM Players WHERE NOT Player_Name ='$playername' ORDER BY RAND() LIMIT 1");
    while($playerrow = mysqli_fetch_array($selectotherplayer)){
      $name = $playerrow['Player_Name'] . " ";
      $otherplayername = $name;
    }
    if(in_array("PLAYER",$row)){
     $break = explode("PLAYER", $row['Task_Desc']);
     echo " " . implode((" " . $otherplayername . " "),$break[0]);
    } else {
     echo $row['Task_Desc'];
    }
   } else {
     $otherplayername = " ";
     $selectotherplayer = mysqli_query($conn,"SELECT Player_Name FROM Players WHERE NOT Player_Name ='$playername' ORDER BY RAND() LIMIT 1");
     while($playerrow = mysqli_fetch_array($selectotherplayer)){
       $name = $playerrow['Player_Name'] . " ";
       $otherplayername = $name;
     }
     $break[] = explode(" PLAYER", $row['Task_Desc']);
     echo " " . implode((" " . $otherplayername . " "),$break[0]) . " " . $row['Task_Sips'] . " " . " sips </p>" ;
    }
  }
  mysqli_close($conn);
 }
?>
<input type="submit" name="getTask" value="Go" />
</div>
  </form>
  <form action="" method="post">
    <div id="form-container2">
     <input type="submit" name="finishGame" value="Finish"/>
   </div>
 <?php
 if(isset($_POST['finishGame'])){
  $delete = mysqli_query($conn,"TRUNCATE TABLE Players");
  $conn->query($delete);
  mysqli_close($conn);
  header("Location: index.php");
 }
 ?>
</form>
 </body>
</html>
