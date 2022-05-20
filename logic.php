<?php
    
    if($_POST!=null){
        $conn = new mysqli("localhost", "root", "", "todo");
        if(isset($_POST['addTodo'])){
            if(addTodo($conn,$_POST)){
                echo ("<SCRIPT LANGUAGE='JavaScript'>
                window.alert('Added')
                window.location.href='./index.php';
                </SCRIPT>");
            }else{
                echo ("<SCRIPT LANGUAGE='JavaScript'>
                window.alert('Error adding')
                window.location.href='./index.php';
                </SCRIPT>");
            }
        }else if(isset($_POST['getTodos'])){
            getTodos($conn);
        }else if(isset($_POST['updateTodo'])){
            if(updateTodo($conn,$_POST)){
                echo ("<SCRIPT LANGUAGE='JavaScript'>
                window.alert('Updated')
                window.location.href='./index.php';
                </SCRIPT>");
            }else{
                echo ("<SCRIPT LANGUAGE='JavaScript'>
                window.alert('Error adding')
                window.location.href='./index.php';
                </SCRIPT>");
            }            
        }else if(isset($_POST['deleteTodo'])){
            deleteTodo($conn,$_POST);            
        }
    }

    function addTodo($connection, $params){
        $q = "INSERT INTO todo_list (task) VALUES (?)";
        $stmt = $connection->prepare($q);
        $stmt->bind_param("s", $task);
        $task = $params["todoTask"];  
        if($stmt->execute()){
            return  true;        
        }else{
            error_log(date("Y-m-d h:m:s")." ERROR when adding task.\n Message==> ".$stmt->error."\n", 3, "./error.log");
            return false;
        }
    }
    function getTodos($connection){
        $query="SELECT * from todo_list";
        $result = $connection->query($query);
        $data = array();
        if($result->num_rows>0){
            while($row=$result->fetch_assoc()){                    
            $data[] = array('id'=>$row['id'],'task'=>$row['task']);
            }
        }      
        echo json_encode($data);
    }
    function updateTodo($connection, $params){
        $q = "UPDATE todo_list SET task=? WHERE id=?";
        $stmt = $connection->prepare($q);
        $stmt->bind_param("si", $task, $id);
        $task = $_POST["todoTaskUpdate"];
        $id = $params["todoTaskUpdateId"];  
        if($stmt->execute()){
            return  true;        
        }else{
            error_log(date("Y-m-d h:m:s")." ERROR when updating task.\n Message==> ".$stmt->error."\n", 3, "./error.log");
            return false;
        }
    }
    function deleteTodo($connection, $params){
        $q = "DELETE FROM todo_list WHERE id=?";
        $stmt = $connection->prepare($q);
        $stmt->bind_param("i", $id);
        $id = $params["id"];  
        if($stmt->execute()){
            echo  true;        
        }else{
            error_log(date("Y-m-d h:m:s")." ERROR deleting task.\n Message==> ".$stmt->error."\n", 3, "./error.log");
            echo false;
        }
    }
?>