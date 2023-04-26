<?php

require "vendor/autoload.php";

session_start();

use App\QuestionManager;

$score = null;
$answers = [];
$results = [];

try {
    $manager = new QuestionManager;
    $manager->initialize();

    if (!isset($_SESSION['answers'])) {
        throw new Exception('Missing answers');
    }

    $answers = $_SESSION['answers'];
    $score = $manager->computeScore($answers);
    $results = $manager->results($answers);

    $file = "results.txt";
    $txt = fopen($file, "w") or die("Unable to open file!");

    $output = "Complete Name: ".$_SESSION['complete_name']."\n";
    $output .= "Email: ".$_SESSION['email']."\n";
    $output .= "Birthdate: ".$_SESSION['birthdate']."\n";
    $output .= "Score: ".$score." out of ".$manager->getQuestionSize()."\n";
    $output .= "Answers:\n\n";

    foreach ($results as $number => $answer) {
        if ($answer[1] == 1) {
            $output .= $number + 1 . ") " . $answer[0] . " (correct) \n";
        } else {
            $output .= $number + 1 . ") " . $answer[0] . " (incorrect) \n";
        }
    }

    fwrite($txt, $output);
    fclose($txt);
    readfile($file);
    exit;

} catch (Exception $e) {
    echo '<h1>An error occurred:</h1>';
    echo '<p>' . $e->getMessage() . '</p>';
    exit;
}
