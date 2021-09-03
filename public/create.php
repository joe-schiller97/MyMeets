<?php 

// this code will only execute after the submit button is clicked
if (isset($_POST['submit'])) {
	
    // include the config file that we created before
    require "../config.php"; 
    
    // this is called a try/catch statement 
	try {
        // FIRST: Connect to the database
        $connection = new PDO($dsn, $username, $password, $options);
		
        // SECOND: Get the contents of the form and store it in an array
        $new_work = array( 
            //this userID post will send the user's ID along with the inputs to differentiate it from other user's data
            "userID" => $_POST['id'],
            "fullname" => $_POST['fullname'], 
            "company" => $_POST['company'],
            "date_meeting" => $_POST['date_meeting'],
            "time_meeting" => $_POST['time_meeting'],
            "notes" => $_POST['notes'],  
        );
        
        // THIRD: Turn the array into a SQL statement
        $sql = "INSERT INTO works (userID, fullname, company, date_meeting, time_meeting, notes) VALUES (:userID, :fullname, :company, :date_meeting, :time_meeting, :notes)";        
        
        // FOURTH: Now write the SQL to the database
        $statement = $connection->prepare($sql);
        $statement->execute($new_work);

	} catch(PDOException $error) {
        // if there is an error, tell us what it is
		echo $sql . "<br>" . $error->getMessage();
	}	
}
?>


<?php include "templates/header.php"; ?>

<h2>Schedule a meeting</h2>

<?php if (isset($_POST['submit']) && $statement) { ?>
<p>Meeting successfully added.</p>
<?php } ?>

<!--form to collect data for each artwork-->

<form method="post">
    <input type="hidden" name="id" id="id" value="<?=$_SESSION['id']?>">
    <!--this hidden input sends over the userID of the user currently logged in to be a part of the array -->
    <label for="fullname">Name</label>
    <input type="text" name="fullname" id="fullname">

    <label for="company">Company</label>
    <input type="text" name="company" id="company">

    <label for="date_meeting">Date</label>
    <input type="date" name="date_meeting" id="date_meeting">
    <!--changed type to date to allow inputting of date with correct format-->
    <label for="time_meeting">Time</label>
    <input type="time" name="time_meeting" id="time_meeting">
    <!--changed type to time to allow inputting of date with correct format-->
    <label for="notes">Notes</label>
    <input type="text" name="notes" id="notes">

    <input type="submit" name="submit" value="Submit">

</form>

<?php include "templates/footer.php"; ?>