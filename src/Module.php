<?php

namespace eseperio\avatar;


use yii\i18n\PhpMessageSource;

class Module extends \yii\base\Module
{

    /**
     * @var string directory where the files will be uploaded
     */
    public $uploadDir = 'uploads';

    /**
     * @var string name of the attribute to be used on forms
     */
    public $attributeName = 'image';
    /**
     * @var array validator to be used for image uploaded
     */
    public $imageValidator = [
        'class' => 'yii\validators\ImageValidator',
        'extensions' => 'png,jpg'
    ];

    public function init()
    {
        $this->registerTranslations();
        parent::init();
    }

    public function registerTranslations()
    {
        \Yii::$app->i18n->translations['avatar'] = [
            'class' => PhpMessageSource::class,
            'sourceLanguage' => 'en-EN',
            'basePath' => '@vendor/eseperio/yii2-avatar/src/i18n',
        ];
    }
}