--TEST--
Test redirection in web server with baisc functionality - mysqli
--SKIPIF--
<?php 
    require_once('skipif_server.inc');
    require_once('skipif.inc');
    require_once('skipifconnectfailure.inc');
?>
--CONFLICTS--
server
--FILE--
<?php
include 'server.inc';
$host = cli_server_start();

// start testing
echo "*** Testing mysqli in web server: basic functionality ***\n";

$url = "http://"."{$host}/server_basic_mysqli_testcase.php";

$fp = fopen($url, 'r');
if(!$fp) {
    echo "[000] request url failed \n";
    die();
}
while (!feof($fp)) {
    echo fgets($fp, 4096);
}

fclose($fp);
?>
===DONE===
--EXPECTF--
*** Testing mysqli in web server: basic functionality ***
step1: redirect enabled, non-persistent connection 
mysqlnd_azure.enabled: On
%s
Location: mysql://%s:%d/user=%s
0
step2: redirect enabled, persistent connection 
mysqlnd_azure.enabled: On
%s
Location: mysql://%s:%d/user=%s
0
step3: redirect disabled, non-persistent connection 
mysqlnd_azure.enabled: Off
%s
Location: mysql://%s:%d/user=%s
1
step4: redirect disabled, persistent connection 
mysqlnd_azure.enabled: Off
%s

0
===DONE===