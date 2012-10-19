<?php
require('_StreamClient.php');

function write() {
	$max=func_num_args();
	for ($i=0; $i<$max; $i++) {
		echo func_get_arg($i);
	}
}

function writeln() {
	call_user_func_array('write', func_get_args());
	echo PHP_EOL;
}

try {
	// Create an instance of the Stream API client
	$client = new StreamClient('https://agencia.attask-ondemand.com');

	// Login
	$session = $client->login('api.attask', 'AtTask.123');


    $client->setRawMode(true);
    $projeto = $client->get('project', '4f0316d600144b5c5d6e9af10d3f8859');
}
catch (StreamClientException $e) {
	write('Error: ', $e->getMessage());
}

unset($client);
?>
<?php
echo($projeto);
?>