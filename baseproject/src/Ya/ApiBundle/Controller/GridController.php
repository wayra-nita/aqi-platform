<?php

namespace Ya\ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use Ya\DataConsumerBundle\Services\VisualizationService;
use Ya\CoreModelBundle\Entity\AirQualityCategory;


class GridController extends FOSRestController {
    private static $horizontalSegments = 3;
    private static $verticalSegments   = 3;
    /**
     * @Method("POST")
     * @Route("/api/get_grid", name = "api_get_grid_data", options = {"expose"=true})
     */
    public function getGridAction(Request $request) {
        $neLat = $request->get('neLat');
        $neLng = $request->get('neLng');
        $swLat = $request->get('swLat');
        $swLng = $request->get('swLng');
        $squares = $this->getSquares($neLat, $neLng, $swLat, $swLng);
        $squares = $this->fillColors($squares);
        return new Response($this->get('serializer')->serialize($squares, "json"));
    }
    
    private function fillColors($squares) {
        $em = $this->getDoctrine()->getEntityManager();
        $visualization = $this->container->get('consumer.visualization');
        foreach ($squares as &$square) {
            $count = $visualization->getCountInQuadrant($square['coord']['ne']['lt'],
              $square['coord']['ne']['lg'],
              $square['coord']['sw']['lt'],
              $square['coord']['sw']['lg']);
            if (!$count) {
                $square['color'] = '#FFFFFF';
                $square['name']  = 'Not enough data';
                $square['average'] = 0;
                continue;
            }
            //$average = $visualization->getAverageByQuadrant(32.9, -112.072, 43.1105, -110.972);
            $average = $visualization->getAverageByQuadrant($square['coord']['ne']['lt'],
              $square['coord']['ne']['lg'],
              $square['coord']['sw']['lt'],
              $square['coord']['sw']['lg']);
            $average = (int)round($average);
            $airQualityCategory = $em->getRepository('YaCoreModelBundle:AirQualityCategory')->getByAqiValue($average);
            $airQualityCategory = $airQualityCategory[0];
            $square['color'] = $this->convertRgbToHex($airQualityCategory->getColorCode());
            $square['name']  = $airQualityCategory->getName();
            $square['average'] = $average;
        }
        return $squares;
    }
    
    private function convertRgbToHex($rgb) {
        $rgb = explode(',', $rgb);
        $hex = "#";
        $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
        $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);
        return $hex;
    }
    
    private function getSquares($neLat, $neLng, $swLat, $swLng) {
        // horizontal, lng
        $horizontalIncrement = (abs($neLng - $swLng) / self::$horizontalSegments);
        $horizontalBase      = min(array($neLng, $swLng));
        
        $verticalIncrement = (abs($neLat - $swLat) / self::$verticalSegments);
        $verticalBase      = min(array($neLat, $swLat));
        
        $columns = $this->getSegments($horizontalBase, $horizontalIncrement, self::$horizontalSegments);
        $rows    = $this->getSegments($verticalBase, $verticalIncrement, self::$verticalSegments);
        return $this->mixRowsAndColumns($columns, $rows);
    }
    
    private function getSegments($horizontalBase, $horizontalIncrement, $segments) {
        $result     = array();
        $horizontal = $horizontalBase;
        for ($i = 0; $i < $segments; $i++) {
            $value       = array($horizontal);
            $horizontal += $horizontalIncrement;
            $value[]     = $horizontal;
            $result[]    = $value;
        }
        return $result;
    } 
    
    private function mixRowsAndColumns($columns, $rows) {
        $result = array();
        foreach ($columns as $column) {
            foreach ($rows as $row) {
                $result[] = array('coord' => array (
                    'ne' => array ('lt' => $row[0], 'lg' => $column[0]),
                    'nw' => array ('lt' => $row[0], 'lg' => $column[1]),
                    'se' => array ('lt' => $row[1], 'lg' => $column[0]),
                    'sw' => array ('lt' => $row[1], 'lg' => $column[1]),
                ));
            }
        }
        return $result;
    }
}
