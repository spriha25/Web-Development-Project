<?php 

	require_once 'DbConnect.php';
	
	$response = array();
	
	if(isset($_GET['apicall'])){
		
		switch($_GET['apicall']){
			
			case 'searchcustomer':
	
   if(isTheseParametersAvailable(array('searchw'))){
        $tosearch = $_POST["searchw"];
		$userph = "";
		$username = "";
		$usercity = "";
        try{
      					
					$stmt = $conn->prepare("SELECT cust_name, cust_ph, cust_city FROM customer WHERE cust_id = ?");
					$stmt->bind_param("i", $tosearch);
					$stmt->execute();					
					$stmt->bind_result($username, $userph, $usercity);
					$stmt->fetch();
					$response['error'] = false;
						$user = array(
								'phone'=>$userph, 
								'name'=>$username, 
								'city'=>$usercity,
							);
						$response['message'] = 'Search done';
						$response['searcheduser'] = $user; 
						$stmt->close();
                   

                    
                  
		}
        catch (Exception $e) {
    	echo 'Caught exception: ',  $e->getMessage(), "\n";
}


    }
    else
    {
        $response['error'] = true;
        $response['message'] = 'required parameters are not available';
    }
break;			

case 'searchitem':


 if(isTheseParametersAvailable(array('searchw'))){
        $tosearch = $_POST["searchw"];
		$iname = "";
		$iq = "";
		$iprice = "";
        try{
      					
					$stmt = $conn->prepare("SELECT item_name, item_q, item_price FROM items WHERE item_id = ?");
					$stmt->bind_param("i", $tosearch);
					$stmt->execute();					
					$stmt->bind_result($iname, $iq, $iprice);
					$stmt->fetch();
					$response['error'] = false;
						$item = array(
								'name'=>$iname, 
								'q'=>$iq, 
								'price'=>$iprice,
							);
						$response['message'] = 'Search done';
						$response['searcheditem'] = $item; 
						$stmt->close();
                   

                    
                  
		}
        catch (Exception $e) {
    	echo 'Caught exception: ',  $e->getMessage(), "\n";
}


    }
    else
    {
        $response['error'] = true;
        $response['message'] = 'required parameters are not available';
    }

break;

case 'searchwarehouse':


 if(isTheseParametersAvailable(array('searchw'))){
        $tosearch = $_POST["searchw"];
		$wname = "";
		$wloc = "";
		
        try{
      					
					$stmt = $conn->prepare("SELECT ware_name, location FROM warehouse WHERE ware_id = ?");
					$stmt->bind_param("i", $tosearch);
					$stmt->execute();					
					$stmt->bind_result($wname, $wloc);
					$stmt->fetch();
					$response['error'] = false;
						$wh = array(
								'name'=>$wname, 
								'location'=>$wloc, 
								
							);
						$response['message'] = 'Search done';
						$response['searchediwarehouse'] = $wh; 
						$stmt->close();
                   

                    
                  
		}
        catch (Exception $e) {
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

