<?php



class ProductionInfoService
{

    public function getHighLowValues($array)
    {
        $temperature = 'temperature';
        $humidity = 'humidity';

        $maxtemp = null;
        $maxhumid = null;
        $mintemp = null; 
        $minhumid = null;

        $boundryArray = array();
        foreach ($array as $k => $v) {
            $maxtemp = max(array($maxtemp, $v[$temperature]));
            $maxhumid = max(array($maxhumid, $v[$humidity]));
            if (is_null($mintemp) && is_null($minhumid)) {
                $mintemp = $v[$temperature];
                $minhumid = $v[$humidity];
            }else {
                $mintemp = min(array($mintemp, $v[$temperature]));
                $minhumid = min(array($minhumid, $v[$humidity]));
            }
        }
        $boundryArray = ['maxtemp' => $maxtemp, 'maxhumid' => $maxhumid, 'mintemp' => $mintemp, 'minhumid' => $minhumid];
        return $boundryArray;
    }
    
}
