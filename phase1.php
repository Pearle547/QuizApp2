<?php
$questions_array = [
    [
        "question" => "What is your favorite color?",
        "answers" => ["Blue", "Green", "Red", "Orange"],
        "correct" => 1
    ],
    [
        "question" => "Which country are you from?",
        "answers" => ["Uganda", "Kenya", "Tanzania", "Rwanda"],
        "correct" => 0
    ],
    [
        "question" => "What is your favorite food?",
        "answers" => ["Rice", "Matooke", "Cassava", "Potatoes"],
        "correct" => 0
    ],
    [
        "question" => "What is your name?",
        "answers" => ["Michael", "Pearl", "Kelvin", "Collin"],
        "correct" => 2
    ]
];

//  answered array
$answered_questions_array = [];

// 3. Randomly select a question
if (!empty($questions_array)) {
    $selected_key = array_rand($questions_array, 1);
    $selected_question = $questions_array[$selected_key];

    // Move to answered array
    $answered_questions_array[] = $selected_question;

    // Remove from questions_array
    unset($questions_array[$selected_key]);
}
?>
<!DOCTYPE html>
<html>
<head><title>Phase 1 - Complete</title></head>
<body>
    <h1>Selected Random Question</h1>
    <h2><?php echo $selected_question["question"]; ?></h2>
    <ol type="A">
        <?php foreach($selected_question["answers"] as $index => $answer): ?>
            <li>
                <?php echo $answer; ?>
                <?php if($index == $selected_question["correct"]): ?>
                    <strong style="color:green;"> - Correct</strong>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ol>

    <hr>
    <h3>Debug Check:</h3>
    <p>Remaining questions: <?php echo count($questions_array); ?></p>
    <p>Answered questions: <?php echo count($answered_questions_array); ?></p>

    <h4>Answered Array Contains:</h4>
    <pre><?php print_r($answered_questions_array); ?></pre>
</body>
</html>

