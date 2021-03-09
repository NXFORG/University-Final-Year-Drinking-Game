<?php
 $playername = $_POST['playername'];
 $playername = $_POST['funnelsoff'];

$conn = new mysqli('localhost','chris','test212','Drinks');
if($conn->connect_error){
    die('connection failed: '.$conn->connect_error);
  }else{
  $sql = $conn->prepare("INSERT INTO Players(Player_Name, Player_Type) VALUES(?,?)");
  $sql->bind_param("ss",$_POST['playername'],$_POST['funnelsoff']);
  $success = $sql->execute();
  if($success){
    echo "success";
  }else{
    echo "Failed";
  }
  $sql->close();
  $conn->close();
}
?>
