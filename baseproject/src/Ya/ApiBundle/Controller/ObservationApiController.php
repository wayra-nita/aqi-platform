<?php

namespace Ya\ApiBundle\Controller;

use Ya\CoreModelBundle\Entity\Observation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;

class ObservationApiController extends FOSRestController {

    /**
     * @Method("GET")
     * @Route("/api/observation", name = "api_get_observation")
     */
    public function getObservationAction()
    {
      $consumer = $this->container->get('consumer.visualization');
      $observations = $consumer->getAverageByQuadrant();
      var_dump(count($observations)); exit;
      echo json_encode($observations);
      exit;
    }

    /**
     * @Method("POST")
     * @Route("/api/observation", name = "api_post_observation", options={"expose"=true})
     * @param ParamFetcher $paramFetcher Paramfetcher
     */
    public function postObservationAction(Request $request) {
        $observation = new Observation();
        $observationData = $request->get('observation');
        if (!$observationData) {
            $response = new Response();
            $response->setStatusCode('400', '"observation" parameter is needed');
            return $response;
        }

        $em = $this->getDoctrine()->getManager();

        $observation = $this->setFromRepositoryById($observation, $observationData, 'partner_id', 'Partner');
        $observation = $this->setIfAvailable($observation, $observationData, 'issue_date');
        $observation = $this->setIfAvailable($observation, $observationData, 'valid_date');
        $observation = $this->setIfAvailable($observation, $observationData, 'time_zone');
        $observation = $this->setFromRepositoryById($observation, $observationData, 'sequence_id', 'SequenceEnum', 'setSequence');
        $observation = $this->setFromRepositoryById($observation, $observationData, 'data_type_id', 'DataTypeEnum', 'setDataType');

        $observation = $this->setIfAvailable($observation, $observationData, 'valid_date');
        if (isset($observationData['air_quality'])) {
            $airQualityCategory = $em->getRepository('YaCoreModelBundle:AirQualityCategory')->getByAqiValue($observationData['air_quality']);
            $observation->setAirQualityCategory($airQualityCategory);
        }
        if (isset($observation['country_code'])
                && isset($observation['region_code'])
                && isset($observation['city_name'])
                && isset($observation['latitude'])
                && isset($observation['longitude'])) {
            $reportingArea = $em->getRepository('YaCoreModelBundle:ReportingArea')
                    ->getOrCreateReportingArea($observation['country_code'], $observation['region_code'], $observation['city_name'], $observation['latitude'], $observation['longitude']);
            $observation->setReportingArea($reportingArea);
        }
        
        // get $reportingArea
        $observation = $this->setIfAvailable($observation, $observationData, 'is_primary', 0);
        $observation = $this->setIfAvailable($observation, $observationData, 'parameter_name');
        $observation = $this->setIfAvailable($observation, $observationData, 'aqi_value');
        $observation = $this->setIfAvailable($observation, $observationData, 'is_action_day', 0);
        $observation = $this->setIfAvailable($observation, $observationData, 'discussion');
        $observation = $this->setIfAvailable($observation, $observationData, 'forecast_source');

        $em->persist($observation);
        $em->flush();
    }

    private function setFromRepositoryById(Observation $observation, $data, $source, $className, $method = null, $bundle = 'YaCoreModelBundle') {
        $id = $this->getIfAvailable($data, $source);
        $em = $this->getDoctrine()->getManager();
        if ($id) {
            $model = $em->getRepository($bundle . ':' . $className)->find($id);
        }
        if (!$method) {
            $method = 'set' . $className;
        }
        if ($model) {
            $observation->$method($model);
        }
        return $observation;
    }

    private function getIfAvailable($data, $source) {
        if (isset($data[$source])) {
            return $data[$source];
        }
        return null;
    }

    private function setIfAvailable(Observation $observation, $data, $source) {
        $data = $this->getIfAvailable($data, $source);
        $method = $this->getMethod($source, 'set');
        if ($data) {
            $observation->$method($data);
        }
        return $observation;
    }

    private function getMethod($string, $prepend = '') {
        $func = create_function('$c', 'return strtoupper($c[1]);');
        $string = preg_replace_callback('/_([a-z])/', $func, $string);
        if ($prepend) {
            $string[0] = strtoupper($string[0]);
            $string = $prepend . $string;
        }
        return $string;
    }

}
