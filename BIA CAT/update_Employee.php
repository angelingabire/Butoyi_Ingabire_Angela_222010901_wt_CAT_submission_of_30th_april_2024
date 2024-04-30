<?php
include('database_connection.php');
// Check if Product_Id is set
if(isset($_REQUEST['employee_id'])) {
    $eid = $_REQUEST['employee_id'];
    
    $stmt = $connection->prepare("SELECT * FROM employee WHERE employee_id=?");
    $stmt->bind_param("i", $eid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['employee_id'];
        $y = $row['employee_name'];
        $y = $row['email'];
        $z = $row['phone_number'];
        $w = $row['customer_id'];                                        
    } else {
        echo "employee not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update employee</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update employee form -->
    <h2><u>Update Form of employee</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">


        <label for="employee_name">Employee name</label>
        <input type="text" name="ename" value="<?php echo isset($w) ? $w : ''; ?>">
        <br><br>

        
        <label for="email">Email:</label>
        <input type="text" name="email" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

        <label for="phone_number">Phone number:</label>
        <input type="number" name="ephoneno" value="<?php echo isset($s) ? $S : ''; ?>">
        <br><br>

        <label for="customer_id">Customer id:</label>
        <input type="number" name="ecid" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>
        

        <input type="submit" name="up" value="Update">
        
    </form>
</body>
</html>

<?php
include('database_connection.php');
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $employee_name = $_POST['ename'];
    $email = $_POST['email'];
    $phone_number = $_POST['ephoneno'];
    $customer_id = $_POST['ecid'];
    
    // Update the customer in the database
    $stmt = $connection->prepare("UPDATE employee SET employee_name=?, email=?,phone_number=?, customer_id=? WHERE employee_id=?");
    $stmt->bind_param("sssss",$employee_name, $email, $phone_number,$customer_id,$eid);
    $stmt->execute();
    
    // Redirect to employee.php
    header('Location: employee.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>