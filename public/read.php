<?php include "templates/header.php"; ?>

<?php $userID = $_SESSION['id']?>

<?php 

    // this code will only execute after the submit button is clicked
    if (isset($_POST['submit'])) {
        
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
            $result = $statement->fetchAll() ;

        } catch(PDOException $error) {
            // if there is an error, tell us what it is
            echo $sql . "<br>" . $error->getMessage();
        }	
    }
?>

<?php  
    if (isset($_POST['submit'])) {
        //if there are some results
        if ($result && $statement->rowCount() > 0) { ?>
<h2>Results</h2>

<!-- This is a loop, which will loop through each result in the array -->
<?php foreach($result as $row) { ?>

<p>
    Name:
    <?php echo $row['fullname']; ?><br>Company:
    <?php echo $row['company']; ?><br> Date:
    <?php echo $row['date_meeting']; ?><br> Time:
    <?php echo $row['time_meeting']; ?><br> Notes:
    <?php echo $row['notes']; ?><br>
</p>
<?php 
            // this willoutput all the data from the array
            //echo '<pre>'; var_dump($row); 
        ?>

<hr>
<?php }; //close the foreach
        }; 
    }; 
?>



<form method="post">

    <input type="submit" name="submit" value="View all">

</form>


<?php include "templates/footer.php"; ?>