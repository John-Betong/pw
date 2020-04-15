<?php DECLARE(STRICT_TYPES=1);

$INFO = <<< ____EOT
  Full texts  id  username  password  email 
____EOT;
  

  $addUser = isset($_GET['adduser']) ? TRUE : FALSE;
  if($addUser):
    $ok = $pw->fnAddUser();
  else: 
    $ok = $pw->fnLogin();
  endif;  

  $id     = $_SESSION['id']     ?? '-99';
  $uName  = $_SESSION['name']   ?? $_POST['username'];
  $eMail  = $_SESSION['email']  ?? $_POST['email'];
  $pWord  = $_SESSION['pWord']  ?? $_POST['password'];
  $pWord  = substr($pWord, 11, 15);

$good = <<< ____EOT
  <h1> Profile </h1>
  <dl class="mga dib bgs bd1 bdr tal">
    <dt class="bge"> 
      Account details: 
    </dt>  
    <dd>
      <table class="dib p42">
        <tr class="hhh">
          <td class="w09">id:</td>
          <td class="w09"> $id </td>
        </tr>
        <tr>
          <td class="w09">Username: </td>
          <td> $uName </td>
        </tr>
        <tr>
          <td class="w09">Password:  </td>
          <td> $pWord </td>
        </tr>
        <tr>
          <td class="w09">Email:</td>
          <td> $eMail </td>
        </tr>
      </table>
    </dd>
  </dl>
____EOT;


if($ok) :
  echo $good;
else:
  $fail = <<< ____EOT
  <h1> Registration Failed  </h1>
  <h3> Email, Username already used or passwords do not match </h3>
____EOT;
  echo $fail;
  echo '<table class="dib bg1">';
    foreach($_POST as $key => $item) :
      echo '<tr>';
        echo '<td class=""w09>' .$key .'</td><td>' .$item .'</td>';
      echo '</tr>';  
    endforeach;
  echo '</table>';  
  # fred(trim($_POST), 'Input details');

  echo '<h3>
    <a href="?register"> 
        Please try again
      </a>
  </h3>';    

endif;