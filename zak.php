<?php
    $db = new PDO('mysql:host=localhost;dbname=chat;charset=utf8','root','',[
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
   
    $task ="list";

    if(array_key_exists("task", $_GET)){
        postMessage();

    }else{
        getMessages();
    }
    function getMessages(){
        global $db;
        $resultat = $db->query("SELECT * FROM messages ORDER BY created_at DESC LIMIT 20");

        $messages = $resultat->fetchAll();

        echo json_encode($messages);
    }
    function postMessage(){
        global $db;
        if(!array_key_exists('author',$_POST)||!array_key_exists('content',$_POST)){
            echo json_encode(["status"=> "error","message"=>"le message na pas été envoyé"]);
            return;
        }
        $author = $_POST['author'];
        $content = $_POST['content'];
        
        $query = $db->prepare('INSERT INTO messages SET author = :author, content = :content, created_at = NOW()');

        $query->execute([
            "author" => $author,
            "content" => $content

        ]);

        echo json_encode(["status" => "success"]);
    }
?>
