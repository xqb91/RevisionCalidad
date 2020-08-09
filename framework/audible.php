<?php 

function records(){

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "../test.wav");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

$headers = array();
$headers[] = "X-Api-Token: XCEFERlmvoj349jimXXXXXX";
$headers[] = "Account: WSXDEXXXXX.crazycall.com";
$headers[] = "Host: api.crazycall.com";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close ($ch);

return $result;

}

$sample = records();

header("Content-type: audio/wav");
header("Content-Disposition: attachment; filename=record.wav");
echo $sample;

?>