<?php return array(
    /**
     * Set your JIRA Service Username here.
     * This is the name which you used to register with JIRA/Crowd.
     */
    'name' => env( 'ATLASSIAN_JIRA_USERNAME', ''),

    /**
     * Set your JIRA password here.
     * This is the password which you used to register with JIRA/Crowd.
     */
    'password' => env( 'ATLASSIAN_JIRA_PASSWORD', ''),

    /**
     * Set the hostname for your JIRA site.
     * This can be a cloud or internally hosted domain.
     * Ex. jira.vionox.com
     */
    'api_url' => env( 'ATLASSIAN_JIRA_HOSTNAME', 'jira.vionox.com'),

    /**
     * Set the protocal method for call Jira urls.
     * Setting to true will use https.
     */
    'secure' => env( 'ATLASSIAN_JIRA_SSL', false),
);