<?php
    session_start();
    require_once('websockets.php');
    require_once('partida.php');
    require_once('user.php');
    
    class TrivialServer extends WebSocketServer
    {
        public $partidas = array();
        private $i=0;
        private $userIdSocketId = array();

        protected function process ($user, $message) 
        {
            global $i;
            global $partidas;
            $obj = json_decode($message);
            $method = $obj->{'method'};
            $msg = $obj->{'data'};
            $idPlayer = $obj->{'idPlayer'};
            $idPartida = $obj->{'idPartida'};
            $date = $obj->{'date'};

            var_dump($_SESSION["User"]);

            echo ' method: '.$method;
            echo ' data: '.$msg;
            echo ' idPlayer: '.$idPlayer. "\n";
            echo ' idPartida: '.$idPartida. "\n";
            //echo ' date: '.$date;

            switch ($method) 
            {
                case 'jugar':
                    $difficulty = "medium";
                    $maxPlayers = 2;
                    $joined = false;
                    $this->i = $this->i+1;
                    $userTrivial = new User($this->i, $user->id);
                    $this->userIdSocketId[$userTrivial->getId()] = $user->id;
                    if (!empty($partidas)) 
                    {
                        foreach ($partidas as $partida) 
                        {
                            if (!$partida->isPrivada() && $partida->hasFreeSlot()) 
                            {
                                $partida->addUser($userTrivial);
                                $idPartida = $partida->getId();
                                $joined = true;
                                break;
                            }
                        }
                        if (!$joined) 
                        {
                            $partida = new Partida($userTrivial, $maxPlayers, $difficulty);
                            $idPartida = $partida->getId();
                            $partidas[$idPartida] = $partida;  
                        }                                        
                    }
                    else
                    {
                        $partida = new Partida($userTrivial, $maxPlayers, $difficulty);
                        $idPartida = $partida->getId();
                        $partidas[$idPartida] = $partida;  
                    }
                    $res = array('idPartida' => $idPartida, 'idPlayer' => $userTrivial->getId());
                    $jsonResponse = array('status' => 'ok', 'res' => $res, 'method' => $method);
                    $this->send($user,json_encode($jsonResponse));
                    break;
                case 'createPrivateGame':
                    //TOOOOOOOOOOOODOOOOOOOOOOOOOOOOOOOOOOOO
                    $diff = $obj->{'difficulty'};
                    $maxPlayers = $obj->{'maxPlayers'};
                    $this->i = $this->i+1;
                    $userTrivial = new User($this->i, $user->id);
                    $this->userIdSocketId[$userTrivial->getId()] = $user->id;
                    $partida = new Partida($userTrivial, $maxPlayers, $diff);
                    $partida->setPrivada();
                    $idPartida = $partida->getId();
                    $partidas[$idPartida] = $partida;
                    $res = array('idPartida' => $idPartida, 'idPlayer' => $userTrivial->getId(), 'code' => $partida->code);
                    $jsonResponse = array('status' => 'ok', 'res' => $res, 'method' => $method);
                    $this->send($user,json_encode($jsonResponse));
                    break;
                case 'joinPrivateGame':
                    //TOOOOOOOOOOOODOOOOOOOOOOOOOOOOOOOOOOOO
                    $code = $obj->{'code'};
                    $joined = false;
                    var_dump($code);
                    $this->i = $this->i+1;
                    $userTrivial = new User($this->i, $user->id);
                    $this->userIdSocketId[$userTrivial->getId()] = $user->id;
                    if (!empty($partidas)) 
                    {
                        foreach ($partidas as $partida) 
                        {
                            if ($partida->isPrivada() && $partida->code==$code && $partida->hasFreeSlot()) 
                            {
                                $partida->addUser($userTrivial);
                                $idPartida = $partida->getId();
                                $joined = true;
                                break;
                            }
                        }
                    }
                    if($joined)
                    {
                        $res = array('idPartida' => $idPartida, 'idPlayer' => $userTrivial->getId(), 'code' => $partida->code);
                        $jsonResponse = array('status' => 'ok', 'res' => $res, 'method' => 'createPrivateGame');
                        $this->send($user,json_encode($jsonResponse));
                    }
                    else
                    {
                        $res = array('ErrMsg' => "Unable to find game or it is full");
                        $jsonResponse = array('status' => 'ok', 'res' => $res, 'method' => 'Err');
                        $this->send($user,json_encode($jsonResponse));
                    }                
                    break;
                case 'determinarTorn':
                    echo "Determinar ORDEN " .$msg. "\n";
                    $partidas[$idPartida]->tornManager->addDiceUser($idPlayer, $msg);
                    /*if (!in_array($msg, $numerosDauxUser)) 
                    {
                        $numerosDauxUser[$user->id] = $msg;
                    }
                    else
                    {
                        echo"NUMERO REPETIT";
                    }*/
                    if (count($partidas[$idPartida]->tornManager->DauUsuari) == $partidas[$idPartida]->getMaxPlayers()) 
                    {
                        $jsonResponse = array('status' => 'ok', 'res' => $partidas[$idPartida]->tornManager->getOrdered(), 'method' => $method);
                        foreach ($this->users as $currentUser) 
                        {                            
                            $this->send($currentUser,json_encode($jsonResponse));
                        }
                    }
                    else
                    {
                        $jsonResponse = array('status' => 'ok', 'res' => 'Esperant a la resta de jugadors...', 'method' => $method);
                        $this->send($user,json_encode($jsonResponse));
                    }
                    break;
                case 'startPartida':
                    $partidas[$idPartida]->StartPartida();
                    $primerJugador = array_keys($partidas[$idPartida]->tornManager->DauUsuari)[0];
                    foreach ($this->users as $currentUser) 
                    {
                        if (in_array($currentUser->id, $partidas[$idPartida]->getUsersSockets())) 
                        {  
                            if ($currentUser->id==$this->userIdSocketId[$primerJugador]) 
                            {
                                $res = array('primerTorn' => '0', 'puntuacions' => $partidas[$idPartida]->getUsersAndPoints());
                                $jsonResponse = array('status' => 'ok', 'method' => 'goToTauler', 'res'=>$res);                        
                                $this->send($currentUser,json_encode($jsonResponse));
                            }
                            else
                            {
                                $res = array('primerTorn' => $primerJugador, 'puntuacions' => $partidas[$idPartida]->getUsersAndPoints());
                                $jsonResponse = array('status' => 'ok', 'method' => 'goToTauler', 'res'=>$res);                        
                                $this->send($currentUser,json_encode($jsonResponse));
                            } 
                        }  
                    }
                    break; 
                case 'pregunta':
                    $pregunta = $partidas[$idPartida]->addPregunta($msg);
                    $res = array('pregunta' => $pregunta->pregunta, 'respostes' => $pregunta->respostes);
                    $jsonResponse = array('status' => 'ok', 'method' => 'goToQuestion', 'res' => $res);
                    $this->send($user,json_encode($jsonResponse));
                    break;
                case 'correctPregunta':
                    $correcte = $partidas[$idPartida]->corregirPregunta($msg, $idPlayer); 
                    $usersPoints = $partidas[$idPartida]->getUsersAndPoints();
                    $res = array('correcte' => $correcte, 'puntuacions' => $usersPoints);
                    $jsonResponse = array('status' => 'ok', 'method' => $method, 'res' => $res);
                    $this->send($user,json_encode($jsonResponse));
                    break;
                case "next":
                    $nextPlayer = $partidas[$idPartida]->nextTorn(); 
                    echo "nextPlayer = " .$nextPlayer; 
                    if ($nextPlayer != "fiPartida") 
                    {                        
                        foreach ($this->users as $currentUser) 
                        {
                            if (in_array($currentUser->id, $partidas[$idPartida]->getUsersSockets())) 
                            {                            
                                if($currentUser->id == $this->userIdSocketId[$nextPlayer])
                                {
                                    $res = array('primerTorn' => '0', 'puntuacions' => $partidas[$idPartida]->getUsersAndPoints());
                                    $jsonResponse = array('status' => 'ok', 'method' => 'goToTauler', 'res' => $res);
                                    $this->send($currentUser,json_encode($jsonResponse));
                                }
                                else
                                {
                                    $res = array('primerTorn' => $nextPlayer, 'puntuacions' => $partidas[$idPartida]->getUsersAndPoints());
                                    $jsonResponse = array('status' => 'ok', 'method' => 'goToTauler', 'res' => $res); // METHOD NEXTTORN ???
                                    $this->send($currentUser,json_encode($jsonResponse));
                                }
                            }
                        } 
                    }
                    else
                    {
                        $partidas[$idPartida]->TerminatePartida();
                        foreach ($this->users as $currentUser) 
                        {
                            if (in_array($currentUser->id, $partidas[$idPartida]->getUsersSockets())) 
                            {  
                                $res = array('primerTorn' => 'fiPartida', 'puntuacions' => $partidas[$idPartida]->getUsersAndPoints());
                                $jsonResponse = array('status' => 'ok', 'method' => 'goToTauler', 'res' => $res);
                                $this->send($currentUser,json_encode($jsonResponse));
                            }
                        }
                    }
                    break;
                default:
                    # code...
                    break;
            }
        }

        protected function connected ($user) 
        {
            //$session_value=(isset($_SESSION['User']))?$_SESSION['User']:'';
            //echo "sessValue = " .$session_value. "\n";
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