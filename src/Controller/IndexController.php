<?php
namespace Tiptone\AyddSchedule\Controller;

use Tiptone\Mvc\Controller\AbstractController;
use Tiptone\Mvc\View\View;

/**
 * Class IndexController
 * @package Tiptone\AyddSchedule\Controller
 */
class IndexController extends AbstractController
{
    public function indexAction()
    {
        return new View();
    }
}

