<?php

namespace eseperio\avatar\widgets;

use eseperio\avatar\assets\AvatarAsset;
use eseperio\avatar\traits\ModuleAwareTrait;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

class Avatar extends \yii\base\Widget
{

    use ModuleAwareTrait;
    /**
     * @var array options for the image tag
     */
    public $imageOptions = [
        'class' => 'img-responsive'
    ];
    /**
     * @var null id of the avatar to display
     */
    public $avatarId = 'no-pic';
    /**
     * @var string attribute name
     */
    private $attributeName = "";

    public function init()
    {

        Html::addCssClass($this->imageOptions, 'avatar-image');
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
            'id' => $this->id,
            'avatarFile' => $this->module->getAvatarFileName($this->avatarId),
            'imageOptions' => $this->imageOptions,
            'canUpdate' => $this->module->canUpdate($this->avatarId),
            'mimeTypes' => $this->module->mimeTypes

        ]);
    }

    public function registerAssets()
    {
        AvatarAsset::register($this->view);
        $config = [
            'attributeName' => $this->attributeName,
            'update' => Url::to(['/avatar/avatar/upload']),
            'delete' => Url::to(['/avatar/avatar/delete']),
            'i18n'=>[
                'deleteMsg'=>\Yii::t('avatar','Remove avatar permanently? This can not be undone.')
            ]

        ];

        if ($this->module->canUpdate($this->avatarId)) {
            $config['avatarId'] = $this->avatarId;
        }
        $config = Json::htmlEncode($config);

        $this->view->registerJs(<<<JS
        $("#{$this->id}").yii2avatar($config);
JS

        );

    }
}