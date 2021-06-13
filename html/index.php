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
			case "play":
				require ("controller/partida_controller.php");
				break;
			case "pregunta":
				require ("controller/pregunta_controller.php");
				break;
			case "tauler":
				require ("controller/tauler_controller.php");
				break;
			case "createUser":
				require "view/register_view.php";
				break;
			case "login":
				require "view/login_view.php";
				break;
			case "logout":
				require "controller/logout_controller.php";
				break;
			case "createGame":
				require "view/createGame_view.php";
				break;
			case "joinGame":
				require "view/joinGame_view.php";
				break;
			case "loginValidate":
				require "controller/login_controller.php";
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