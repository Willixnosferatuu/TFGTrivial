<?php   
    require_once('websockets.php');
    require_once('partida.php');
    
    class TrivialServer extends WebSocketServer
    {
        public $partida = array();

        protected function process ($user, $message) 
        {
            global $partida;
            $obj = json_decode($message);
            $method = $obj->{'method'};
            $msg = $obj->{'data'};
            $id = $obj->{'id'};
            $date = $obj->{'date'};

            echo ' method: '.$method;
            echo ' data: '.$msg;
            echo ' id: '.$id. "\n";
            //echo ' date: '.$date;

            switch ($method) 
            {
                case 'crearPartida':
                    $idPartida = 1;
                    if (!empty($partida)) 
                    {
                        $partida[$idPartida]->addUser($user);
                        echo "IdPartida: " .$partida[$idPartida]->getId();
                        echo "\n";
                        echo "users: ";
                        $us = $partida[$idPartida]->getUsers();
                        foreach ($us as $u) 
                        {
                            echo $u->id;
                        }
                        echo "\n";                        
                    }
                    else
                    {
                        $partida[$idPartida] = new Partida($user, $idPartida);
                        echo "IdPartida: " .$partida[$idPartida]->getId();
                        echo "\n";
                        echo "users: ";
                        $us = $partida[$idPartida]->getUsers();
                        foreach ($us as $u) 
                        {
                            echo $u->id;
                        }
                        echo "\n";
                    }
                    echo $msg. "\n";
                    break;
                case 'determinarTorn':
                    echo "Determinar ORDEN " .$msg. "\n";
                    $idPartida = 1;
                    $partida[$idPartida]->tornManager->addDiceUser($user->id, $msg);
                    /*if (!in_array($msg, $numerosDauxUser)) 
                    {
                        $numerosDauxUser[$user->id] = $msg;
                    }
                    else
                    {
                        echo"NUMERO REPETIT";
                    }*/
                    if (count($partida[$idPartida]->tornManager->DauUsuari) == $partida[$idPartida]->getMaxPlayers()) 
                    {
                        foreach ($this->users as $currentUser) 
                        {
                            $jsonResponse = array('status' => 'ok', 'res' => $partida[$idPartida]->tornManager->getOrdered(), 'method' => $method);
                            $this->send($currentUser,json_encode($jsonResponse));
                        }
                    }
                    else
                    {
                        $jsonResponse = array('status' => 'ok', 'res' => 'Esperant a la resta de jugadors...', 'method' => $method);
                        $this->send($user,json_encode($jsonResponse));
                    }
                    break;
                case 'printarTorns':
                    echo "PRINTAR TORNS \n";
                    echo json_encode($numerosDauxUser);
                    //$this->send($user,"");
                    break; 
                case 'startPartida':
                    $idPartida = 1;
                    $partida[$idPartida]->StartPartida();
                    $primerJugador = array_keys($partida[$idPartida]->tornManager->DauUsuari)[0];
                    foreach ($this->users as $currentUser) 
                    {
                        if ($currentUser->id==$primerJugador) 
                        {
                            $jsonResponse = array('status' => 'ok', 'method' => 'goToTauler', 'res'=>'');                        
                            $this->send($currentUser,json_encode($jsonResponse));
                        }
                        else
                        {
                            $jsonResponse = array('status' => 'ok', 'method' => 'goToTauler', 'res'=>$primerJugador);                        
                            $this->send($currentUser,json_encode($jsonResponse));
                        }   
                    }
                    break; 
                case 'pregunta':
                    $idPartida = 1;
                    echo "PREGUNTA CATEGORIA: " .$msg. " \n";
                    $pregunta = $partida[$idPartida]->addPregunta($msg);
                    $res = array('pregunta' => $pregunta->pregunta, 'respostes' => $pregunta->respostes);
                    $jsonResponse = array('status' => 'ok', 'method' => 'goToQuestion', 'res' => $res);
                    foreach ($this->users as $currentUser) 
                    {
                        if($currentUser == $user)
                        {
                            $this->send($currentUser,json_encode($jsonResponse));
                        }
                    }
                    break;
                case 'correctPregunta':
                    $idPartida = 1;
                    $correcte = $partida[$idPartida]->corregirPregunta($msg); 
                                 
                    foreach ($this->users as $currentUser) 
                    {
                        if($currentUser == $user)
                        {
                            $jsonResponse = array('status' => 'ok', 'method' => $method, 'res' => $correcte);
                            $this->send($currentUser,json_encode($jsonResponse));
                        }
                    }
                    break;
                case "next":
                    $idPartida = 1;
                    $nextPlayer = $partida[$idPartida]->nextTorn(); 
                    echo "nextPlayer = " .$nextPlayer; 
                    foreach ($this->users as $currentUser) 
                    {
                        if($currentUser->id == $nextPlayer)
                        {
                            $jsonResponse = array('status' => 'ok', 'method' => 'goToTauler', 'res' => '');
                            $this->send($currentUser,json_encode($jsonResponse));
                        }
                        else
                        {
                            $jsonResponse = array('status' => 'ok', 'method' => 'goToTauler', 'res' => $nextPlayer); // METHOD NEXTTORN ???
                            $this->send($currentUser,json_encode($jsonResponse));
                        }
                    } 
                    break;
                default:
                    # code...
                    break;
            }

            //var msg = JSON.parse(event.data);
            //var time = new Date(msg.date);
            //var timeStr = time.toLocaleTimeString();
            //echo 'user sent: '.$message.PHP_EOL;    

            /*foreach ($this->users as $currentUser) 
            {
                //resta de sockets
                if($currentUser !== $user)
                    $this->send($currentUser,json_encode($jsonResponse));
                //socket origen (usuari que ha contactat)
                if($currentUser == $user)
                    $this->send($currentUser,json_encode($jsonResponse));
            }*/
        }

        protected function connected ($user) 
        {
            echo 'user connected'.PHP_EOL;
        }
        protected function closed ($user) 
        {
            echo 'user disconnected'.PHP_EOL;
        }        
    }    

    $TrivialServer = new TrivialServer("192.168.1.100","9000");
    try 
    {
        $TrivialServer->run();
    }
    catch (Exception $e) 
    {
        $TrivialServer->stdout($e->getMessage());
    }
?>