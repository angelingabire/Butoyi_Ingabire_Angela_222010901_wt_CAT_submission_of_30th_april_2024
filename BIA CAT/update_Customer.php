<?php
include('database_connection.php');

// Check if Product_Id is set
if(isset($_REQUEST['Customer_id'])) {
    $cid = $_REQUEST['Customer_id'];
    
    $stmt = $connection->prepare("SELECT * FROM customer WHERE Customer_id=?");
    $stmt->bind_param("i", $cid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['Customer_id'];
        $y = $row['Customer_name'];
        $s = $row['Email'];
        $z = $row['Address'];
        $w = $row['Telephone'];
        $f = $row['branch_id'];                                         
    } else {
        echo "customer not found.";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Update customer</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update customer form -->
    <h2><u>Update Form of customer</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">



        
        <label for="Customer_name">Customer name:</label>
        <input type="text" name="cname" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

        <label for="Email">Email:</label>
        <input type="text" name="eml" value="<?php echo isset($s) ? $s : ''; ?>">
        <br><br>

        <label for="Address">Address:</label>
        <input type="text" name="adrss" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>

        <label for="Telephone">Telephone:</label>
        <input type="number" name="tlphn" value="<?php echo isset($w) ? $w : ''; ?>">
        <br><br>

         <label for="branch_id">Branch id:</label>
        <input type="number" name="braid" value="<?php echo isset($f) ? $f : ''; ?>">
        <br><br>

        

        <input type="submit" name="up" value="Update">
        
    </form>
</body>
</html>

<?php
include('database_connection.php');
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $Customer_id = $_POST['cid'];
    $Customer_name = $_POST['cname'];
    $Email = $_POST['eml'];
    $Address = $_POST['adrss'];
    $Telephone = $_POST['tlphn'];
    $branch_id = $_POST['braid'];
    
    // Update the customer in the database
    $stmt = $connection->prepare("UPDATE customer SET Customer_name=?, Email=?, Address=?, Telephone=?,branch_id=? WHERE Customer_id=?");
    $stmt->bind_param("ssssss", $Customer_name,$Email, $Address, $Telephone, $branch_id,$cid);
    $stmt->execute();
    
    // Redirect to customer.php
    header('Location: customer.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>