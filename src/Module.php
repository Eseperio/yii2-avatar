<?php

namespace eseperio\avatar;


use yii\i18n\PhpMessageSource;

class Module extends \yii\base\Module
{
    const FORMAT_PNG = 1;
    const FORMAT_JPG = 2;

    /**
     * @var bool whether create the target directories if they do not exists.
     */
    public $createDirectories=false;
    /**
     * @var int size of thumbnail size
     */
    public $thumbWidth= 150;
    /**
     * @var int size of thumbnail size
     */
    public $thumbHeight= 150;
    /**
     * @var string
     */
    public $outputFormat = 2; //Defaults to jpg. See Module::FORMAT_JPG
    /**
     * @var bool whether keep the original uploaded file
     */
    public $keepOriginal = true;
    /**
     * @var string suffix to be appended to original files. If keep original enabled
     */
    public $originalSuffix = '_or';
    /**
     * @var string directory where the files will be uploaded
     */
    public $uploadDir = '@app/uploads/';
    /**
     * @var string directory to store thumbs generated
     */
    public $thumbsDir = '@app/images/thumbs';
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
    /**
     * @var array list of allowed mimetypes
     */
    public $mimeTypes = [];

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