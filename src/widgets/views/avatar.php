<?php
/* @var $view \yii\web\View */

/** @var string $attribute */

?>

<div class="avatar-box" id="<?= $id ?>">
    <img style="" class="avatar-image"
         src=""/>
    <div class="avatar-spinner">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
    <div class="avatar-loader"><input id="av-input-<?= $id ?>" type="file" accept="image/jpeg"/>
        <label for="av-input-<?= $id ?>"><span>
        <?= Yii::t('avatar', 'Change') ?></span></label></div>

</div>