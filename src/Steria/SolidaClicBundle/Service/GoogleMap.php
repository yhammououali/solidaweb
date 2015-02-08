<?php
// Documentation API GeoCoding de Google
// https://developers.google.com/maps/documentation/geocoding/

namespace Steria\SolidaClicBundle\Service;

class GoogleMap
{
    protected $pays = "France";
    
    /*
    public function __construct($locale)
    {
        switch ($locale) {
            "fr":
                    $pays = "France";
                    break;
            default:
                    $pays = "France";
                    break;
        }
    }
    */

    public function addressToCoord($address, $city, $zip) {
        $reqaddress = $address .", ".$city.", ".$zip.", ".$this->pays;
        
        return $this->addressOneToCoord($reqaddress);
    }
    
    public function addressZipToCoord($zip) {
        $reqaddress = $zip.", ".$this->pays;
        
        return $this->addressOneToCoord($reqaddress);
    }
    
    public function addressOneToCoord($reqaddress) {
        $url = "http://maps.google.com/maps/api/geocode/json?address=".urlencode($reqaddress)."&sensor=false";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        
        $response = curl_exec($ch);
        if ($response === FALSE) {
            throw new \Exception('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        
        $response_a = json_decode($response);
        
        if (isset($response_a) && isset($response_a->results[0])) {
            return array(
                "latitude"  => $response_a->results[0]->geometry->location->lat,
                "longitude" => $response_a->results[0]->geometry->location->lng,
            );
        }
        
        return null;
        
    }
}