<?php defined('SYSPATH') or die('No direct script access.');
define( "DB_DSN", "mysql:host=localhost;dbname=gallery" );
define( "DB_USERNAME", "gallery_cms" );
define( "DB_PASSWORD", "!hw8eKKXc*x&" );
define("USERS_TABLE", "users");

class Controller_Auth extends Controller {

    // Определяем шаблон по умолчанию
    //public $template = 'main';
    public $session;
    public function action_about()
    {
        $content = View::factory('/pages/about');
        //$this->template->title = 'О сайте';
        // $this->template->description = 'Страница о сайте';
        $this->template->content = $content;

    }
    protected function register($login)
    {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $time = time();
        $st = $conn->prepare("SELECT SQL_CALC_FOUND_ROWS id from  " . USERS_TABLE . " WHERE login = :login limit 1");
        $st->bindValue(":login", $login, PDO::PARAM_STR);
        $st->execute();

        if ($row = $st->fetch()) {
            $_SESSION['userId'] = $row['id'];
        }
        else {
            $st = $conn->prepare("INSERT INTO users set `login` = :login");
            $st->bindValue(":login", $login, PDO::PARAM_STR);
            $st->execute();

            $_SESSION['userId'] = $conn->lastInsertId();
        }


        $conn = null;
    }

    public function action_google()
    {
        $this->session = Session::instance();
        $client_id = '62701041915-id05msd2pgu9omtcmn5rphhgb9f46sna.apps.googleusercontent.com'; // Client ID
        $client_secret = '-8vpblQWTe3R9ysPSzNTAOKC'; // Client secret
        $redirect_uri = 'http://m.sharein.ru/auth/google'; // Redirect URI

        $url = 'https://accounts.google.com/o/oauth2/auth';

        $params = array(
            'redirect_uri'  => $redirect_uri,
            'response_type' => 'code',
            'client_id'     => $client_id,
            'scope'         => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile'
        );

        if (isset($_GET['code']))
        {
            $result = false;

            $params = array(
                'client_id'     => $client_id,
                'client_secret' => $client_secret,
                'redirect_uri'  => $redirect_uri,
                'grant_type'    => 'authorization_code',
                'code'          => $_GET['code']
            );

            $url = 'https://accounts.google.com/o/oauth2/token';
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($curl);
            curl_close($curl);
            $tokenInfo = json_decode($result, true);

            if (isset($tokenInfo['access_token'])) {
                $params['access_token'] = $tokenInfo['access_token'];

                $userInfo = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo' . '?' . urldecode(http_build_query($params))), true);
                if (isset($userInfo['id'])) {
                    //       $userInfo = $userInfo;
                    $result = true;
                }


                if ($result) {
                    //$_SESSION['username'] = 'google' . $userInfo['id'];
                    $this->session->set('username', 'google'.$userInfo['id']);
                    $this->register($_SESSION['username']);
                    $this->redirect('/');
                    /*$this->template->content = "Социальный ID пользователя: " . $userInfo['id'] . '<br />'.
                        "Сессия пользователя: " . $this->session->get('username')  . '<br />'.
                        "Имя пользователя: " . $userInfo['name'] . '<br />'.
                        "Email: " . $userInfo['email'] . '<br />'.
                        "Ссылка на профиль пользователя: " . $userInfo['link'] . '<br />'.
                        "Пол пользователя: " . $userInfo['gender'] . '<br />'.
                        '<img src="' . $userInfo['picture'] . '" />'."<br />";*/
                }

            }

        }
        //$this->template->content = $content;

    }
    public function action_twitter(){
        $content = View::factory('/pages/underConstruction');
        $this->template->content = $content;
    }
    public function action_facebook(){
        $content = View::factory('/pages/underConstruction');
        $this->template->content = $content;
    }


}