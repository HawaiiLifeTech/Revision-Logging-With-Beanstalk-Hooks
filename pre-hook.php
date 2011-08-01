<?php
// Load hook handler
include('BeanstalkHookHandler.php');
$beanstalkHookHandler = new BeanstalkHookHandler();

// Get post request from Beanstalk
$postValues = @file_get_contents('php://input');

// If there is a post values
if($postValues){

	// Get revision info
	$deploymentInfo = json_decode($postValues);

	// Save revision info
	$beanstalkHookHandler->logDeployment( 'pre-deployment', $deploymentInfo );

// Couldn't find post values
}else{

	// Add error to file log

}