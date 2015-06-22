<?php
define("IMAGES_CLASS_VIEW", "IMAGE_VIEW_V4");
define("IMAGES_CLASS_VIEW_EXT", "IMAGE_VIEW_EXT_V3");
define("IMAGES_TABLE", "images");
define("THUMB_HEIGHT", 132);
define("THUMB_WIDTH", 200);
define( "DB_DSN", "mysql:host=localhost;dbname=gallery" );
define( "DB_USERNAME", "gallery_cms" );
define( "DB_PASSWORD", "!hw8eKKXc*x&" );
define("IMAGES_ROOT", "images/");



/**
 * Класс для обработки статей
 */
class Image
{
    // Свойства

    /**
     * @var int ID картинок  из базы данных
     */
    public $id = null;

    /**
     * @var string Путь к файлу на диске
     */
    public $path = null;

    public $thumbnail = null;

    /**
     * @var string название
     */
    public $label = null;

    /**
     * @var int Дата первой публикации статьи
     */
    public $publicationDate = null;

    /**
     * @var string Логин пользователя
     */
    public $login = null;


    /**
     * Устанавливаем свойства с помощью значений в заданном массиве
     *
     * @param assoc Значения свойств
     */

    public function __construct($data = array())
    {

        // Default publication date value
        $this->publicationDate = time();

        if (isset($data['id']))         $this->id = (int)$data['id'];
        if (isset($data['path']))       $this->path = $data['path'];
        if (isset($data['publicationDate']) && $data['publicationDate'] != 0)
            $this->publicationDate = (int)$data['publicationDate'];
        if (isset($data['label'])) $this->label = preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['label']);
        if (isset($_SESSION["username"])) $this->login = $_SESSION["username"];
        if (isset($data['thumbnail']) && isset($data['thumbnail']) != '')
            $this->thumbnail = $data['thumbnail'];
        else
            $this->createThumbnail();
    }

    /**
     * Возвращаем объект статьи соответствующий заданному ID статьи
     *
     * @param int ID статьи
     * @return Article|false Объект статьи или false, если запись не найдена или возникли проблемы
     */
    public static function getById($id)
    {
        $session = Session::instance();
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "SELECT `id`, `path`,`thumbnail`, `label`, UNIX_TIMESTAMP(`publicationDate`) AS publicationDate FROM " . IMAGES_CLASS_VIEW_EXT .
                " WHERE `id` = :id  and `login` =: login";
        $st = $conn->prepare($sql);
        $st->bindValue(":id", $id, PDO::PARAM_INT);
        $st->bindValue(":login", $_SESSION["username"], PDO::PARAM_STR);
        $st->execute();
        $row = $st->fetch();
        $conn = null;
        if ($row) return new Image($row);
    }


    /**
     * Возвращает все (или диапазон) объектов картинок  в базе данных
     *
     * @param int Optional Количество строк (по умолчанию все)
     * @param string Optional Столбец по которому производится сортировка  статей (по умолчанию "publicationDate DESC")
     * @return Array|false Двух элементный массив: results => массив, список объектов картинок; totalRows => общее количество статей
     */

    public static function getList($numRows = 1000000, $order = "publicationDate DESC")
    {
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "SELECT SQL_CALC_FOUND_ROWS *, UNIX_TIMESTAMP(publicationDate) AS publicationDate FROM " . IMAGES_CLASS_VIEW .
            " where `login` = :login ORDER BY " . mysql_escape_string($order) . " LIMIT :numRows";

        $st = $conn->prepare($sql);
        $st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
        $st->bindValue(":login", $_SESSION["username"], PDO::PARAM_STR);
        $st->execute();
        $list = array();

        while ($row = $st->fetch()) {
            $image = new Image($row);
            $list[] = $image;
        }

        // Получаем общее количество картинок, которые соответствуют критерию
        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $conn->query($sql)->fetch();
        $conn = null;
        return (array("results" => $list, "totalRows" => $totalRows[0]));
    }


    /**
     * Вставляем текущий объект статьи в базу данных, устанавливаем его свойства.
     */

    public function insert()
    {
        $session = Session::instance();
        // Есть у объекта статьи ID?
        if (!is_null($this->id)) trigger_error("Image::insert(): Attempt to insert an Article object that already has its ID property set (to $this->id).", E_USER_ERROR);

        // Вставляем статью
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "INSERT INTO " . IMAGES_TABLE . " (`path`, `label`, `thumbnail`, `publicationDate`, `userId` )
                                        VALUES (:path, :label, :thumbnail, FROM_UNIXTIME(:publicationDate), :userId )";
        $st = $conn->prepare($sql);
        $st->bindValue(":path", $this->path, PDO::PARAM_STR);
        $st->bindValue(":thumbnail", $this->thumbnail, PDO::PARAM_STR);
        $st->bindValue(":label", $this->label, PDO::PARAM_STR);
        $st->bindValue(":publicationDate", $this->publicationDate, PDO::PARAM_INT);
        $st->bindValue(":userId", $session->get("userId"), PDO::PARAM_INT);
        #$st->bindValue(":userId", '234', PDO::PARAM_INT);
        //$st->bindValue(":userId",1 , PDO::PARAM_INT);
        $st->execute();
        $this->id = $conn->lastInsertId();
        $conn = null;
    }

    private function autoRotateImage($image)
    {
        $orientation = $image->getImageOrientation();
        switch ($orientation) {
            case imagick::ORIENTATION_BOTTOMRIGHT:
                $image->rotateimage("#000", 180); // rotate 180 degrees
                break;
            case imagick::ORIENTATION_RIGHTTOP:
                $image->rotateimage("#000", 90); // rotate 90 degrees CW
                break;
            case imagick::ORIENTATION_LEFTBOTTOM:
                $image->rotateimage("#000", -90); // rotate 90 degrees CCW
                break;
        }
    }

    public function createThumbnail()
    {
        $img_file = $this->path;
        $tmp = explode ( '/', $img_file);
        $name = end($tmp);

        $img = new Imagick($img_file);
        $this->autoRotateImage($img);
        //$img->resizeImage(THUMB_WIDTH, 0, imagick::FILTER_CATROM, 1);
        $img->cropThumbnailImage ( THUMB_WIDTH,THUMB_HEIGHT);
        $tmp_file = sys_get_temp_dir() . "/" . $name;
        $img->writeImage( $tmp_file );
        $tmp1 = explode('.',$name);
        $thumb_name = md5_file( $tmp_file) . "." . end($tmp1);
        $thumb_path = IMAGES_ROOT . substr($thumb_name, 0, 2) . "/" . substr($thumb_name, 2, 2);

        if (!file_exists($thumb_path . "/" . $thumb_name))
        {
            if (!file_exists($thumb_path)) {
                mkdir($thumb_path, 0777, true);
            }
            rename($tmp_file, $thumb_path . "/" . $thumb_name);
        }
        $this->thumbnail = $thumb_path . "/" . $thumb_name;
    }

    /**
     * Обновляем текущий объект картинки в базе данных
     */

    public function update()
    {

        // Есть ли у объекта статьи ID?
        if (is_null($this->imageID)) trigger_error("Image::update(): Attempt to update an Image object that does not have its ID property set.", E_USER_ERROR);

        // Обновляем статью
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "UPDATE " . IMAGES_TABLE . " SET path=:path, label=:label, thumbnail=:thumbnail,  publicationDate=FROM_UNIXTIME(:publicationDate)  WHERE id = :id and `userId` = :userId";
        $st = $conn->prepare($sql);
        $st->bindValue(":path", $this->path, PDO::PARAM_STR);
        $st->bindValue(":thumbnail", $this->thumbnail, PDO::PARAM_STR);
        $st->bindValue(":label", $this->label, PDO::PARAM_STR);
        $st->bindValue(":publicationDate", $this->publicationDate, PDO::PARAM_INT);
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->bindValue(":userId", $_SESSION["userId"], PDO::PARAM_INT);
        //$st->bindValue(":login", 1, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }


    /**
     * Удаляем текущий объект картинки из базы данных
     */

    public function delete()
    {

        // Есть ли у объекта статьи ID?
        if (is_null($this->id)) trigger_error("Image::delete(): Attempt to delete an Article object that does not have its ID property set.", E_USER_ERROR);

        // Удаляем статью
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $time = time();
        $st = $conn->prepare("UPDATE " . IMAGES_TABLE . " set deleted = FROM_UNIXTIME(:time) WHERE id = :id and `userId` = :userId LIMIT 1");
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->bindValue(":time", $time, PDO::PARAM_INT);
        $st->bindValue(":userId", $_SESSION["userId"], PDO::PARAM_INT);
        //$st->bindValue(":userId", 1, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }

    public function undelete()
    {

        // Есть ли у объекта статьи ID?
        if (is_null($this->id)) trigger_error("Image::delete(): Attempt to delete an Article object that does not have its ID property set.", E_USER_ERROR);

        // Удаляем статью
        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $time = time();
        $st = $conn->prepare("UPDATE " . IMAGES_TABLE . " set deleted = null WHERE id = :id and `userId` = :userId LIMIT 1");
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->bindValue(":userId", $_SESSION["userId"], PDO::PARAM_INT);
        //$st->bindValue(":userId", 1, PDO::PARAM_INT);
        $st->execute();
        $conn = null;
    }

}

?>

