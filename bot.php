<?php
error_reporting(0);
$h = "\33[32;1m"; $b = "\33[0;36m"; $m = "\33[31;1m"; $p = "\e[1;37m";$dark="\033[1;30m"; $k = "\33[1;33m"; $c = "\e[1;36m"; $u = "\e[1;35m"; $abu = "\e[1;30m"; $end = "\033[0m"; $babu = "\033[100m"; $bmerah = "\033[101m"; $bputih = "\033[107m";
function an($str){$arr = str_split($str); 
foreach ($arr as $az){echo $az; usleep(6000);}}

function save($data,$data_post){
if(!file_get_contents($data)){
file_put_contents($data,"[]");}
$json=json_decode(file_get_contents($data),1);
$arr=array_merge($json,$data_post);
file_put_contents($data,json_encode($arr,JSON_PRETTY_PRINT));}

if(!file_exists("data.json")){
system("clear");
an(" {$k}Isikan data sesuai yang di intruksikan{$m}!\n");
$id=readline($p." Id: {$h}");
$username=readline($p." username: {$h}");
$tumbal=readline($p." username (tumbal): {$c}");
$pswd=readline($p." password (tumbal): {$c}");
$data=["id"=>$id,"username"=>$username,"tumbal"=>$tumbal,"pswd"=>$pswd];
save("data.json",$data);}

$id=json_decode(file_get_contents("data.json"),true)["id"];
$username=json_decode(file_get_contents("data.json"),true)["username"];
$tumbal=json_decode(file_get_contents("data.json"),true)["tumbal"];
$pswd=json_decode(file_get_contents("data.json"),true)["pswd"];


function curl($url,$httpheader=0,$post=0){ 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, "cookie.txt");
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    if($httpheader){
    curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
    }
    if($post){
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    curl_setopt($ch, CURLOPT_HEADER, true);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch);
    if(!$httpcode) return "Curl Error : ".curl_error($ch); else{
    $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
    $body = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
    curl_close($ch);
return array($header, $body);}
}
function head(){
 $ua[]="Host: app.followersandlikes.co";
 $ua[]="x-requested-with: XMLHttpRequest";
 $ua[]="user-agent: Mozilla/5.0 (Linux; Android 10; dandelion Build/QP1A.190711.020;) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/91.0.4472.101 Mobile Safari/537.36";
 $ua[]="referer: https://app.followersandlikes.co/";
 return $ua; }
 
function token(){
 $url="https://app.followersandlikes.co/member";
 return curl($url,head()); }
 
function masuk(){
global $tumbal,$pswd,$tk;
 $url="https://app.followersandlikes.co/member?";
 $data = "username=".$tumbal."&password=".$pswd."&userid=undefined&antiForgeryToken=".$tk;
 return curl($url,head(),$data); }

function kirim(){
global $username,$id;
 $url = "https://app.followersandlikes.co/tools/send-follower/".$id."?formType=send";
 $data = "adet=10&userID=".$id."&userName=".$username;
 return curl($url,head(),$data); }

system("clear");
an(" {$m}╔╦╗{$p}┌─┐┬┌─┬┌─┐┌─┐┬{$m}╔╦╗═╗ ╦\n");
an(" {$m} ║ {$p}├─┤├┴┐│├─┘│  │{$m}║║║╔╩╦╝\n");
an("  {$m}╩ {$p}┴ ┴┴ ┴┴┴  └─┘┴{$m}╩ ╩╩ ╚═\n");
an(" {$c}~ {$p}Author{$abu}: {$p}Ryuk\n");
an(" {$c}~ {$p}Version{$abu}: {$k}v0.12\n");

system("rm cookie.txt");
$ftoken = token()[1];
$tk=explode('";',explode('&antiForgeryToken=',$ftoken)[1])[0];

$masuk = masuk()[1];
file_put_contents("info_masuk.txt",$masuk);
$status = json_decode($masuk)->status;
 if($status=="success"){
 $kirim = kirim()[1];
 $info = json_decode($kirim)->status;
  if($info=="success"){
  an(" {$p}Messages{$abu}: {$h}berhasil menambahkan followers ke {$c}{$username}\n");
  }else{
  an(" {$p}Messages{$abu}: {$m}gagal {$p}menambahkan followers instagram\n");
  }
 
 }else{
 an(" {$p}Messages{$abu}: {$m}gagal tersambung ke akun\n");
 exit;
 }