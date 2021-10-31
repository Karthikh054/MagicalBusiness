
<?PHP
//include"connect.php";

if(!isset($_SESSION)) 
    { 
      
session_start();
	}
if($_SESSION['LOGOUT']!="NO")
{
	header('Location: index.php');
	exit;
}

?>