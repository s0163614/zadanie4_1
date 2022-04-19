<?php
// Отправляем браузеру правильную кодировку,
// файл index.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  if (!empty($_COOKIE['save'])) {
    setcookie('save', '', 100000);
    $messages[] = 'Спасибо, результаты сохранены.';
  }
  $errors = array();
  $errors['fio'] = !empty($_COOKIE['fio_error']);
  $errors['mail'] = !empty($_COOKIE['mail_error']);
  $errors['year'] = !empty($_COOKIE['year_error']);
  $errors['sex'] = !empty($_COOKIE['sex_error']);
  $errors['limb'] = !empty($_COOKIE['limb_error']);
  $errors['powers'] = !empty($_COOKIE['powers_error']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);
  $errors['privacy'] = !empty($_COOKIE['privacy_error']);

  if ($errors['fio']) {
    $messages[] = '<div class="error">Заполните имя.</div>';
  }
  if ($errors['mail']) {
    $messages[] = '<div class="error">Заполните или исправьте почту.</div>';
  }
  if ($errors['year']) {
    $messages[] = '<div class="error">Выберите год рождения.</div>';
  }
  if ($errors['sex']) {
    $messages[] = '<div class="error">Выберите пол.</div>';
  }
  if ($errors['limb']) {
    $messages[] = '<div class="error">Выберите сколько у вас конечностей.</div>';
  }
  if ($errors['powers']) {
    $messages[] = '<div class="error">Выберите хотя бы одну суперспособность.</div>';
  }
  if ($errors['privacy']) {
    $messages[] = '<div class="error">Необходимо согласиться с политикой конфиденциальности.</div>';
  }

  $values = array();
  $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
  $values['mail'] = empty($_COOKIE['mail_value']) ? '' : $_COOKIE['mail_value'];
  $values['year'] = empty($_COOKIE['year_value']) ? 0 : $_COOKIE['year_value'];
  $values['sex'] = empty($_COOKIE['sex_value']) ? '' : $_COOKIE['sex_value'];
  $values['limb'] = empty($_COOKIE['limb_value']) ? '' : $_COOKIE['limb_value'];
  $values['immortal'] = empty($_COOKIE['immortal_value']) ? 0 : $_COOKIE['immortal_value'];
  $values['ghost'] = empty($_COOKIE['ghost_value']) ? 0 : $_COOKIE['ghost_value'];
  $values['levitation'] = empty($_COOKIE['levitation_value']) ? 0 : $_COOKIE['levitation_value'];
  $values['bio'] = empty($_COOKIE['bio_value']) ? '' : $_COOKIE['bio_value'];
  $values['privacy'] = empty($_COOKIE['privacy_value']) ? FALSE : $_COOKIE['privacy_value'];

  include('form.php');
}
else{
// Проверяем ошибки.
$errors = FALSE;
//проверка имени
if (empty($_POST['fio'])) {
  setcookie('fio_error', '1', time() + 24 * 60 * 60);
  setcookie('fio_value', '', 100000);
  $errors = TRUE;
}
else {
  setcookie('fio_value', $_POST['fio'], time() + 12*30 * 24 * 60 * 60);
  setcookie('fio_error','',100000);
}
//проверка почты
if (empty($_POST['mail']) or !filter_var($_POST['mail'],FILTER_VALIDATE_EMAIL)) {
  setcookie('mail_error', '1', time() + 24 * 60 * 60);
  setcookie('mail_value', '', 100000);
  $errors = TRUE;
}
else {
  setcookie('mail_value', $_POST['mail'], time() + 12*30 * 24 * 60 * 60);
  setcookie('mail_error','',100000);
}
//проверка года
if ($_POST['year']=='Выбрать') {
  setcookie('year_error', '1', time() + 24 * 60 * 60);
  setcookie('year_value', '', 100000);
  $errors = TRUE;
}
else {
  setcookie('year_value', intval($_POST['year']), time() + 12*30 * 24 * 60 * 60);
  setcookie('year_error','',100000);
}
//проверка пола
if (!isset($_POST['sex'])) {
  setcookie('sex_error', '1', time() + 24 * 60 * 60);
  setcookie('sex_value', '', 100000);
  $errors = TRUE;
}
else {
  setcookie('sex_value', $_POST['sex'], time() + 12*30 * 24 * 60 * 60);
  setcookie('sex_error','',100000);
}
//проверка конечностей
if (!isset($_POST['limb'])) {
  setcookie('limb_error', '1', time() + 24 * 60 * 60);
  setcookie('limb_value', '', 100000);
  $errors = TRUE;
}
else {
  setcookie('limb_value', $_POST['limb'], time() + 12*30 * 24 * 60 * 60);
  setcookie('limb_error','',100000);
}
//проверка суперспособностей
if (!isset($_POST['power'])) {
  setcookie('powers_error', '1', time() + 24 * 60 * 60);
  setcookie('immortal_value', '', 100000);
  setcookie('ghost_value', '', 100000);
  setcookie('levitation_value', '', 100000);
  $errors = TRUE;
}
else {
  $pwrs=$_POST['power'];
  $a=array(
    "immortal_value"=>0,
    "ghost_value"=>0,
    "levitation_value"=>0
  );
  foreach($pwrs as $pwr){
    if($pwr=='бессмертие'){setcookie('immortal_value', 1, time() + 12*30 * 24 * 60 * 60); $a['immortal_value']=1;} 
    if($pwr=='прохождение сквозь стены'){setcookie('ghost_value', 1, time() + 12*30 * 24 * 60 * 60);$a['ghost_value']=1;} 
    if($pwr=='левитация'){setcookie('levitation_value', 1, time() + 12*30 * 24 * 60 * 60);$a['levitation_value']=1;} 
  }
  foreach($a as $c=>$val){
    if($val==0){
      setcookie($c,'',100000);
    }
  }
}
//запись куки для биографии
setcookie('bio_value',$_POST['bio'],time()+ 12*30*24*60*60);
//проверка согласия с политикой конфиденциальности
if(!isset($_POST['priv'])){
  setcookie('privacy_error','1',time()+ 24*60*60);
  setcookie('privacy_value', '', 100000);
  $errors=TRUE;
}
else{
  setcookie('privacy_value',TRUE,time()+ 12*30*24*60*60);
  setcookie('privacy_error','',100000);
}

if ($errors) {
  header('Location: index.php');
  exit();
}
else {
  setcookie('fio_error', '', 100000);
  setcookie('mail_error', '', 100000);
  setcookie('year_error', '', 100000);
  setcookie('sex_error', '', 100000);
  setcookie('limb_error', '', 100000);
  setcookie('powers_error', '', 100000);
  setcookie('bio_error', '', 100000);
  setcookie('privacy_error', '', 100000);
}

// Сохранение в базу данных.

$user = 'u47502';
$pass = '8701243';
$db = new PDO('mysql:host=localhost;dbname=u47502', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

try {
  $stmt = $db->prepare("INSERT INTO application SET name=:name,mail=:mail,date=:date,sex=:sex,limb=:limb,bio=:bio");
  $stmt->bindParam(':name',$_POST['fio']);
  $stmt->bindParam(':mail',$_POST['mail']);
  $stmt->bindParam(':date',$_POST['year']);
  $stmt->bindParam(':sex',$_POST['sex']);
  $stmt->bindParam(':limb',$_POST['limb']);
  $stmt->bindParam(':bio',$_POST['bio']);
  $stmt -> execute();
  $id=$db->lastInsertId();
  $pwr=$db->prepare("INSERT INTO powers SET power=:power,id=:id");
  $pwr->bindParam(':id',$id);
  foreach($_POST['power'] as $power){
    $pwr->bindParam(':power',$power); 
    $pwr->execute();  
  }
}
catch(PDOException $e){
  print('Error : ' . $e->getMessage());
  exit();
}
// Сохраняем куку с признаком успешного сохранения.
setcookie('save', '1');

// Делаем перенаправление.
header('Location: index.php');
}
