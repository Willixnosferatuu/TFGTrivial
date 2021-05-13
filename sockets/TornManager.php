<?php       
    class TornManager
    {
    	public $DauUsuari = array();
    	public $torn;

    	function __construct() 
        {
           $this->torn = 0;
        }

        public function addDiceUser($user, $dauNum)
        {
        	$this->DauUsuari[$user] = $dauNum;
        }

        public function getOrdered()
        {
        	arsort($this->DauUsuari);
        	return json_encode($this->DauUsuari);
        }

        public function Next()
        {
        	if ($this->torn < count($this->DauUsuari)-1) 
        	{
        		$this->torn = $this->torn+1;
        	}
        	elseif ($this->torn == count($this->DauUsuari)-1) 
        	{
        		$this->torn = 0;
        	}
        	return array_keys($this->DauUsuari)[$this->torn];
        }
    }
?>