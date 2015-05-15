<?php
/**
 * Created by PhpStorm.
 * User: anikulchin
 * Date: 5/15/15
 * Time: 1:57 PM
 */
defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Common extends Controller_Template {

    //public $template = 'main';
    public $session;
    public $template = 'template';
    public function before()
    {
        parent::before();
        //View::set_global('page_title','Персональный мобильный портал');
        View::set_global('description', 'Самый лучший сайт');
        //$this->template->styles = array('bootstrap');
        $this->template->page_title='Мой мобильный портал';
        $this->session = Session::instance();
        $this->template->styles=array('bootstrap','contextMenu','styles','bootstrap-social','font-awesome');
        $this->template->content = '';
        $this->template->scripts = array('bootstrap.min');
    }

} // End Common