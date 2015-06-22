<?php
/**
 * Created by PhpStorm.
 * User: anikulchin
 * Date: 6/19/15
 * Time: 6:47 PM
 */
defined('SYSPATH') or die('No direct script access.');
define( "MAX_FILE_SIZE", 10000000 );

class Controller_Ajax extends Controller {
    protected function isImageValid()
    {
        $allowedExts = array("gif", "jpeg", "jpg", "png");
        $temp = explode(".", $_FILES["fileToUpload"]["name"]);
        $extension = strtolower(end($temp));

        if ((($_FILES["fileToUpload"]["type"] == "image/gif")
                || ($_FILES["fileToUpload"]["type"] == "image/jpeg")
                || ($_FILES["fileToUpload"]["type"] == "image/jpg")
                || ($_FILES["fileToUpload"]["type"] == "image/pjpeg")
                || ($_FILES["fileToUpload"]["type"] == "image/x-png")
                || ($_FILES["fileToUpload"]["type"] == "image/png"))
            && ($_FILES["fileToUpload"]["size"] < MAX_FILE_SIZE)
            && in_array($extension, $allowedExts)
        ) {
            return 1;
        }
        return 0;
    }

    public function action_delete() {
        $id = $this->request->param('id');
        $img = Image::getById($id);
        $img->delete();
    }

    public function action_undelete() {
        $id = $this->request->param('id');
        $img = Image::getById($id);
        $img->undelete();
    }


    public function action_upload(){


            if ($_POST["label"]) {
        $label = $_POST["label"];
    }

    if ($this->isImageValid())
    {
        #echo "AAAAA";
        #exit;
        $temp = explode(".", $_FILES["fileToUpload"]["name"]);
        $extension = strtolower(end($temp));

        if ($_FILES["fileToUpload"]["error"] > 0) {
            $data["err_code"] =  $_FILES["fileToUpload"]["error"];
        } else {
            $data["upload"] = $_FILES["fileToUpload"]["name"];
            $data["type"] = $_FILES["fileToUpload"]["type"];
            $data["size"] = ($_FILES["fileToUpload"]["size"] / 1024) . "kB";
            //echo "Temp file: " . $_FILES["fileToUpload"]["tmp_name"] . "<br>\n";

            $filename = md5_file($_FILES['fileToUpload']['tmp_name']) . "." . $_FILES["fileToUpload"]["size"] . "." . $extension;

            $path = "images/" . substr($filename, 0, 2) . "/" . substr($filename, 2, 2);
            if (file_exists($path . "/" . $filename)) {
                $data["exist"] = "true";
            } else {
                $data["exist"] = "false";
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $path . "/" . $filename);
            }
            $img = new Image (
                        array("path" => $path . "/" . $filename, "label" => date("Ymd_His"))
                            );
            $img->insert();
            $data["thumbnail"] = $img->thumbnail;
            $data["imageId"] = $img->id;
            $data["filename"] = $filename;
            $data["path"] = $img->path;
        }
    } else {
        $data["error"] = "true";
        $data["err_msg"] = "Invalid file";
    }
    echo json_encode($data);



    }
}