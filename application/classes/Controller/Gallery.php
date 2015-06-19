<?php
/**
 * Created by PhpStorm.
 * User: anikulchin
 * Date: 6/19/15
 * Time: 3:48 PM
 */
defined('SYSPATH') or die('No direct script access.');
class Controller_Gallery extends Controller {
    public function action_index()
    {
  //    $content = View::factory('pages/gallery');
//      $content->images =array('a6/1c/a61cd5dab648b600eeac620324ca7ca8.1907530.jpg');


        $images = array();

        $content = View::factory('/pages/gallery')
            ->bind('images', $images);

        $images = Model::factory('gallery')->get_all();

        $this->response->body($content);

    }
}