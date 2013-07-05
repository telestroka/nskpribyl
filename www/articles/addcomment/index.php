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
if ($site->getUserAccess() < $config['access']['addcomment']) response(array('form' => 'У вас недостаточно прав для добавления комментария'));

$item = $site->getParamInt('item');
if (!$item) response(array('form' => 'Не удалось определить идентификатор статьи'));

$form = new Form();
$form->add('item', array('value' => $item));
$form->add('text', array('title' => 'Текст'));
$form->fill();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	//validation
	if (empty($form->text->value)) response(array('text' => 'Введите пожалуйста комментарий'));
    if (!isset($_REQUEST['key']) || $_REQUEST['key'] != '') response(array('form' => 'Доступ запрещен'));

	//process
    $formValues = $form->toArray();
    $formValues['user'] = $_SESSION['current_user']['id'];
    $formValues['ip'] = $_SERVER['REMOTE_ADDR'];
    $formValues['date'] = date('Y-m-d');
    $formValues['access'] = 0;

    $fields = $placeholders = $values = array();
    foreach ($formValues as $field => $value) {
        if (!isset($config['comments'][$field])) continue;
        $fields[] = $field;
        $placeholders[] = ':' . $field;
        $values[$field] = $value;
    }
    $st = $site->db->prepare(
        'INSERT INTO ' . $site->module . '_comments (' . implode(',', $fields) . ') values (' . implode(',', $placeholders) . ')'
    );
    $st->execute($values);
	$site->mail($site->owner, $_SERVER['HTTP_HOST'] . ' - add comment', $form->text->value);
    response();
}
response(array('form' => 'Отправка запросов должна быть только в формате POST'));