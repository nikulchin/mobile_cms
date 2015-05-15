<?php
/**
 * Created by PhpStorm.
 * User: anikulchin
 * Date: 5/15/15
 * Time: 5:32 PM
 */
defined('SYSPATH') or die('No direct script access.');

class Controller_Login extends Controller_Common {

    public function action_index()
    {
        $content = View::factory('login')
            ->set('social_login_caption','Вход через социальную сеть')
            ->set('google_href','https://accounts.google.com/o/oauth2/auth')
            ->set('google_redirect_uri','http://m.sharein.ru/auth/google&response_type=code')
            ->set('google_client_id','62701041915-id05msd2pgu9omtcmn5rphhgb9f46sna.apps.googleusercontent.com')
            ->set ('google_scope','https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile');

        $this->template->content = $content;
    }
} // End Login
