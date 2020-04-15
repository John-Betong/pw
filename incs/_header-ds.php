<?php DECLARE(STRICT_TYPES=1);

# https://cutcodedown.com/for_others/john_betong/skyhook/
$tmpUser = $_SESSION['name'] ?? ''; // 'Guest';

$bgL = 'bgr';
$tmp = $_SESSION['loggedin'] ?? FALSE;
if($tmp) :
  $bgL = 'bgn';
endif;

$INFO = <<< ____EOT
  \$fontAwe = 'incs/fa-5.13.0-web/css/all-jb.css';
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
____EOT;

$title = 'QQQ'.getcwd();
$HHH   = 'share'===$page ? 'hhh ' : '';


?><!DOCTYPE html><html lang="en-gb">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1">
<link rel="stylesheet" href="<?= $BASE_URL ?>incs/screen-ds.css"  media="screen">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
  media="screen"
>
<!--
<link rel="stylesheet" href="<?= $BASE_URL ?>incs/jodit/build/jodit.min.css"/>
<script src="<?= $BASE_URL ?>incs/jodit/build/jodit.min.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<link rel="stylesheet" href="<?= $BASE_URL ?>incs/jodit/build/jodit.min.css"/>
<script src="<?= $BASE_URL ?>incs/jodit/build/jodit.min.js"></script>

-->  
<link rel="stylesheet" href="http://localhost/ci2/vendor/jodit/build/jodit.min.css"/>
<script src="http://localhost/ci2/vendor/jodit/build/jodit.min.js"></script>


<title> <?= $page ?> Page </title>
</head>
<body>

<header id="top" class=" <?= $bgL ?>">
  <h1> <?= ucFirst($page) ?> Page </h1>

  <div class="userBar">
    <i class="fll fgs fss"> User: </i> &nbsp; <b><?= $tmpUser ?> </b> 
  </div><!-- .userbar -->

  <ul id="mainMenu" class="<?= $HHH ?>">

    <li class="home" >
      <a href="<?= $BASE_URL ?>home"> Home </a>
    </li>

    <?php if(1 || $_SESSION['loggedin']): ?>
      <li class="login" >
        <a href="<?= $BASE_URL ?>login"> Log In </a>
      </li>
    <?php else: ?>  
      <li class="login" >
        <a href="<?= $BASE_URL ?>logout"> Log In </a>
      </li>
    <?php endif; ?>

    <li class="register">
      <a href="<?= $BASE_URL ?>register">  Register </a>
    </li>

    <li class="search">
      <a href="<?= $BASE_URL ?>search">Search</a>
    </li>

    <?php if(0 && LOCALHOST) : ?>
      <li class="todo">
        <a href="<?= $BASE_URL ?>todo">Todo</a>
      </li>
    <?php endif; ?>
  </ul>

  <div class="backToTop" >
    <a href="#top">
      <span> Back To Top </span>
      <i class="fas fa-arrow-circle-up fa-2x">&nbsp;</i>
    </a>
  </div>
</header>  <!-- #top -->
  <div class="tar fss">ver: <?= VERSION ?> </div>

  <h4 class="hhh clb ooo tac">
    <?= $meminero ?>
  </h4>  

<?php 
 # fred($_SERVER);
/*
  <div class="hhh fileLink">
    <a href="https://codeshack.io/secure-login-system-php-mysql/">Source</a>
  </div><!-- .fileLink -->
*/  

