var idPartida;
var idPlayer;
var puntuacions;
var code;
var username;

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

function gotoRegister()
{
	$.ajax(
	{
		url:"createUser",
		//url: "controller/register_controller.php",
		cache: false,
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


function gotoLogin()
{
	$.ajax(
	{
		url: "login",
		cache: false,
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

function loginValidate()
{
	var user = document.getElementById("loginForm").elements["username"].value;
	var password = document.getElementById("loginForm").elements["password"].value;
	$.ajax(
	{
		type:"Post",
		url: "loginValidate",
		cache: false,
		data: {username: user, password: password},
		success: function(response)
		{
			//TOOOOOOOOOOOOOOOOOOODDOOOOOOOOOOOOOOOOOOOOOOO
    		console.log(response);
    		idPlayer = response;
    		username = user;
    		document.getElementById("mnuButtons").style.display="unset";
    		document.getElementById("mnuLogButtons").style.display="none";
    		$("#content").html("");
    		var msg = {
			    method: "partidasPending",
			    data: "",
			    idPlayer: idPlayer,
			    date: Date.now()
				};
			sockSend(msg);
		},
  		error: function(xhr, exception)
  		{
  			console.log("error");
  		}
	});
}

function showPartidasPending(result)
{
	var builder = "<p>Partidas Pendents</p><ul>";
	for (var i = result.length - 1; i >= 0; i--) 
	{
		if (result[i].torn==1) 
		{
			builder = builder + "<li><Button onClick='retomarPartida(" + result[i].id + ")'> Partida: " + result[i].id + " // Et Toca Jugar!</Button></li></br>";
		}
		else
		{
			builder = builder + "<li><Button onClick='retomarPartida(" + result[i].id + ")' disabled> Partida: " + result[i].id + "</Button></li></br>";
		}
		
	}
	builder = builder + "</ul> ";
	$("#content").html(builder);
	console.log(result);
}

function retomarPartida(idGame)
{
	idPartida = idGame;
	restorePartida();
}

function Logout()
{
	console.log("Logout");
	//window.location.href = "index.php";
	/*$.ajax(
	{
		url: "logout",
		cache: false,
		success: function(response)
		{
    		$("#content").html(response);
    		console.log(response);
  		},
  		error: function(xhr)
  		{
  			console.log("error");
  		}
	});*/
}

/*function createGame()
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
}*/

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
	    method: "jugar",
	    data: "TEST",
	    idPlayer:   idPlayer,
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

function partidaCreada(response)
{
	idPartida = response.idPartida;
	idPlayer = response.idPlayer;
	console.log("idPartida: " + idPartida + "\n");
	console.log("idPlayer: " + idPlayer + "\n");
}

function partidaPrivadaCreada(response)
{
	idPartida = response.idPartida;
	idPlayer = response.idPlayer;
	code = response.code;
	console.log("idPartida: " + idPartida + "\n");
	console.log("idPlayer: " + idPlayer + "\n");
	console.log("code: " + code + "\n");
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
    		document.getElementById("partidaCode").innerHTML = code;
  			//document.getElementById("btnStart").disabled = false;
  		},
  		error: function(xhr)
  		{
  			console.log("error");
  		}
	});
}

function createGameShowForm()
{
	$.ajax(
	{
		url: "createGame",
		cache: false,
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

function joinGameShowForm()
{
	$.ajax(
	{
		url: "joinGame",
		cache: false,
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

function createGame()
{
	var difficulty = document.getElementById("createGameForm").elements["diff"].value;
	var mp = document.getElementById("createGameForm").elements["maxPlayers"].value;
	console.log("DENTRO CREATE GAME");
	var msg = {
	    method: "createPrivateGame",
	    data: "TEST",
	    idPlayer: idPlayer,
	    date: Date.now(),
	    difficulty: difficulty,
	    maxPlayers: mp
  	};
  	sockSend(msg);
}

function joinGame()
{
	console.log("DENTRO JOIN GAME");
	var code = document.getElementById("joinGameForm").elements["gameCode"].value;
	var msg = {
	    method: "joinPrivateGame",
	    data: "",
	    idPlayer: idPlayer,
	    date: Date.now(),
	    code: code
  	};

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
	    idPlayer: idPlayer,
	    idPartida: idPartida,
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
	    idPartida: idPartida,
	    idPlayer: idPlayer,
	    date: Date.now()
  	};
  	console.log("Partida Començada");
	sockSend(msg);
}

function restorePartida()
{
	console.log("Entra restorePartida()");
	console.log(idPartida);
	var msg = {
	    method: "restorePartida",
	    data: "test",
	    idPartida: idPartida,
	    idPlayer: idPlayer,
	    date: Date.now()
  	};
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

function goToTauler(result)
{
	console.log("result goToTauler: " + result);
	var primerTorn = result.primerTorn;
	puntuacions = result.puntuacions;
	if (primerTorn!="fiPartida") 
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
	    		$('#jugador').html("<p>Jugador -> " + username + "</p>");
	    		updatePuntuacions();
	    		if (primerTorn!=0) 
	    		{
	    			$('#primerTorn').html("Espera! Es el torn de  " + primerTorn);
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
	else
	{
		var puntuacionsTag ="";
		var maxPoints = 0;
		var winner = "";
		for (var p in puntuacions) 
		{
			if (puntuacions[p]>maxPoints) {maxPoints=puntuacions[p]; winner = p;}
			if (p==idPlayer) 
			{
				puntuacionsTag = puntuacionsTag + "<p style='color: aqua'>" + p + ": " + puntuacions[p] + "</p>";
			}
			else
			{
				puntuacionsTag = puntuacionsTag + "<p>" + p + ": " + puntuacions[p] + "</p>";
			}	
		}
		$("#content").html("<p>FI PARTIDA</p>" + puntuacionsTag + "<h2>And the winner is : " + winner + "</h2> </br><Button href='index.php'>Home</Button>");
	}	
}

function updatePuntuacions()
{
	var puntuacionsTag ="";
	for (var p in puntuacions) 
	{
		if (p==idPlayer) 
		{
			puntuacionsTag = puntuacionsTag + "<p style='color: aqua'>" + p + " : " + puntuacions[p] + "</p>";
		}
		else
		{
			puntuacionsTag = puntuacionsTag + "<p>" + p + " : " + puntuacions[p] + "</p>";
		}		
	}
	$('#puntuacions').html(puntuacionsTag);
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
	    idPlayer:   idPlayer,
	    idPartida: idPartida,
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
	    idPlayer:   idPlayer,
	    idPartida: idPartida,
	    date: Date.now()
  	};
	sockSend(msg);
}

function correccioResposta(result)
{
	var correcte = result.correcte;
	puntuacions = result.puntuacions;	
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
	    idPlayer:   idPlayer,
	    idPartida: idPartida,
	    date: Date.now()
  	};
	sockSend(msg);
}

function initMenu()
{
	console.log("Entra initMenu");	
    var userId='<?php echo $session_value;?>';
	console.log(userId);
}
