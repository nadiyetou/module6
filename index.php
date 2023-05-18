<?php

    // 1. Create a database connection

      $databaseConnection = mysqli_connect( "localhost", "root", "root","WWDB_Comments");
      if ( mysqli_connect_error()) {
        exit( "Database connection failed" );
      }
        // echo ( "Connection to the database is successful");

        // if( $_SERVER['REQUEST_METHOD'] == 'POST' && isset( postButtonClicked ) ) {
        //   $postContent = $POST['postContent'];

        //   $sql = "INSERT INTO posts";
        //   $sql .= "(postContent, userid ) ";
        //   $sql .= "VALUES ( ";
        //   $sql .= ")";       
        // }

    // 2. Perform a database query

    // 3. Use the return data from the database

    // 4. Release the return data

    // 5. Close the database connection

?>

<html>
  <head>
    <title>PHP Test</title>
    <link rel="stylesheet" href="css/main.css">
    
  </head>
  <body>

<!-- date -->
<marquee>
    <?php

      function displayWebsiteName(){
        return "World Wide Initiative!!!";
      }
                
       define("GREETING", "hello!");

          echo "Nadia " . GREETING . "<br><br>";
            
          if ( date('l') == 'Thursday' ){
              echo "Today is Happy " . date("l"); 
            } else if( date('l') == 'Friday' ) {
              echo "Today is Thai " . date("l") . "<br>"; 
            } else if( date('l') == 'Monday' ) {
              echo "Today is KayPinky " . date("l") . "<br>"; 
            } else if( date('l') == 'Tuesday' ) {
              echo "a smile " . date("l") . "<br>"; 
            } else if( date('l') == 'wednesday' ) {
              echo "Happy day " . date("l") . "<br>"; 
            }
          
      echo( date(' jS \o\f F') );

  echo( "<span class=\"attention\"><br><br>ATTENTION: THIS IS NOT EASY WORK. I DID THIS WITH PHP :)</span>" );
            ?>
  </marquee>
    <?php
        $websiteName = displayWebsiteName();

       echo '<h1>' . $websiteName . '</h1>'; 

    ?> 
    <ul>
      <?php

// This is your menu
$items = ["home" => "index.php", "news" => "news.php", "about" => "about.php", "contact" => "contact.php"];

foreach ($items as $linkName => $fileName)
{
  echo '<li class="name"><a href=' . $fileName . '"> ' . $linkName . '</a></li>';
}
?>
</ul>

<?php
session_start();

// Let's pretend the user has logged in and their user ID is stored in the session
$_SESSION['userId'] =1;

$connection = mysqli_connect('localhost', 'root', 'root', 'WWDB_Comments');

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['new_post'])) {
    $userId = $_SESSION['userId'];
    $post = $_POST['post'];
    $date = date('Y-m-d');
    $time = date('H:i:s');
    $sql = "INSERT INTO posts (date, time, post, userId) VALUES ('$date', '$time', '$post', '$userId')";
    mysqli_query($connection, $sql);
}

if(isset($_GET['delete_post'])) {
    $postId = $_GET['delete_post'];
    $sql = "DELETE FROM posts WHERE postId = $postId AND userId = ".$_SESSION['userId'];
    mysqli_query($connection, $sql);
}

if(isset($_POST['update_post'])) {
    $postId = $_POST['postId'];
    $post = $_POST['post'];
    $sql = "UPDATE posts SET post = '$post' WHERE postId = $postId AND userId = ".$_SESSION['userId'];
    mysqli_query($connection, $sql);
}

$result = mysqli_query($connection, "SELECT posts.*, users.firstName, users.lastName 
                                     FROM posts INNER JOIN users 
                                     ON posts.userId = users.userId");

function getDynamicDateTimeDisplay($date, $time) {
    $postDateTime = new DateTime($date . ' ' . $time);
    $currentDateTime = new DateTime();
    
    $interval = $postDateTime->diff($currentDateTime);
    
    if ($interval->y >= 1) {
        return $postDateTime->format('Y-m-d H:i:s');
    } else if ($interval->m >= 1 || $interval->d >= 7) {
        return $postDateTime->format('M j');
    } else if ($interval->d >= 1) {
        return $interval->d == 1 ? 'Yesterday' : $interval->d . ' days ago';
    } else if ($interval->h >= 1) {
        return $interval->h == 1 ? '1 hour ago' : $interval->h . ' hours ago';
    } else if ($interval->i >= 1) {
        return $interval->i == 1 ? '1 minute ago' : $interval->i . ' minutes ago';
    } else {
        return 'Just now';
    }
}

?>

<!-- HTML form for new posts -->
<form method="post">
    <textarea name="post"></textarea><br>
    <input type="submit" name="new_post" value="Post">
</form>

<!-- List of posts -->
<?php while($row = mysqli_fetch_assoc($result)) { ?>
    <div>
        <strong><?php echo $row['firstName'] . ' ' . $row['lastName']; ?></strong>
        <small><?php echo getDynamicDateTimeDisplay($row['date'], $row['time']); ?></small>
        <p><?php echo $row['post']; ?></p>
        <?php if($row['userId'] == $_SESSION['userId']) { ?>
            <a href="?edit_post=<?php echo $row['postId']; ?>">Edit</a>
            <a href="?delete_post=<?php echo $row['postId']; ?>">Delete</a>
            <?php if(isset($_GET['edit_post']) && $_GET['edit_post'] == $row['postId']) { ?>
                <form method="post">
                    <input type="hidden" name="postId" value="<?php echo $row['postId']; ?>">
                    <textarea name="post"><?php echo $row['post']; ?></textarea>
                    <input type="submit" name="update_post" value="Update">
                </form>
            <?php } ?>
        <?php } ?>
    </div>
<?php } ?>

<?php mysqli_close($connection); ?>



  </body>
</html>