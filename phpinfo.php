<html>
<body>
<?php
echo "LOADED EXTENSIONS:";
echo "<br>";
print_r(get_loaded_extensions());
echo "<br>";
print_r(php_ini_loaded_file());
echo "<br>";
echo phpinfo();
?>
</body>
</html>