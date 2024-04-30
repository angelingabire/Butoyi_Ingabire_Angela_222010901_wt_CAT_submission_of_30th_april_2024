<?php
include('database_connection.php');

// Function to show delete confirmation modal
function showDeleteConfirmation($cid) {
    echo <<<HTML
    <div id="confirmModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center;">
        <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 15px rgba(0,0,0,0.2);">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this record?</p>
            <button onclick="confirmDeletion($cid)">Confirm</button>
            <button onclick="returnToCustomers()">Back</button>
        </div>
    </div>
    <script>
    function confirmDeletion(cid) {
        window.location.href = '?Customer_id=' + cid + '&confirm=yes';
    }
    function returnToCustomers() {
        window.location.href = 'customer.php';
    }
    </script>
HTML;
}

// Check if Customer_id is set
if(isset($_REQUEST['Customer_id'])) {
    $cid = $_REQUEST['Customer_id'];
    
    // Check for confirmation response
    if(isset($_REQUEST['confirm']) && $_REQUEST['confirm'] == 'yes') {
        // Prepare and execute the DELETE statement
        $stmt = $connection->prepare("DELETE FROM customer WHERE Customer_id=?");
        $stmt->bind_param("i", $cid);
        if($stmt->execute()) {
            echo "<script>alert('Record deleted successfully.'); window.location.href = 'customer.php';</script>";
        } else {
            echo "<script>alert('Error deleting data: " . $stmt->error . "');</script>";
        }
        $stmt->close();
    } else {
        // Show confirmation dialog
        showDeleteConfirmation($cid);
    }
} else {
    echo "<script>alert('Customer_id is not set.'); window.location.href = 'customer.php';</script>";
}

$connection->close();
?>
