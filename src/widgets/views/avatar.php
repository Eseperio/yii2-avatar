<?php
/* @var $view \yii\web\View */
/* @var string $attribute */
/* @var array $imageOptions */
/* @var boolean $isAdmin */

/* @var string $mimeTypes */

/* @var string $avatarFile */

use yii\helpers\Url;


?>

<div class="avatar-box" id="<?= $id ?>">
    <img <?= \yii\helpers\Html::renderTagAttributes($imageOptions) ?>
            src="<?= Url::to(['/avatar/avatar/picture', 'id' => $avatarFile]) ?>"/>
    <?php if ($canUpdate): ?>
        <div class="avatar-spinner">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
        <div class="avatar-loader">
            <input id="av-input-<?= $id ?>" type="file" accept="<?= implode(',', $mimeTypes) ?>"/>
            <label for="av-input-<?= $id ?>"><span>
        <?= Yii::t('avatar', 'Change') ?></span></label>

        </div>
        <span class="remove-avatar" title="<?= Yii::t('avatar','Remove') ?>">
X
        </span>

    <?php endif; ?>
</div>