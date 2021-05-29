
<?php 

	require_once 'DbConnect.php';
	
	$response = array();
	
	if(isset($_GET['apicall'])){
		
		switch($_GET['apicall']){
			case 'update':

if(isTheseParametersAvailable(array('name','city','cnumber','id'))){
					$name = $_POST["name"];
					$address = $_POST["city"];
					$cnumber = $_POST["cnumber"];
					$id = $_POST['id'];
					
						
						$stmt = $conn->prepare("UPDATE customer SET cust_name = ?, cust_ph = ?, cust_city = ? WHERE cust_id = ?" );
						$stmt->bind_param("ssss", $name, $cnumber, $address, $id);

						if($stmt->execute()){
							
							
							$response['error'] = false; 
							$response['message'] = 'User profile updated successfully'; 
							
						}else{
							$response['error'] = true; 
							$response['message'] = 'User profile updation failed'; 
						}
					
					
				}else{
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
