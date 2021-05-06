var socket;

function init() 
{
	var host = "ws://192.168.1.100:9000"; // SERVER
	try 
	{
		socket = new WebSocket(host);
		console.log('WebSocket - status '+ socket.readyState);
		socket.onopen    = function(msg) { 
							   console.log("Entra socket.OnOpen");
						   };
		socket.onmessage = function(msg) {
						   		//$('#content').html(msg.data); 
							   	console.log("Recieved: " + msg.data);
							   	var res = JSON.parse(msg.data); 
							   	if (res.status=='ok')
							   	{
					   				var method = res.method;
								   	switch (method) 
								   	{
									  	case "determinarTorn":
									    	$('#torn').html(res.res);
										    break;
									  	case "altresJugadors":
									  		$('#jsonResponse').html("L'altre jugador ha tret un " + res.res);								    
										    break;
									  	default:								    
										    break;
										}
							   	}
							   	else
							   	{
							   		$('#content').html("ERROR");
								   	console.log("Recieved: " + msg.data);
							   	}							   							   
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

function send()
{

	var msg = {
	    type: "message",
	    text: "TEST",
	    id:   1,
	    date: Date.now()
  	};

	try 
	{ 
		socket.send(JSON.stringify(msg)); 
	} 
	catch(ex) { 
		console.log(ex); 
	}
}

function quit()
{
	if (socket != null) {
		socket.close();
		socket=null;
	}
}

function reconnect() {
	quit();
	init();
}