<?php !defined('IN_APP') and header('location: /');

class Command_error extends Command {
	//  Let's go.
	public function __construct($arg = '') {
		parent::__construct();
		
		$this->arg = $arg;
	}
	
	//  And handle the argument
	public function run($arg) {
		$fails = array(
			'Task * not found.',
			'I beg your pardon?',
			'I will not be talked to in that way!',
			'Are you sure you spelt that right? * sounds wrong.',
			'0mgz0r5, you spelt a command wrong.',
			'What in blazes is *?',
			'* ain\'t no method I ever heard of.',
			'That does not exist, and probably never will do.',
			'Negatory, big buddy.',
			'Made a typo? * doesn\'t sound right.',
			'Bleep bloop bleep KTHWAWK.'
		);
		
		return str_replace('*', '"' . $this->arg . '"', $fails[mt_rand(0, count($fails) -1)]);
	} 
}