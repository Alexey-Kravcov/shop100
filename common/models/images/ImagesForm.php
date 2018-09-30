<?

namespace common\models\images;

use yii\base\Model;

class ImagesForm extends Model {
    public $preview_image;
    public $detail_image;

    public function rules() {
        return [
            [['preview_image', 'detail_image'], 'file', 'extensions'=> ['jpg', 'png']]
        ];
    }

    private function magic($name, $value) {
        $this->$name = $value;
    }

    function __set($name, $value) {
        $this->magic($name, $value);
    }

}
?>