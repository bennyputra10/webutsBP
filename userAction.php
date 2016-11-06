<?php
require_once 'db.php';
if(isset($_GET['action_type']) && !empty($_GET['action_type'])){
    if($_GET['action_type'] == 'data'){
        $conn = konek_db();
        if (!isset($_GET['id'])) {
            echo "<javascript>alert('fak')</javascript>";
        }
        $id = 1;
        $query = $conn->prepare("select * from users where id=?");
        $query->bind_param("i", $id);
        $result = $query->execute();
        if (! $result)
            die("gagal query");
        $row = $query->get_result();
        $user = $row->fetch_array();
        echo json_encode($user);
    }elseif($_GET['action_type'] == 'add'){
        $conn = konek_db();
        $name = $_GET['name'];
        $email = $_GET['email'];
        $phone = $_GET['phone'];
        $query = $conn->prepare("INSERT into users(name, email, phone, created, modified ) values(?, ?, ?, now(), now())");
        $query->bind_param("sss", $name, $email, $phone);
        $result = $query->execute();
        echo $result ? 'ok':'err';
    }elseif($_GET['action_type'] == 'edit'){
        if(!empty($_GET['id'])){
            $conn = konek_db();
            $id = $_GET['id'];
            $name = $_GET['name'];
            $email = $_GET['email'];
            $phone = $_GET['phone'];
            $query = $conn->prepare("UPDATE users SET name = ?, email= ?, phone =?, modified= NOW() WHERE id = ?");
            $query->bind_param("sssi", $name, $email, $phone, $id);
            $result = $query->execute();
            echo $result?'ok':'err';
        }
    }elseif($_GET['action_type'] == 'delete'){
        if(!empty($_GET['id'])){
            $conn = konek_db();
            $id = $_GET['id'];
            $query = $conn->prepare("delete from users where id=?");
            $query->bind_param("i",$id);
            $result = $query->execute();
            echo $result?'ok':'err';
        }
    }
    exit;
}else {
    echo "fak";
}
?>