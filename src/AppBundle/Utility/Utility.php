<?php
/**
 * Created by PhpStorm.
 * User: Raffaele
 * Date: 19/11/2016
 * Time: 10:28
 */

namespace AppBundle\Utility;


class Utility
{

    public static function loadFile($nameinputFile,$nomeCartella)
    {
       // define("UPLOAD_DIR", "../web/imgArt/");
        define("UPLOAD_DIR", "../web/ImmaginiApp/".$nomeCartella."/");

            if(isset($_FILES[$nameinputFile]))
            {
                $file = $_FILES[$nameinputFile];
                if($file["error"] == UPLOAD_ERR_OK and is_uploaded_file($file["tmp_name"]))
                {
                    move_uploaded_file($file['tmp_name'], UPLOAD_DIR.time().$file['name']);
                    return (time().$file['name']);
                }
            }
            else return null;

    }

}
