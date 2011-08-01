<?php
// Load hook handler
include('BeanstalkHookHandler.php');
$beanstalkHookHandler = new BeanstalkHookHandler();

// The Beanstalk environment name for which you want revision info
$environment = 'demo';

?><!DOCTYPE html>
<html lang="en">
	<head>
		<title>Revision Logging With Beanstalk Hooks</title>
		<link rel="stylesheet" href="my-cached-stylesheet.css?revision=<?php echo $beanstalkHookHandler->getLatestRevision( $environment ) ?>" media="screen">
	</head>
	<body>
		<h1>Revision Logging With Beanstalk Hooks</h1>
		<p>The current revision for environment <?php echo $environment ?> is <?php echo $beanstalkHookHandler->getLatestRevision( $environment ) ?></p>
	</body>
</html>