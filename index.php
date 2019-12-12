<!DOCTYPE html>
<html>
<head>
<title> Test Payment </title>
</head>

<style>
#form-success {border: 1px solid #ccc; background: #f8f8f8; display: none; padding: 10px; width: 320px; }
</style>
<body>

<h3> Payment Form </h3>

<div id="form-success"></div>
<form id="payment_info" method="post" action="secure.php?action=payment">

<input type="hidden" name="purchaseOrderNo" value="ODR1">

<p> <label> Product Name </label>
<input type="text" name="pname" value="Some name" required>
</p>

<p> <label> Amount: </label>
<input type="text" name="amount" value="" required>
</p>


<p><input type="submit" value="Submit"> </p>

</form>

</body>
</html>


