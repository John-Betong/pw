<?php DECLARE(STRICT_TYPES=1);
error_reporting(-1);
ini_set('display_errors','1');
ini_set('error_log', 'ERROR_LOG.php');
touch('ERROR_LOG.php');

  session_start();

  $BASE_URL = $_SERVER['REQUEST_SCHEME']
            . '://'
            . $_SERVER['SERVER_NAME']
            . strstr($_SERVER['REQUEST_URI'], 'pw', TRUE)
            . 'pw/';
            ;
  define('BASE_URL', $BASE_URL);
  define('FFF', 'FUCK');
  $_SESSION['BASE_URL'] = $BASE_URL;
  define('LOGGED_OUT', 'Logged OUT'); 
  define('VERSION', '04-08-001');

  require 'incs/Class-pw.php';
  $pw = new class_pw;

  $ok = $_SESSION['loggedin'] ?? NULL;
  if($ok) :
    $page = 'search';
  endif;  
  $title  = $title ?? 'DEFAULT Profile Page';

  $page = $_SERVER['QUERY_STRING'] ?? 'home';

# MAYBE SHARE  
  $XROW = substr($page, 6);
  $page = empty($page) ? 'home' : $page;
  if( strpos($page, 'share') ):
    $page = 'share';
    $XROW = substr($_SERVER['QUERY_STRING'], 9);
  else:  
    $page = explode('/', $page) [0];
  endif;  

  switch($page):
    case 'search' :
      $ok = isset($_POST['username']) && isset($_POST['password']);
      if($ok):
        $_SESSION['loggedin'] = $pw->fnLogin();
      endif;  

      $loggedin = $_SESSION['loggedin'] ?? NULL;
      if($loggedin) :
          $add = $_POST['newRecord'] ?? NULL ;
          if($add) :
            $obj = $pw->insertRecord();
            # if(-999===$obj):
              $page = 'new-record';
            # endif;  
            # unset( $_POST['addRecord']);
          else:  
            $flip = array_flip($_POST);

            $save = $flip['save'] ?? NULL;
            if($save) :
              $save = substr($save, 7);
              $ok = $pw->saveRec($save);
            endif;  

            $delete = $flip['delete'] ?? NULL;
            if( $delete ) :
              $delete = substr($delete, 9);
              $ok = $pw->deleteRec($delete);
            endif;  
          endif;  
          // include $page=SEARCH
      else:  
        $page = 'login';
      endif;   
    break;

    case 'register':
      $_SESSION['loggedin'] = FALSE;
    break;

    case 'home': 
    case 'login':
    case 'share':
    case 'edit-rec':
    default;
    break;
  endswitch;  


  $_SESSION['loggedin'] = $_SESSION['loggedin'] ?? FALSE;
  $title    = ucFirst($page) .' Page';
  $_SPACER  = 'search'===$page 
            ? '<br><br>' 
            : '<p class="hg4"> </p>';


  //========================================================
  //========================================================
  //========================================================
    require 'incs/_header-ds.php';

    echo '<div class="tac bg0">';
      require 'pages/' .$page .'.php';
    echo '</div>';  
  //========================================================
  //========================================================
  //========================================================




  # DEBUG
    if(0):
      echo '<div class="bug bgs">';
        fred($_SERVER, '$_SERVER');
        fred($_SESSION, '$_SESSION');
        if( isset($_POST) ):
          fred($_POST, '$_POST');
        endif;  
        fred($_GET, '$_GET');
      echo '</div>';  
      echo '<p> &nbsp; </p>';
    endif;

    require 'incs/_footer.php';
  echo '</body></html>';    


//==================================================
function fred($val='Nothing set', $title='NO TITLE')
{
  # unset($_SESSION['SHOP']);
  echo '<div class="w88 mga z02"><br><pre class="tal bgs p42 bd1">'; 
    echo '<b class="ooo">'. $title .' ==> </b>';
    print_r($val);
  echo '</pre><hr></div>';  
}    

//==================================================
function vd($val='Nothing set', $title='NO TITLE')
{
  # unset($_SESSION['SHOP']);
  echo '<div class="w88 mga bgs"><hr><pre class="tal">'; 
    echo '<b>'.$title .'</b> ==> ';
    var_dump($val);
  echo '</pre><hr></div>';  
}    



/*
1. Upload binary data
2. Share a link to a single read-only entry
3. Make the last 5 items listed show mine (not somebody else's)
4. Name suggestion: Memini - o, s, z, j, etc (eg. Meminio)

*/