<?php
namespace app\exporter;
abstract class ExporterFactory
{

    protected $results = array();

    /**
     * Returning the date in the format we want
     * @param string $date
     */
    private static function periodTime( $date= "")
    {
        return date('M/y', strtotime($date));
    }

    /**
     * The function for checking if a day is Saturday or Sunday
     * @param string $date
     * @param bool $bonuss default False
     */

    private static function checkDay( $date = "", $bonus = FALSE )
    {
        
        $workingDay = date('l', strtotime($date));
    
        $date = date ( 'Y-m-d' , strtotime($date) );
    
        if($workingDay == "Saturday") 
        { 
            $newdate = strtotime ('-1 day', strtotime($date));
    
            if($bonus)
            $newdate = strtotime ('+2 day', strtotime($date));
    
            $date = date ('Y-m-d', $newdate);
        }
        
        if($workingDay == "Sunday") 
        { 
            $newdate = strtotime ('-2 day', strtotime($date));
    
            if($bonus)
            $newdate = strtotime ('+1 day', strtotime($date));
    
            $date = date ( 'Y-m-d' , $newdate );
        }
    
        return $date;
    }

    /**
     * The function for creating the array with days
     * @param string $date
     * @param int $nextMonths default 11 -- taking curent month and 11 after
     * @param int $bonusDay default 10 
     */

    public static function getMoneyDay($date, $nextMonths = 11, $bonusDay = 10)
    {
        $final = [];
    
        //exceptions for February if bonusDay is >28(29) wip

        if( 0 < $bonusDay && $bonusDay < 10)
        {
            $bonusDay="0".$bonusDay;
        }

        for ($i = 0; $i <= $nextMonths; $i++) 
        {
        
            $bonusDate = date("l Y-m-{$bonusDay}", strtotime( date("Y-m-{$bonusDay}", strtotime($date))." +$i months"));

            $workingDate = date('Y-m-d', strtotime("+$i months", strtotime($date)));
            
            $final[]=   [   "period" => ExporterFactory::periodTime($workingDate), 
                            "basicPayment" => ExporterFactory::checkDay(date("Y-m-t",strtotime($workingDate))),
                            "bonusPayment" =>  ExporterFactory::checkDay($bonusDate, TRUE),
                        ];        
        }

        return $final;
    }

 





}