var socket;

function init() 
{
	var host = "ws://37.15.36.40:9000"; // SERVER
	try 
	{
		socket = new WebSocket(host);
		console.log('WebSocket - status '+ socket.readyState);
		socket.onopen    = function(msg) { 
							   console.log("Entra socket.OnOpen");
						   };
		socket.onmessage = function(msg) { 
							   console.log("Recieved: " + msg.data);
						   };
		socket.onclose   = function(msg) { 
							   console.log("Entra socket.OnClose");
						   };
	}
	catch(ex)
	{ 
		console.log(ex); 
	}
}

function testPostClick()
{
	console.log("Entra al script");
	$.ajax(
	{
		type:"Post",
		//url:"test",
		url: "controller/testPostAjax_controller.php",
		cache: false,
		//data:{test: document.getElementById("testBox").value},
		data:{test: "TESTTEST"},
		success: function(response)
		{
    		$("#content").html(response);
    		console.log(response);
  		},
  		error: function(xhr)
  		{
  			console.log("error");
  		}
	});
}

function createGame()
{
	console.log("Entra createGame");
	$.ajax(
	{
		type:"Post",
		//url:"NewGame",
		url: "controller/newGame_controller.php",
		cache: false,
		data:{mp: document.getElementById("maxPlayers").value},
		success: function(response)
		{
    		$("#content").html(response);
    		console.log(response);
  		},
  		error: function(xhr)
  		{
  			console.log("error");
  		}
	});
}

function playGame()
{
	
	var msg = {
	    type: "message",
	    text: "TEST",
	    id:   1,
	    date: Date.now()
  	};

  	// Send the msg object as a JSON-formatted string.
  	//exampleSocket.send(JSON.stringify(msg));
  	console.log("Entra playGame");
	try 
	{ 
		socket.send(JSON.stringify(msg)); 
	} 
	catch(ex) { 
		console.log(ex); 
	}
}

function play()
{
	window.location = "controller/partida_controller.php";
}