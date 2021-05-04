<?php
if (!isset($_GET["url"]))
{
		require ("controller/main_controller.php");
}else
{
		$url=explode("/",$_GET["url"]);
		$resource= $url[0];
		switch($resource){
			case "index":
				require ("controller/main_controller.php");
				break;
			case "NewGame":
				require ("controller/newGame_controller.php");
				break;
			case "nftTest":
				$tokenID=$url[1];
				$attachment_location= "nftTest/".$tokenID.".json";
				if (file_exists($attachment_location)){
					header("Content-Type: application/json");
					echo file_get_contents($attachment_location);
				}
				break;
			//case "user":
				//$action= $url[1];
				//switch($action){
					//case "create":
						//require "view/register_view.php";
						//break;
			default:
				require "view/404_view.html";
				break;
		}
}
?>