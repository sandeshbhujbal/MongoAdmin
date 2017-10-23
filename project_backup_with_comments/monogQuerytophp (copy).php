<?php 
echo "hello";

	$db="sandesh";
	$connection=new Mongo();	
	$db_selection=$connection->$db;
	$collection="student";




$query=$_GET['query'];
echo $query;





$query=str_replace("\"","",$query);

$temp=explode(".",$query);

//print_r($temp);

$collection=$temp[1];



$pos1=strpos($query,"find");

echo "<br><br>";
$pos2=strpos($query,")");

$condition=substr($query,$pos1,$pos2-$pos1+1);

$conditionAsArray=getArray($condition);

print_r($conditionAsArray);

$records=$db_selection->$collection->find($conditionAsArray);

echo "<br>";

while ($document = $records->getNext())
{
	print_r($document);
	echo "<br>";
}



function getArray($stringArray)
{

//echo "in function"."<br><br><br>";
//echo $stringArray;

$pos1=strpos($stringArray,"{");
//echo "<br>";
$pos2=strrpos($stringArray,"}");
//echo "<br>";

$stringArray=substr($stringArray,$pos1+1,$pos2-$pos1-1);

//echo $stringArray;
//echo "<br>";

$keyValueArray=explode(",",$stringArray);

//print_r($keyValueArray);

echo "<br><br>";

$keys=array();
$values=array();


for($i=0;$i<sizeof($keyValueArray);$i++)
{
	$keyValue=explode(":",$keyValueArray[$i],2);

	$keys[]=$keyValue[0];


	if(strpos($keyValue[1],"{")!==false)
	{
		$values[]=getArray($keyValue[1]);
	}
	else
	{
		if(strpos($keyValue[1],".")!==false)
		{
			if(is_numeric($keyValue[1]))
			{
				$values[]=(float)$keyValue[1];
				
			}
			else
			{
				$values[]=$keyValue[1];
			}
		}
		elseif(is_numeric($keyValue[1]))
		{
			$values[]=(int)$keyValue[1];
		}
		else
		{
			$values[]=$keyValue[1];
		}
	}



}

echo "<br><br>";

//echo "<br>keys: ";
//print_r($keys);

//echo "<br>values: ";
//print_r($values);
/*
foreach($values as $v)
{
echo gettype($v);
echo "<br>";
}
*/
$newArray=array_combine($keys,$values);

//echo "<br>new array: ";
//print_r($newArray);

return $newArray;
}


?>


<!--
<?php

echo $_GET['query'];

$query="{\"name\":\"aaa\"}";

$t=json_decode($query,true);











$temp=explode(".",$query);

//print_r($temp);

$collection=$temp[1];



$pos1=strpos($query,"find");

echo "<br><br>";
$pos2=strpos($query,")");

$condition=substr($query,$pos1,$pos2-$pos1+1);

echo $condition;


/*
	$db="sandesh";
	$connection=new Mongo();	
	$db_selection=$connection->$db;
	$collection="student";




$query=$_GET['query'];

//echo $query;
$query=str_replace("\"","",$query);

$temp=explode(".",$query);

//print_r($temp);

$collection=$temp[1];



$pos1=strpos($query,"find");

echo "<br><br>";
$pos2=strpos($query,")");

$condition=substr($query,$pos1,$pos2-$pos1+1);

$conditionAsArray=getArray($condition);

print_r($conditionAsArray);

$records=$db_selection->$collection->find($conditionAsArray);

echo "<br>";

while ($document = $records->getNext())
{
	print_r($document);
	echo "<br>";
}













function getArray($stringArray)
{

//echo "in function"."<br><br><br>";
//echo $stringArray;

$pos1=strpos($stringArray,"{");
//echo "<br>";
$pos2=strrpos($stringArray,"}");
//echo "<br>";

$stringArray=substr($stringArray,$pos1+1,$pos2-$pos1-1);

//echo $stringArray;
//echo "<br>";

$keyValueArray=explode(",",$stringArray);

//print_r($keyValueArray);

echo "<br><br>";

$keys=array();
$values=array();


for($i=0;$i<sizeof($keyValueArray);$i++)
{
	$keyValue=explode(":",$keyValueArray[$i],2);

	$keys[]=$keyValue[0];


	if(strpos($keyValue[1],"{")!==false)
	{
		$values[]=getArray($keyValue[1]);
	}
	else
	{
		if(strpos($keyValue[1],".")!==false)
		{
			if(is_numeric($keyValue[1]))
			{
				$values[]=(float)$keyValue[1];
				
			}
			else
			{
				$values[]=$keyValue[1];
			}
		}
		elseif(is_numeric($keyValue[1]))
		{
			$values[]=(int)$keyValue[1];
		}
		else
		{
			$values[]=$keyValue[1];
		}
	}



}

echo "<br><br>";

//echo "<br>keys: ";
//print_r($keys);

//echo "<br>values: ";
//print_r($values);
/*
foreach($values as $v)
{
echo gettype($v);
echo "<br>";
}
*/
/*
$newArray=array_combine($keys,$values);

//echo "<br>new array: ";
//print_r($newArray);

return $newArray;
}

*/

?>



























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
	$collection="temp";

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


       /* $records=$db_selection->$collection->find(array('$or'=>[array('age'=>25),array('gender'=>'m')]));
	echo "<br>";
	while ($document = $records->getNext())
	{
		print_r($document);
		echo "<br>";
	}
*/

//db->temp->insert(array('name'=>'pppp'));

//echo $db_selection->$collection->insert(dfgdf);

/*
$query=$_GET['query'];

echo $query."<br>";

$querySplit=explode(".",$query);

print_r($querySplit);

echo "<br><br>";


$collection=$querySplit[1];

$query=$querySplit[2];

echo "<br>Db=".$db."<br>";

echo "<br>Collection=".$collection."<br>";

echo "<br>Query=".$query."<br><br>";

$query=str_replace("\"","",$query);

echo $query;

echo "<br>";



$query=str_replace(".","->",$query);

echo $query;
echo "<br>";


$query=str_replace(":","=>",$query);

echo $query;
echo "<br>";


$query=str_replace("{","array(",$query);

echo $query;
echo "<br>";


$query=str_replace("}",")",$query);

echo $query;
echo "<br>";


if(strpos($query,"find")!==false)
{
echo "hello";

$pos1=strpos($query,"(");
echo $pos1;
$pos2=strrpos($query,")");
echo $pos2;

$condition=substr($query,$pos1+1,$pos2-$pos1-1);

if(strlen($condition)!=0)
{

$conditionInArray=getArray($condition);

echo "<br><br>";

print_r($conditionInArray);

foreach($conditionInArray as $k=>$v)
{
	echo $k."=====>".gettype($v)."<br>";

}

$temp=array("name"=>"eee","age"=>45);

print_r($temp);

$records=$db_selection->$collection->find($conditionInArray);

echo "<br>";

while ($document = $records->getNext())
{
	print_r($document);
	echo "<br>";
}


}
else
{

$records=$db_selection->$collection->find();

echo "<br>";

while ($document = $records->getNext())
{
	print_r($document);
	echo "<br>";
}

}



}







function getArray($stringArray)
{

echo "in function"."<br><br><br>";
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
		$values[]=getArray($keyValue[1]);
	}
	else
	{
		if(is_numeric($keyValue[1]))
		{
			$values[]=(int)$keyValue[1];
		}
		else
		{
			$values[]=$keyValue[1];
		}
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

*/

?>
