<?php
require_once('db.php');

if (isset($_GET['login'])) {
    $login = $_GET['login'];
} else {
    header("Location: registration.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Интересы успешно сохранены!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Выбор интересов</title>
</head>
<body>
  <h1>Выберите ваши интересы</h1>
  <form action="" method="post">
    <input type="hidden" name="login" value="<?= htmlspecialchars($login) ?>">
    <label><input type="checkbox" name="interests[]" value="Футбол"> Футбол</label><br>
    <label><input type="checkbox" name="interests[]" value="Путешествия"> Путешествия</label><br>
    <button type="submit">Сохранить интересы</button>
  </form>
</body>
</html>
