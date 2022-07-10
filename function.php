<?php
function check_user_by_email($email) {
    $pdo = new PDO("mysql:host=localhost;dbname=tolaravel", "root","root");
    $sql = "SELECT * from 2task_users WHERE email=:email";
    $statement = $pdo->prepare($sql);
    $statement -> execute([ "email" => $email ]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    return $user;
};

function get_user_by_id($id) {
    $pdo = new PDO("mysql:host=localhost;dbname=tolaravel", "root","root");
    $sql = "SELECT * from 2task_users WHERE id=:id";
    $statement = $pdo->prepare($sql);
    $statement -> execute([ "id" => $id]);
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    return $user;
};

function set_flash_message($name, $message) {
    $_SESSION[$name] = $message;
};

function redirect_to($path) {
    header("Location: /$path");
    exit;
};

function add_user($email, $password) {
    $pdo = new PDO("mysql:host=localhost;dbname=tolaravel", "root","root");
    $sql = "INSERT INTO 2task_users (email, password ) VALUES (:email, :password)";
    $statement = $pdo->prepare($sql);
    $statement -> execute([
        "email" => $email,
        "password" => password_hash($password, PASSWORD_DEFAULT)
    ]);
    $user = check_user_by_email($email);
    
    set_flash_message ("id", $user["id"]);

};

function display_flash_message($name) {
    if(isset($_SESSION[$name])) {
        echo "<div class=\"alert alert-$name text-dark\" role=\"alert\"><strong></strong>$_SESSION[$name]</div>";
        unset($_SESSION[$name]);
    }
    };


    // авторизовать пользователя 

function login($email, $password) {

    $user = check_user_by_email($email);
    if ((empty($user)) or (!password_verify($password,$user["password"]))) {
        set_flash_message("danger", "ЛОГИН ИЛИ ПАРОЛЬ НЕ ПОДХОДЯТ.");
        redirect_to("page_login.php");    
    } else {
        set_flash_message("auth", "$email");
        set_flash_message("role", $user["role"]);
            
        redirect_to("users.php");    
    }
    

}

function logged()
{
    if (isset($_SESSION['auth']))
            return true;
        else
            return false;
}

function admin()
{
    if ($_SESSION['role'] == "admin")
            return true;
        else
            return false;
}

function currentuser($email)
{
    if ($_SESSION['auth'] == $email)
            return true;
        else
            return false;
}


function allpersons ()
{
    $pdo = new PDO ("mysql:host=localhost;dbname=tolaravel", "root", "root");
    $sql = "SELECT * FROM 2task_users";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $persons = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $persons;
 
}

// дописать эту функцию

function edit($id, $name, $work, $phone, $address) {
    $pdo = new PDO("mysql:host=localhost;dbname=tolaravel", "root","root");
    $sql = "UPDATE 2task_users  SET name=:name, work=:work, phone=:phone, address=:address WHERE id=:id";
    $statement = $pdo->prepare($sql);
    $statement -> execute([
        "id" => $id,
        "name" => $name,
        "work" => $work,
        "phone" => $phone,
        "address" => $address
        ]);
    $user = check_user_by_email($email);
    
    set_flash_message ("id", $user["id"]);
    redirect_to("users.php"); 
}


function set_status($id, $status) {
    $pdo = new PDO("mysql:host=localhost;dbname=tolaravel", "root","root");
    $sql = "UPDATE 2task_users  SET name=:name, work=:work, phone=:phone, address=:address WHERE id=:id";
    $statement = $pdo->prepare($sql);
    $statement -> execute([
        "id" => $id,
        "status" => $status,
        ]);
    $user = check_user_by_email($email);
    
    set_flash_message ("id", $user["id"]);
    redirect_to("users.php"); 
}


function upload_avatar($id) {

    $newfilename = uniqid().'.png';
    move_uploaded_file($_FILES['image']['tmp_name'],'avatar/'.$newfilename);
    $pdo = new PDO('mysql:host=localhost;dbname=tolaravel','root','root');
    $sql = "UPDATE 2task_users SET avatar=:avatar WHERE id=:id";
    $statement = $pdo->prepare($sql);
    $statement ->execute([
        'id' => $id,
        'avatar' => $newfilename]);
}

function add_social_links($id, $telegram, $instagram, $vk) {
    $pdo = new PDO("mysql:host=localhost;dbname=tolaravel", "root","root");
    $sql = "UPDATE 2task_users  SET telegram=:telegram, instagram=:instagram, vk=:vk, address=:address WHERE id=:id";
    $statement = $pdo->prepare($sql);
    $statement -> execute([
        "id" => $id,
        "telegram" => $telegram,
        "instagram" => $instagram,
        "vk" => $vk,
        ]);
    $user = get_user_by_id($id);
    
    set_flash_message ("id", $user["id"]);
    redirect_to("users.php"); 
    
}