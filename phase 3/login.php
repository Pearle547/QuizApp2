<?php
require 'config.php';
$err="";
if($_SERVER['REQUEST_METHOD']==='POST'){
    $username = htmlspecialchars(trim($_POST['username']));
    $pass = $_POST['password'];
    foreach($_SESSION['users'] as $u){
        if($u['username']===$username && password_verify($pass, $u['password'])){
            $_SESSION['admin'] = $username;
            header("Location: addquestion.php"); exit;
        }
    }
    $err="Invalid login";
}
?>
<form method="POST"><h2>Admin Login</h2><p style="color:red"><?=$err?></p>
<input name="username" required><br><br>
<input type="password" name="password" required><br><br>
<button>Login</button>
</form>