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
  <link rel="stylesheet" href="setup.css">
 </head>
 <body>
   <h1>Drinks at Darlington</h1>
   <h4>Drink responsibly :)</h4>
   <form id="playeradd" action="addplayers.php" method="post">
     <div id="form-container">
      <h5>Enter each player's name then click 'Add'. Once everyone has been added, click 'Next' to start</h3>
      <br>
      <label class="form-label">Player names</label>
      <input type="text" id="players" name="players">
      <br>
      <br>
      <label class="form-label">Disable funnel and drink-downing tasks for this player?</label>
      <select id="funnelTasks" name="funnelTasks">
        <option value="No">No</option>
        <option value="Yes">Yes</option>
      </select>
      <br>
      <button type="submit" class="btn btn-primary" name="playersadded">Add</button>
      <p id="successmsg">Player added</p>
      <a href="play.php">Next</a>
    </div>
   </form>
   <script>
     $(document).ready(function() {
       $("#successmsg").hide();
     });
     $("#playeradd").submit(function(event) {
       event.preventDefault(); /*Stops redirect*/
       var $form = $(this),
       url = $form.attr('action');
       var posting = $.post(url, {
         playername: $('#players').val(),
         funnelsoff: $('#funnelTasks').val()
       });
       posting.done(function(data) {
         $("#successmsg").show("slow").delay(1000).hide("slow");
       });
       posting.fail(function() {
         alert("Error: Player not added");
       });
     });
   </script>
 </body>
</html>
