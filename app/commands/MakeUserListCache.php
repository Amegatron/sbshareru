<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakeUserListCache extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'users:cache';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Rebuilds user-list cache.';

    /**
     * Create a new command instance.
     *
     * @return \MakeUserListCache
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
		$users = User::active()->lists('username');
        Cache::forever(User::CACHE_LIST_KEY, $users);
        $this->info('There are ' . count($users) . ' active users in total.');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array();
	}

}
