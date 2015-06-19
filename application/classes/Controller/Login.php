<?php
/**
 * Created by PhpStorm.
 * User: anikulchin
 * Date: 5/15/15
 * Time: 5:32 PM
 */
defined('SYSPATH') or die('No direct script access.');

class Controller_Login extends Controller {
//  public $template = 'main';

    public function action_index()
    {
      $content = View::factory('login')
            ->set('social_login_caption','Вход через социальную сеть')
            ->set('google_href','https://accounts.google.com/o/oauth2/auth')
            ->set('google_redirect_uri',isset($_SERVER['DEBUG_LOCAL'])?'http://m.sharein.ru/auth/google&response_type=code':'http://m.sharein.ru/auth/google&response_type=code')
            ->set('google_client_id','62701041915-id05msd2pgu9omtcmn5rphhgb9f46sna.apps.googleusercontent.com')
            ->set ('google_scope','https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile')
            ->set('facebook_href','/auth/facebook')
            ->set('twitter_href','/auth/twitter');

        $this->response->body($content);
    }
} // End Login
