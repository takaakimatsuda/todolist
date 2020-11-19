<?php
require_once('functions.php');

if(isset($_POST['submit'])){

  $name = $_POST['name'];
  $name = htmlspecialchars($name, ENT_QUOTES);
  
  $dbh = db_connect();

  $sql = 'INSERT INTO tasks (name, done) VALUES (?, 0)';
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(1, $name, PDO::PARAM_STR);
  $stmt->execute();
  $dbh = null;
  unset($name);

}

if(isset($_POST['method']) &&
($_POST['method'] === 'put')){

  $id = $_POST["id"];
  $id = htmlspecialchars($id, ENT_QUOTES);
  $id = (int)$id;

  $dbh = db_connect();

  $sql = 'UPDATE tasks SET done = 1 WHERE id = ?';
  $stmt = $dbh->prepare($sql);
  $stmt->bindValue(1, $id, PDO::PARAM_INT);
  $stmt->execute();

  $dbh = null;
}

?>
<!doctype html>
<html>
  <head>
    <metacharset="utf8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link rel="stylesheet" href="asset/css/main.scss">
    <title>TO DO LIST</title>
  </head>
  <body>
    <div class="app-title text-center">
      <h2>TO DO LIST</h2>
    </div>
    <div class="task-card text-center">
      <form action="index.php" method="post">
        <ul>
          <li><input type="submit" class="btn btn-primary" name="submit" value="ADD"><input type="text" name="name"></li>
        </ul>
      </form>
    </div>
    <div class="task-list text-center mx-auto">
      <ul>
      <?php
      $dbh = db_connect();

      $sql = 'SELECT id, name FROM tasks WHERE done = 0 ORDER BY id DESC';
      $stmt = $dbh->prepare($sql);
      $stmt->execute();
      $dbh = null;

      while($task = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        print '<li>';
        print '
                <form acttion="index.php" method="post">
                <input type="hidden" name="method" value="put">
                <input type="hidden" name="id" value="'.$task['id'].'">
                <button class="check-btn" type="submit"><i class="fas fa-check"></i></button>
                <a class="task_name">';
        print $task["name"];
        print  '
                </form>
                </a>';
        print '</li>';

      }

      ?>
      </ul>
    </div>
  </body>
</html>
