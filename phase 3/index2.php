<?php require 'config.php'; ?>
<!DOCTYPE html>
<html><head><title>Quiz - Phase 3</title></head><body>
<h1>Quiz Questions</h1>

<!-- Preference Form - COOKIE -->
<form method="POST">
    Questions per page: 
    <select name="per_page" onchange="this.form.submit()">
        <option value="1" <?= $per_page==1?'selected':'' ?>>1</option>
        <option value="2" <?= $per_page==2?'selected':'' ?>>2</option>
        <option value="3" <?= $per_page==3?'selected':'' ?>>3</option>
        <option value="5" <?= $per_page==5?'selected':'' ?>>5</option>
    </select>
</form>

<?php
// Pagination
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$total = count($_SESSION['questions_array']);
$pages = ceil($total / $per_page);
$offset = ($page - 1) * $per_page;
$slice = array_slice($_SESSION['questions_array'], $offset, $per_page);

foreach($slice as $q){
    echo "<h3>".htmlspecialchars($q['question'])."</h3><ol type='A'>";
    foreach($q['answers'] as $idx => $a){
        echo "<li>".htmlspecialchars($a);
        if($idx==$q['correct']) echo " <strong style='color:green'>- Correct</strong>";
        echo "</li>";
    }
    echo "</ol>";
}

echo "<div>";
for($i=1;$i<=$pages;$i++){
    echo $i==$page ? " <strong>[$i]</strong> " : " <a href='?page=$i'>$i</a> ";
}
echo "</div>";
?>

<hr>
<h2>Random Question </h2>
<?php
if(!empty($_SESSION['questions_array'])){
    $rk = array_rand($_SESSION['questions_array'],1);
    $rq = $_SESSION['questions_array'][$rk];
    echo "<h3>".$rq['question']."</h3><ol type='A'>";
    foreach($rq['answers'] as $i=>$a){
        echo "<li>$a".($i==$rq['correct']?" <b>- Correct</b>":"")."</li>";
    }
    echo "</ol>";
}
?>
<p><a href="addquestion.php">Add Question (Admin Only)</a> | <a href="login.php">Login</a></p>
</body></html>