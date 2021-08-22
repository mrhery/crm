<?php
header("Content-Type: text/plain");
include_once(__DIR__ . "/Addons/vendor/autoload.php");

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class MyChat implements MessageComponentInterface {
	private $users = [];
	private $customers = [], $admin = [];
	
    public function __construct(){
		echo "Server Called on " .  gethostbyname(gethostname()) . "\n";
    }

    public function onOpen(ConnectionInterface $conn){
		$us = explode("/", ltrim($conn->httpRequest->getUri()->getPath(), "/"));
		$error = true;
		
		print_r($us);
		
		if(count($us) > 1){
			switch($us[0]){
				case "admin":
					if(isset($us[1])){
						$uc = user_chat::getBy([
							"channel"	=> $us[1]
						]);
						
						if(count($uc)){
							$error = false;
							$uc = $uc[0];
							
							$this->users[$us[1]] = $conn;
							
							$this->admin[] = $us[1];
							echo "admin logged in\n";
						}
					}
				break;
				
				case "client":
					
				break;
			}
		}
		
		if($error){
			$conn->close();
		}
    }

    public function onMessage(ConnectionInterface $from, $msg){
		$us = explode("/", $from->httpRequest->getUri()->getPath());
		
		print_r($msg);
		
		$d = json_decode(base64_decode($msg));
		
		if(count($us) > 1){
			if(isset($this->users[$us[1]])){
				switch($msg->action){
					case "issue":
						switch($msg->type){
							case "list":
							
							break;
							
							case "create":
							
							break;
							
							case "update":
							
							break;
						}
					break;
					
					case "chat":
						switch($msg->type){
							case "load":
							
							break;
							
							case "send":
								
							break;
						}
					break;
				}
			}else{
				$from->close();
			}
		}
	}

    public function onClose(ConnectionInterface $conn){
		$url = str_replace("/echo/", "", $conn->httpRequest->getUri()->getPath());
		$us = explode("/", $url);
    }

    public function onError(ConnectionInterface $conn, \Exception $e){
		echo "Server Error \n";
		print_r($e->getMessage());
        $conn->close();
    }
}

$app = new HttpServer(new WsServer(new MyChat()));

//For none SSL server, use this code: (comment it if want to use ssl)
$server = IoServer::factory(
	$app,
	PORT
);
$server->run();

/*
//For SSL server can user this code:
$loop = \React\EventLoop\Factory::create();

$secure_websockets = new \React\Socket\Server(HOST . ":" . PORT, $loop);
$secure_websockets = new \React\Socket\SecureServer($secure_websockets, $loop, [
	'local_cert' => SSL_CERT,
	'local_pk' => SSL_KEY,
	'verify_peer' => false,
	'allow_self_signed' => true,
]);

$secure_websockets_server = new \Ratchet\Server\IoServer($app, $secure_websockets, $loop);
$secure_websockets_server->run();
*/