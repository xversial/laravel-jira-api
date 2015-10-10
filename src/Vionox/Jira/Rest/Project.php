<?php namespace Vionox\Jira\Rest;

use Illuminate\Support\Collection;

use Vionox\Jira\Rest\ApiInterface;

use Vionox\Jira\Rest\Project\Lead;

class Project extends JiraModel
{
	protected $project;

	protected $id;

	public $name;

	protected $issueTypes;

	public function __construct(array $project = array())
	{
		$this->project = $project;

		if(null !== $project)
		{
			$this->loadProperties($project);
		}
	}

	/**
	 * Create a new collection instance if the value isn't one already.
	 *
	 * @param $project
	 * @return Project[]
	 */
	public static function make($project)
	{
		if (is_null($project)) return new static;

		if ($project instanceof Project) return $project;

		return new static(is_array($project) ? $project : array($project));
	}

	public function id()
	{
		return $this->id;
	}

	public function key()
	{
		return $this->key;
	}

	public function lead()
	{
		return Lead::make($this->project['lead']);
	}

	/**
	 * @return \chobie\Jira\Issue[]
	 */
	public function issues()
	{
		return \Jira::listProjectIssues($this->key);
	}
}