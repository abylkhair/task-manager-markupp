<?php
session_start();
if(!isset($_SESSION['user_id'])) {
    header('Location: /login-form.php');
    exit;
}
$id = $_GET['id'];
//подготовка и выполнение запроса к БД
require_once(__DIR__."/database_connection.php");
$sql = 'SELECT * from tasks where id=:id';
$statement = $pdo->prepare($sql);
$statement->execute([
  ':id'  =>  $id,
]);
$task = $statement->fetch(PDO::FETCH_ASSOC);
?>
<!-- <!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">

    <title>Show Task</title> -->

    <!-- Bootstrap core CSS -->
   <!--  <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <style>

    </style>
  </head>

  <body>

  </body>
</html> -->
<!DOCTYPE html>
<html lang="ru">
 <head>
   <meta charset="utf-8">
  <title>How to Add New Node in Dynamic Treeview using PHP Mysql Ajax</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-treeview/1.2.0/bootstrap-treeview.min.css" />
  <style>
  </style>
 </head>
 <body>
  <br /><br />
  <div class="container" style="width:900px;">
   <h2 align="center"><?php echo $task['title'];?></h2>
   <h3 align="center"><?php echo $task['description'];?></h3>
   <br /><br />
   <div class="row">
    <div class="form-wrapper text-center">
      <!-- <h3><?php echo $task['title'];?></h3>
      <p><?php echo $task['description'];?></p>
      <img src="/uploads/<?php echo $task['image'];?>" width="100"> -->
      <br>

    </div>
    <div class="col-md-6">
     <h3 align="center"><u>Add New Category</u></h3>
     <br />
     <form method="post" id="treeview_form">
      <div class="form-group">
       <label>Select Parent Category</label>
       <select name="parent_category" id="parent_category" class="form-control">

       </select>
      </div>
      <div class="form-group">
       <label>Enter Category Name</label>
       <input type="text" name="category_name" id="category_name" class="form-control">
      </div>
      <div class="form-group">
       <input type="submit" name="action" id="action" value="Add" class="btn btn-info" />
       <br>
        <a href="taskview/index.php">Просмотр задач</a>
      </div>
      <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Назад</a>
     </form>
    </div>
    <div class="col-md-6">
     <h3 align="center"><u>Category Tree</u></h3>
     <br />
     <div id="treeview"></div>
    </div>
   </div>
  </div>
 </body>
</html>
<script>
 $(document).ready(function(){

  fill_parent_category();

  fill_treeview();

  function fill_treeview()
  {
   $.ajax({
    url:"fetch.php",
    dataType:"json",
    success:function(data){
     $('#treeview').treeview({
      data:data
     });
    }
   })
  }

  function fill_parent_category()
  {
   $.ajax({
    url:'fill_parent_category.php',
    success:function(data){
     $('#parent_category').html(data);
    }
   });

  }

  $('#treeview_form').on('submit', function(event){
   event.preventDefault();
   $.ajax({
    url:"add.php",
    method:"POST",
    data:$(this).serialize(),
    success:function(data){
     fill_treeview();
     fill_parent_category();
     $('#treeview_form')[0].reset();
     alert(data);
    }
   })
  });
 });
</script>
