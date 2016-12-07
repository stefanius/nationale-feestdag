<?php

namespace Stefanius\NationalHolidayBundle\Controller;

use Stefanius\NationalHolidayBundle\Model\Domain;
use Stefanius\NationalHolidayBundle\Model\Page;
use Stefanius\SpecialDates\DateParser\Parser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    protected $months = [
        'januari'   => 1,
        'februari'  => 2,
        'maart'     => 3,
        'april'     => 4,
        'mei'       => 5,
        'juni'      => 6,
        'juli'      => 7,
        'augustus'  => 8,
        'september' => 9,
        'oktober'   => 10,
        'november'  => 11,
        'december'  => 12,
    ];

    protected function buildPage(array $data = [])
    {
        $page = new Page();

        $page = $this->setPageTitle($page, $data);
        $page = $this->setPageDescription($page, $data);

        $domain = new Domain($data['request']);

        if (array_key_exists('request', $data)) {
            $page->setDomainYear($domain->pickYear());
        }

        if ($domain->hasYearSpecificDomain()) {
            $page->setBrand("NATIONALE.FEESTDAGEN.{$domain->pickYear()}");
        } else {
            $page->setBrand("NATIONALE.FEESTDAG");
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

    public function indexAction(Request $request)
    {
        $domain = new Domain($request);

        $year = $domain->pickYear();

        $page = $this->buildPage([
            'title'       => $this->getIndexPageTitle($year),
            'description' => $this->getIndexPageDescription($year),
            'request'     => $request,
        ]);

        return $this->render($this->getIndexView($domain), [
            'page'   => $page,
            'domain' => $domain,
            'months' => array_keys($this->months),
        ]);
    }

    /**
     * @param Domain $domain
     *
     * @return string
     */
    protected function getIndexView(Domain $domain)
    {
        if ($domain->hasYearSpecificDomain()) {
            return 'StefaniusNationalHolidayBundle:YearDomain:index.html.twig';
        }

        return 'StefaniusNationalHolidayBundle:Default:index.html.twig';
    }


    protected function getIndexPageTitle($year)
    {
        if ($year > 0) {
            return 'Nationale Feestdagen ' . $year;
        }

        return 'Nederlandse Feestdagen';
    }

    protected function getIndexPageDescription($year)
    {
        if ($year > 0) {
            return 'In ' . $year . ' zijn er weer genoeg dagen om bij stil te staan! Bekijk daarom hier alle Nederlandse feestdagen en themadagen voor het hele jaar ' . $year;
        }

        return 'Nederlandse Feestdagen';
    }

    public function listAction(Request $request)
    {
        $domain = new Domain($request);

        $year = $domain->pickYear();

        $parser = new Parser();
        $dates = $parser->getAllValidDates($year);

        $page = $this->buildPage([
            'title'       => 'Totaal overzicht bijzondere dagen ' . $year,
            'description' => 'Bekijk hier het totale overzicht van bijzondere dagen voor ' . $year,
            'request'     => $request,
        ]);

        return $this->render('StefaniusNationalHolidayBundle:Default:list.html.twig', [
            'dates'  => $dates,
            'page'   => $page,
            'domain' => $domain,
        ]);
    }

    public function monthAction(Request $request, $dutchMonthName)
    {
        if (!array_key_exists($dutchMonthName, $this->months)) {
            return $this->redirect($this->generateUrl('stefanius_national_holiday_list_all'));
        }

        $domain = new Domain($request);

        $year = $domain->pickYear();

        $parser = new Parser();
        $dates = $parser->findSpecialDateByMonthNumber($year, $this->months[$dutchMonthName]);

        $page = $this->buildPage([
            'title'       => 'Bijzondere dagen ' . $dutchMonthName. ' '. $year,
            'description' => ucfirst($dutchMonthName) . ' ' . $year . ' heeft maar liefst ' . count($dates) . ' dagen om bij stil te staan. Bekijk het hele overzicht van ' . $dutchMonthName,
            'request'     => $request,
        ]);

        return $this->render('StefaniusNationalHolidayBundle:YearDomain:bymonth.html.twig', [
            'dates'          => $dates,
            'page'           => $page,
            'domain'         => $domain,
            'dutchMonthName' => $dutchMonthName,
            'monthNumber'    => $this->months[$dutchMonthName],
            'months'         => array_keys($this->months),
        ]);
    }

    public function monthWithoutDomainYearAction(Request $request, $year, $dutchMonthName)
    {
        if (!array_key_exists($dutchMonthName, $this->months)) {
            return $this->redirect('/');
        }

        if (strlen($year) !== 4 || $year < 1500 || !is_numeric($year)) {
            return $this->redirect('/');
        }

        $domain = new Domain($request);

        $parser = new Parser();
        $dates = $parser->findSpecialDateByMonthNumber($year, $this->months[$dutchMonthName]);

        $page = $this->buildPage([
            'title'       => 'Feestelijke dagen in ' . $year . ' - ' . $dutchMonthName,
            'description' => $year . ' - ' . ucfirst($dutchMonthName) . ' bevat ' . count($dates) . ' bijzondere dagen! Naast ' . $dutchMonthName . ' hebben we ook de andere maanden in kaart gebracht voor ' . $year,
            'request'     => $request,
        ]);

        $page->setDomainYear($year);

        return $this->render('StefaniusNationalHolidayBundle:Default:bymonth.html.twig', [
            'dates'          => $dates,
            'page'           => $page,
            'domain'         => $domain,
            'dutchMonthName' => $dutchMonthName,
            'monthNumber'    => $this->months[$dutchMonthName],
            'months'         => array_keys($this->months),
        ]);
    }
}
