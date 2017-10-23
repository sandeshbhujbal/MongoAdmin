<?php 


function getArray($stringArray)
{

//echo "in function"."<br><br><br>";
//echo $stringArray;

$pos1=strpos($stringArray,"{");
//echo "<br>";
$pos2=strrpos($stringArray,"}");
//echo "<br>";

if((($pos1+strlen("{"))-$pos2)!=0)
{


	$stringArray=substr($stringArray,$pos1+1,$pos2-$pos1-1);
	echo "<br>";	
	echo $stringArray;
	echo "<br>";

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

}
else
{
	$newArray=array();
}
//echo "<br>new array: ";
//print_r($newArray);

return $newArray;
}




?>



<?php 












	$db="sandesh";
	$connection=new Mongo();	
	$dbConnect=$connection->$db;
	$collection="student";




$query=$_GET['query'];
echo $query;



$query=str_replace("\"","",$query);

$temp=explode(".",$query);

//print_r($temp);

$collection=$temp[1];

if(strpos($query,"find")!==false)
{

	if(strpos($query,"$")!=false)
	{
		

		$pos1=strpos($query,"find");

		echo "<br><br>";
		$pos2=strpos($query,")");

		$condition=substr($query,$pos1,$pos2-$pos1+1);


		echo $condition;
		//echo $pos1+strlen("find(");
		//echo $pos2;

		if((($pos1+strlen("find("))-$pos2)!=0) //to check whether find condition is empty
		{

			$conditionAsArray=getArray($condition);

			print_r($conditionAsArray);

			$records=$dbConnect->$collection->find($conditionAsArray);
		}
		else
		{
			$records=$dbConnect->$collection->find();
		}
		echo "<br>";

		
//	echo $query;

	}
	else
		{
		$pos1=strpos($query,"find");

		echo "<br><br>";
		$pos2=strpos($query,")");


		if((($pos1+strlen("find("))-$pos2)!=0) //to check whether find condition is empty
		{

			$condition=substr($query,$pos1,$pos2-$pos1+1);

			echo $condition;

			echo "<br>";
			$pos1=strpos($condition,"{");

			$pos2=strpos($condition,"}");

			$check=substr($condition,$pos1,$pos2-$pos1+1);


			$checkArray=getArray($check);
			echo "check=   ";

			print_r($checkArray);

			echo "<br>";
			$condition1=substr($condition,$pos2);

			echo $condition1;

			$pos1=strpos($condition1,"{");

			if($pos1!==false)
			{

				$pos2=strpos($condition1,"}");

				$toDisplay=substr($condition1,$pos1,$pos2-$pos1+1);

				echo $toDisplay;

				$toDisplayArray=getArray($toDisplay);

				print_r($toDisplayArray);


				//db.temp.update({"name":"pppp"},{$set:{"age":60}});


				//$temp1=array('$set'=>array("age"=>50));
				//echo "<br><br>";
				//print_r($temp1);
				//echo "<br><br>";
				//$records=$dbConnect->$collection->update(array("name"=>"pppp"),array('$set'=>array("age"=>50)));

			}
			else
			{
				$toDisplayArray=array();

			}

			$records=$dbConnect->$collection->find($checkArray,$toDisplayArray);
		}
		else
		{
			$records=$dbConnect->$collection->find();
		}	



	}



	while ($document = $records->getNext())
		{
			print_r($document);
			echo "<br>";
		}










//$query=$_GET['query'];
/*
$pos1=strpos($query,"find");

echo "<br><br>";
$pos2=strpos($query,")");


	if((($pos1+strlen("find("))-$pos2)!=0) //to check whether find condition is empty
	{

		$condition=substr($query,$pos1,$pos2-$pos1+1);

		echo $condition;

		echo "<br>";
		$pos1=strpos($condition,"{");

		$pos2=strpos($condition,"}");

		$check=substr($condition,$pos1,$pos2-$pos1+1);


		$checkArray=getArray($check);
		echo "check=   ";

		print_r($checkArray);

		echo "<br>";
		$condition1=substr($condition,$pos2);

		echo $condition1;

		$pos1=strpos($condition1,"{");

		if($pos1!==false)
		{

			$pos2=strpos($condition1,"}");

			$toDisplay=substr($condition1,$pos1,$pos2-$pos1+1);

			echo $toDisplay;

			$toDisplayArray=getArray($toDisplay);

			print_r($toDisplayArray);


			//db.temp.update({"name":"pppp"},{$set:{"age":60}});


			//$temp1=array('$set'=>array("age"=>50));
			//echo "<br><br>";
			//print_r($temp1);
			//echo "<br><br>";
			//$records=$dbConnect->$collection->update(array("name"=>"pppp"),array('$set'=>array("age"=>50)));

		}
		else
		{
			$toDisplayArray=array();

		}

		$records=$dbConnect->$collection->find($checkArray,$toDisplayArray);
	}
	else
	{
		$records=$dbConnect->$collection->find();
	}
//echo $records;

	while ($document = $records->getNext())
	{
		print_r($document);
		echo "<br>";
	}




*/



	//...........................sort............................................

	if(strpos($query,"sort")!==false)
	{
	$pos1=strpos($query,"sort");
	echo "<br>";
	$query1=substr($query,$pos1);
	echo $query1;
	$pos1=strpos($query1,"sort");

	echo "<br><br>";
	$pos2=strpos($query1,")");

	$condition=substr($query1,$pos1,$pos2-$pos1+1);


	echo $condition;


	if((($pos1+strlen("sort("))-$pos2)!=0) //to check whether sort condition is empty
	{
		

		$conditionAsArray=getArray($condition);

		print_r($conditionAsArray);

		$records=$records->sort($conditionAsArray);
	}
	else
	{
		$records=$records;
	}
	echo "<br>";
	/*
	while ($document = $records->getNext())
	{
		print_r($document);
		echo "<br>";
	}
	*/
	}

	//...........................limit............................................

	if(strpos($query,"limit")!==false)
	{
	$pos1=strpos($query,"limit");
	echo "<br>";
	$query1=substr($query,$pos1);
	echo $query1;
	$pos1=strpos($query1,"(")+1;

	echo "<br><br>";
	$pos2=strpos($query1,")")-1;

	$condition=(int)substr($query1,$pos1,$pos2-$pos1+1);


	echo $condition;


	$records=$records->limit($condition);

	echo "<br>";

	}

	//...........................skip............................................

	if(strpos($query,"skip")!==false)
	{
	$pos1=strpos($query,"skip");
	echo "<br>";
	$query1=substr($query,$pos1);
	echo $query1;
	$pos1=strpos($query1,"(")+1;

	echo "<br><br>";
	$pos2=strpos($query1,")")-1;

	$condition=(int)substr($query1,$pos1,$pos2-$pos1+1);


	echo $condition;


	$records=$records->skip($condition);

	echo "<br>";

	}

	//.......................................................................


	while ($document = $records->getNext())
	{
		print_r($document);
		echo "<br>";
	}


}
elseif(strpos($query,"insert")!==false)
{
	$pos1=strpos($query,"insert");

	echo "<br><br>";
	$pos2=strpos($query,")");

	$condition=substr($query,$pos1,$pos2-$pos1+1);

	echo $pos1." ".$pos2;
		
	echo $pos1+strlen("insert(");
	echo "<br>";
	echo $condition;

	if((($pos1+strlen("insert("))-$pos2)!=0) //to check whether sort condition is empty
	{
		$conditionAsArray=getArray($condition);
	
		print_r($conditionAsArray);


		$records=$dbConnect->$collection->insert($conditionAsArray);

		if($records==1)
		{
			echo "Record inserted successfully";
		}
		else
		{
			echo "Record insertion failed.";
			
		}
	}
	else
	{
		echo "Can not insert empty values";
	}
}
elseif(strpos($query,"update")!==false)
{

//$query=$_GET['query'];

$pos1=strpos($query,"update");

echo "<br><br>";
$pos2=strpos($query,")");

$condition=substr($query,$pos1,$pos2-$pos1+1);

echo $condition;

echo "<br>";
$pos1=strpos($condition,"{");

$pos2=strpos($condition,"}");

$check=substr($condition,$pos1,$pos2-$pos1+1);


$checkArray=getArray($check);
echo "check=   ";

print_r($checkArray);

echo "<br>";
$condition1=substr($condition,$pos2);

echo $condition1;

$pos1=strpos($condition1,"{");

$pos2=strpos($condition1,"}");

$newValue=substr($condition1,$pos1,$pos2-$pos1+1);

echo $newValue;

$newValueArray=getArray($newValue);

print_r($newValueArray);

//db.temp.update({"name":"pppp"},{$set:{"age":60}});


//$temp1=array('$set'=>array("age"=>50));
//echo "<br><br>";
//print_r($temp1);
//echo "<br><br>";
//$records=$dbConnect->$collection->update(array("name"=>"pppp"),array('$set'=>array("age"=>50)));
$records=$dbConnect->$collection->update($checkArray,$newValueArray);

echo $records;
}
elseif(strpos($query,"remove")!==false)
{

	$pos1=strpos($query,"remove");

	echo "<br><br>";
	$pos2=strpos($query,")");

	$condition=substr($query,$pos1,$pos2-$pos1+1);



	//echo $pos1+strlen("find(");
	//echo $pos2;

	if((($pos1+strlen("remove("))-$pos2)!=0) //to check whether find condition is empty
	{

		$conditionAsArray=getArray($condition);

		print_r($conditionAsArray);

		$records=$dbConnect->$collection->remove($conditionAsArray);
	}
	else
	{
		echo "hello";

		$records=$dbConnect->$collection->remove();
	}
	echo "<br>";
	/*
	while ($document = $records->getNext())
	{
		print_r($document);
		echo "<br>";
	}
	*/
	echo $query;



}
else
{
	$pos1=strpos($query,"count");

	echo "<br><br>";
	$pos2=strpos($query,")");

	$condition=substr($query,$pos1,$pos2-$pos1+1);



	//echo $pos1+strlen("find(");
	//echo $pos2;

	if((($pos1+strlen("count("))-$pos2)!=0) //to check whether find condition is empty
	{

		$conditionAsArray=getArray($condition);

		print_r($conditionAsArray);

		$records=$dbConnect->$collection->count($conditionAsArray);
	}
	else
	{
		echo "hello";

		$records=$dbConnect->$collection->count();
	}
	echo "<br>";
	/*
	while ($document = $records->getNext())
	{
		print_r($document);
		echo "<br>";
	}
	*/
	echo $records;

}






//.......................................................................


?>

