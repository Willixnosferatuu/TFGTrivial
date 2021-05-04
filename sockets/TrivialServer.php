<?php   
    require_once('websockets.php');
    
    class TrivialServer extends WebSocketServer
    {
        protected function process ($user, $message) 
        {
            /*$obj = json_decode($message);
            $type = $obj->{'type'};
            $msg = $obj->{'text'};
            $id = $obj->{'id'};
            $date = $obj->{'date'};

            echo ' user sent type: '.$type;
            echo ' user sent text: '.$msg;
            echo ' user sent id: '.$id;
            echo ' user sent date: '.$date;*/
            //var msg = JSON.parse(event.data);
            //var time = new Date(msg.date);
            //var timeStr = time.toLocaleTimeString();
            echo 'user sent: '.$message.PHP_EOL;
            foreach ($this->users as $currentUser) 
            {
                if($currentUser !== $user)
                $this->send($currentUser,$message);
            }
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