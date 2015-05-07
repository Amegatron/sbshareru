<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CalculateAllCounters extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'counters:all';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Runs all "counters" commands.';

    /**
     * Create a new command instance.
     *
     * @return \CalculateAllCounters
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
		$this->call('counters:planets');
        $this->call('counters:comments');
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
