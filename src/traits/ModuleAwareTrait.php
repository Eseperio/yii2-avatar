<?php

/*
 * This file is part of the 2amigos/yii2-usuario project.
 *
 * (c) 2amigOS! <http://2amigos.us/>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace eseperio\avatar\traits;

use eseperio\avatar\Module;
use Yii;

/**
 * @property-read Module $module
 */
trait ModuleAwareTrait
{
    /**
     * @return Module
     */
    public function getModule()
    {
        return Yii::$app->getModule('avatar');
    }
}
