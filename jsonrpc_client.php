<?php
// demo: php jsonrpc_client.php 127.0.0.1:8080 SendMail 123456789
$addr = $argv[1];
$params = $argv[2]();

$request = array(
    'method'  => $argv[1],
    'params'  => array((object)$params),
    'id'      => 1
);

$jsonRequest = json_encode($request);

$ctx = stream_context_create(array(
    'http' => array(
        'method'  => 'POST',
        'timeout' => 10,
        'header'  => 'Content-Type: application/json\r\n',
        'content' => $jsonRequest,
    )
));

$url = "http://${addr}/api/";
echo json_encode(array($url, $request))."\n";

$fp = fopen($url, 'r', false, $ctx);
fpassthru($fp);
$buffer = '';
$buffer .= fgets($fp, 5120);
echo $buffer."\n";

fclose($fp);

function SendMail() {
    return array(
        'playerId' => $argv[3],  

        'mailId' => 25,
        'content' => 'Test！', 
        'items' =>  array(
            array('type' => 0, 'id' => 1863, 'num' =>1), 
        ),
    );
}

?>
