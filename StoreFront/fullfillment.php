<?php 
// Run a select query to get my letest 6 items
// Connect to the MySQL database  
include "js/connect_to_mysql.php"; 
$dynamicList = "";
$sql = mysql_query("SELECT * FROM products ORDER BY productID DESC LIMIT 10");
$productCount = mysql_num_rows($sql); // count the output amount
if ($productCount > 0) {
	while($row = mysql_fetch_array($sql)){ 
             $productID = $row["productID"];
			 $productName = $row["productName"];
			 $price = $row["price"];
			 $image = $row["image"];
			 $category = $row["category"];
			 $sku = $row["sku"];
			 $stock = $row["stock"];
			 $cost = $row["cost"];
			 $description = $row["description"];
			 $weight = $row["weight"];
			 $productID = strftime("%b %d, %Y", strtotime($row["productID"]));
			 $dynamicList .= '<table width="100%" border="0" cellspacing="0" cellpadding="6">
        <tr>
          <td width="17%" valign="top"><a href="catalog.php?productID=' . $productID . '"><img style="border:#666 1px solid;" src="img/'.$image.'.jpg' . $productID . '.jpg" alt="' . $productName . '" width="77" height="102" border="1" /></a></td>
          <td width="83%" valign="top">' . $productName . '<br />
            $' . $price . '<br />
			' . $description . '<br />
           
			
			<form id="form1" name="form1" method="post" action="cart.php">
        <input type="hidden" name="pid" id="pid" value="<?php echo $productID; ?>" />
        <input type="submit" name="button" id="button" value="Add to Shopping Cart" />
      </form>
			
			<fieldset class="rating">
    <legend>Please rate:</legend>
    <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="Rocks!">5 stars</label>
    <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="Pretty good">4 stars</label>
    <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="Meh">3 stars</label>
    <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="Kinda bad">2 stars</label>
    <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="Sucks big time">1 star</label>
</fieldset>

		</td>
        </tr>
      </table>';
    }
} else {
	$dynamicList = "We have no products listed in our store yet";
}
mysql_close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Cliff's Sporting Goods Order Fullfillment-Gina Levy</title>
<link rel="stylesheet" href="css/styles.css" type="text/css" media="screen" />
</head>

<body>
<div align="center" id="mainWrapper"> 
	<?php include_once("template_header.php");?>
    <div id="pageContent">
    <table width="100%" border="0" cellspacing="0" cellpadding="10">
    <tr>
        <td width="100%" align="center" valign="left">
        <h3>Order Fullfillment:
     </h3>
          
          <form>
            <p>First name:
              <input type="text" name="firstname">
  <br>
              Last name:
              <input type="text" name="lastname">
            </p>
            <p>Billing Address :
              <input type="text" name="firstline">
            </p>
            <p> 
              <input type="text" name="secondline">
            </p>
            <p>
              <input type="text" name="thirdline">
              </p>
            <p>Payment Method:</p>
            <p>Card Number
  <input type="text" name="lastname">
            </p>
            <p>CSV Number
              <input type="text" name="lastname3" />
            </p>
            <p>EXP Date
              <input type="text" name="lastname2" />
            </p>
            <p>
              <input type="button" onclick="alert('Thank you for your purchase!')" value="Finish Purchase!">
            </p>

          </form>
          <p><br />  
  </p>
      <p><br />
    </p></td>
        
    </tr>
    <tr>
      <td align="center" valign="left">&nbsp;</td>
    </tr>
    </table>
    </div>
    
	<?php include_once("template_footer.php");?>
</div>
</body>
</html>