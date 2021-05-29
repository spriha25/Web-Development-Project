<?php 

	require_once 'DbConnect.php';
	
	$response = array();
	
	if(isset($_GET['apicall'])){
		
		switch($_GET['apicall']){
			
			case 'addsupplier':

    if (isTheseParametersAvailable(array(
        'supp_name',
        'supp_ph',
        'supp_city',
    )))
    {
        $supp_name = $_POST['supp_name'];
        $supp_ph = $_POST['supp_ph'];
        $supp_city = $_POST['supp_city'];

        try{
        $stmt = $conn->prepare("INSERT INTO supplier (supp_name, supp_ph,supp_city) VALUES ( ?, ?, ?)");

        $stmt->bind_param("sss", $supp_name, $supp_ph, $supp_city);


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

