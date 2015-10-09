<?php

namespace Stefanius\NationalHolidayBundle\Controller;

use Stefanius\NationalHolidayBundle\Model\Page;
use Stef\SpecialDates\DateParser\Parser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    protected function buildPage(array $data = [])
    {
        $page = new Page();

        $page = $this->setPageTitle($page, $data);
        $page = $this->setPageDescription($page, $data);

        $page->setDomainYear($this->container->getParameter('app.domain_year'));

        return $page;

    }

    protected function setPageTitle(Page $page, array $data = [])
    {
        if (array_key_exists('title', $data)) {
            $page->setTitle($data['title']);
        }

        return $page;
    }

    protected function setPageDescription(Page $page, array $data = [])
    {
        if (array_key_exists('description', $data)) {
            $page->setDescription($data['description']);
        }

        return $page;
    }

    public function indexAction()
    {
        $year = $this->container->getParameter('app.domain_year');

        $page = $this->buildPage([
            'title'       => 'Nationale Feestdagen ' . $year,
            'description' => 'In ' . $year . ' zijn er weer genoeg dagen om bij stil te staan! Bekijk daarom hier alle Nederlandse feestdagen en themadagen voor het hele jaar ' . $year,
        ]);

        return $this->render('StefaniusNationalHolidayBundle:Default:index.html.twig', [
            'page' => $page
        ]);
    }

    public function listAction()
    {
        $year = $this->container->getParameter('app.domain_year');

        $parser = new Parser();
        $dates = $parser->getAllValidDates($year);

        $page = $this->buildPage([
            'title'       => 'Totaal overzicht bijzondere dagen ' . $year,
            'description' => 'Bekijk hier het totale overzicht van bijzondere dagen voor ' . $year,
        ]);

        return $this->render('StefaniusNationalHolidayBundle:Default:list.html.twig', [
            'dates' => $dates,
            'page'  => $page,
        ]);
    }
}
