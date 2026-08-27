<?php require 'config.php';
$err="";
if($_SERVER['REQUEST_METHOD']==='POST'){
    $username = trim($_POST['username']??'');
    $pass = $_POST['password']??'';
    // Validations
    if(strlen($username)<3) $err="Username min 3 chars";
    elseif(strlen($pass)<4) $err="Password min 4 chars";
    else{
        $username = htmlspecialchars($username);
        foreach($_SESSION['users'] as $u){ if($u['username']===$username) $err="User exists"; }
        if(!$err){
            $_SESSION['users'][] = ['username'=>$username, 'password'=>password_hash($pass, PASSWORD_DEFAULT)];
            header("Location: login.php"); exit;
        }
    }
}
?>
<form method="POST">
<h2>Admin Register</h2>
<p style="color:red"><?=$err?></p>
<input name="username" placeholder="Username" required><br><br>
<input type="password" name="password" placeholder="Password" required><br><br>
<button>Register</button>
</form>