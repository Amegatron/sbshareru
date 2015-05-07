<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CalculateCommentCounters extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'counters:comments';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Recalculates comment counters for each planet.';

    /**
     * Create a new command instance.
     *
     * @return \CalculateCommentCounters
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
		$counters = DB::table('comments')
            ->select(array(
                DB::raw('COUNT(*) as counter'),
                'planet_id'
            ))->groupBy('planet_id')
            ->get();

        $this->info("Going to update " . count($counters) . " planets ...");

        foreach($counters as $counter) {
            DB::table('planets')
                ->where('id', $counter->planet_id)
                ->update(array('comments_count' => $counter->counter));
        }

        $this->info('Done.');
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
