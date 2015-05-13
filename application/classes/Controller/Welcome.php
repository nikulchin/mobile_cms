<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Template {

	public function action_index()
	{
		$this->response->body('hello, world!');
	}
    public function action_test()
    {
        $content = View::factory('login');
        $this->template->content = $content;
        #$this->response->body(View::factory('login'));
    }

} // End Welcome
