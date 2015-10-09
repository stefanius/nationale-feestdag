<?php

namespace Stefanius\NationalHolidayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('StefaniusNationalHolidayBundle:Default:index.html.twig', array('name' => $name));
    }
}
