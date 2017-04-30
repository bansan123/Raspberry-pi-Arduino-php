<?php
//var_dump($_post);
if (isset($_SERVER['HTTP_TOKEN']) && $_SERVER['HTTP_TOKEN'] == "testbishefarmol") {//可以改token,这相当于密码，在Arduino端改成相应的值即可
	$con = mysqli_connect('localhost:3306','root','','rasptest'); 
	//$data = $_GET['data'];
	//mysql_select_db("rasptest", $con);//要改成相应的数据库名
	//$result = mysql_query("SELECT * FROM farmol");
	/*while($arr = mysql_fetch_array($result)){//找到需要的数据的记录，并读出状态值
		if ($arr['ID'] == 1) {
			$state = $arr['state'];
		}
	}*/
	var_dump($_POST);
	date_default_timezone_set('PRC');
	if(isset($_POST['temp']) || isset($_POST['humidity']) || isset($_POST['light']))
	{
		$temp=$_POST['temp'];
		$humidity=$_POST['humidity'];
		$light=$_POST['light'];
		$date = time();//获取时间
		$sql = "insert into farmol (date,temp,light,humidity) values ('$date','$temp','$light','$humidity')";
	 	//mysqli_query($con,$sql);
		//echo(date("Y-m-d H:i:s"));
		if(!mysqli_query($con,$sql)){
		    die('Error: ' . mysql_error());//如果出错，显示错误
		}
		mysqli_close($con);
	}else{
		echo "Permission Denied";//请求中没有POST数据时显示显示Permission Denied
		exit();
	}
	
	//echo "{".$state."}";//返回状态值，加“{”是为了帮助Arduino确定数据的位置
}else{
	echo "Permission Denied";//请求中没有type或data或token或token错误时，显示Permission Denied
	exit();
}
?>