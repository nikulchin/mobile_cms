<?php
/**
 * Created by PhpStorm.
 * User: anikulchin
 * Date: 6/19/15
 * Time: 4:54 PM
 */

defined('SYSPATH') or die('No direct script access.');

class Model_Gallery extends Model
{
    protected $_tableImages = 'V_IMAGES_ACTIVE';

    /**
     * Get all articles
     * @return array
     */
    public function get_all()
    {
        $session = Session::instance();
        $sql = "SELECT * FROM ". $this->_tableImages." WHERE userId = ".$session->get("userId")." ORDER BY id DESC";

        return DB::query(Database::SELECT, $sql)
            ->execute();
    }
    public function add($path, $thumbnail,$publicationDate)
    {
        return DB::insert('images', array('path', 'thumbnail','publicationDate'))
            ->values(array($path, $thumbnail,$publicationDate))
            ->execute();
    }

}
?>