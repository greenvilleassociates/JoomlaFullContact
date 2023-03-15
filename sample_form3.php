<?php



defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Form\Form;
use Joomla\CMS\Factory;

$form = Form::getInstance("sample", __DIR__ . "/sample_form3.xml", array("control" => "myform"));
$prefillData = array("email" => ".@.");

	function addJoomlaUser($name, $username, $password, $email) 
	{
        $data = array(
            "name"=>$name, 
            "username"=>$username, 
            "password"=>$password,
            "password2"=>$password,
            "email"=>$email
        );

        $user = clone(JFactory::getUser());
        //Write to database
        if(!$user->bind($data)) {
            throw new Exception("Could not bind data. Error: " . $user->getError());
        }
        if (!$user->save()) {
            throw new Exception("Could not save user. Error: " . $user->getError());
        }

        return $user->id;
	}

	function getdatabaseuserid($emailaddress)
	{
	// database connection code
	$servername = "localhost";
	$username = "u46wepy7oxttc";
	$password = "*Columbia1";
	$dbname = "dbdrxy58mkqzxh";
	$conn = new mysqli($servername, $username, $password, $dbname);


	// get the post records

	$value1 = $user_id;
	$value2 = $profile_key;
	$value3 = $profile_value;

	// database insert SQL code
	$sql = "SELECT id, email FROM `hwf98_users` WHERE email = '$emailaddress'";

	$mysqli = new mysqli("localhost","u46wepy7oxttc","*Columbia1","dbdrxy58mkqzxh");
	// Check connection
	if ($mysqli -> connect_errno) {
		  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
	  exit();
	
	}	


	if ($result = $mysqli -> query("SELECT id, email FROM hwf98_users WHERE email='$emailaddress'")) 
	{
	  echo "Returned rows are: " . $result -> num_rows;
  	  echo "<br>";
		while ($row = $result->fetch_row()) 
		{
	    	printf("%s (%s)\n", $row[0]);
		echo "<br>";
		return $row[0];
		}       
	
	

	  // Free result set
	  $result -> free_result();
	}

	//echo mysqli_query_result($result, 2); // outputs third employee's name
	//mysql_close($link);
	
	//$rs = mysqli_query($conn, $sql);
	
	$conn->close();
	return 'complete';
	}


	function addprofiledata($user_id, $profile_key, $profile_value) 
	{
	// database connection code

	$con = mysqli_connect('localhost', 'root', '','db_contact');

	// get the post records

	$value1 = $user_id;
	$value2 = $profile_key;
	$value3 = $profile_value;


	// database insert SQL code
	//ORIGINAL STRING $sql = "INSERT INTO `tbl_contact` (`Id`, `fldName`, `fldEmail`, `fldPhone`, `fldMessage`) VALUES ('0', '$txtName', '$txtEmail', '$txtPhone', '$txtMessage')";
	$sql = "INSERT INTO `gaweb1_user_profiles` (`user_id`, `profile_key`, `profile_value`) VALUES ('$value1', '$value2', '$value3')";

	// insert in database 
	$rs = mysqli_query($con, $sql);
	}

///FUNCTION DECLARATIONS END

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	$app   = JFactory::getApplication();
	$data = $app->input->post->get('myform', array(), "array");
	echo "Message was " . $data["message"] .
		", email was " . $data["email"] .
		", lastname was " . $data["lastname"] .
		", and telephone was " . $data["telephone"] . "<br>";
	$filteredData = $form->filter($data);
	$result = $form->validate($filteredData);
	if ($result)
	{
		echo "Validation passed ok<br>";
 $emailtest = $data["email"];
 $passwordtest = $data["password"];
 $fullusernametest = $data["lastname"];
 //echo 'User registration...'.'<br/>';


 addJoomlaUser($fullusernametest,$emailtest,$passwordtest,$emailtest);
 $sqlresult = getdatabaseuserid($emailtest);
 echo $sqlresult;
 
 //echo '<br/>'.'User registration is completed'.'<br/>';


	}
	else
	{
		echo "Validation failed<br>";
		$errors = $form->getErrors();
		foreach ($errors as $error)
		{
			echo $error->getMessage() . "<br>";
		}
		// in the redisplayed form show what the user entered (after data is filtered)
		$prefillData = $filteredData;
	}
}

$form->bind($prefillData);
?>
<form action="<?php echo JRoute::_('index.php?option=com_sample_form3'); ?>"
    method="post" name="sampleForm" id="adminForm" enctype="multipart/form-data">

	<?php echo $form->renderField('firstname');  ?>
	<?php echo $form->renderField('lastname');  ?>
	<?php echo $form->renderField('address1');  ?>
	<?php echo $form->renderField('address2');  ?>
	<?php echo $form->renderField('city');  ?>
	<?php echo $form->renderField('state');  ?>
	<?php echo $form->renderField('zip');  ?>
	<?php echo $form->renderField('message');  ?>
	<?php echo $form->renderField('email');  ?>
	<?php echo $form->renderField('password');  ?>
	<?php echo $form->renderField('telephone');  ?>

	<button type="submit">Submit</button>
</form>