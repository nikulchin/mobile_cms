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
    protected $_tableImages = 'IMAGE_VIEW_V3';

    /**
     * Get all articles
     * @return array
     */
    public function get_all()
    {
        $sql = "SELECT * FROM ". $this->_tableImages;

        return DB::query(Database::SELECT, $sql)
            ->execute();
    }
}
?>