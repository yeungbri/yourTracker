<?php
// Print Events for user
$sql = "SELECT * FROM event e JOIN record r ON r.rec_id = e.rec_id WHERE r.user_id = $login_session";
if ($result = mysqli_query($db, $sql)) {
//$row = mysqli_fetch_assoc($result);
echo 'Events' . '<br />';
while ($row = mysqli_fetch_array($result)) {
  echo '<tr>';
  //foreach($row as $field) {
      //echo '<td>' . htmlspecialchars($field) . '</td>';
      echo 'Name: ' . $row['name'] . ' | ';
      echo 'Description: ' . $row['description'] . ' | ';
      echo 'Location: ' . $row['location'] . ' | ';
      echo 'Date: ' . $row['edate'] . ' | ';
      echo 'Time start: ' . $row['time_start'] . ' | ';
      echo 'Time end: ' . $row['time_end'] . ' | ';
  //}
  echo '</tr>';
  echo '<br />';
}
}
?>