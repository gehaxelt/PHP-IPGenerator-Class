<?php
include_once 'ipgenerator.class.php';

$generator = New IPGenerator();

$generator->setStartIP(127,0, 0, 1);
$generator->setStopIP(127, 0, 0, 5);

while($generator->isNextIPaddress()) 
{
	echo $generator->getNextIPaddress()."\n";
}

unset($generator);

?>