<?php

namespace Stefanius\NationalHolidayBundle\Controller;

use Stefanius\NationalHolidayBundle\Model\Page;
use Stef\SpecialDates\DateParser\Parser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    protected function buildPage(array $data = [])
    {
        $page = new Page();

        $page = $this->setPageTitle($page, $data);
        $page = $this->setPageDescription($page, $data);

        if (array_key_exists('request', $data)) {
            $page->setDomainYear($this->getDomainYear($data['request']));
        }

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

    protected function getDomainYear(Request $request)
    {
        $splitTld = explode('.', $request->getHttpHost());
        $splitOnDashes = explode('-', $splitTld[0]);

        return (int) $splitOnDashes[2];
    }

    public function indexAction(Request $request)
    {
        $year = $this->getDomainYear($request);

        $page = $this->buildPage([
            'title'       => 'Nationale Feestdagen ' . $year,
            'description' => 'In ' . $year . ' zijn er weer genoeg dagen om bij stil te staan! Bekijk daarom hier alle Nederlandse feestdagen en themadagen voor het hele jaar ' . $year,
            'request'     => $request,
        ]);

        return $this->render('StefaniusNationalHolidayBundle:Default:index.html.twig', [
            'page' => $page
        ]);
    }

    public function listAction(Request $request)
    {
        $year = $this->getDomainYear($request);

        $parser = new Parser();
        $dates = $parser->getAllValidDates($year);

        $page = $this->buildPage([
            'title'       => 'Totaal overzicht bijzondere dagen ' . $year,
            'description' => 'Bekijk hier het totale overzicht van bijzondere dagen voor ' . $year,
            'request'     => $request,
        ]);

        return $this->render('StefaniusNationalHolidayBundle:Default:list.html.twig', [
            'dates' => $dates,
            'page'  => $page,
        ]);
    }
}
