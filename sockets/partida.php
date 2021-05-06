<?php       
    class Partida
    {
        private $partidaUsers = array();
        private $id;
        private $maxPlayers = 2;

        function __construct($user, $idPartida) 
        {
            $this->id = $idPartida;
            $this->partidaUsers[] = $user;  
        }

        public function addUser($user)
        {
            /*if (count($partidaUsers)<$maxPlayers) 
            {
                $this->partidaUsers[] = $user;
            }*/
            $this->partidaUsers[] = $user;
            if (empty($this->partidaUsers)) 
            {
                echo "USERS VACIO \n";
            }
            else
            {
                echo "Qty users: " .count($this->partidaUsers). "\n";
            }            
        }

        public function getUsers()
        {
            return $this->partidaUsers;
        }

        public function getId()
        {
            return $this->id;
        }

        public function getMaxPlayers()
        {
            return $this->maxPlayers;
        }
        
    }    
?>