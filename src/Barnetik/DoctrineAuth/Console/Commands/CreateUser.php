<?php namespace Barnetik\DoctrineAuth\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateUser extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'doctrine-auth:user:create';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

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
		$user = new \Barnetik\DoctrineAuth\User;
        $user->setUsername($this->option('username'));
        $user->setPassword($this->option('password'));
        $em = \App::make('Doctrine\ORM\EntityManager');
        $em->persist($user);
        $em->flush();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
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
			['username', 'u', InputOption::VALUE_REQUIRED, 'User Identity.', null],
			['password', 'p', InputOption::VALUE_REQUIRED, 'User Password.', null],
		];
	}

}
