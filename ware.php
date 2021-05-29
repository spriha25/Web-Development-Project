<?php 

	require_once 'DbConnect.php';
	
	$response = array();
	
	if(isset($_GET['apicall'])){
		
		switch($_GET['apicall']){
			
			case 'addpackage':

    if (isTheseParametersAvailable(array(
        'ware_name',
        'location',
    )))
    {
        $ware_name = $_POST['ware_name'];
        $location = $_POST['location'];
        $status = "Placed";
        $statuscode = 0;

        try{
        $stmt = $conn->prepare("INSERT INTO warehouse(ware_name, location) VALUES ( ?, ?)");

        $stmt->bind_param("ss", $ware_name, $location);


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

