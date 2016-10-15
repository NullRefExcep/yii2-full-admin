<?php
use nullref\fulladmin\widgets\Flash;
use nullref\core\widgets\WidgetContainer;

/* @var $this \yii\web\View */
/* @var $content string */

?>

<?php $this->beginContent('@nullref/fulladmin/views/layouts/base.php') ?>
    <div id="wrapper">

        <?= $this->render('header') ?>

        <div id="page-wrapper">
            <?= Flash::widget() ?>
            <?= $content ?>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
<?= WidgetContainer::widget(['widgets' => Yii::$app->getModule('admin')->globalWidgets]) ?>

<?php $this->endContent('@nullref/fulladmin/views/layouts/base.php') ?>