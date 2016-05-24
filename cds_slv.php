<html>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE-Edge"/>
	<meta http-equiv="Content-Type" content="text/html"/>
	<meta http-equiv="refresh" content="5"/>
	<title>Nagios Simple Live View</title>
	<style>
		body { margin: 0; padding: 0; background-color: #ccc; }
		#canvas { width: 99%; margin: 10px auto; height: 95%; border: solid 4px #999; background-color: White; }
	</style>
</head>
<body onload="draw()" onresize="draw()">
<img id="aix.png" width="0" height="0" src="images/logos/aix.png">
<img id="linux.png" width="0" height="0" src="images/logos/linux.png">
<img id="barracuda.png" width="0" height="0" src="images/logos/barracuda.png">
<img id="linuxvm.png" width="0" height="0" src="images/logos/linuxvm.png">
<img id="windowsvm.png" width="0" height="0" src="images/logos/windowsvm.png">
<img id="windowsxpvm.png" width="0" height="0" src="images/logos/windowsxpvm.png">
<img id="windowsxp.png" width="0" height="0" src="images/logos/windowsxp.png">
<img id="windowsntvm.png" width="0" height="0" src="images/logos/windowsntvm.png">
<img id="windows.png" width="0" height="0" src="images/logos/windows.png">
<img id="alcatel6850.png" width="0" height="0" src="images/logos/alcatel6850.png">
<img id="server.png" width="0" height="0" src="images/logos/server.png">
<img id="lexmark.png" width="0" height="0" src="images/logos/lexmark.png">
<img id="pabxF4.png" width="0" height="0" src="images/logos/base/pabxF4.png">
<img id="pabxF5.png" width="0" height="0" src="images/logos/base/pabxF5.png">
<img id="pabxF6.png" width="0" height="0" src="images/logos/base/pabxF6.png">
<img id="eads.png" width="0" height="0" src="images/logos/eads.png">
<canvas id ="canvas"></canvas>
<script>
function draw() {
var c = document.getElementById("canvas");
var ctx = c.getContext("2d");
var w = canvas.width = canvas.clientWidth;
var h = canvas.height = canvas.clientHeight;
var q = h/5;
var gh = 2*h-300;
var gw = 2*w-300;
var degrees = 360;
var new_degrees = 0;
var difference = 0;
var gcolor = "limegreen"; //green looks better to me
var bgcolor = "White";
var gtext;
var animation_loop, redraw_loop;
ctx.fillStyle = "SlateGrey";
ctx.font = "bold 40px Arial";

<?php
/**
  * Script configuration
  */
$conf = Array(
	'socketType'	=> 'unix',
	'socketPath'	=> '/var/log/nagios/live',
	'socketAddress'	=> '',
	'socketPort'	=> '',
	'queryTypes'	=> '(GET|LOGROTATE|COMMAND)',
	'queryTables'	=> '([a-z]+)',
);

class LiveException extends Exception {}

$LIVE = null;

// start the main function
livestatusCom();

function livestatusCom() {
	global $conf;
	try {
		verifyConfig();
		//run preflight checks
		if($conf['socketType'] == 'unix') {
			checkSocketExists();
		}
		checkSocketSupport();
		connectSocket();
		date_default_timezone_set("Europe/Paris");
		echo 'ctx.fillText(\'';
		echo "" . date("H:i:s");
		echo '\', w-200, h/12, w-120);
';
		# we request the number of services in each state (0=OK, 1=warning, 2=critical, 3=unknown)
		$query = "GET services\nFilter: host_acknowledged = 0\nFilter: acknowledged = 0\nFilter: host_checks_enabled = 1\nStats: state = 0\nStats: state = 1\nStats: state = 2\nFilter: host_notifications_enabled = 1\nFilter: notifications_enabled = 1\n";

		//handle the query now
		$tab = queryLivestatus($query);
		$resp = $tab[0];
		$ok = $resp[0];
		$warn = $resp[1];
		$crit = $resp[2];
		$unkn = $resp[3];
		$tot = $ok + $warn + $crit + $unkn;
		$tpb = $warn + $crit + $unkn;
		$pok = $tpb / $tot;
		$pcrit = $crit / $tot;
		$dcrit = $pcrit * 360;
		$pwarn = $warn / $tot;
		$dwarn = $pwarn * 360;
		$dok = $pok * 360;
		$deg = 360 - $dok;
		echo 'degrees = '.$deg.';
ctx.beginPath();
ctx.strokeStyle = bgcolor;
ctx.lineWidth = 50;
ctx.arc(gw/2, gh/2, 10, 0, Math.PI*2, false); //you can see the arc now
ctx.stroke();
		var radians = degrees * Math.PI / 180;
		ctx.beginPath();
		ctx.strokeStyle = gcolor;
		ctx.lineWidth = 20;
		ctx.arc(gw/2, gh/2, 80, 0 - 90*Math.PI/180, radians - 90*Math.PI/180, false); 
		ctx.stroke();
		
		ctx.fillStyle = gcolor;
		ctx.font = "bold 30px bebas";
		text = Math.floor(degrees/360*100) + "% OK";
		text_width = ctx.measureText(text).width;
		ctx.fillText(text, gw/2 - text_width/2, gh/2 + 15);
';
		echo 'degrees = '.$dcrit.';
gcolor = "crimson"; 
gh = 2*h-800;
gw = 2*w-300;
';
		echo'ctx.beginPath();
ctx.strokeStyle = bgcolor;
ctx.lineWidth = 50;
ctx.arc(gw/2, gh/2, 10, 0, Math.PI*2, false); //you can see the arc now
ctx.stroke();
		var radians = degrees * Math.PI / 180;
		ctx.beginPath();
		ctx.strokeStyle = gcolor;
		ctx.lineWidth = 20;
		ctx.arc(gw/2, gh/2, 80, 0 - 90*Math.PI/180, radians - 90*Math.PI/180, false); 
		ctx.stroke();
		
		ctx.fillStyle = gcolor;
		ctx.font = "bold 30px bebas";
		text = Math.floor(degrees/360*100) + "% CRIT";
		text_width = ctx.measureText(text).width;
		ctx.fillText(text, gw/2 - text_width/2, gh/2 + 15);
';
		echo 'degrees = '.$dwarn.';
gcolor = "DarkOrange"; 
gh = 2*h-1300;
gw = 2*w-300;
';
		echo'ctx.beginPath();
ctx.strokeStyle = bgcolor;
ctx.lineWidth = 50;
ctx.arc(gw/2, gh/2, 10, 0, Math.PI*2, false); //you can see the arc now
ctx.stroke();
		var radians = degrees * Math.PI / 180;
		ctx.beginPath();
		ctx.strokeStyle = gcolor;
		ctx.lineWidth = 20;
		ctx.arc(gw/2, gh/2, 80, 0 - 90*Math.PI/180, radians - 90*Math.PI/180, false); 
		ctx.stroke();
		
		ctx.fillStyle = gcolor;
		ctx.font = "bold 30px bebas";
		text = Math.ceil(degrees/360*100) + "% WARN";
		text_width = ctx.measureText(text).width;
		ctx.fillText(text, gw/2 - text_width/2, gh/2 + 15);
';
		echo 'ctx.fillStyle = "black";
';
		echo 'ctx.font = "bold 50px Arial";
';
		echo 'ctx.fillText(\'';
		echo "$ok services OK; ";
		$color = 'green';
		if($crit > 0) {
			$color = 'red';
			echo "$crit services CRITICAL; ";
			if($warn > 0) {
				echo "$warn warning; ";
			}
			if($unkn > 0) {
				echo "$unkn in an unknown state.";
			}
		} elseif($warn > 0) {
			$color = 'yellow';
			echo "$warn WARNING; ";
			if($unkn > 0) {
				echo "$unkn in an unknown state.";
			}
		} elseif($unkn > 0) {
			$color = 'black';
			echo "$unkn in an UNKNOWN state.";
		}
		echo '\', 70, h/6, w-120);
';
		closeSocket();
		connectSocket();
		$query2 = "GET services\nColumns:  host_icon_image host_name description state\nFilter: state = 2\nFilter: host_acknowledged = 0\nFilter: acknowledged = 0\nFilter: host_checks_enabled = 1\nFilter: host_notifications_enabled = 1\nFilter: notifications_enabled = 1\n";
		$tab2 = queryLivestatus($query2);
		#$json_string = jsonpp($tab2);
		echo 'ctx.font = " bold 40px Arial" ;
';
		echo 'ctx.fillStyle = "DarkRed";';
		$nbcrit = count($tab2);
		for($k=0;$k < $nbcrit;$k++)
		{
			$cnt = $tab2[$k];
			if($cnt[0] == "")
				$cnt[0] = "server.png";
			if($cnt[0] == "base/pabxF4.png")
				$cnt[0] = "pabxF4.png";
			if($cnt[0] == "base/pabxF5.png")
				$cnt[0] = "pabxF5.png";
			if($cnt[0] == "base/pabxF6.png")
				$cnt[0] = "pabxF6.png";
			echo 'q += 45;
';
			echo 'var img = document.getElementById("'.$cnt[0].'"); '
;
			echo 'ctx.drawImage(img, 50, q-35, 40, 40);';
			echo 'ctx.fillText(\'';
			echo "CRIT $cnt[1] $cnt[2]";
 			echo '\', 120, q, w-120);
';
		}
		closeSocket();
		connectSocket();
		$query3 = "GET services\nColumns:  host_icon_image host_name description state\nFilter: state = 1\nFilter: host_acknowledged = 0\nFilter: acknowledged = 0\nFilter: host_checks_enabled = 1\nFilter: host_notifications_enabled = 1\nFilter: notifications_enabled = 1\nFilter: is_flapping = 0\n";
		$tab3 = queryLivestatus($query3);
		echo 'ctx.font = " bold 40px Arial" ;
';
		echo 'ctx.fillStyle = "DarkOrange";';
		$nbcrit = count($tab3);
		for($k=0;$k < $nbcrit;$k++)
		{
			$cnt = $tab3[$k];
			if($cnt[0] == "")
				$cnt[0] = "server.png";
			if($cnt[0] == "base/pabxF4.png")
				$cnt[0] = "pabxF4.png";
			if($cnt[0] == "base/pabxF5.png")
				$cnt[0] = "pabxF5.png";
			if($cnt[0] == "base/pabxF6.png")
				$cnt[0] = "pabxF6.png";
			echo 'q += 45;
';
			echo 'var img = document.getElementById("'.$cnt[0].'"); '
;
			echo 'ctx.drawImage(img, 50, q-35, 40, 40);';
			echo 'ctx.fillText(\'';
			echo "WARN $cnt[1] $cnt[2]";
 			echo '\', 120, q, w-120);
';
		}
		echo '
ctx.beginPath();
ctx.lineWidth = "50";
ctx.strokeStyle = "LightSkyBlue";
ctx.rect(10, 10, w-20, h-20);
ctx.stroke();
}
</script>
</body>
</html>';
		closeSocket();
		exit(0);
	} catch(LiveException $e) {
		echo 'ERROR: '.$e->getMessage();
		closeSocket();
		exit(1);
	}
}

function verifyConfig() {
	global $conf;
	
	if($conf['socketType'] != 'tcp' && $conf['socketType'] != 'unix')
		throw new LiveException('Socket Type is invalid. Need to be "unix" or "tcp".');
	
	if($conf['socketType'] == 'unix') {
		if($conf['socketPath'] == '')
			throw new LiveException('Socket Path is empty.');
	} elseif($conf['socketType'] == 'tcp') {
		if($conf['socketAddress'] == '')
			throw new LiveException('Socket Address is empty.');
		if($conf['socketPort'] == '')
			throw new LiveException('Socket Port is empty.');
	}
}

function closeSocket() {
	global $LIVE;
	@socket_close($LIVE);
	$LIVE = null;
}

function readSocket($len) {
	global $LIVE;
	$offset = 0;
	$socketData = '';
	while($offset < $len) {
		if(($data = @socket_read($LIVE, $len - $offset)) === false)
			return false;

		$dataLen = strlen ($data);
		$offset += $dataLen;
		$socketData .= $data;
		
		if($dataLen == 0)
			break;
	}
	return $socketData;
}
	
function queryLiveStatus($query) {
	global $LIVE;

	socket_write($LIVE, $query . "OutputFormat:json\nResponseHeader: fixed16\n\n");
	$read = readSocket(16);
	if($read === false)	
		throw new LiveException('Problem while reading from socket: '.socket_strerror(socket_last_error($LIVE)));
	$status = substr($read, 0, 3);
	$len = intval(trim(substr($read, 4, 11)));
	$read = readSocket($len);
	if($read === false)
		throw new LiveException('Problem while reading from socket: '.socket_strerror(socket_last_error($LIVE)));
	if($status != "200")
		throw new LiveException('Problem while reading from socket: '.$read);
	if(socket_last_error($LIVE) == 104)
		throw new LiveException('Problem while reading from socket: '.socket_strerror(socket_last_error($LIVE)));
	$obj = json_decode(utf8_encode($read));
	if($obj === null)
		throw new LiveException('The response has an invalid format: ');
	else
		return $obj;
}

function connectSocket() {
	global $conf, $LIVE;
	if($conf['socketType'] === 'unix') {
		$LIVE = socket_create(AF_UNIX, SOCK_STREAM, 0);
	} elseif($conf['socketType'] === 'tcp') {
		$LIVE = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
	}

	if($LIVE == false) {
		throw new LiveException('Could not create livestatus socket connection');
	}

	if($conf['socketType'] === 'unix') {
		$result = socket_connect($LIVE, $conf['socketPath']);
	} elseif($conf['socketType'] === 'tcp') {
		$result = socket_connect($LIVE, $conf['socketAddress'], $conf['socketPort']);
	}

	if($result == false) {
		throw new LiveException('Unable to connect to livestatus socket.');
	}

	if($conf['socketType'] === 'tcp') {
		if(defined('TCP_NODELAY')) {
			socket_set_option($LIVE, SOL_TCP, TCP_NODELAY, 1);
		} else {
			socket_set_option($LIVE, SOL_TCP, 1, 1);
		}
	}
}

function checkSocketSupport() {
	if(!function_exists('socket_create'))
		throw new LiveException('The php socket_create function is not available, check your PHP installation.');
}

function checkSocketExists() {
	global $conf;
	if(!file_exists($conf['socketPath']))
		throw new LiveException('The configured livestatus socket does not exists.');
}
function jsonpp($json, $istr='  ')
{
    $result = '';
    for($p=$q=$i=0; isset($json[$p]); $p++)
    {
        $json[$p] == '"' && ($p>0?$json[$p-1]:'') != '\\' && $q=!$q;
        if(!$q && strchr(" \t\n\r", $json[$p])){continue;}
        if(strchr('}]', $json[$p]) && !$q && $i--)
        {
            strchr('{[', $json[$p-1]) || $result .= "\n".str_repeat($istr, $i);
        }
        $result .= $json[$p];
        if(strchr(',{[', $json[$p]) && !$q)
        {
            $i += strchr('{[', $json[$p])===FALSE?0:1;
            strchr('}]', $json[$p+1]) || $result .= "\n".str_repeat($istr, $i);
        }
    }
    return $result;
}
?>
