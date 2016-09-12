<?php
$DomainName = $_SERVER['SERVER_NAME'];
setcookie("login", '', time()-60*60*24*3650, '/maBoutique', $DomainName );
setcookie("PHPSESSID", '', time()-60*60*24*3650, '/', $DomainName);
// TODO Header Index
header("Location: ../index.php");

?>