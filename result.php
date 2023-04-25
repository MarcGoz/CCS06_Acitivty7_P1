<?php

require "vendor/autoload.php";

session_start();

use App\QuestionManager;

$score = null;
$answers = [];

try {
    $manager = new QuestionManager;
    $manager->initialize();

    if (!isset($_SESSION['answers'])) {
        throw new Exception('Missing answers');
    }

    $answers = $_SESSION['answers'];
    $score = $manager->computeScore($answers);


}






 catch (Exception $e) {
    echo '<h1>An error occurred:</h1>';
    echo '<p>' . $e->getMessage() . '</p>';
    exit;
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quiz</title>
</head>
<body>
    <h1>Thank You</h1>
    <p style="color: gray">You've completed the exam.</p>
    <h3>Congratulations <?php echo $_SESSION['complete_name']; ?>!</h3>
    <h3>Your score is <?php echo $score; ?> out of <?php echo $manager->getQuestionSize(); ?></h3>
    <?php $ex = $manager->Question($_SESSION["answers"]);?> </h3>
    <p>Click <a href="download.php" download>here</a> to download the results.</p>

    
  
</body>

</html>
</body>
</html>
