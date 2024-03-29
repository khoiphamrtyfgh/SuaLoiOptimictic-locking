<?php
// Start the session
session_start();
require_once 'models/UserModel.php';
$userModel = new UserModel();

$user = NULL; //Add new user
$_id = NULL;
$_version = null;
$_message1 = null;

if (!empty($_GET['id'])) {
    $_id = $_GET['id'];
    $user = $userModel->findUserById($_id);//Update existing user
    
}

if (!empty($_POST['submit'])) {

    if (!empty($_id)) {
        if( $user[0]['version'] == $_POST['version']){
            
            $userModel->updateUser($_POST);
            $_message1 = 'Update thành công !!!';
            header('location: list_users.php?success_message='.urldecode($_message1));
            exit();
           
        }else{
            $_message1 = 'Version chưa phải mới nhất !!!';
            header('location: list_users.php?success_message='.urldecode($_message1));
            exit();
        }
    } else {
        $userModel->insertUser($_POST);
        header('location: list_users.php');
    }
    
    
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>User form</title>
    <?php include 'views/meta.php' ?>
</head>
<body>
    <?php include 'views/header.php'?>
    <div class="container">

            <?php if ($user || !isset($_id)) { ?>
                <div class="erro alert alert-warning" role="alert">
                    User form
                </div>
                
                <form method="POST">
                    <input type="hidden" name="id" value="<?php echo $_id ?>">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input class="form-control" name="name" placeholder="Name" value='<?php if (!empty($user[0]['name'])) echo $user[0]['name'] ?>'>
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <input class="form-control" name="type" placeholder="Type" value='<?php if (!empty($user[0]['type'])) echo $user[0]['type'] ?>'>
                    </div>
                    <div class="form-group">
                    <input type="hidden" name="version" value='<?php echo (!empty($user[0]['version']) ? $user[0]['version'] : "0"); ?>'>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>

                    <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
                </form>
            <?php } else { ?>
                <div class="alert alert-success" role="alert">
                    User not found!
                </div>
            <?php } ?>
    </div>
</body>
</html>