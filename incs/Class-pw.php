<?php DECLARE(STRICT_TYPES=1);

define('jj', "<br>\n");
# require 'Class-login.php';


# ==================================================
Class Class_pw # extends Class_login
{
public $con  = NULL;
public $pdo  = NULL;
public $out  = TRUE;
public $LGO  = [];


// =================================================
private function elapsed
(
  object $row
)
: string 
{
  $result = date('l, jS F Y - H:i:s - e P ', strtotime($row->touch));

  $result = time() - strtotime($row->touch);

  # $result = $result . ' ==> ' .date('H:i', $result) .' hours ';
  $result = date('H:i', $result) .' hours';

  return (string) $result . ' ago';
}


# ==================================================
public function updateGuid()
:bool
{ 
  $result  = FALSE;

  $cnt = 1;
  while ($cnt) :
    $GUID   = $this->guidv4();

    $sql = <<< ____EOT
      UPDATE `password` SET `guid`="$GUID" WHERE `guid`=""  
      ORDER BY `guid` ASC LIMIT 1  
  ____EOT;  
    $qry = $this->getPdoObject($sql);

    $sql = <<< ____EOT
      SELECT count(*) AS `count` FROM `password` WHERE `guid`=""
  ____EOT;
    $qry = $this->getPdoObject($sql);
    $qry = $qry->fetchObject();
    $cnt = $qry->count;
  endwhile;  

  return $result;
}//

# ==================================================
Public function getPdoObject( string $sql, $lShow=FALSE)
:object
{
  $result = (object) -1;

  echo $lShow ? '$sql => <br>' .$sql : NULL;

  try{
    $qry = $this->pdo->prepare($sql);
    $qry->execute();
    $arr = $qry->errorInfo();

    $result = $qry;
# echo '<br>SUCCESS ==> '.__line__;
  } catch (Exception $e) {
    if(LOCALHOST) :
echo '<br>'.__line__;
    echo "<br>PDOStatement::errorInfo():<br>";
echo '<br>'.__line__;
    fred($qrr, '$qrr');
echo '<br>'.__line__;
    fred($e, '$e ==> ERRORS ' .__line__);
echo '<br>'.__line__;
    endif;
    die('WHOOPS WE HAVE ERRORS - CONTINUING IS FRUITLESS');
echo '<br>'.__line__;
  }  

  return $result;  
}  


# ==================================================
public function test_pword($pWord='THIS IS A TEST TO SEE IF IT WORKS')
:bool
{
  $result = FALSE;
  echo $this->guidv4();

  return $result;
}

//==================================================
public function insertRecord()
:object
{
  $result = (object) -999;

  $empty = empty($_POST['url']) || empty($_POST['text']) ;
  if(isset($_POST['url'], $_POST['text']) && ! $empty):
      $sql  = "INSERT INTO `password` (`ref`, `url`, `text`) VALUES (?,?,?)";
      try {
        $qry   = $this->pdo->prepare($sql);
        $result = $qry->execute( [ $_SESSION['id'], $_POST['url'], $_POST['text'] ] );

        $sql = <<< ____EOT
          SELECT
              *
          FROM
              `password`
          WHERE
              `ref` = "{$_SESSION['id']}"
          ORDER BY 
              `touch` DESC
          LIMIT 
              0,1            
____EOT;        
        $qry    = $this->pdo->prepare($sql);
        $result = $qry->execute( [ $_SESSION['id'], $_POST['url'], $_POST['text'] ] );
        $result = $qry->fetchObject();
        $this->updateGuid();
      }catch (PDOException $e) {
        if ($e->getCode() == 1062) {
          // Take some action if there is a key constraint violation, i.e. duplicate name
        } else {
          throw $e;
        }
      }
  else:  
    # 
  endif;    

  return $result;
}


//==================================================
public function deleteRec
(
  string $deleteRec = "-1"
)
:bool
{
  $result = FALSE;

  $sql = <<< ____EOT
    DELETE FROM
      `password`
    WHERE
      `id`= "{$deleteRec}" 
____EOT;
  $result = $this->pdo->query($sql);

  return (bool) $result;
}

//==================================================
public function saveRec
(
  string $id
)
:bool
{
  $result = FALSE;
fred($_POST, __method__);  
fred($id, '$_POST');
  $url = htmlspecialchars($_POST['url' .$id ]);
  $txt = htmlspecialchars($_POST['text' .$id]);
  $sql = <<< ____EOT
    UPDATE `password`
    SET
      `url`   = "$url", 
      `text`  = "$txt"
    WHERE  
      `id` = "$id"         
____EOT;
  $result = $this->pdo->query($sql);

  return (bool) $result;
}

//==================================================
public function getRec
(
  string $id = ''
)
:array
{
  $aResult = [];

  $sql = <<< ____EOT
    SELECT *
    FROM   `password`
    WHERE  `id`= $id 
____EOT;
  $qry = $this->pdo->query($sql);
  $aResult = $qry->fetch(); 

  return $aResult;
}

//==================================================
public function getEmail
(
  string $email = 'jack@bing.com'
)
:int
{
  $result = FALSE;

  $sql = <<< ____EOT
    SELECT *
    FROM   `accounts`
    WHERE  `email`= "$email" 
____EOT;
  $qry   = $this->pdo->query($sql);
  $result = $qry->fetch(); 
  $result = $result['id']; // STRING

  return (int) $result; 
}

## ========================================
# Render search results to screen
## ========================================== 
public function render
(
  object $row,
  string $tog,
  string $editorUniique = ' '
)
:string
{
  $result = '';

  $nl2br = nl2br($row->text);
  $touch = $this->elapsed($row);
 #$touch = $row->touch .date(' - e P ', strtotime($row->touch));
  $URL   = $_SESSION['BASE_URL'];
  $HHH   = strpos($_SERVER['REQUEST_URI'], 'share') ? 'hhh' : '';
  $ROWS  = empty($HHH) ? "4" : "22";

  $result = <<< ____TMP
    <div class="$tog p42 fss tal p42 bd0 bdr"> 
      <div class="w96">
        <label class="w99"> 
          Title:  
          <i class="flr">#{$row->id} </i> 
        </label>
        <br>

        <input
          type  = "text"
          name  = "url{$row->id}"
          class = "fsn"
          value = "{$row->url}"
        >
        <br>

        <label> Notes: </label> <br>
        <!--
          name  = "text{$row->id}"
        -->  
        <textarea
          rows  = "{$ROWS}"
          name  = "editor"
          id    = "$editorUniique" 
          class = "fsn w88 "
        >{$row->text}</textarea>
      </div>  

      <div class="$HHH hhh w96">
        <label> Share: </label> 

        <input 
          readonly
          class = "hhh fwb" 
          type  = "text" 
          name  = "shareLinx" 
          value = "{$URL}share/{$row->guid}"
        >
        <a target="_blank" href="{$URL}share/{$row->guid}">
          {$URL}share/{$row->guid}
        </a>  
      </div>  

      <div class="fss tal"> 
        <i> Saved: </i> <b> {$touch} </b>
      </div>  

      <div class="$HHH tac XXXp42">
        <input 
          class = "fsl fwb fgr bdr" 
          type  = "submit" 
          name  = "deleteRec{$row->id}" 
          value = "delete"
        >
         &nbsp; &nbsp; &nbsp; &nbsp; 
        <input 
          class = "fsl fwb bgc bdr" 
          type  = "submit" 
          name  = "saveRec{$row->id}" 
          value = "save"
        >

        <a class="bdr flr fss bgl btn tdn" target="_blank" href="{$URL}share/{$row->guid}">
          Share
        </a>  

      </div>  
    </div>  
    <p> &nbsp; </p>
____TMP;

  return $result;
}//endfunc render()


//==================================================
public function fnLastFive()
:string
{
  $aResult = '';

  $sql = <<< ____EOT
    SELECT `id`, `url`, `touch`, `text`, `guid`
    FROM `password`
    WHERE `ref` = "{$_SESSION['id']}"
    # AND
    # CONCAT
    # ( `id`, `url`, `touch`, `text` )
    # LIKE '%a%' ORDER BY `touch` DESC
    ORDER BY `touch` DESC
    LIMIT 0, 5
____EOT;
  $qry = $this->pdo->query($sql);
  $i2  = 0;
  while($result = $qry->fetchObject() ):
    $editorUniique = $i2 ? 'editor' .$result->id : 'editor';
    if($i2):
      // 
    else:
      fred($result);  
    endif;  

    # $tog = $i2++ % 2 ? 'bgd' : 'bga' ;
    $tog = $i2++ % 2 ? 'bgd' : 'bge' ;
    $aResult .= $this->render($result, $tog, $editorUniique);
  endwhile;  

  return $aResult;
}// endunc

//==================================================
public function recTotals
(
  int $id = -1
)
:string 
{
  # $id = $_SESSION['id'];
# fred($_SESSION, __method__);
  $result = 'OH HELL: ' . $id;

  $sql = <<< ____EOT
    SELECT  COUNT(*) AS `totalRex`
    FROM   `password`
    WHERE  `ref`= "$id" 
____EOT;
  $qry = $this->pdo->query($sql);
  $result = $qry->fetch()['totalRex'];

  return $result;
}

//==================================================
public function getUsers()
: string
{
  $sql= 
    "
    SELECT `id`, `username`,  `email` 
    FROM   `accounts`
    ORDER BY `id` ASC
    ";

  $qry = $this->pdo->query($sql);

  $result = '<table class="w88 mga  tal ls2 p42">'
          . '<tr><th> id </th><th> Name </th><th> eMail </th></tr>';
    while ($row = $qry->fetch()) :

    if(0):  
      /*
      $RECORDS = $row['id'];
      $sql = "
        SELECT DISTINCT `id` 
        FROM   `password` 
        WHERE  `ref` = $RECORDS ";

        $qry = $this->pdo->prepare($sql);
        $qry->execute();
      # echo jj, '$count ==> ', 
        $count = $qry->rowCount();
      */  
    endif;
    $count = 'count';  

    $result .= <<< ____EOT
      <tr>
        <td> {$row['id']} </td>
        <td> {$row['username']} </td>
        <td> {$row['email']} </td>
      </tr>
____EOT;
# <td class="hhh"> $count Recs </td>
    endwhile;
  $result .= '</table>';

  return $result;
}//

//===========================================================
private function getHash($pWord)
:string 
{
  $result = '';

  if(0):  
    $result = password_hash($pWord, PASSWORD_DEFAULT) ?? NULL;    
  else:  
    $result = password_hash($pWord, PASSWORD_DEFAULT) ?? NULL;    
  endif;
  
  return $result;  
}


//==================================================
public function fnAddUser()
:bool
{
  $result   = isset($_POST['username']);
  $result   = $result  && isset($_POST['password']);
  
  $username = $_POST['username'] ?? NULL;
  $pass1    = $_POST['password'];
  $email    = $_POST['email'] ?? NULL;

  if($email && $this->getEmail($email) ):
    return FALSE;
  endif;  

  $password = $this->getHash($_POST['password']);
#  $password = password_hash($pass1, PASSWORD_BCRYPT)  ?? NULL;
#  $password = password_hash($pass1, PASSWORD_BCRYPT, ['cost' => 12]) ?? NULL;

# CHECK USERNAME ALREADY EXISTS
  $sql = <<< ____EOT
    SELECT `username`
    FROM   `accounts`
    WHERE  `username` = ?
____EOT;
  $qry = $this->pdo->prepare($sql); 
  $qry->execute([$_POST['username']]); 
  $tmp  = $qry->fetch();
  if($tmp):
    $result = FALSE;
  endif;

# CHECK EAILE ALREADY EXISTS
  if($result) :
    $sql = <<< ____EOT
      SELECT `email`
      FROM   `accounts`
      WHERE  `email` = ?
____EOT;
    $qry = $this->pdo->prepare($sql); 
    $qry->execute([$_POST['email']]); 
    $tmp  = $qry->fetch();
    if($tmp):
      $result = FALSE;
    endif;
  endif;
  $result = $_POST['password'] === $_POST['password2'];

# TRY INSERTING
  if($result):
    if(0):
      $sql = <<< ____EOT
        INSERT INTO `accounts`
        (
          `username`, `password`, `email`
        )
        VALUES( '$username', '$password', '$email' );
____EOT;
      endif;
    $sql = "
      INSERT INTO `accounts` 
        (`username`, `password`, `email`) 
      VALUES (?,?,?)
      ";
      $qry= $this->pdo->prepare($sql);
      $qry->execute([$username, $password, $email]);      

      $_SESSION['username'] = $_POST['username']; 
      $_SESSION['password'] = $_POST['password']; 
      $_SESSION['email']    = $_POST['email'];
  endif;

  return $result; // 
}//

//==================================================
public function groupRefs()
: string
{
# $sql  = "SELECT ref, count(*) AS TOTAL FROM password group by ref";
  $sql  = <<< ____EOT
      SELECT
          ref,
          username,
          email,
          COUNT(*) AS TOTAL
      FROM
          password,
          accounts
      where ref=accounts.id    
      GROUP BY
          ref
____EOT;

  $qry = $this->pdo->query($sql);
 #$result = '<table class="dib tal">';

  $result   = '<dl class="dib mga bd1">';
  $result  .= '<dt class="tal fwb fsl bgc"> Total records: </dt>';

  $result  .= '<dd><table class="tal groupby">'
            . '<tr><th> id </th><th> User </th><th> email </th><th> Total </th> </tr>'
            ;
  while ($row = $qry->fetch()) :
    # fred($row['ref'], $row['TOTAL']);
    $result .= <<< ____EOT
      <tr>
        <td> {$row['ref']}      </td>
        <td> {$row['username']} </td>
        <td> {$row['email']} </td>
        <td> {$row['TOTAL']}    </td>
      </tr>
____EOT;
    endwhile;
  $result .= '</table></dd></dl>';

  return $result;
}//


//==================================================
public function fnLogin()
:bool
{
  $result = isset($_POST['username'], $_POST['password'])  ;
  if($result) :
    $sql  = <<< ____EOT
      SELECT 
        `id`, `username`, `password`, `email` 
      FROM  
        `accounts` 
      WHERE 
        `username` = "{$_POST['username']}"
  ____EOT;
  # fred($sql);
  # QUERY and RESULTS  
    $qry   = $this->pdo->query($sql);
    $qry   = $qry->fetchObject(); // ['password'];
  # fred(__line__, __line__);

    $result = FALSE;
    if( $qry ) :  
      $id     = $qry->id; 
      $pWord  = $_POST['password'];
      $hash   = $qry->password;
      $result = password_verify($pWord, $hash);
      if($result):
        $_SESSION['id']       = $qry->id;
        $_SESSION['name']     = $qry->username;
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['loggedin'] = $result;
      endif;
    endif;
  endif; // ($result) :

  return $result;
}// endfunc fnLogin()


//==================================================
public function __construct
(
  string $name='No Name'
) # NO RETURN TYPE ALLOWED - :object
{
  define('LOCALHOST', 'localhost'===$_SERVER['SERVER_NAME']);

# GET LOGIN DETAILS
  $tmp = strstr(__DIR__, 'public_html/', TRUE); 
  define('ABR', $tmp);
  $login = '/var/www/ASSETS/pwords/password-login.php';
  if( file_exists($login) ) :
    require $login;
  else:  
    if(LOCALHOST) :  
      define('uHOST',   'uHOST-GOES-HERE');
      define('uNAME',   'uNAME-GOES-HERE'); # 
      define('pWORD',   'pWORD-GOES-HERE');  
      define('dBASE',   'dBASE-GOES-HERE'); 
      define('dTABLE',  'dTABLE-GOES-HERE'); 
    else:
      define('uHOST',   'uHOST-GOES-HERE');
      define('uNAME',   'uNAME-GOES-HERE'); # 
      define('pWORD',   'pWORD-GOES-HERE');  
      define('dBASE',   'dBASE-GOES-HERE'); 
      define('dTABLE',  'dTABLE-GOES-HERE'); 
    endif;  
  endif;  

# MYSQLI - Try and connect using the info above.
# echo uHOST, '  ', uNAME, '  ', pWORD, '  ', dBASE; ;  
  try {  
    $this->con = mysqli_connect(uHOST, uNAME, pWORD, dBASE);
    if ( mysqli_connect_errno() ) :
      echo ('<br>MySqli connected Failed: ' . mysqli_connect_error());
      EXIT;
    endif;
  }
  catch(Exception $e)
  {
    echo("CANNOT CONNECT TO DATABASE:  " . $e->getMessage() );
    EXIT;
  }

# PDO  
  try {
    $this->pdo = new PDO
    (
      'mysql:host=' .uHOST .';dbname=' .dBASE,
      uNAME, 
      pWORD
    );
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    # echo "Connected successfully";
    # fred($this->pdo, '$this->pdo');  
  }
  catch(PDOException $e)
  {
    echo("PDO Connection failed: " . $e->getMessage() );
  }

  $this->name = $name;
}//


//========================================================================
private function guidv4()
{
    if (function_exists('com_create_guid') === true)
        return trim(com_create_guid(), '{}');

    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

}# endClass JB =====================================



