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
    public function action_login()
    {
        $content = View::factory('login')
            ->set('social_login_caption','Вход через социальную сеть')
            ->set('google_href','https://accounts.google.com/o/oauth2/auth')
            ->set('google_redirect_uri','http://m.sharein.ru/auth&response_type=code')
            ->set('google_client_id','62701041915-id05msd2pgu9omtcmn5rphhgb9f46sna.apps.googleusercontent.com')
            ->set ('google_scope','https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile');

        $this->template->page_title = 'Персональный мобильный портал';
        $this->template->content = $content;
        #$this->response->body(View::factory('login'));
    }

} // End Welcome
