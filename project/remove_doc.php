<?php
session_start();
if(!isset($_GET['host']))
{
	session_destroy();
?>
	<script>
		alert("Connect to the server first."); 
		window.location.href="index.php";				
	</script>
<?php
}
else
{
	$host=$_GET['host'];
	$port=$_GET['port'];
}
?>



<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

	$authentication=$_GET['authenticate'];
//	echo $authentication;

	if($authentication==0)
	{
		try
		{
			$connection = new Mongo($host.":".$port);
		}
		catch (MongoException $e)
		{
			?>

			<script>
			alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
			window.location = document.referrer;				
			</script>
			<?php
//			die('Failed to connect to MongoDB '.$e->getMessage());
        		

		}
	
	}
	else
	{
		$username=$_SESSION['username'];
		$password=$_SESSION['password'];
		$database=$_SESSION['database'];


		try
		{
			$connection = new Mongo($host.":".$port, array(
			'username' => $username,
			'password' => $password,
		    	'db'       => $database
			));			
		}
		catch (MongoException $e)
		{
        		
			?>

			<script>
			alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
			window.location = document.referrer;				
			</script>
			<?php
//			die('Failed to connect to MongoDB '.$e->getMessage());

		}
		
	}

	try
	{
		$collection = $connection->selectDB($_GET['db'])->selectCollection($_GET['collection']);
        	$e = $collection->remove(array('_id'=>new MongoId($_GET['id'])),array('w'=>true));
	}
	catch ( MongoException $e )
	{
	    
			?>

			<script>
			alert("failed to connect to MongoDB<?php echo $e->getMessage();?>");
			window.location = document.referrer;				
			</script>
			<?php
//			die('Failed to connect to MongoDB '.$e->getMessage());



	}
//	var_dump($e);

	$temp='index1.php?db='.$_GET['db'].'&collection='.$_GET['collection'].'&host='.$host.'&port='.$port.'&authenticate='.$authentication;

/*	if($authentication==1)
	{
		$temp=$temp.'&username='.$_SESSION['username'];
		$temp=$temp.'&password='.$_SESSION['password'];					
		$temp=$temp.'&database='.$_SESSION['database'];
	}
*/
?>
			<script>
			alert("Document Deleted successfully.");
			window.location = document.referrer;				
			</script>

<?php
	//header('location:'.$temp);

/*
    try {
        $connection = new Mongo($host.":".$port);
        $collection = $connection->selectDB($_GET['db'])->selectCollection($_GET['collection']);
        $e = $collection->remove(array('_id'=>new MongoId($_GET['id'])));
    } catch (MongoConnectionException $e) {
        die('Failed to connect to MongoDB '.$e->getMessage());
    }catch (MongoException $e) {
        die('Failed to connect to MongoDB '.$e->getMessage());
    }
    header('location:index1.php?db='.$_GET['db'].'&collection='.$_GET['collection'].'&host='.$host.'&port='.$port.'');
  */  
?>
