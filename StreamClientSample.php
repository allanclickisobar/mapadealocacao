<?php
require('src/StreamClient.php');

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
	write('Logging in...');
	$session = $client->login('api.attask', 'AtTask.123');
	writeln('done');
	writeln();

	// Get user
	write('Retrieving user...');
	$user = $client->get('user', $session->userID, array('ID', 'homeGroupID', 'emailAddr'));
	writeln('done');
	writeln();
	echo '<pre>';
	var_dump($user);
	echo '</pre>';
	// Search projects
	write('Searching projects...');
	$results = $client->search('project', array('groupID' => $user->homeGroupID), array('ID', 'name'));
	writeln('done');

	for ($i=0; $i<min(10, sizeof($results)); $i++) {
		writeln(' - ', $results[$i]->name);
	}
	writeln();

	// Count projects
	write('Counting projects...');
	$count = $client->count('project', array('groupID' => $user->homeGroupID));
	writeln('done');

	writeln('Group has ', $count, ' projects');
	writeln();

	// Report projects
	write('Getting project hours report...');
	$results = $client->report('project', array('groupID' => $user->homeGroupID, 'name_1_GroupBy' => true, 'hours_AggFunc' => 'sum'));
	writeln('done');

	$i=0;
	foreach ($results as $result) {
		writeln(' - ', $result->name, ' (', (empty($result->sum_hours_hours) ? 0 : $result->sum_hours_hours), ' hours)');
		if (++$i == 10) break;
	}
	writeln();

	// Named query
	write('Getting my work...');
	$results = $client->namedquery('work', 'myWork');
	writeln('done');

	for ($i=0; $i<min(10, sizeof($results)); $i++) {
		writeln(' - ', $results[$i]->name);
	}
	writeln();

	// Batch operation
	write('Performing batch operation...');
	$client->batchStart();
	$client->namedquery('work', 'myWork');
	$client->count('project', array('groupID' => $user->homeGroupID));
	$client->batchEnd();
	writeln('done');
	writeln();

	// Create project
	write('Creating project...');
	$proj = $client->post('project', array('name' => 'My Project', 'groupID' => $user->homeGroupID));
	writeln('done');
	writeln();

	// Get project
	write('Retrieving project...');
	$proj = $client->get('project', $proj->ID);
	writeln('done');
	writeln();

	// Edit project
	write('Editing project...');
	$proj = $client->put('project', $proj->ID, array('name' => 'Your Project'));
	writeln('done');
	writeln();

	// Copy project
	write('Copying project...');
	$copy = $client->copy('project', $proj->ID, array('name' => 'Your Project (Copy)'));
	writeln('done');
	writeln();

	// Delete project
	write('Deleting project...');
	$client->batchStart(true);
	$client->delete('project', $proj->ID);
	$client->delete('project', $copy->ID);
	$client->batchEnd();
	writeln('done');
	writeln();

	// Logout
	write('Logging out...');
	$client->logout();
	writeln('done');
}
catch (StreamClientException $e) {
	write('Error: ', $e->getMessage());
}

unset($client);

?>