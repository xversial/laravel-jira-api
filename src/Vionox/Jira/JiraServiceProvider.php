<?php namespace Vionox\Jira;

use Illuminate\Support\ServiceProvider;

class JiraServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		//$this->package('Vionox/jira');
		$configPath = __DIR__ . '/../../config/vionox.jira.php';
		if (function_exists('config_path')) {
			$publishPath = config_path('vionox.jira.php');
		} else {
			$publishPath = base_path('config/vionox.jira.php');
		}
		$this->publishes([$configPath => $publishPath], 'config');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $configPath = __DIR__ . '/../../config/vionox.jira.php';
		$this->mergeConfigFrom($configPath, 'vionox.jira');

		$this->app['jira'] = $this->app->share(function($app)
		{

			$config = $this->loadConfiguration();

			return new \Vionox\Jira\Rest\Api(

				$this->getJiraApiUrl(),

				new \chobie\Jira\Api\Authentication\Basic($config['name'], $config['password'])

			);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

	public function getJiraApiUrl()
	{
		$config = $this->loadConfiguration();

		if( $config['secure'] )
		{
			return "https://" . $config['api_url'];
		}

		return "http://" . $config['api_url'];
	}

	/**
	 * Load the configuration for accessing Jira.
	 *
	 * @return array
	 */
	public function loadConfiguration()
	{
		$filesystem = new \Illuminate\Filesystem\FileSystem;

		$packageConfigDir = __DIR__ . '/../../config/config.php';

		$appConfigDir = app_path() . '/../config/vionox.jira.php';

		if($filesystem->exists($appConfigDir))
		{
			return require $appConfigDir;
		}
		else
		{
			return require $packageConfigDir;
		}
	}

}
