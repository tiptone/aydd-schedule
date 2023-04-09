<?php
namespace Tiptone\AyddSchedule\Controller;

use Tiptone\Mvc\Controller\AbstractController;
use Tiptone\Mvc\View\View;
use Tiptone\AyddSchedule\Service\ClassService;
use Tiptone\AyddSchedule\Service\SectionService;

/**
 * Class IndexController
 * @package Tiptone\AyddSchedule\Controller
 */
class IndexController extends AbstractController
{
    /**
     * @var SectionService
     */
    protected $sectionService;

    /**
     * @var ClassService
     */
    protected $classService;

    /**
     * @param ClassService $classService
     * @param SectionService $sectionService
     */
    public function __construct(ClassService $classService, SectionService $sectionService)
    {
        $this->classService = $classService;
        $this->sectionService = $sectionService;
    }

    public function indexAction()
    {
//        $classes = $this->classService->findAll();

        $view = new View();
//        $view->setVariable('classes', $classes);

//        $section = $this->sectionService->find(1);
//        $view->setVariable('section', $section);

        if (date('w') == '1') {
            $monday = new \DateTime();
        } else {
            $monday = new \DateTime('last Monday');
        }

        $sunday = new \DateTime('this Sunday');

        $sections = $this->sectionService->findWeeklySchedule($monday, $sunday);

        $schedule = [];

        foreach ($sections as $section) {
            $schedule[$section->getStartTime()->format('l')][] = $section;
        }

        $view->setVariable('schedule', $schedule);

        return $view;
    }
}

