<?php
error_reporting(0);
ini_set('max_execution_time', 0);
ini_set('memory_limit','2048M');

$msg = "";
if (isset($_POST['dbname'])) {
	$host = $_POST['host'];
	$uname = $_POST['username'];
	$pass = $_POST['password'];
	$dbname = $_POST['dbname'];

	if ($contest = mysqli_connect("$host","$uname","$pass","$dbname")) {

		//for change a file all content
		$string = '
		<?php 
			$host = "'.$host.'";
			$uname = "'.$uname.'";
			$pass = "'.$pass.'";
			$dbname = "'.$dbname.'";
		?>
		';
		if (file_exists("db.php")) {
			if(file_put_contents('db.php', $string))
			{
				echo "done";
			}
		}
		mysqli_close($contest);
		//end
	}else{
		echo "Database can not connect!";
		mysqli_close($contest);
	}
}

//for replace spacific file data
$data_db = file_get_contents('db.php');
$data_db = str_replace('db_name',	'dd',	$data_db);
file_put_contents('db.php', $data_db);
//end


//for input .sql file

    // Set line to collect lines that wrap
    $templine = '';
    // Read in entire file
    $lines = file('./uploads/install.sql');
    // Loop through each line
    foreach ($lines as $line) {
      // Skip it if it's a comment
      if (substr($line, 0, 2) == '--' || $line == '')
        continue;
      // Add this line to the current templine we are creating
      $templine .= $line;
      // If it has a semicolon at the end, it's the end of the query so can process this templine
      if (substr(trim($line), -1, 1) == ';') {
        // Perform the query
        $this->db->query($templine);
        // Reset temp variable to empty
        $templine = '';
      }
    }
//end


//for verification

$product_code = "123";

        $verify_url = 'https://reqres.in/api/users?page=2';
        $ch_verify = curl_init();

        curl_setopt($ch_verify,CURLOPT_URL,$verify_url);
        curl_setopt($ch_verify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch_verify, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch_verify, CURLOPT_CONNECTTIMEOUT, 5);


        $verify_data = curl_exec($ch_verify);
        curl_close($ch_verify);

        $response = json_decode($verify_data, true); //true means convert to a array
        //echo "<pre>";
        //print_r($response);
        //print_r($response['data'][0]);

        if ($response['data'][0]['id'] == 7) {
        	echo "yes";
        }else{
        	echo "no";
        }

//end


?>

<form action="" method="post">
	Host:<input type="text" name="host" value="localhost">
	Username:<input type="text" name="username">
	Password:<input type="text" name="password">
	DB:<input type="text" name="dbname">
	<input type="submit" name="">
</form>
