<?php
session_start();

if (!isset($_SESSION['questions_array']) || empty($_SESSION['questions_array'])) {
    $_SESSION['questions_array'] = [
        ["question" => "What is your favorite color?", "answers" => ["Blue", "Green", "Red", "Orange"], "correct" => 1],
        ["question" => "Which country are you from?", "answers" => ["Uganda", "Kenya", "Tanzania", "Rwanda"], "correct" => 0],
        ["question" => "What is your favorite food?", "answers" => ["Rice", "Matooke", "Cassava", "Potatoes"], "correct" => 0],
        ["question" => "What is your name?", "answers" => ["Michael", "Pearl", "Kelvin", "Collin"], "correct" => 2]
    ];
    $_SESSION['answered'] = [];
}

$error = "";
$success = "";

// RESET BUTTON
if(isset($_GET['reset'])){
    session_destroy();
    header("Location: phase2.php");
    exit;
}

// ADD NEW QUESTION
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $q_text = trim($_POST['question'] ?? '');
    $answers = array_map('trim', [$_POST['a1'] ?? '', $_POST['a2'] ?? '', $_POST['a3'] ?? '', $_POST['a4'] ?? '']);
    $correct = (int)($_POST['correct'] ?? 0);

    if (empty($q_text)) {
        $error = "Question is required";
    } elseif (strlen($q_text) > 50) {
        $error = "Question should not be more than 50 characters long";
    } elseif (in_array("", $answers)) {
        $error = "All 4 answers are required";
    } else {
        $safe_q = htmlspecialchars($q_text);
        $safe_answers = array_map('htmlspecialchars', $answers);

        $exists = false;
        foreach ($_SESSION['questions_array'] as $existing) {
            if (strtolower($existing['question']) === strtolower($safe_q)) {
                $exists = true; break;
            }
        }

        if ($exists) {
            $error = "Question already exists";
        } else {
            $_SESSION['questions_array'][] = [
                "question" => $safe_q,
                "answers" => $safe_answers,
                "correct" => $correct
            ];
            $success = "Question added! Total: " . count($_SESSION['questions_array']);
        }
    }
}

// RANDOM QUESTION
$selected_question = null;
if (!empty($_SESSION['questions_array'])) {
    $rand_key = array_rand($_SESSION['questions_array'], 1);
    $selected_question = $_SESSION['questions_array'][$rand_key];
}
?>
<!DOCTYPE html>
<html>
<head><title>Phase 2</title></head>
<body>
    <h1>Phase 2 - Add Question</h1>
    <a href="?reset=1" style="color:red">Reset All Questions</a>

    <?php if($error): ?><p style="color:red"><?php echo $error; ?></p><?php endif; ?>
    <?php if($success): ?><p style="color:green"><?php echo $success; ?></p><?php endif; ?>

    <form method="POST">
        <input type="text" name="question" placeholder="Question max 50 chars" required style="width:300px"><br><br>
        <input type="text" name="a1" placeholder="Answer A" required>
        <input type="text" name="a2" placeholder="Answer B" required>
        <input type="text" name="a3" placeholder="Answer C" required>
        <input type="text" name="a4" placeholder="Answer D" required><br><br>
        Correct: 
        <select name="correct">
            <option value="0">A</option><option value="1">B</option>
            <option value="2">C</option><option value="3">D</option>
        </select><br><br>
        <button type="submit">Add Question</button>
    </form>

    <hr>
    <h1>Random Question</h1>
    <?php if($selected_question): ?>
        <h2><?php echo $selected_question['question']; ?></h2>
        <ol type="A">
            <?php foreach($selected_question['answers'] as $idx => $ans): ?>
                <li>
                    <?php echo $ans; ?>
                    <?php if($idx == $selected_question['correct']): ?>
                        <strong style="color:green"> - Correct Answer</strong>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ol>
    <?php else: ?>
        <p>No questions available</p>
    <?php endif; ?>

    <p>Total Questions: <?php echo count($_SESSION['questions_array']); ?></p>
</body>
</html>
