<?php

namespace eseperio\avatar\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;
use yii\widgets\ActiveFormAsset;

class AvatarAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . "/dist";

    public $js = [
        'js/avatar.js'
    ];

    public $css = [
      'css/avatar.css'
    ];

    public $depends = [
        JqueryAsset::class,
        ActiveFormAsset::class
    ];
}