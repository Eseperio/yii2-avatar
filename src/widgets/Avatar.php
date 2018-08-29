<?php

namespace eseperio\avatar\widgets;

use eseperio\avatar\models\UploadForm;
use eseperio\avatar\traits\ModuleAwareTrait;

class Avatar extends \yii\base\Widget
{

    use ModuleAwareTrait;

    public function run()
    {
        $module = $this->getModule();

        return $this->render('avatar', [
            'attribute' => $module->attributeName,
            'model' => new UploadForm()
        ]);
    }
}