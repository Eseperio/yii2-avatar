<div class="panel panel-default">
    <div class="panel-body">
        Avatar
    </div>
    <div class="panel-body">
        <img src="asda" alt="">

        <?php
        $form = \yii\widgets\ActiveForm::begin();

        echo $form->field($model,$attribute)->fileInput();

        \yii\widgets\ActiveForm::end();
        ?>
    </div>
</div>