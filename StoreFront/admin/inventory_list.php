<?php
session_start();
if(!isset($_SESSION["manager"])){
	header("location:admin_login.php");
	exit();
}
// Be sure to check that this manager SESSION value is in fact in the database
$managerID = preg_replace('#[^0-9]#i', '', $_SESSION["id"]); // filter everything but numbers and letters
$manager = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["manager"]); // filter everything but numbers and letters
$password = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["password"]); // filter everything but numbers and letters
// Run mySQL query to be sure that this person is an admin and that their password session var equals the database information
// Connect to the MySQL database  
include "../js/connect_to_mysql.php"; 
$sql = mysql_query("SELECT * FROM admin WHERE id='$managerID' AND username='$manager' AND password='$password' LIMIT 1"); // query the person
// ------- MAKE SURE PERSON EXISTS IN DATABASE ---------
$existCount = mysql_num_rows($sql); // count the row nums
if ($existCount == 0) { // evaluate the count
	 echo "Your login session data is not on record in the database.";
     exit();
}
?>
<?php
//Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<?php 
// Parse the form data and add inventory item to the system
if (isset($_POST['productName'])) {
	
    $productName = mysql_real_escape_string($_POST['productName']);
	$price = mysql_real_escape_string($_POST['price']);
	$category = mysql_real_escape_string($_POST['category']);
	$subcategory = mysql_real_escape_string($_POST['subcategory']);
	$description = mysql_real_escape_string($_POST['description']);
	// See if that product name is an identical match to another product in the system
	$sql = mysql_query("SELECT productID FROM products WHERE productName='$productName' LIMIT 1");
	$productMatch = mysql_num_rows($sql); // count the output amount
    if ($productMatch > 0) {
		echo 'Sorry you tried to place a duplicate "Product Name" into the system, <a href="inventory_list.php">click here</a>';
		exit();
	}
	// Add this product into the database now
	$sql = mysql_query("INSERT INTO products (productName, price, description, category, subcategory, date_added) 
        VALUES('$productName','$price','$description','$category','$subcategory',now())") or die (mysql_error());
     $pid = mysql_insert_productID();
	// Place image in the folder 
	$newname = "$pid.jpg";
	move_uploaded_file( $_FILES['fileField']['tmp_name'], "../img/$newname");
	header("location: inventory_list.php"); 
    exit();
}
?>

<?php
//this block grabs the whole list for viewing
$product_list="";
$sql=mysql_query("SELECT*FROM products ORDER BY productID DESC");
$productCount=mysql_num_rows($sql);//count the output amount
if($productCount>0){
	while($row=mysql_fetch_array($sql)){
		$productID=$row["productID"];
		$productName=$row["productName"];
		$price=$row["price"];
		$description=$row["description"];
		$image=$row["image"];
		$date_added = strftime("%b %d, %Y", strtotime($row["date_added"]));
		$product_list.="$date_added-$productID-$productName &nbsp; &nbsp; &nbsp;<a href='#'>edit</a><br /> &bull; <a href='#'>delete</a><br />";
	}
}else{
	$product_list="You have no products listed in your store yet.";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Cliff's Sporting Goods Inventory List-Gina Levy</title>
<link rel="stylesheet" href="../css/styles.css" type="text/css" media="screen" />
</head>

<body>
<div align="center" id="mainWrapper">
  <?php include_once("../template_header.php");?>
  <div id="pageContent"><br />
  <div align="right" style="margin-right: 32px;"><a href="inventory_list.php#inventoryForm">+Add New Inventory Item</a></div>
  
    <div align="left" style="margin-left:24px;">
      <h2>Inventory List</h2>
      <?php echo $product_list; ?>
    </div>
    <a name="inventoryForm"id="inventoryForm"></a>
    <h3><br />
  Add New Inventory Item<br /></h3>
  <br />
  <form action="inventory_list.php" enctype="multipart/form-data" name="myForm" id="myform" method="post">
    <table width="90%" border="0" cellspacing="0" cellpadding="6">
      <tr>
        <td width="20%" align="right">Product Name</td>
        <td width="80%"><label>
          <input name="productName" type="text" id="product_name" size="64" />
        </label></td>
      </tr>
      <tr>
        <td align="right">Product Price</td>
        <td><label>
          $
          <input name="price" type="text" id="price" size="12" />
        </label></td>
      </tr>
      <tr>
        <td align="right">Category</td>
        <td><label>
          <select name="category" id="category">
          <option value="Clothing">Clothing</option>
          </select>
        </label></td>
      </tr>
      <tr>
        <td align="right">Subcategory</td>
        <td><select name="subcategory" id="subcategory">
        <option value=""></option>
          <option value="Hats">Hats</option>
          <option value="Pants">Pants</option>
          <option value="Shirts">Shirts</option>
          </select></td>
      </tr>
      <tr>
        <td align="right">Product Details</td>
        <td><label>
          <textarea name="details" id="details" cols="64" rows="5"></textarea>
        </label></td>
      </tr>
      <tr>
        <td align="right">Product Image</td>
        <td><label>
          <input type="file" name="fileField" id="fileField" />
        </label></td>
      </tr>      
      <tr>
        <td>&nbsp;</td>
        <td><label>
          <input type="submit" name="button" id="button" value="Add This Item Now" />
        </label></td>
      </tr>
    </table>
    </form>
    <br />
  <br />
  </div>
  <?php include_once("../template_footer.php");?>
</div>
</body>
</html>