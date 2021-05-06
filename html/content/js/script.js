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
  	sockSend(msg);
}

function play()
{
	var msg = {
	    method: "crearPartida",
	    data: "TEST",
	    id:   1,
	    date: Date.now()
  	};
  	
	//window.location = "play";
	$.ajax(
	{
		type:"Post",
		url: "play",
		cache: false,
		data:{},
		success: function(response)
		{
    		$("#content").html(response);
  			//document.getElementById("btnStart").disabled = false;
  		},
  		error: function(xhr)
  		{
  			console.log("error");
  		}
	});
	sockSend(msg);
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
    		$("#contentPartidaFile").html(response);
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
  	console.log("Entra determinarTorn");
	sockSend(msg);
}

function printarTorn()
{
	var msg = {
	    method: "printarTorns",
	    data: "test",
	    id:   1,
	    date: Date.now()
  	};
  	console.log("Entra printarTorn");
	sockSend(msg);
}

function test()
{
	document.getElementById("btnStart").disabled = false;
}

function sockSend(msg)
{
	try 
	{ 
		socket.send(JSON.stringify(msg)); 
	} 
	catch(ex) 
	{ 
		console.log(ex); 
	}
}