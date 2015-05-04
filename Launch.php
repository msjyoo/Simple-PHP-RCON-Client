<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sekjun9878
 * Date: 28/09/13
 * Time: 3:04 PM
 * To change this template use File | Settings | File Templates.
 */

require __DIR__ . '/SourceQuery/SourceQuery.class.php';
$Query = new SourceQuery( );

define( 'SQ_TIMEOUT',     1 );
define( 'SQ_ENGINE',      SourceQuery :: SOURCE );

echo "----------------------------------------------------------------------\n";
echo "| PHP RCON Client v0.1 by sekjun9878\n";
echo "|\n";
echo "| Open Source under Creative Commons A-NC-SA 3.0 Unported License\n";
echo "| Thanks to xPaw for the Minecraft RCON Library for PHP!\n";
echo "----------------------------------------------------------------------\n";

$fp = fopen('php://stdin', 'r');


echo "Please enter the IP / Address of the server you wish to connect to.\n";
echo "IP> ";
$IP = trim(fgets($fp, 1024));

echo "Please enter the Port of the server you wish to connect to.\n";
echo "Port> ";
$Port = trim(fgets($fp, 1024));

try
{
	$Query->Connect( $IP , $Port, SQ_TIMEOUT, SQ_ENGINE );

	echo "Please enter the RCON Password of the server you wish to connect to.\n";
	echo "RCON Password> ";
	$RCONPassword = trim(fgets($fp, 1024));

	$Query->setRconPassword($RCONPassword);
}
catch( Exception $e )
{
	echo $e->getMessage( )."\n";
	echo "Failed to connect to server. Exiting...\n";
	exit(0);
}

$quit = false;
echo "Connected! Type '.' to quit.\n";

while (!$quit) {
	echo "> ";
	$next_line = fgets($fp, 1024); // read the special file to get the user input from keyboard
	if (".\n" == $next_line) {
		$quit = true;
	} else {
		try
		{
			echo $Query->Rcon(trim($next_line))."\n";
		}
		catch( Exception $e )
		{
			echo $e->getMessage( )."\n";
			echo "Failed to send RCON Message.\n";
		}
	}
}

exit(0);
