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
	$mysqli = new mysqli("localhost","u46wepy7oxttc","*Columbia1","dbdrxy58mkqzxh");
	//echo $user_id, $profile_key, $profile_value;
	// get the post records

	$value1 = $user_id;
	$value2 = $profile_key;
	$value3 = $profile_value;


	// database insert SQL code
	$sql = "INSERT INTO `hwf98_user_profiles` (`user_id`, `profile_key`, `profile_value`) VALUES ('$value1', '$value2', '$value3')";

	// insert in database 
	$rs1 = mysqli_query($mysqli, $sql);
	}

	function createArticle($data)
	{
	$id = 3333;
        return $id;
        }
	
	function createpage($vFullname, $vPhone)
	{
	$vrand = rand();
	echo $vrand;
        $app = JFactory::getApplication('site');
	
	$article_data = array(
	    'id' => 44,
    	'catid' => 3, // any cat id will work here
    	'title' => 'User Directory Page',
    	'alias' => '$vFullName',
    	'introtext' => 'This is a Default User Page on Account Creation',
    	'fulltext' => '$vFullName' . " " . '$vPhone',
    	'state' => 1, //if you want to keep the article published else 0
    	'alias' => '$vFullname',
    	'state'=>1,
    	'language' => '*',
    	'access' => 1,
    	'metadata' => json_encode(array('author' => '', 'robots' => ''))
	);

	$article_id = createArticle($article_data);
	return $article_id;
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
 $formFirstname = $data["firstname"];
 $formLastname = $data["lastname"];
 $formMiddlename = $data["middlename"];
 $fullusernametest = "$formFirstname" . " " . "$formMiddlename" . " " . "$formLastname";
 //echo $fullusernametest;
 //echo '<BR>';
 $formAddress1 = $data["address1"];
 $formAddress2 = $data["address2"];
 $formCity = $data["city"];
 $formState = $data["state"];
 $formCountry = $data["country"];
 $formZip = $data["zip"];
 $formPhone = $data["telephone"];
 $formCell = $data["cell"];

 //echo 'User registration...'.'<br/>';

// STEP1 - CREATE JOOMLA USER
// STEP2 - GET JOOMLA USERID FOR THE NEW USER
// STEP3 - ADD ADDRESS INFORMATION TO JOOMLA PROFILE BASED ON FORM (WEIRD SCHEMA).

addJoomlaUser($fullusernametest,$emailtest,$passwordtest,$emailtest);
// echo '<BR>'
// echo $functionresult + 77;
// echo '<BR>';
 $sqlresult = getdatabaseuserid($emailtest);
 //$sqlresult = 28; 
 echo $sqlresult;
 addprofiledata($sqlresult, 'profile.address1', $formAddress1);
 addprofiledata($sqlresult, 'profile.address2', $formAddress2);
 addprofiledata($sqlresult, 'profile.city', $formCity);
 addprofiledata($sqlresult, 'profile.region',$formState);
 addprofiledata($sqlresult, 'profile.postal_code',$formZip);
 addprofiledata($sqlresult, 'profile.phone',$formPhone);
 addprofiledata($sqlresult, 'profile.country',$formCountry);
 $Jpageid = createpage($fullusernametest, $formPhone);
 echo $Jpageid;
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
	<?php echo $form->renderField('middlename');  ?>
	<?php echo $form->renderField('lastname');  ?>
	<?php echo $form->renderField('address1');  ?>
	<?php echo $form->renderField('address2');  ?>
	<?php echo $form->renderField('city');  ?>
	<?php echo $form->renderField('state');  ?>
	<?php echo $form->renderField('country');  ?>
	<?php echo $form->renderField('zip');  ?>
	<?php echo $form->renderField('message');  ?>
	<?php echo $form->renderField('email');  ?>
	<?php echo $form->renderField('password');  ?>
	<?php echo $form->renderField('telephone');  ?>

	<button type="submit">Submit</button>
</form>