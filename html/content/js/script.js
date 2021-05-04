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
	window.location = "play";
}

function tirarDau()
{
	console.log("Entra tirarDau()");
	var numDau ="";
	$.ajax(
	{
		type:"Post",
		url: "controller/dice_controller.php",
		cache: false,
		data:{},
		success: function(response)
		{
    		$("#content").html(response);
    		numDau = response.replace(/\D/g, '');
    		console.log(numDau);
    		determinarTorn(numDau);
    		//var element = document.getElementById("btnStart");
  			//element.classList.remove("btn-disable");
  			document.getElementById("btnStart").disabled = false;
  		},
  		error: function(xhr)
  		{
  			console.log("error");
  		}
	});
}

function determinarTorn(numeroDau)
{
	var msg = {
	    method: "determinarTorn",
	    data: numeroDau,
	    id:   1,
	    date: Date.now()
  	};

  	// Send the msg object as a JSON-formatted string.
  	//exampleSocket.send(JSON.stringify(msg));
  	console.log("Entra determinarTorn");
	try 
	{ 
		socket.send(JSON.stringify(msg)); 
	} 
	catch(ex) { 
		console.log(ex); 
	}
}

function test()
{
	document.getElementById("btnStart").disabled = false;
}