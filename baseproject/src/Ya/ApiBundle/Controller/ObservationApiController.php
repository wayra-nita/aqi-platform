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
     * @Route("/api/observation/", name = "api_get_observation")
     */
    public function getObservationAction() {
        $em = $this->getDoctrine()->getManager();
        $observations = $em->getRepository('YaCoreModelBundle:Observation')
                ->findAll();

        return new \Symfony\Component\HttpFoundation\Response($this->get('serializer')->serialize($observations, "json"));
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
        // add air quality enum here
        // get $reportingArea
        $observation = $this->setIfAvailable($observation, $observationData, 'is_primary', 0);
        $observation = $this->setIfAvailable($observation, $observationData, 'parameter_name');
        $observation = $this->setIfAvailable($observation, $observationData, 'aqi_value');
        $observation = $this->setIfAvailable($observation, $observationData, 'is_action_day', 0);
        $observation = $this->setIfAvailable($observation, $observationData, 'discussion');
        $observation = $this->setIfAvailable($observation, $observationData, 'forecast_source');

        $em->persist($observation);
        $em->flush();

        $response = new Response();
        $response->setStatusCode('200', 'Record added');
        return $response;
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

    private function setIfAvailable(Observation $observation, $data, $source, $default = null) {
        $data = $this->getIfAvailable($data, $source);
        $method = $this->getMethod($source, 'set');
        if ($data) {
            $observation->$method($data);
        } elseif ($default !== null) {
            $observation->$method($default);
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
