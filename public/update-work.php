<?php 

    // include the config file that we created last week
    require "../config.php";
    require "common.php";


    // run when submit button is clicked
    if (isset($_POST['submit'])) {
        try {
            $connection = new PDO($dsn, $username, $password, $options);  
            
            //grab elements from form and set as varaible
            $work =[
              "id"       => $_POST['id'],
              "fullname" => $_POST['fullname'],
              "company"  => $_POST['company'],
              "date_meeting"   => $_POST['date_meeting'],
              "time_meeting"   => $_POST['time_meeting'],
              "notes"   => $_POST['notes'],              
            ];
            
            // create SQL statement
            $sql = "UPDATE `works` 
                    SET id = :id, 
                        fullname = :fullname, 
                        company = :company, 
                        date_meeting = :date_meeting, 
                        time_meeting = :time_meeting,
                        notes = :notes                      
                    WHERE id = :id";

            //prepare sql statement
            $statement = $connection->prepare($sql);
            
            //execute sql statement
            $statement->execute($work);

        } catch(PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    }

    // GET data from DB
    //simple if/else statement to check if the id is available
    if (isset($_GET['id'])) {
        //yes the id exists 
        
        try {
            // standard db connection
            $connection = new PDO($dsn, $username, $password, $options);
            
            // set if as variable
            $id = $_GET['id'];
            
            //select statement to get the right data
            $sql = "SELECT * FROM works WHERE id = :id";
            
            // prepare the connection
            $statement = $connection->prepare($sql);
            
            //bind the id to the PDO id
            $statement->bindValue(':id', $id);
            
            // now execute the statement
            $statement->execute();
            
            // attach the sql statement to the new work variable so we can access it in the form
            $work = $statement->fetch(PDO::FETCH_ASSOC);
            
        } catch(PDOExcpetion $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    } else {
        // no id, show error
        echo "No id - something went wrong";
        //exit;
    };


?>

<?php include "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
	<p>Meeting successfully updated.</p>
<?php endif; ?>

<h2>Edit a meeting</h2>

<form method="post">
    
    <label for="id">ID</label>
    <input type="text" name="id" id="id" value="<?php echo escape($work['id']); ?>" >
    
    <label for="fullname">Name</label>
    <input type="text" name="fullname" id="fullname" value="<?php echo escape($work['fullname']); ?>">

    <label for="company">Company</label>
    <input type="text" name="company" id="company" value="<?php echo escape($work['company']); ?>">

    <label for="date_meeting">Date</label>
    <input type="date" name="date_meeting" id="date_meeting" value="<?php echo escape($work['date_meeting']); ?>">

    <label for="time_meeting">Time</label>
    <input type="time" name="time_meeting" id="time_meeting" value="<?php echo escape($work['time_meeting']); ?>">

    <label for="Notes">Notes</label>
    <input type="text" name="notes" id="notes" value="<?php echo escape($work['notes']); ?>">
    
    <input type="submit" name="submit" value="Save">

</form>





<?php include "templates/footer.php"; ?>