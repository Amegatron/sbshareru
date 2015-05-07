<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CalculatePlanetCounters extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'counters:planets';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Calculates the number of planets and resets cache.';

    /**
     * Create a new command instance.
     *
     * @return \CalculatePlanetCounters
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
        $counter = Planet::count();
        Cache::forever(Planet::$counterCacheKey, $counter);
        $this->info("There are " . $counter . " planets in DB.");
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
