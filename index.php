<?php
if(!file_exists("test.pl"))die("Unable to locate test.pl file, current directory is: ".__DIR__);
$cmd='swipl -s test.pl -g "test." -t halt.';

var_dump($cmd);
system( $cmd );
echo "\n";

$output = exec( $cmd );
echo $output;
echo "\n";

exec( $cmd, $output );
print_r( $output );
echo "\n";

$output = shell_exec( $cmd );
echo $output;
echo "\n";
?>