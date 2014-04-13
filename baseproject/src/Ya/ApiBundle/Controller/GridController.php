<?php

namespace Ya\ApiBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;


class GridController extends FOSRestController {
    private static $horizontalSegments = 5;
    private static $verticalSegments   = 4;
    /**
     * @Method("GET")
     * @Route("/api/get_grid/{neLat}/{neLng}/{swLat}/{swLng}", name = "api_get_grid_data")
     */
    public function getGridAction(Request $request, $neLat, $neLng, $swLat, $swLng) {
        $squares = $this->getSquares($neLat, $neLng, $swLat, $swLng);
        return new Response($this->get('serializer')->serialize($squares, "json"));
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
