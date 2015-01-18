<?php
$command = $_REQUEST['command'];
$value = $_REQUEST['value'];

if (preg_match("/^[a-z_0123456789]*$/", $command)) {
    print "executing $command\n";
    if ($command == "bounce_opc") {
        exec("sudo systemctl restart ledscape.service");
    } elseif ($command == "stop_opc") {
        exec("sudo systemctl stop ledscape.service");
    } elseif ($command == "reboot") {
        exec("sudo /sbin/shutdown -r now");
    }
} else {
    print "trololololol";
}
?>
