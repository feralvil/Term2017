<?php
unset($_SERVER['PHP_AUTH_USER']);
unset($_SERVER['PHP_AUTH_PW']);
header('WWW-Authenticate: Basic realm="Intranet COMDES"');
header('HTTP/1.0 401 Unauthorized');
?>
