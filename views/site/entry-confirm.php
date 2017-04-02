<?php
use yii\helpers\Html;
?>

<p>Unijeli ste sljedece informacije:</p>

<ul>
	<li><label>Ime</label>:<?= Html::encode($model->name); ?></li>
	<li><label>Email</label>:<?= Html::encode($model->email); ?></li>
</ul>


