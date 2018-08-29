<?php

namespace eseperio\avatar\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class AvatarAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . "/dist";

    public $js = [
        'js/change-avatar.min.js'
    ];

    public $css = [
      'css/avatar.css'
    ];

    public $depends = [
        JqueryAsset::class
    ];
}