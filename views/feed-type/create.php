<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FeedType */

$this->title = 'Create Feed Type';
$this->params['breadcrumbs'][] = ['label' => 'Feed Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="feed-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
