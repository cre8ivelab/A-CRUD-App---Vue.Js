<?php
 $connnection = new mysqli("localhost", "root", "", "crud_app");
 if($connnection->connect_error){
     die("Connection Failed!".$connnection->connect_error);
 }
 
 $result = array('error'=>false);
 $action = '';

 if(isset($_GET['action'])){
     $action  = $_GET['action'];
 }

 //to get all categories
 if($action == 'readCat'){
     $sql = $connnection->query("SELECT * FROM categories");
     $categories = array();
     while($row = $sql->fetch_assoc()){
         array_push($categories, $row);
     }
     $result['categories'] = $categories;
 }

 //to get all documents
 if($action == 'readDoc'){
   // $catId = $_POST['id'];WHERE category_id='$catId'
    $sql = $connnection->query("SELECT * FROM documents ");
    $documents = array();
    while($row = $sql->fetch_assoc()){
        array_push($documents, $row);
    }
    $result['documents'] = $documents;
}

//to add new document
if($action == 'create'){
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $sql = $connnection->query("INSERT INTO documents (category_id, name) VALUES('$category_id', '$name')");
    if($sql){
        $result['message'] = "document added successfully.";
    }
    else{
        $result['error'] = true;
        $result['message'] = "Failed to add document!";
    }
}

//update the document
if($action == 'update'){
    $id = $_POST['id'];
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $sql = $connnection->query("UPDATE documents SET category_id='$category_id', name='$name' WHERE id='$id'");
    if($sql){
        $result['message'] = "document updated successfully.";
    }
    else{
        $result['error'] = true;
        $result['message'] = "Failed to update document!";
    }
}

//delete the document
if($action == 'delete'){
    $id = $_POST['id'];
    $sql = $connnection->query("DELETE FROM documents WHERE id='$id'");
    if($sql){
        $result['message'] = "document deleted successfully.";
    }
    else{
        $result['error'] = true;
        $result['message'] = "Failed to delete document!";
    }
}

$connnection->close();
echo json_encode($result);

?>