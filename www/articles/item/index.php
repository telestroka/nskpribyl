<?php
require('../../core/init.php');
require('../init.php');
$site->setPage(basename(dirname(__FILE__)));

$id = $site->getParamInt('id');
if (!$id) $site->redirect($site->moduleUrl);

if (isset($config['items'])) {
	$item = $site->db->query('SELECT * FROM ' . $site->module . '_items' . ' WHERE id = ' . $id . ';')->fetch();
} else {
	$items = parse_ini_file($site->moduleItemsPath . '/items.ini', true);
	$item = $items[$id];
}

if (empty($item)) $site->redirect($site->moduleUrl);

$form = new Form();
$form->add('title', array('title' => 'Заголовок', 'value' => $item['title']));

if (isset($config['comments'])) {
	$comments = $site->db->query('SELECT * FROM ' . $site->module . '_comments' . ' WHERE item = ' . $id . ' AND access=1 ORDER BY id;')->fetchAll();
}

include($site->layoutPath . '/default.phtml');