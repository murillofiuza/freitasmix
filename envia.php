<?php 



$para='marcio@freitasmix.com.br';


//pego os dados enviados pelo formulário 
$nome_para = $_POST["nome_para"]; 
$email = $_POST["email"]; 
$mensagem = $_POST["mensagem"]; 
$assunto = $_POST["assunto"]; 
//formato o campo da mensagem 
$mensagem = wordwrap( $mensagem, 50, "<br>", 1); 

//valido os emails 
if (!ereg("^([0-9,a-z,A-Z]+)([.,_]([0-9,a-z,A-Z]+))*[@]([0-9,a-z,A-Z]+)([.,_,-]([0-9,a-z,A-Z]+))*[.]([0-9,a-z,A-Z]){2}([0-9,a-z,A-Z])?$", $email)){ 

echo"<center>Digite um email valido</center>"; 
echo "<center><a href=\"javascript:history.go(-1)\">Voltar</center></a>"; 
exit; 

} 

$arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : FALSE;

if(file_exists($arquivo["tmp_name"]) and !empty($arquivo)){

$fp = fopen($_FILES["arquivo"]["tmp_name"],"rb");
$anexo = fread($fp,filesize($_FILES["arquivo"]["tmp_name"])); 
$anexo = base64_encode($anexo); 

fclose($fp);

$anexo = chunk_split($anexo); 


$boundary = "XYZ-" . date("dmYis") . "-ZYX"; 

$mens = "--$boundary\n";
$mens .= "Content-Transfer-Encoding: 8bits\n";
$mens .= "Content-Type: text/html; charset=\"ISO-8859-1\"\n\n"; //plain
$mens .= "$mensagem\n";
$mens .= "--$boundary\n";
$mens .= "Content-Type: ".$arquivo["type"]."\n"; 
$mens .= "Content-Disposition: attachment; filename=\"".$arquivo["name"]."\"\n"; 
$mens .= "Content-Transfer-Encoding: base64\n\n"; 
$mens .= "$anexo\n"; 
$mens .= "--$boundary--\r\n"; 

$headers = "MIME-Version: 1.0\n"; 
$headers .= "From: \"$nome_para\" <$email>\r\n"; 
$headers .= "Content-type: multipart/mixed; boundary=\"$boundary\"\r\n";$headers .= "$boundary\n";



//envio o email com o anexo 
If(mail($para,$assunto,$mens,$headers,  "-r".$email)); 

echo"Email enviado com Sucesso!"; 

} 



echo "<meta HTTP-EQUIV='Refresh' CONTENT='2;URL=index.html'>";
?>

