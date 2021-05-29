<?php 

	require_once 'DbConnect.php';
	
	$response = array();
	
	if(isset($_GET['apicall'])){
		
		switch($_GET['apicall']){
			
			case 'addpackage':

    if (isTheseParametersAvailable(array(
        'manu_name',
        'manu_ph',
        'manu_city',
    )))
    {
        $manu_name = $_POST['manu_name'];
        $manu_ph = $_POST['manu_ph'];
        $manu_city = $_POST['manu_city'];
        $status = "Placed";
        $statuscode = 0;

        try{
        $stmt = $conn->prepare("INSERT INTO manufacturer(manu_name, manu_ph,manu_city) VALUES ( ?, ?, ?)");

        $stmt->bind_param("sss", $manu_name, $manu_ph, $manu_city);


        if ($stmt->execute())
        {
            $response['error'] = false;
            $response['message'] = 'Package added successfully';
        }else{
        	$response['error'] = true;
            $response['message'] = 'Package addition failed';
        }
        }catch (Exception $e) {
    	echo 'Caught exception: ',  $e->getMessage(), "\n";
}


    }
    else
    {
        $response['error'] = true;
        $response['message'] = 'required parameters are not available';
    }
break;			
	default: 
				$response['error'] = true; 
				$response['message'] = 'Invalid Operation Called';
		}
}
else
{
    $response['error'] = true;
    $response['message'] = 'Invalid API Call';
}

echo json_encode($response);

function isTheseParametersAvailable($params)
{

    foreach ($params as $param)
    {
        if (!isset($_POST[$param]))
        {
            return false;
        }
    }
    return true;
}

