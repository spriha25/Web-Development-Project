<?php 

	require_once 'DbConnect.php';
	
	$response = array();
	
	if(isset($_GET['apicall'])){
		
		switch($_GET['apicall']){
			
			case 'addpackage':

    if (isTheseParametersAvailable(array(
        'cust_name',
        'cust_ph',
        'cust_city',
    )))
    {
        $cust_name = $_POST['cust_name'];
        $cust_ph = $_POST['cust_ph'];
        $cust_city = $_POST['cust_city'];
        $status = "Placed";
        $statuscode = 0;

        try{
        $stmt = $conn->prepare("INSERT INTO customer(cust_name, cust_ph,cust_city) VALUES ( ?, ?, ?)");

        $stmt->bind_param("sss", $cust_name, $cust_ph, $cust_city);


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

