<?php

namespace eseperio\avatar\widgets;

use eseperio\avatar\assets\AvatarAsset;
use eseperio\avatar\traits\ModuleAwareTrait;
use yii\helpers\Json;
use yii\helpers\Url;

class Avatar extends \yii\base\Widget
{

    use ModuleAwareTrait;

    /**
     * @var string attribute name
     */
    private $attributeName = "";

    public function init()
    {
        $module = $this->getModule();
        $this->attributeName = $module->attributeName;

        $this->id = 'avatar-' . $this->getId();
        parent::init();
    }

    public function run()
    {

        $this->registerAssets();

        return $this->render('avatar', [
            'attribute' => $this->attributeName,
            'id' => $this->id

        ]);
    }

    public function registerAssets()
    {
        AvatarAsset::register($this->view);
        $config = Json::htmlEncode([
            'attributeName' => $this->attributeName,
            'url' => Url::to(['/avatar/avatar/upload'])
        ]);
        $this->view->registerJs(<<<JS
        $("#{$this->id}").yii2avatar($config);
JS

        );

    }
}