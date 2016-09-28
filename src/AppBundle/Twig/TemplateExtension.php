<?php

namespace AppBundle\Twig;

use Symfony\Component\Intl\Intl;

class TemplateExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            'daysLeft' => new \Twig_SimpleFilter('days_left', array($this, 'daysLeft')),
            'getFile' => new \Twig_SimpleFilter('get_file', array($this, 'getFile')),
            'getInfo' => new \Twig_SimpleFilter('get_info', array($this, 'getInfo')),
            'countryName' => new \Twig_SimpleFilter('countryName', array($this, 'countryName')),
            'getOfferingStatus' => new \Twig_SimpleFilter('get_status', array($this, 'getOfferingStatus')),
            'getDocuments' => new \Twig_SimpleFilter('get_documents', array($this, 'getDocuments'))
        );
    }

    /**
     * @param $params
     * @param $type
     * @param string $default
     * @return string
     */
    public function getInfo($params, $type, $default = '')
    {
        if(!empty($params['info'])) {
            foreach ($params['info'] as $data) {
                if ($data['type'] == $type) {
                    return $data['value'];
                }
            }
        }
        return $default;
    }

    /**
     * @param $params
     * @param $key
     * @param array $default
     * @return array
     */
    public function getFile($params, $key, $default = [])
    {
        if(!empty($params['file'])) {
            foreach ($params['file'] as $data) {
                if(!empty($data[$key])){
                    $default[$key][] = $data[$key];
                }
            }

            if(!empty($default) && count($default[$key]) == 1){
                return $default[$key] = $default[$key][0];
            }
        }
        return $default;
    }

    public function getDocuments($user)
    {
        $documents = [];
        if(!empty($user['file'])) {
            foreach ($user['file'] as $docArray) {
				foreach ($docArray as $document) {
				 	array_push($documents, $document);
				}
            }
        }
        return $documents;
    }


    /**
     * @param $countryCode
     * @return null|string
     */
    public function countryName($countryCode)
    {
        return Intl::getRegionBundle()->getCountryName($countryCode);
    }

    public function getOfferingStatus($infos, $lifeCycleStage)
    {        
        switch ($lifeCycleStage) {
            case 1: {
                return 'Submitted';
                break;
            }
            case 2: {
                return 'Rejected';
                break;
            }
            case 3: {
                return 'Approved';
                break;
            }
            case 4: {
                return 'Restricted';
                break;
            }                
            case 5: {
                return 'Published';
                break;
            }
            case 6: {
                return 'Live';
                break;
            }
            case 7: {
                return 'Closing';
                break;
            }
            case 8: {
                return 'Settled';
                break;
            }
            case 9: {
                return 'Canceled';
                break;
            }
            default:
                return 'Draft';
                break;
        }
    }

    /**
     * @param $date
     * @return string
     */
    public function daysLeft($date)
    {
        $current_date = new \DateTime(date("Y-m-d H:i:s"));
        $end_date = new \DateTime( $date );
        $interval = $current_date->diff($end_date);
        return $interval->format('%a');
    }

    public function getName()
    {
        return 'app_extension';
    }

}
