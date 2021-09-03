<?php include "templates/header.php"; ?>

<?php $userID = $_SESSION['id']?>

<?php 

    // include the config file 
    require "../config.php";
    require "common.php";

    // This code will only run if the delete button is clicked
    if (isset($_GET["id"])) {
	    // this is called a try/catch statement 
        try {
            // define database connection
            $connection = new PDO($dsn, $username, $password, $options);
            
            // set id variable
            $id = $_GET["id"];
            
            // Create the SQL 
            $sql = "DELETE FROM works WHERE id = :id";

            // Prepare the SQL
            $statement = $connection->prepare($sql);
            
            // bind the id to the PDO
            $statement->bindValue(':id', $id);
            
            // execute the statement
            $statement->execute();

            // Success message
            $success = "Meeting cancelled";

        } catch(PDOException $error) {
            // if there is an error, tell us what it is
            echo $sql . "<br>" . $error->getMessage();
        }
    };

    // This code runs on page load
    try {
        $connection = new PDO($dsn, $username, $password, $options);
		
        // SECOND: Create the SQL 
        $sql = "SELECT * FROM works WHERE userID=$userID ORDER BY `date_meeting`, `time_meeting` ASC";
        
        // THIRD: Prepare the SQL
        $statement = $connection->prepare($sql);
        $statement->execute();
        
        // FOURTH: Put it into a $result object that we can access in the page
        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }

?>

<h2>Cancel a meeting</h2>

<?php if ($success) echo $success; ?>

<!-- This is a loop, which will loop through each result in the array -->
<?php foreach($result as $row) { ?>

<p>
    Name:
    <?php echo $row['fullname']; ?><br> Company:
    <?php echo $row['company']; ?><br> Date:
    <?php echo $row['date_meeting']; ?><br> Time:
    <?php echo $row['time_meeting']; ?><br> Notes:
    <?php echo $row['notes']; ?><br>
    <a href='delete.php?id=<?php echo $row['id']; ?>'>Delete</a>
</p>

<hr>
<?php }; //close the foreach
?>



<?php include "templates/footer.php"; ?>