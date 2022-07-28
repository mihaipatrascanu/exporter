<?php
namespace app\exporter;

class ExporterFactory
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

    /**
     * Check if the folder name exist
     * @param string $folderName
     */
    private static function makeDir($folderName)
    {
        return is_dir($folderName) || mkdir($folderName);
    }

    /**
     * Creating and exporting the CSV file
     * @param array $data Data for creating CSV file
     * @param string $fileName  Name of the exported file
     * @param string $folderName Name of the folder file
     * @param string $delimiter  
     */
    public static function createCSV($data, $fileName, $folderName, $delimiter = ",")
    {
        
       //self::makeDir($folderName);
       //$this->makeDir($folderName);

        ExporterFactory::makeDir($folderName);

        $path = $folderName."/". $fileName;

        $export = "";
        foreach($data as $key=>$value)
        {
            $export .= $value["period"].$delimiter.$value["basicPayment"].$delimiter.$value["bonusPayment"]."\n";
        }

        $fp = fopen($path , 'w+');
        fwrite($fp, print_r($export, true)); 
        //Once the data is written, it will be saved in the path given.
        fclose($fp);
    }
 
}