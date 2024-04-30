<?php
include('database_connection.php');

// Check if branch_id is set
if(isset($_REQUEST['branch_id'])) {
    $bid = $_REQUEST['branch_id'];
    
    $stmt = $connection->prepare("SELECT * FROM branch WHERE branch_id=?");
    $stmt->bind_param("i", $bid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['branch_id'];
        $y = $row['branch_name'];
        $s = $row['address'];                                   
    } else {
        echo "Branch not found.";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Update branch</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update branch form -->
        <h2><u>Update Form of branch</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">

            <label for="branch_name">Branch name:</label>
            <input type="text" name="bname" value="<?php echo isset($y) ? $y : ''; ?>">
            <br><br>

            <label for="Address">Address:</label>
            <input type="text" name="badrss" value="<?php echo isset($s) ? $s : ''; ?>">
            <br><br>

            <input type="hidden" name="branch_id" value="<?php echo isset($x) ? $x : ''; ?>">
            <input type="submit" name="up" value="Update">
        
        </form>
    </center>
</body>
</html>

<?php
include('database_connection.php');
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $branch_name = $_POST['bname'];
    $address = $_POST['badrss'];
    $branch_id = $_POST['branch_id']; // added this line to retrieve branch_id
    
    // Update the branch in the database
    $stmt = $connection->prepare("UPDATE branch SET branch_name=?, address=? WHERE branch_id=?");
    $stmt->bind_param("ssi", $branch_name, $address, $branch_id);
    $stmt->execute();
    
    // Redirect to branch.php
    header('Location: branch.php');
    exit(); // Ensure that no other content is sent after the header redirection
}
?>
