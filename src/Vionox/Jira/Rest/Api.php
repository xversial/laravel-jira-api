<?php namespace Vionox\Jira\Rest;

use chobie\Jira\Api as ChobieJiraApi;
use Illuminate\Support\Collection;

/**
 * Class Api
 * @package Vionox\Jira\Rest
 */
class Api extends ChobieJiraApi
{
    protected $query = null;

    protected $projectName = null;

    /**
     * @return Collection|null
     */
    public function projects()
    {
        $resultCollection = new Collection( $this->getProjects()->getResult() );

        $this->query = $resultCollection;

        return $this->query;
    }

    /**
     * @param $projectName
     */
    public function setProjectName( $projectName )
    {
        $this->projectName = $projectName;
    }

    /**
     * @param $name
     * @return \chobie\Jira\Issue[]
     */
    public function listAssigneeIssues( $name )
    {
        $issues = $this->search( "assignee = $name" )->getIssues();

        return $issues;
    }

    /**
     * get the defined project
     *
     * @param string $projectKey
     * @return \Vionox\Jira\Rest\Project
     * @static
     */
    public function project( $projectKey )
    {
        $project = Project::make( $this->getProject( $projectKey ) );

        return $project;
        // do something with the project object
    }

    /**
     * @param $key
     * @param string $expand
     * @return \chobie\Jira\Issue
     */
    public function issue( $key, $expand = 'expand' )
    {
        $issue = $this->getIssue( $key, $expand );

        return $issue;
    }

    /**
     * get specified issue.
     *
     * issue key should be YOURPROJ-221
     *
     * @param $name
     * @param string $expand
     * @return ChobieJiraApi\Result|false|string
     */
    public function getIssue( $name, $expand = '' )
    {
        $issues = $this->search( "project = $name" )->getIssues();

        $this->projectName = $name;

        return $issues;
    }

    /**
     * @param null $value
     * @return int
     */
    public function count( $value = null )
    {
        // return the count of listProjectIssues

        $count = 0;

        if ( null !== $value ) {
            $count = count( $this->listProjectIssues( $value ) );
        } elseif ( null !== $this->projectName ) {
            $count = count( $this->listProjectIssues( $this->projectName ) );
        }

        return $count;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->query;
    }
}