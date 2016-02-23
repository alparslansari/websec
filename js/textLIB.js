    function draw() {
  var canvas = document.getElementById('gameBoard');
  if (canvas.getContext){
     var ctx = canvas.getContext('2d');

    ctx.beginPath();
    ctx.arc(135,110,40,0,Math.PI*2,true); // Outer circle
    ctx.moveTo(110,75);
    ctx.moveTo(120,100);
    ctx.arc(120,100,5,0,Math.PI*2,true);  // Left eye
    ctx.moveTo(150,100);
     ctx.arc(150,100,5,0,Math.PI*2,true);  // Right eye
    ctx.moveTo(155,135);
    ctx.arc(135,135,20,0,Math.PI,true);  // Mouth (clockwise)
    ctx.stroke();
  }
}

    function drawRightArm() {
  var canvas = document.getElementById('gameBoard');
  if (canvas.getContext){
     var ctx = canvas.getContext('2d');
    ctx.beginPath();
    ctx.moveTo(140,150);
    ctx.lineTo(200,180);
    ctx.lineWidth = 5;
    ctx.stroke();
  }
}

    function drawLeftArm() {
  var canvas = document.getElementById('gameBoard');
  if (canvas.getContext){
     var ctx = canvas.getContext('2d');
    ctx.beginPath();
    ctx.moveTo(136,150);
    ctx.lineTo(85,180);
    ctx.lineWidth = 5;
    ctx.stroke();
  }
}

    function drawRightLeg() {
  var canvas = document.getElementById('gameBoard');
  if (canvas.getContext){
     var ctx = canvas.getContext('2d');
    ctx.beginPath();
    ctx.moveTo(136,235);
    ctx.lineTo(195,280);
    ctx.lineWidth = 5;
    ctx.stroke();
  }
}



    function drawLeftLeg() {
  var canvas = document.getElementById('gameBoard');
  if (canvas.getContext){
     var ctx = canvas.getContext('2d');
    ctx.beginPath();
    ctx.moveTo(136,235);
    ctx.lineTo(100,200);
    ctx.lineWidth = 5;
    ctx.stroke();
  }
}

    function putText(text, color,attempt) {
  var canvas = document.getElementById('gameBoard');
  if (canvas.getContext){
       var ctx = canvas.getContext("2d");
      ctx.font = "15px Arial";
      if (color==1)
        ctx.fillStyle = 'green';
        else
      ctx.fillStyle = 'purple';
      if (attempt <= 20)
      {
        ctx.fillText(text,200,20*attempt);
      }
      else
      {
        ctx.fillText("|"+text,270,20*(attempt-20));
      }
      
      ctx.fillStyle = 'black';
  }
}


function updateGameBoard(hang) {
  var c=document.getElementById("gameBoard");
  var ctx=c.getContext("2d");
  switch(hang) {
      case 0:
          break;
      case 1:
        ctx.fillRect(0,300,200,9); // taban
        break;
      case 2:
        ctx.fillRect(15,10,9,290); // direk
        break;
      case 3:
        ctx.fillRect(15,10,120,9); // tavan
        break;
      case 4:
        ctx.fillRect(135,10,3,60); // kafa tutan
        draw(); // kafa
        break;
      case 5:
        ctx.fillRect(135,150,6,90); // govde
        break;
      case 6:
        drawRightArm();
        break;
      case 7:
        drawRightLeg();
        break;
      case 8:
        drawLeftArm();
        break;
      case 9:
        drawLeftLeg();
        //$("#gameBoard").width("300");
        //$("#gameBoard").height("320");
        $("#gameBoard").css("background-color","red");
        $("#myCanvas").css("background-color","red");
        // LOCK BOARD - Failed
        $("#wordGuess").prop('disabled', true);
        $('#sbtGuess').prop('disabled', true);
        break;
  } 
}


$( document ).ready(function() {
    console.log( "The game is ready!" );
    var attempt = 0;
    var hang = 0;
    var score = 0;
    var incData;
    var userSolution = new Set();
    var userErr = new Set();
    
    $("#wordGuess").val("");
    $("#wordGuess").prop('disabled', false);
    
    $.get( "game.php", function( data ) {
       //alert( "Data Loaded: " + data );
       incData = data.subRacks;
       
       var canvas = document.getElementById("myCanvas");
       var ctx = canvas.getContext("2d");
      ctx.font = "30px Arial";
      ctx.fillText(data.rack,10,50);

       //$("#rackID").html(data.rack)
    });
    
    $('#resetGame').click(function() {
        $("#wordGuess").val("");
    location.reload();
    });
    

    
    $('#sbtGuess').click(function() {
        
    if(userSolution.size < incData.length)
    {
        var guess = $("#wordGuess").val();
        var control = false;
        $.each(incData, function(i,obj) {
           if (obj === guess.toUpperCase()) {
             var hasIT = userSolution.has(obj);
             if(!hasIT)
             {
               userSolution.add(obj);
               score = score + (guess.length - 1) * 10;
               if(attempt > 40)
               {
                 // LOCK BOARD - Survived
               }
               attempt = attempt + 1;
               putText(guess,1,attempt);
               control = true;
               return false;
             }
             else
             {
               control = true;
               return false;
             }
             
               
           }
        });
    
        if(!control && guess!="")
        {
          var hasIT = userErr.has(guess);
             if(!hasIT)
             {
                userErr.add(guess);
                attempt = attempt + 1;
                putText(guess,0,attempt);
                hang = hang + 1;
                updateGameBoard(hang);
             }
        }
       
        $("#attemptID").html(attempt);
        $("#scoreID").html(score);
        $("#wordGuess").val("");
    } else if (userSolution.size == incData.length)
    {
        // Draw win board!
        alert("Meh, you won this time but...You cheated are not you!");
    }
    
        
        
    });


});