<?php
/**
 * This class handles POST requests sent by Beanstalk hooks
 */

class BeanstalkHookHandler{

	private $databaseName;
	private $databaseUser;
	private $databasePassword;
	private $databaseHost;

	function __construct(){
		$this->databaseName = 'deployments';
		$this->databaseUser = 'username';
		$this->databasePassword = 'password';
		$this->databaseHost = 'localhost';
	}

	/**
	 *
	 * Connects to database and runs a SQL query
	 * @param string $query
	 * @return mixed $result the MySQL resultset or false if query failed
	 */
	function query( $query ){

		// Connect to database server
		$connection = mysql_connect($this->databaseHost, $this->databaseUser, $this->databasePassword) or die( "Database connection error" );

		// Select database
		mysql_select_db(DB_NAME, $connection) or die("Database connection error. Could not select database.");

		// Run query
		$resultset =  mysql_query($query, $connection) or die( "SQL Error: ". mysql_error() . "<br>Query: ". $query );

		// Return resultset
		return $resultset;
	}

	/**
	 *
	 * Logs deployment info
	 * @param string $deployment_info JSON-encoded deployment info
	 * @return bool
	 */
	function logDeployment( $hook, $deploymentInfo ){

		// Decode JSON
		$deploymentInfo = json_decode( $deploymentInfo );

		// Save revision info
		$deploymentSQL = "INSERT INTO deployments ( revision, environment, hook, post_values ) VALUES ( '".$deploymentInfo->revision."','".$deploymentInfo->environment."', 'post-deployment', '".$deploymentInfo->environment."' )";
		$deploymentRS = $this->query( $deploymentSQL );

		// Return true if success
		return $deploymentRS ? true : false;

	}

	/**
	 *
	 * Gets latest revision of production site to be appended to cacheable resources
	 * @param string $environment
	 * @return int The latest revision number for a specific environment
	 */
	function getLatestRevision( $environment ){

		// Default value for revision parameter
		$revision = false;

		// Get latest deployment info
		$revisionSQL = "SELECT revision FROM deployments WHERE environment = '".$environment."' ORDER BY revision DESC LIMIT 1";
		$revisionRS = $this->query( $revisionSQL );

		// If query was successful and 1 row was found
		if( $revisionRS && mysql_num_rows( $revisionRS ) == 1 ){

			// Get revision number
			$deployment = mysql_fetch_object( $revisionRS );
			$revision = $deployment->revision;

		}

		// Return revision number
		return $revision;

	}

}