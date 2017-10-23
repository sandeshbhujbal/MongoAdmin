<!--
http://stackoverflow.com/questions/8300046/how-do-i-do-mongodb-console-style-queries-in-php


replace

    "dots" with "arrows"
    "colon" with "double arrow"
    "left brace" with "array("
    "right brace" with ")"

-->



<?php


/*
	$db="sandesh";
	$connection=new Mongo();	
	$db_selection=$connection->$db;
	$collection="student";
*/

/*	print_r($db_selection->execute('db.student.find();'));


	$records=$db_selection->$collection->find(json_decode('{}'));
	echo "<br>";
	while ($document = $records->getNext())
	{
		print_r($document);
		echo "<br>";
	}

//	db->temp->insert(array("name"=>"bbb"));

	$db_selection->$collection->insert(array(name=>"bbb"));
*/

//db->student->find(array('$or'=>[array('age'=>25),array('gender'=>'m')]))


      /*  $records=$db_selection->$collection->find(array('$or'=>[array('age'=>25),array('gender'=>'m')]));
	echo "<br>";
	while ($document = $records->getNext())
	{
		print_r($document);
		echo "<br>";
	}
*/

//echo $db_selection->$collection->count();

$temp=array('name'=>10,'name1'=>'bbbb','name2'=>array('age'=>'cccc'));

print_r($temp);
echo "<br>";
//$stringarray="array('name':'aaaa','name1':'bbbb')";
$stringarray="array('name'=>10,'name1'=>'bbbb','name2'=>array('age'=>'cccc'))";


$new=getArray($stringarray);
echo "<br><br><br>";
print_r($new);



function getArray($stringArray)
{
echo $stringArray;

$pos1=strpos($stringArray,"(");
echo "<br>";
$pos2=strrpos($stringArray,")");
echo "<br>";

$stringArray=substr($stringArray,$pos1+1,$pos2-$pos1-1);

echo $stringArray;
echo "<br>";

$keyValueArray=explode(",",$stringArray);

print_r($keyValueArray);

echo "<br><br>";

$keys=array();
$values=array();


for($i=0;$i<sizeof($keyValueArray);$i++)
{
	$keyValue=explode("=>",$keyValueArray[$i],2);

	$keys[]=$keyValue[0];


	if(strpos($keyValue[1],"array")!==false)
	{
		echo "hello".$i;
		$values[]=getArray($keyValue[1]);
	}
	else
	{
		$values[]=$keyValue[1];
	}



}

echo "<br><br>";

echo "<br>keys: ";
print_r($keys);

echo "<br>values: ";
print_r($values);

$newArray=array_combine($keys,$values);

echo "<br>new array: ";
print_r($newArray);

return $newArray;
}



?>
