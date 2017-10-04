<?php
    include("config.php");

    if (isset ($_GET['q'])) {
        
        if (intval($_GET['q']) != 0) {
            $qr = intval($_GET['q']);
            $_SESSION['qr'] = intval($_GET['q']);
        }
    }

    $f = $_GET['f'];
    if ($f == "deleter") {
        deleter($qr);
    }
    
    
    function deleter($myRecId) {
        global $db;
        $sql = "DELETE FROM record WHERE rec_id = '$myRecId'";
        if (mysqli_query($db, $sql)) {
            // Success
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($db);
        }
    }
    
    function eventUpdater($recId)
    {
        global $db;
        global $qr;
        $ename      = $_GET['ueventName'];
        $edesc      = $_GET['ueventDesc'];
        $edate      = $_GET['uedate'];
        $eloc       = $_GET['ueventLoc'];
        $etimeStart = $_GET['uetimeStart'];
        $etimeEnd   = $_GET['uetimeEnd'];
        $sql = "UPDATE event SET name='" . mysqli_real_escape_string($db, $ename) . "' WHERE rec_id=" . mysqli_real_escape_string($db, $_SESSION['qr']) . ";";
        if (mysqli_query($db, $sql)) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . mysqli_error($db);
        }
        header("location:home.php?#");
    }
?>