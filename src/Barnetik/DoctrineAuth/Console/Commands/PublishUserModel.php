<?php namespace Barnetik\DoctrineAuth\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class PublishUserModel extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'doctrine-auth:publish:usermodel';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Copy the base User Model into the given path.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
	    $path = realpath(base_path($this->argument('path')));
	    if (!$path) {
	        $this->error("[PATH ERROR]");
	        $this->error("The given path doesn't exists.");
	        $this->error("Check and try again.");
	        $this->error(base_path($this->argument('path')));
	        return;
	    }
	    $finalPath = $path . "/User.php";
	    $this->info("Destination path:");
	    $this->comment($finalPath);
	    if ($this->confirm("Is this correct? [y|n]")) {
    	    copy(dirname(__FILE__) . '/../../../../resources/User.php', $finalPath);
            $this->info("The file has been copied");
	    } else {
	        $this->error("Model copy aborted");
	    }
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
		    ['path', InputArgument::REQUIRED, 'Path to locate the User Model.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
		];
	}

}
