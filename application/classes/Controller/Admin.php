<?php
/**
 * Created by PhpStorm.
 * User: anikulchin
 * Date: 5/15/15
 * Time: 6:05 PM
 */
defined('SYSPATH') or die('No direct script access.');

class Controller_Admin extends Controller_Common {

    public function action_index()
    {
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : "";

        if (!$username) {
            $this->redirect('/');
        }
        $content = View::factory('admin');
        $this->template->content = $content;
    }
} // End Login
