<?php
$key = $_REQUEST['key'];
$value = $_REQUEST['value'];

if (preg_match("/^[A-Za-z_0123456789]*$/", $key) and preg_match("/^[A-Za-z_0123456789]*$/", $value)) {
    $file = "config.json";
    $json = file_get_contents($file);
    $data = json_decode($json, true);

    $data[$key] = $value;

    file_put_contents($file, json_encode($data, JSON_FORCE_OBJECT));

    print "$key updated to $value";

    exec("sudo /bin/systemctl restart ledscape.service");

} else {
    print "trololololol";
}
?>
