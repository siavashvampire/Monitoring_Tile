#!/php -q
<?php  
// Run from command prompt > php -q ws_server.php
include "phpwebsocket.php";

$server_ip="192.168.1.11";  //what is the IP of your server
$server_ip=$argv[1];  //what is the IP of your server

// Extended basic WebSocket as ws_server
class ws_server extends phpWebSocket{

  //Overridden process function from websocket.class.php
  function process($user,$msg){
      if ( $msg == 'disconnect' ){
	      $this->disconnect($user->socket);
	      return ;
      }
	  foreach($this->users as $u)
		  $this->send($u->socket,$msg);
  }

}  //end class

$master = new ws_server($server_ip,$argv[2]);
