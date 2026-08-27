<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'config.php';
if(!isset($_SESSION['admin'])){ header("Location: login.php"); exit; } // Protect

$err=""; $ok="";
if($_SERVER['REQUEST_METHOD']==='POST'){
    $q = trim($_POST['question']??'');
    $a = [trim($_POST['a1']), trim($_POST['a2']), trim($_POST['a3']), trim($_POST['a4'])];
    $correct = (int)$_POST['correct'];

    if(empty($q)) $err="Question required";
    elseif(strlen($q)>50) $err="Max 50 chars";
    elseif(in_array("", $a)) $err="All answers required";
    else{
        $safe_q = htmlspecialchars($q);
        foreach($_SESSION['questions_array'] as $ex){ if(strtolower($ex['question'])==strtolower($safe_q)) $err="Already exists"; }
        if(!$err){
            $_SESSION['questions_array'][] = ["question"=>$safe_q, "answers"=>array_map('htmlspecialchars',$a), "correct"=>$correct];
            $ok="Added!";
        }
    }
}
?>
<h2>Add Question - Admin: <?=$_SESSION['admin']?></h2>
<p style="color:red"><?=$err?></p><p style="color:green"><?=$ok?></p>
<form method="POST">
<input name="question" placeholder="Question max 50" required style="width:300px"><br><br>
<input name="a1" placeholder="A" required> <input name="a2" placeholder="B" required> <input name="a3" placeholder="C" required> <input name="a4" placeholder="D" required><br><br>
Correct: <select name="correct"><option value="0">A</option><option value="1">B</option><option value="2">C</option><option value="3">D</option></select><br><br>
<button>Add</button>
</form>
<form method="POST" action="logout.php"><button>Logout</button></form>
<a href="index2.php">Back to Quiz</a>