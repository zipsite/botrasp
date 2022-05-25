<?php
class UpdateRasp {
    public $raspUrl = "http://rasp.vksit.ru/";
	public $count = 0;

    function __construct() {
        global $BaseData;
        $this->bd = $BaseData->bd;
    }

    function updateStatus() {
		$result = $this->bd->query("SELECT * FROM `filestatus`;");
		$rows = $result->num_rows;

		if($rows > 0)
		{
			for($x = 0;$x < $rows;$x++)
			{
				$result->data_seek($x);
				$rasp = $result->fetch_assoc();

                $url = "{$this->raspUrl}{$rasp['name']}";

		        $curl = curl_init();
		        curl_setopt($curl, CURLOPT_URL, $url);
		        curl_setopt($curl, CURLOPT_NOBODY, true);
		        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		        curl_setopt($curl, CURLOPT_FILETIME, true);
		        curl_exec($curl);
		        $timestamp = curl_getinfo($curl, CURLINFO_FILETIME);

		        $last = date('Y-m-d H:i:s',$timestamp);

		        if ($rasp['date'] != $last)
		        {
					$this->count += 1;
		        	$this->bd->query("UPDATE filestatus SET  date ='{$last}', status ='outdate' WHERE name ='{$rasp["name"]}';");
		        }
            }
        }
    }

	function getStatus() {
		return $this->count;
	}

    function syncRaspFile() {
        $result = $this->bd->query("SELECT * FROM filestatus WHERE status = 'outdate';");
        $rows = $result->num_rows;

		if($rows > 0)
		{
			for($x = 0;$x < $rows;$x++)
			{
				$result->data_seek($x);
				$rasp = $result->fetch_assoc();

				if (file_exists(RaspFileDir.$rasp['name'])) {
					$res = file_get_contents(RaspFileDir.$rasp['name']);

                	$fp = fopen(RaspFileDir."old.".$rasp['name'], 'w');
                	fwrite($fp, $res."\n");
                	fclose($fp);
				}

                $res = file_get_contents($this->raspUrl.$rasp['name']);

                $fp = fopen(RaspFileDir.$rasp['name'], 'w');
                fwrite($fp, $res."\n");
                fclose($fp);
            }
        }
    }

    function whohave() {
		$result = $this->bd->query("SELECT * FROM user;");
        $rows = $result->num_rows;

		if($rows > 0)
		{
			for($x = 0;$x < $rows;$x++)
			{
				$result->data_seek($x);
				$rasp = $result->fetch_assoc();
				if ($rasp['permition'] != "guest") {
					$this->bd->query("UPDATE user 
					SET upst = 'outdate' 
					WHERE platform_id = '{$rasp['platform_id']}' 
					AND platform = '{$rasp['platform']}';");
				}
				
			}
		}
    }
}
?>