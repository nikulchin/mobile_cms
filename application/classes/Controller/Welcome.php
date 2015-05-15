<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Common {

	public function action_index()
	{
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : "";
        if (!$username) {
            $this->template->content = Request::factory('login/')->execute();
        }
	}

    public function action_test()
    {
        $content = View::factory('login');
        $this->template->content = $content;
        #$this->response->body(View::factory('login'));
    }


} // End Welcome
