<?php 
class Analyze
{
	public $countInterval;
	public function accessAnalyze(array $tes){
$text=fopen('tests/test.log',"r");
settype($tes["u"], 'float');
settype($tes["t"], 'float');
$countLines=0;
$countFail=0;
$availabilitylevel=0;
$timeStart;
$minAvailabilityLevel=100;
$pattern='#.+:(\d{2}:\d{2}:\d{2}).+" ([0-9]{3}) \d (\S+)#i';
$this->countInterval=0;
if ($text) 
{
    while (($buffer = fgets($text)) !== false) 
	{
		$countLines++;
		preg_match($pattern,$buffer, $ok);
		settype($ok[2], 'float');
		settype($ok[3], 'float');
 		if(!empty($ok))
	 {
			
			if (($ok[2]>=500 and $ok[2]<600) || $ok[3]>$tes["t"])
			{
				$countFail++;
			}
			$availabilitylevel=(($countLines-$countFail)/$countLines)*100;
							//echo $countLines . "  ";
							//echo $countFail."  "; 
							//echo $availabilitylevel. "\n";
				if($availabilitylevel<$tes["u"] and empty($timeStart))
				{
					$timeStart=$ok[1];
					//echo $timeStart;
				}
									if($minAvailabilityLevel>$availabilitylevel)
					{
						$minAvailabilityLevel=$availabilitylevel;
					}
				if($availabilitylevel>=$tes["u"] and !empty($timeStart))
				{
					$timeEnd=$ok[1];
					echo "$timeStart  $timeEnd  ".round($minAvailabilityLevel, 1)."\n";
					$timeStart=0;
					$timeEnd=0;
					$minAvailabilityLevel=$availabilitylevel;
					$this->countInterval++;
					//echo "\n".$this->countInterval." \n";
				}
			
     }
			
    }
				if($availabilitylevel<$tes["u"] and !empty($timeStart))
				{
					$timeEnd=$ok[1];
					echo "$timeStart  $timeEnd  ".round($availabilitylevel, 1)."\n";
					$this->countInterval++;
					//echo "\n".$this->countInterval." \n";
				}
}
	}
}