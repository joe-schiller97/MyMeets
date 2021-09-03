<?php include "templates/header.php"; ?>

<?php $userID = $_SESSION['id']?>

<?php 
	
    // include the config file that we created before
    require "../config.php"; 
    
    // this is called a try/catch statement 
	try {
        // FIRST: Connect to the database
        $connection = new PDO($dsn, $username, $password, $options);
		
        // SECOND: Create the SQL -- This will only show the records of the user who is signed in
        $sql = "SELECT * FROM works WHERE userID=$userID ORDER BY `date_meeting`, `time_meeting` ASC";
        
        // THIRD: Prepare the SQL
        $statement = $connection->prepare($sql);
        $statement->execute();
        
        // FOURTH: Put it into a $result object that we can access in the page
        $result[0] = $statement->fetch() ;
        // Here we are accessing the index to access the first result only, to be used to display next meeting
	} catch(PDOException $error) {
        // if there is an error, tell us what it is
		echo $sql . "<br>" . $error->getMessage();
	}	

?>

<?php  
        if ($result && $statement->rowCount() > 0) { ?>

<h1>Your next meeting is in:</h1>

<!-- This is a loop, which will loop through each result in the array -->
<?php foreach($result as $row) { ?>


<?php 
    $meetingdate = $row['date_meeting'];
    $meetingtime = $row['time_meeting'];
    $combinedDT = date('Y-m-d H:i:s', strtotime("$meetingdate $meetingtime"));
?>

<h3>
    <?php
        $now = new DateTime();
        $future_date = new DateTime($combinedDT);
        
        $interval = $future_date->diff($now);
        
        echo $interval->format("%a days, %h hours, %i minutes, %s seconds");
    ?>
</h3>

<h1>With:</h1>

<h3>
    <?php echo $row['fullname']; ?> from
    <?php echo $row['company']; ?><br> 

</h3>

<?php }; //close the foreach
        }; 
?>

<?php include "templates/footer.php"; ?>