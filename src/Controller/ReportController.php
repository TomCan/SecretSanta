<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use App\Service\ExportReportQueriesService;

class ReportController extends Controller
{
    /**
     * @Route("/report/{year}", defaults={"year" = "all"}, name="report")
     * @Template()
     * @Method("GET")
     */
    public function indexAction(ExportReportQueriesService $exportReportQueriesService, string $year)
    {
        if ('all' !== $year) {
            if (false === strtotime($year)) {
                $year = date('Y');
            }
        }

        return $exportReportQueriesService->getReportQuery($year);
    }
}
