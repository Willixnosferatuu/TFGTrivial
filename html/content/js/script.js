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

	$.ajax(
	{
		type:"Post",
		url: "play",
		cache: false,
		data:{},
		success: function(response)
		{
			document.getElementById("mnuButtons").style.display="none";
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
			document.getElementById("dauTorns").disabled = true;
			document.getElementById("dauTorns").style.display = "none";
    		$("#contentPartidaFile").html("<p>Has tret un :</p><p id='numeroDau'>"+response+"</p><p id='torn'></p>");
    		numDau = response.replace(/\D/g, '');
    		console.log(numDau);
    		determinarTorn(numDau);
    		//var element = document.getElementById("btnStart");
  			//element.classList.remove("btn-disable");			
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

function determinarTornReturned(msg)
{
	if (!msg.includes("Esperant")) 
	{
		$('#torn').html("L'ordre de jugadors es: " + msg);
		document.getElementById("btnStart").disabled = false;
	}
	else
	{
		$('#torn').html(msg);
	}
	
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

function startPartida()
{
	console.log("Entra startPartida()");
	var msg = {
	    method: "startPartida",
	    data: "test",
	    id:   1,
	    date: Date.now()
  	};
  	console.log("Partida Començada");
	sockSend(msg);
}

function showTablero()
{
	$.ajax(
	{
		type:"Post",
		url: "tauler",
		cache: false,
		data:{},
		success: function(response)
		{
    		$("#content").html(response);
  		},
  		error: function(xhr)
  		{
  			console.log("error");
  		}
	});
}

function goToTauler(primerTorn)
{
	$.ajax(
	{
		type:"Post",
		url: "tauler",
		cache: false,
		data:{},
		success: function(response)
		{
    		$("#content").html(response);
    		console.log(primerTorn);
    		if (primerTorn) 
    		{
    			$('#primerTorn').html("Espera! Es el torn del jugador " + primerTorn);
    			document.getElementById("btnDau").disabled = true;
    		}
    		else
    		{
    			$('#primerTorn').html("Es el teu torn, llença el dau!");
    			document.getElementById("btnDau").disabled = false;
    		}
    		
    		//goToQuestion();
  		},
  		error: function(xhr)
  		{
  			console.log("error");
  		}
	});
}

function avanzar()
{
	console.log("Entra Avanzar()");
	document.getElementById("btnDau").disabled = true;
	var numDau ="";
	$.ajax(
	{
		type:"Post",
		url: "controller/dice_controller.php",
		cache: false,
		data:{},
		success: function(response)
		{
			console.log("response Avanxar: " + response)
			var categoria = document.getElementById(response).value;
    		$("#primerTorn").html("<p>Has tret un : "+response+". Categoria: " + categoria + "</p><button id='btnQuestion' onclick='loadQuestion(\"" + categoria + "\")'>CarregarPregunta</button>");
    		numDau = response.replace(/\D/g, '');
    		console.log(numDau);
  		},
  		error: function(xhr)
  		{
  			console.log("error");
  		}
	});
}

function loadQuestion(categoria)
{
	document.getElementById("btnQuestion").disabled = true;
	console.log("Entra loadQuestion()");
	var msg = {
	    method: "pregunta",
	    data: categoria,
	    id:   1,
	    date: Date.now()
  	};
	sockSend(msg);
}

function goToQuestion(pregunta)
{
	$.ajax(
	{
		type:"Post",
		url: "pregunta",
		cache: false,
		data:{},
		success: function(response)
		{
    		$("#contentPregunta").html(response);
    		$("#preguntaText").html(pregunta.pregunta);
    		document.getElementById("resposta1").value = pregunta.respostes[0];
    		document.getElementById("resposta2").value = pregunta.respostes[1];
    		document.getElementById("resposta3").value = pregunta.respostes[2];
    		document.getElementById("resposta4").value = pregunta.respostes[3];
    		document.getElementsByName("resposta1")[0].textContent = pregunta.respostes[0];
    		document.getElementsByName("resposta2")[0].textContent = pregunta.respostes[1];
    		document.getElementsByName("resposta3")[0].textContent = pregunta.respostes[2];
    		document.getElementsByName("resposta4")[0].textContent = pregunta.respostes[3];
  		},
  		error: function(xhr)
  		{
  			console.log("error");
  		}
	});
}

function respondrePregunta()
{
	var msg = {
	    method: "correctPregunta",
	    data: $("input[type='radio'][name='testQuest']:checked").val(),
	    id:   1,
	    date: Date.now()
  	};
	sockSend(msg);
}

function correccioResposta(correcte)
{
	if (correcte) 
	{
		$("#contentPregunta").html("<p>OLE! Has encertat. </p><button onclick='nextTorn()'>Next!</button>");
	}
	else
	{
		$("#contentPregunta").html("<p>Llastima, aquesta no era la resposta... </p><button onclick='nextTorn()'>Next!</button>");
	}	
}

function nextTorn()
{
	var msg = {
	    method: "next",
	    data: "",
	    id:   1,
	    date: Date.now()
  	};
	sockSend(msg);
}

/*function nextTorn(nextPlayer)
{

}*/