<?php
    session_start();
    require_once('websockets.php');
    require_once('partida.php');
    require_once('user.php');
    require_once('ManagerPartidas.php');
    
    class TrivialServer extends WebSocketServer
    {
        public $partidas = array();
        private $userIdSocketId = array();

        protected function process ($user, $message) 
        {
            global $partidas;
            $obj = json_decode($message);
            $method = $obj->{'method'};
            $msg = $obj->{'data'};
            $idPlayer = $obj->{'idPlayer'};
            $idPartida = $obj->{'idPartida'};
            $date = $obj->{'date'};

            //var_dump($_SESSION["User"]);

            echo '--------------------------';
            echo ' method: '.$method. "\n";
            echo ' data: '.$msg. "\n";
            echo ' idPlayer: '.$idPlayer. "\n";
            echo ' idPartida: '.$idPartida. "\n";
            echo '--------------------------';
            //echo ' date: '.$date;

            switch ($method) 
            {
                case 'jugar':
                    $difficulty = "medium";
                    $maxPlayers = 2;
                    $joined = false;
                    $userTrivial = new User($idPlayer, $user->id);
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
                            $partida = new Partida();
                            $partida->Create($userTrivial, $maxPlayers, $difficulty);
                            $idPartida = $partida->getId();
                            $partidas[$idPartida] = $partida;  
                        }                                        
                    }
                    else
                    {
                        $partida = new Partida();
                        $partida->Create($userTrivial, $maxPlayers, $difficulty);
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
                    $userTrivial = new User($idPlayer, $user->id);
                    $this->userIdSocketId[$userTrivial->getId()] = $user->id;
                    $partida = new Partida();
                    $partida->Create($userTrivial, $maxPlayers, $diff);
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
                    $userTrivial = new User($idPlayer, $user->id);
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
                    $manager = new ManagerPartidas();
                    $primerJugadorUsername = $manager->getUsernameById($primerJugador);
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
                                $res = array('primerTorn' => $primerJugadorUsername, 'puntuacions' => $partidas[$idPartida]->getUsersAndPoints());
                                $jsonResponse = array('status' => 'ok', 'method' => 'goToTauler', 'res'=>$res);                        
                                $this->send($currentUser,json_encode($jsonResponse));
                            } 
                        }  
                    }
                    break; 
                case 'restorePartida':
                    $orderJugadors = $partidas[$idPartida]->tornManager->getOrderedUsers();
                    foreach($orderJugadors as $u)
                    {
                        $userTrivial = new User($idPlayer, $user->id);
                        if($userTrivial->hasTurn($idPartida))
                        {
                            $primerJugador = $userTrivial->getId();
                            break;
                        }
                    }          
                    $manager = new ManagerPartidas();
                    $primerJugadorUsername = $manager->getUsernameById($primerJugador);
                    if ($primerJugador===$idPlayer) 
                    {
                        $res = array('primerTorn' => '0', 'puntuacions' => $partidas[$idPartida]->getUsersAndPoints());
                        
                    }
                    else
                    {
                        $res = array('primerTorn' => $primerJugadorUsername, 'puntuacions' => $partidas[$idPartida]->getUsersAndPoints());
                    }
                    $jsonResponse = array('status' => 'ok', 'method' => 'goToTauler', 'res'=>$res);                        
                    $this->send($user,json_encode($jsonResponse));         
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
                        $manager = new ManagerPartidas();
                        $nextJugadorUsername = $manager->getUsernameById($nextPlayer);
                        if ($partidas[$idPartida]->getUsersSockets()) 
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
                                        $res = array('primerTorn' => $nextJugadorUsername, 'puntuacions' => $partidas[$idPartida]->getUsersAndPoints());
                                        $jsonResponse = array('status' => 'ok', 'method' => 'goToTauler', 'res' => $res); // METHOD NEXTTORN ???
                                        $this->send($currentUser,json_encode($jsonResponse));
                                    }
                                }
                            } 
                        }  
                        else
                        {
                            $res = array('primerTorn' => $nextJugadorUsername, 'puntuacions' => $partidas[$idPartida]->getUsersAndPoints());
                            $jsonResponse = array('status' => 'ok', 'method' => 'goToTauler', 'res' => $res); // METHOD NEXTTORN ???
                            $this->send($user,json_encode($jsonResponse));
                        }             
                        
                    }
                    else
                    {
                        $puntuacions = $partidas[$idPartida]->getUsersAndPoints();
                        $manager = new ManagerPartidas();
                        $nextJugadorUsername = $manager->addPuntsTotalsUsers($puntuacions);
                        $partidas[$idPartida]->TerminatePartida();
                        if ($partidas[$idPartida]->getUsersSockets()) 
                        {
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
                        else
                        {
                            $res = array('primerTorn' => 'fiPartida', 'puntuacions' => $partidas[$idPartida]->getUsersAndPoints());
                            $jsonResponse = array('status' => 'ok', 'method' => 'goToTauler', 'res' => $res); // METHOD NEXTTORN ???
                            $this->send($user,json_encode($jsonResponse));
                        }
                    }
                    break;
                case "partidasPending":
                    $manager = new ManagerPartidas();
                    $partidasRes = array();
                    $userTrivial = new User($idPlayer, $user->id);
                    $this->userIdSocketId[$userTrivial->getId()] = $user->id;
                    $arrPartidas = $manager->RetrievePending($idPlayer);
                    foreach($arrPartidas as $p)
                    {
                        $partidas[$p->getId()] = $p;
                        $partidasRes[] = array('id' => $p->getId(), 'torn' => $userTrivial->hasTurn($p->getId()));
                    }
                    $res = $partidasRes;
                    $jsonResponse = array('status' => 'ok', 'method' => 'retrieve', 'res' => $res);
                    $this->send($user,json_encode($jsonResponse));
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