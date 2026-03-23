<?php
session_start();
session_destroy(); // Mata todas as sessões ativas
header("Location: login.php");
exit;
?>