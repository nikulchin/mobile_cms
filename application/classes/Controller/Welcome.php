<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Common {

	public function action_index()
	{
/*        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 300)) {
            // last request was more than 30 minutes ago
            session_unset();     // unset $_SESSION variable for the run-time
            session_destroy();   // destroy session data in storage
        }
        $_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp*/
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : "";
        if (!$username) {
          $this->template->content = Request::factory('login/')->execute();
        }
        else {
            $this->template->content = Request::factory('gallery/')->execute();
        }
       // $this->template->content = Request::factory('login/')->execute();
	}

    public function action_test()
    {
//        $content = View::factory('login');
  //      $this->template->content = $content;
        #$this->response->body(View::factory('login'));
    }


} // End Welcome
