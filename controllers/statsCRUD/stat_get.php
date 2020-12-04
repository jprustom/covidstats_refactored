<?php
    
    if (!isset($_GET['statId']))
        throw new Exception('statId not provided');
    $statId=(int)($_GET['statId']);
    if ($statId==0)
        throw new Exception('invalid stat id');
    $stat=\Models\CovidStats::getStat($statId);
    $initialStatDate=$stat->date;
    $initialStatDate = date("d-M-Y", strtotime($initialStatDate));  
    $initialStatCases=$stat->lastCases;
    $initialStatDeaths=$stat->lastDeaths;
    $initialStatCountryId=$stat->countryId;
    $initialStatCountryName=null;
    foreach($countries as $country){
        if ($country->id==$initialStatCountryId){
            $initialStatCountryName=$country->countryName;
            break;
        }
    }

?>