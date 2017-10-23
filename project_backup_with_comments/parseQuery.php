<?php

$query="db.student.find({name:eeee,age:dfdfg}).limit(5);";

$pos1=strpos($query,"find");

echo "<br><br>";
$pos2=strpos($query,")");

$condition=substr($query,$pos1,$pos2-$pos1+1);

print_r(getArray($condition));
















function getArray($stringArray)
{

echo "in function"."<br><br><br>";
echo $stringArray;

$pos1=strpos($stringArray,"{");
echo "<br>";
$pos2=strrpos($stringArray,"}");
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
	$keyValue=explode(":",$keyValueArray[$i],2);

	$keys[]=$keyValue[0];


	if(strpos($keyValue[1],"array")!==false)
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

echo "<br>keys: ";
print_r($keys);

echo "<br>values: ";
print_r($values);

foreach($values as $v)
{
echo gettype($v);
echo "<br>";
}

$newArray=array_combine($keys,$values);

echo "<br>new array: ";
print_r($newArray);

return $newArray;
}

?>
