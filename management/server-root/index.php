<DOCTYPE html>
<head>
<meta name="HandheldFriendly" content="true" />
<meta name="viewport" content="width=device-width, height=device-height, user-scalable=no" />
<style>
* {
    font-family: Verdana, Geneva, sans-serif;
}
body {
    background-image: url('/background.jpg');
    background-repeat: repeat;
}
p {
    padding-left: 10px;
}
ul {
    padding: 0px;
    margin: 0px;
    padding-top: 10px;
}
ul li {
    list-style-type: none;
    padding-left: 10px;
}
a:link {
    color: #9284CC;
    text-decoration: none;
}
a:hover {
    color: #9284CC;
    text-decoration: underline;
}
a:active {
    color: #9284CC;
    text-decoration: underline;
}

pre {
    background-color: black;
    color: green;
    font-weight: bold;
    font-family: "Courier New", Courier, monospace;
    padding-left: 5px;
    padding-top: 10px;
    padding-bottom: 10px;
}

h3 {
    color: #D6D6D6;
    font-weight: bold;
    padding-right: 5px;
    margin: 4px;
}
.buttons {
    text-align: center;
}
.attached {
    text-align: center;
    background: green;
    width: 6%;
}
.removed {
    text-align: center;
    background: red;
    width: 6%;
}
input[type="button"] {
    background-color: #3D3D3D;
    color: #D6D6D6;
    margin-top: 10px;
    margin-left: 4px;
    margin-right: 4px;
    border:none;
    font-size: 150%;
    font-weight:bold;
    width:48%;
}
.downloads {
    background-color: #B0B0B0;
}

.description {
    vertical-align: top;
    background-color: #3D3D3D;
    color: #D6D6D6;
}
.game {
    background-color: #222222;
    margin-top: 10px;
    padding: 3px;
}
.selected {
    color: #9284CC;
}
.title {
    color: white;
    font-size: 130%;
    margin-left: 20px;
}
.title h1 {
    margin-bottom: 0px;
    color: #<?php system("ifconfig | grep eth0 | awk -F: '{print $5 $6 $7}'") ?>;
}
#messages {
    color: #E26A6A;
    text-align: center;
    font-size: 100%;
    font-weight: bold;
    font-style: italic;
    padding-bottom: 10px;
    margin-top: 10px;
    margin-right: 20px;
    float: right;
}
#oldmessages {
    color: #E26A6A;
    text-align: center;
    font-size: 150%;
    font-weight: bold;
    font-style: italic;
    padding-bottom: 10px;
    margin-top: 20px;
    margin-right: 20px;
    float: right;
    visibility: hidden;
}
.line {
    width: 100%;
    background-color: black;
}
.small_line {
    width: 100%;
    background-color: #D6D6D6;
    height: 5px;
    margin-bottom: 10px;
}
td {
}
table {
}
</style>
</head>
<script src="jquery-1.8.3.min.js"></script>
<script>
function urlParam(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
            return sParameterName[1];
        }
    }
}
window.blocked = false;
window.disable_blocked = false;
function disable_patterns() {
    if (window.disable_blocked == false) {
        $(".pattern").attr("disabled", "disabled");
        $(".pattern").css("color","#222222");
    }
}
function enable_patterns() {
    if (window.blocked == false) {
        $(".pattern").removeAttr("disabled");
        $(".pattern").css("color","#D6D6D6");
    }
}
function update_config(key,value) {
	$('#messages').load("update_config.php", { key:key, value:value });	
    $('.pattern').css('color','#D6D6D6');
    if(key == 'demoMode'){ 
        $('#' + value).css('color','#9284CC');
    }
}
function run_command(command,value) {
    disable_patterns();
	$('#messages').load("change.php", { command:command, value:value });	
    window.blocked = true;
    setTimeout(function(){window.blocked = false;enable_patterns()}, 3000);
}
function are_you_sure(command,value) {
    var r=confirm("Are you sure you want to " + command + "?");
    if (r==true) {
        run_command(command,value);
    }
}

<?php
$file = "config.json";
$json = file_get_contents($file);
$data = json_decode($json, true);

function build_form($value, $key = '', $depth = 0) {
    $spacer = str_repeat("&nbsp;&nbsp;",$depth);
    if (is_array($value)) {
        print "<tr><td>$spacer$key</td><td></td></tr>";
        foreach ($value as $this_key => $this_value) {
            build_form($this_value, $this_key, $depth + 1);
        }
    } else {
        print "<tr><td>$spacer$key</td><td><input type='text' name='$key' value='$value'></td></tr>";
    }
}

$demoMode = $data['demoMode'];
?>

$(document).ready(function() {
    <?php print "$('#$demoMode').css('color','#9284CC');"; ?>
    setInterval(function() {
        $('#stats').load('index.php #stats');
    }, 1000);
    setInterval(function() {
        $('#messages').text('nothing to report');
    }, 4000);
});

</script>
<?php $identity = json_decode(file_get_contents('identity.json'),true); ?>

<html>
<body onload=" ">
        <div class="title">
        <div id="messages">nothing to report</div>
        <h1 style="color:<?php print $identity['color'];?>"><?php print $identity['mac']; ?></h1>
        </div>
        <div class="line">&nbsp;</div>
<div id="local_buttons" class="buttons">
<input type="button" value="Fade" id="fade" class="pattern" onClick="update_config('demoMode','fade');" />
<input type="button" value="ID" id="id" class="pattern" onClick="update_config('demoMode','id');" />
<input type="button" value="White" id="white" class="pattern" onClick="update_config('demoMode','white');" />
<input type="button" value="Half White" id="half" class="pattern" onClick="update_config('demoMode','half');" />
<input type="button" value="Black" id="black" class="pattern" onClick="update_config('demoMode','black');" />
<input type="button" value="None" id="half" class="pattern" onClick="update_config('demoMode','none');" />
</div>

<div id="stats" class="game">
<?php 
#<h3>FC Status:</h3>
#<table>
#<tr>
#$status = shell_exec("/usr/local/bin/pulse-usb-status");
#$status = "";
#$lines = explode(PHP_EOL, $status);
#$count = 1;
#foreach ($lines as $line) {
    #if ($line != "") {
        #print "<td class='$line'>$count</td>\n";
    #}
    #$count++;
#}
#</tr>
#</table>
?>
<h3>Uptime:</h3>
<pre>
<?php system("uptime"); ?>
</pre>

<h3>Network connections:</h3>
<pre>
<?php 
$tcp_port = $data['opcTcpPort'];
$udp_port = $data['opcUdpPort'];
system("sudo netstat -aon | egrep '$tcp_port|$udp_port'"); ?>
</pre>

</div>
<div class="buttons">
<input type="button" value="Restart opc" onClick="are_you_sure('bounce_opc');" />
<input type="button" value="Stop opc" onClick="are_you_sure('stop_opc');" />
<input type="button" value="Reboot" onClick="are_you_sure('reboot');" />
