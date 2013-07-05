<?php
require('../../core/init.php');
require('../init.php');
$site->setPage(basename(dirname(__FILE__)));

function response($errors = null) {
    $result = array(
        'success' => $errors === null,
        'errors' => $errors
    );

    exit(json_encode($result));
}

header('Content-Type: application/json');
if ($site->getUserAccess() < $config['access']['addcomment']) response(array('form' => 'У вас недостаточно прав для добавления темы'));

$form = new Form();
$form->add('text', array('title' => 'Текст'));
$form->fill();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	//validation
	if (empty($form->text->value)) response(array('text' => 'Введите пожалуйста тему опроса'));
    if (!isset($_REQUEST['key']) || $_REQUEST['key'] != '') response(array('form' => 'Доступ запрещен'));

	//process
	$site->mail($site->owner, $_SERVER['HTTP_HOST'] . ' - add theme', $form->text->value);
    response();
}
response(array('form' => 'Отправка запросов должна быть только в формате POST'));