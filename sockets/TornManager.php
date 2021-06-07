<?php       
    require_once('../html/model/model.php');

    class TornManager
    {
    	public $DauUsuari = array();
    	public $torn;
        private $maxRondas = 2;
        private $idPartida;

    	function __construct($idPartida, $maxRondas) 
        {
           $this->torn = 0;
           $this->idPartida = $idPartida;
           $this->maxRondas = $maxRondas;
        }

        public function addDiceUser($user, $dauNum)
        {
        	$this->DauUsuari[$user] = $dauNum;
        }

        public function getOrdered()
        {
        	arsort($this->DauUsuari);
            putPlayersInOrderBD($this->idPartida, array_keys($this->DauUsuari));
        	return json_encode($this->DauUsuari);
        }

        public function Next()
        {
            $idPastUser = array_keys($this->DauUsuari)[$this->torn];
            roundTorn($this->idPartida, $idPastUser, 0);
        	if ($this->torn < count($this->DauUsuari)-1) 
        	{
        		$this->torn = $this->torn+1;
                $idNextUser = array_keys($this->DauUsuari)[$this->torn];
        	}
        	elseif ($this->torn == count($this->DauUsuari)-1) 
        	{
        		$this->torn = 0;
                $idNextUser = array_keys($this->DauUsuari)[$this->torn];
                $this->maxRondas = $this->maxRondas-1;
                if ($this->maxRondas==0) 
                {
                    return "fiPartida";
                }
        	}
            roundTorn($this->idPartida, $idNextUser, 1);
        	return array_keys($this->DauUsuari)[$this->torn];
        }
    }
?>