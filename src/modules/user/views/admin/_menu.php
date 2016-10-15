<?php

use yii\helpers\Html;
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title) ?></h1>
    </div>
</div>
<p>
    <?= Html::a(Yii::t('user', 'Users'), ['/user/admin/index'], ['class' => 'btn btn-success']) ?>
    <?= Html::a(Yii::t('user', 'Add New user'), ['/user/admin/create'], ['class' => 'btn btn-success']) ?>
</p>