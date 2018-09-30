<?php

namespace common\components;

use common\models\product\ProductImages;
use common\models\cell\CellImages;

class FileHelper {

    public static function getProductPath($id) {
        $file = ProductImages::findOne($id);
        return "/".$file->path . $file->name .".". $file->extension;
    }

    public static function getContentPath($id) {
        $file = CellImages::findOne($id);
        return "/".$file->path . $file->name .".". $file->extension;
    }
    
}
