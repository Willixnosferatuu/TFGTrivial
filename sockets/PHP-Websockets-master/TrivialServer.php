<?php   
    require_once('websockets.php');
    
    class TrivialServer extends WebSocketServer
    {
        protected function process ($user, $message) 
        {
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

    $TrivialServer = new TrivialServer("localhost","9000");
    try 
    {
        $TrivialServer->run();
    }
    catch (Exception $e) 
    {
        $TrivialServer->stdout($e->getMessage());
    }
?>