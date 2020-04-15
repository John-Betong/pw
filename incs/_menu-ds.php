<?php DECLARE(STRICT_TYPES=1);

$bgL = 'bgr';

# if( isset($_SESSION['loggedin']) && $_SESSION['loggedin']) :
$tmp = $_SESSION['loggedin'] ?? FALSE;
if($tmp) :
  $bgL = 'bgn';
endif;
$errors    = strlen(file_get_contents('ERROR_LOG.php')); 
$tmpName   = $_SESSION['name'] ?? '';


?>
 <div class="<?= $bgL ?> navtop fga tac tac fgs z02 tdn">
    <?php  # echo  $showUsers ?>
    <h1> <?= $title ?> </h1>
    <br>

    <a href="?home"> Home </a>
    &nbsp;&nbsp;&nbsp;&nbsp;
    
   <?php if( isset($_SESSION['loggedin']) && $_SESSION['loggedin'] ): ?>
      <a href="?logout"> Logout </a>
    <?php else: ?>
      <a href="?login"> Login </a>
    <?php endif; ?>
    &nbsp;&nbsp;&nbsp;&nbsp;

    <a href="?register"> Register </a>
    &nbsp;&nbsp;&nbsp;&nbsp;

    <a href="?search"> Search </a>

    <a class="hhh flr" href="https://codeshack.io/secure-login-system-php-mysql/"> 
      Source &nbsp;
    </a> 

    <i class="hhh fll fgr"> $page: <?=$page ?> </i>
  </div>  

  <p> <br><br><br><br><br><br> </p>