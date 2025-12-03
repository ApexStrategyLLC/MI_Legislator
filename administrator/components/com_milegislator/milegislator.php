<?php

declare(strict_types=1);

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;

$controller = BaseController::getInstance('Milegislator', ['base_path' => __DIR__]);
$input = Factory::getApplication()->getInput();
$controller->execute($input->getCmd('task', 'display'));
$controller->redirect();
