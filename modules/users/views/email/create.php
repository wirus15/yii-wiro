<?php $this->emailSubject = Yii::app()->name.' - account created'; ?>

<h2>Your account has been created.</h2>

<p>You may now log in using the following credentials:</p>

<p>
    <strong>Username:</strong> <?= $user->username; ?><br/>
    <strong>Password:</strong> <?= $password; ?>
</p>

<p>
    Use this link to sign in:<br/>
    <?= CHtml::link($link, $link); ?>
</p>
