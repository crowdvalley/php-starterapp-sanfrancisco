<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BaseController extends Controller
{
    protected $params = array();
    protected $_request = null;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->_request = $container->get('request');
        $this->containerInitialized();
    }

    //used to init values for controller
    public function containerInitialized()
    {
    }
}
