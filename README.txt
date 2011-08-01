Revision logging with Beanstalk deployment hooks

We use Beanstalk post-deployment hook to log our website's latest revision number. We then append that revision to our cacheable resources (mostly CSS and javascript). This allows us to cache files forever, yet always serve fresh files if a change to the website has been made.

Step 1: Create database table by running the query in database.sql
Step 2: Update the database connection info in BeanstalkHookHandler.php
Step 3: Set up deployment hooks in your Beanstalk account
Step 4: Add revision info to your cached resources (see index.php)