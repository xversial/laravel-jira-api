<?php namespace Vionox\Jira\Rest;

interface ApiInterface
{
    public function getProjects();

    public function getProject( $projectKey );

    /**
     * get specified issue.
     *
     * issue key should be YOURPROJ-221
     *
     * @param $issueKey
     * @param $expand
     * @return \chobie\Jira\Api\Result|string|false
     */
    public function getIssue( $issueKey, $expand = '' );

    public function search( $jql, $startAt = 0, $maxResult = 20, $fields = '*navigable' );

    public function api(
        $method = self::REQUEST_GET,
        $url,
        $data = array(),
        $return_as_json = false,
        $isfile = false,
        $debug = false
    );
}