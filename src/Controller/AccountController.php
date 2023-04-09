<?php
namespace Tiptone\AyddSchedule\Controller;

use Tiptone\Mvc\Controller\AbstractController;
use Tiptone\Mvc\View\View;
use Tiptone\AyddSchedule\Service\UserService;

class AccountController extends AbstractController
{
    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function indexAction()
    {
        return new View();
    }

    public function createAction()
    {

    }
}
