<?php
/* @var $view \yii\web\View */
/** @var string $attribute */

\eseperio\avatar\assets\AvatarAsset::register($this);
?>

<div class="panel panel-default">
    <div class="panel-body">
        Avatar
    </div>
    <div class="panel-body">
        <img src="" alt="">

        <div class="loader"><input type="file" name="avatar" accept="image/jpeg" id="change-avatar"/>
            <label for="change-avatar"><span><?= Yii::t('xenon', 'Change') ?></span></label></div>
        <?php
        $form = \yii\widgets\ActiveForm::begin();

        echo $form->field($model, $attribute)->fileInput();

        \yii\widgets\ActiveForm::end();
        ?>
    </div>
</div>