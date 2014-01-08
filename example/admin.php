<?php

header('Content-type: text/html; charset=utf8');

require '../dynamicForm.php';

$form = new DynamicForm(array(
    'variable' => 'ayarlar',
    'file' => 'ayarlar.php',
    'path' => realpath('.')
));

$form->config(array(
    array('Kişisel Bilgiler'),
    array(
        'name' => 'adsoyad',
        'text' => 'Adınız ve soyadınız!'
    ),
    array(
        'name' => 'eposta',
        'text' => 'E-posta adresini yazın!',
        'desc' => 'Geçerli bir eposta adresi girin!'
    ),
    array(
        'name' => 'telefon',
        'text' => 'Telefon numarası'
    ),
    array(
        'name' => 'web',
        'text' => 'Site adresi'
    ),
    array(
        'name' => 'hakkinda',
        'text' => 'Bir şeyler söyleyin',
        'field' => 'textarea'
    ),
    array('Sosyal Bilgiler'),
    array(
        'name' => 'facebook',
        'text' => 'Facebook Adresiniz'
    ),
    array(
        'name' => 'twitter',
        'text' => 'Twitter Adresiniz'
    ),
    array(
        'name' => 'youtube',
        'text' => 'Youtube Adresiniz'
    )
));

?>

<form action="" method="post">
    <?php $form->create(); ?>
    <input type="submit" name="submit" value="Kaydet" />
</form>

<?php
    if ( isset($_POST['submit']) ){
        $form->update();
        header('Location:admin.php');
    }
?>
