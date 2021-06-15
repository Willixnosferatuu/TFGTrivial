<?php
	require_once('../html/model/model.php');
    class ManagerPartidas
    {
		public function RetrievePending($idPlayer)
		{
			$partidasArr = array();
		    $res = retrievePendingGame($idPlayer);
		    var_dump($res);
		    foreach($res as $r)
		    {
		        $p = new Partida();
		        $p->Retrieve($r["id"]);
		        $partidasArr[] = $p;
		    }
		    return $partidasArr;
		}

		public function getUsernameById($idPlayer)
		{
			return getUserNameByID($idPlayer);
		}

		public function addPuntsTotalsUsers($puntuacions)
		{
			foreach($puntuacions as $key => $value)
			{
				echo "USER => ".$key;
				echo "Points => " .$value;
				addTotalPointsUserBD($key, $value);
			}
		}
	}

?>