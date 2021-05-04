<?php   
    require_once('websockets.php');
    
    class TrivialServer extends WebSocketServer
    {
        public $numerosDauxUser = array();

        protected function process ($user, $message) 
        {
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
                case 'determinarTorn':
                    $numerosDauxUser[$user->id] = $msg;
                    echo "Determinar ORDEN " .$msg. "\n";
                    echo json_encode($numerosDauxUser);
                    $jsonResponse = array('status' => 'ok', 'res' => 'orderNumero', 'method' => $method);
                    $this->send($user,json_encode($jsonResponse));
                    foreach ($this->users as $currentUser) 
                    {
                        //resta de sockets
                        if($currentUser !== $user)
                            $jsonResponse = array('status' => 'ok', 'res' => 'orderNumero', 'method' => 'altresJugadors');
                            $this->send($currentUser,json_encode($jsonResponse));
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