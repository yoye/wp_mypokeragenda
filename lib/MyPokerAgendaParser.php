<?php

class MyPokerAgendaParser
{
    
    /**
     * Get casinos from "www.mypokeragenda.com"
     * 
     * @return array 
     */
    public function getCasinos()
    {
        $output = array();
        
        if (!$xml = @file_get_contents('http://www.mypokeragenda.com/casino/list.xml')) {
            return $output;
        }
        
        $sxe = new SimpleXMLElement($xml);
        
        foreach ($sxe as $casino) {
            $output[] = array(
                'label' => (string)$casino->name,
                'type' => 'casino',
                'id' => (string)$casino->id,
            );
        }
        
        return $output;
    }
    
    /**
     * Get Series
     * 
     * @return array
     */
    public function getSeries()
    {
        $output = array();
        
        if (!$xml = @file_get_contents('http://www.mypokeragenda.com/serie/list.xml')) {
            return $output;
        }
        
        $sxe = new SimpleXMLElement($xml);
        
        foreach ($sxe as $serie) {
            $output[] = array(
                'label' => (string)$serie->name,
                'type' => 'serie',
                'id' => (string)$serie->id,
            );
        }
        
        return $output;
    }
    
    /**
     * Get Rooms
     * 
     * @return array
     */
    public function getRooms()
    {
        $output = array();
        
        if (!$xml = @file_get_contents('http://www.mypokeragenda.com/room/list.xml')) {
            return $output;
        }
        
        $sxe = new SimpleXMLElement($xml);
        
        foreach ($sxe as $room) {
            $output[] = array(
                'label' => (string)$room->name,
                'type' => 'room',
                'id' => (string)$room->id,
            );
        }
        
        return $output;
    }
    
    /**
     * Merge all datas
     * 
     * @return array
     */
    public function getAll()
    {
        return array_merge($this->getCasinos(), $this->getSeries(), $this->getRooms());
    }
}