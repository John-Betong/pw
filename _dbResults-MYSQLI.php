<?php
  declare(strict_types=1);
  error_reporting(-1);
  ini_set('display_errors', '1');

  session_start();
  
  require 'incs/Class-pw.php';
  $pw = new Class_pw;

  $recTotals = $pw->recTotals( (int) $_GET['id'] );

  define('SHOWSQL',  FALSE);
  define('LIMIT', '99');

//==========================================================
//   Display Search Results
//==========================================================
  $search  = $_GET['q'] ?? '';
  if( empty($search) ):
    #
  else:
    $data = fnData($pw, $search, $recTotals, $LIMIT=LIMIT);
  endif;


# ========== ONLY FUNCTION BELOW ========================

/* =================================
#  Validate and clean input text
================================== */
function getParams
(
  string $params = NULL
)
:array
{
  $result = NULL;

# REMOVE DOUBLE SPACES
  while (strpos($params, '  ') ) {
    $params = str_replace('  ',  ' ', $params);
  }

# CONVERT TO ARRAY
  $result = explode(' ', $params);
  if( empty($result) ):
    $result[] = $params;
  endif;

  return $result;
}//endFunc getParams()


/* ============================================
#  Parse Uset's input input into a string
============================================== */
function getSqlWhere
(
  array  $aParams = [], 
  string $cols    = ''
)
:string
{
  $result = '';

  foreach($aParams as $i2 => $param):
    if($i2 > 0):
      $result .= ' AND ';
    endif;
    $result .= "
               CONCAT($cols) 
               LIKE '%$param%'
              ";
  endforeach;

  return $result;
}//endfuncgetSqlWhere(...)


/* ===========================================
# Conbine two SQL Statements - ORDER IMPORTANT
=========================================== */
function getCombinedCount
(
  string $table   = '', 
  string $sWhere  = '', 
  string $cols    = ''
)
:string
{
  $result = <<< ____TMP
    SELECT COUNT(*) AS `recNo` 
    FROM  `$table` 
    WHERE  $sWhere 
    ;
____TMP;

  return $result;
}//endfunc getCombinedCount(...)


/* ===========================================
# Conbine two SQL Statements - ORDER IMPORTANT
=========================================== */
function getCombinedRows
(
  string $table   = '', 
  string $sWhere  = '', 
  string $cols    = '',
  string $LIMIT   = '3'
)
:string
{
  $result = '';

  $result = <<< ____TMP
    SELECT $cols  
    FROM   `$table`  
    WHERE  $sWhere  
    ORDER BY `touch` 
    DESC
    LIMIT  0, $LIMIT
____TMP;

  return $result;
}

## ========================================
# Render search results to screen
## ========================================== 
function render($row, $tog)
:string
{
  $INFO = <<< ____EOT
    Array
    (
        [0] => id 
        [0] => url
        [1] => touch 
        [2] => text
    )
____EOT;

  $nl2br = nl2br($row->text);
  $touch = date('l, jS F Y - H:i:s - e P ', strtotime($row->touch));
  $touch = $row->touch .date(' - e P ', strtotime($row->touch));
  $id   = $row->id;   

  $book = <<< ____TMP
    <form class="$tog bdr bd1" action="search" method="post">
      <fieldset class="p42 fss tal p42"> 
        <legend>
          <i class="hhh"> $id </i>
          <b class="fll"> Title: </b>
          <input
            type  = "text"
            name  = "url"
            class = "fsn"
            value = "{$row->url}"
          >
        </legend>
        <input type="hidden" name="id" value="{$row->id}"> 
        <!-- br><br -->

        <label class="fll fwb"> Notes: </label> 
        <textarea
          rows  = "12"
          name  = "text"
          class = "fsn w88 "
        >{$row->text}</textarea>
        <br class="clb"><br>

        <label class="fll fwb"> Saved: </label>
        <div class="clb fss"> 
          <i> {$touch} </i>
        <div>  
        <!-- br class="clb" -->

        <input class="clb flr fsl bge fwb" type="submit" name="saveSingle" value="save">

      </fieldset>  
    </form>
      <p> &nbsp; </p>
____TMP;


  return $book;
}//endfunc render()

//================================
function showSql(
  string $sql = ''
)
:string
{
  $result = '';

  $from = [
    'SELECT', 
    'FROM', 
    'WHERE', 
    'LIKE', 
    'AND', 
    'CONCAT(', 
    'LIMIT', 
  ];
  $to   = [
    '<b>SELECT </b> ', 
    '<br><b>FROM </b> ', 
    '<br><b>WHERE </b> ', 
    '<br><b>LIKE </b>', 
    '<br><b>AND </b>', 
    '<br><b>CONCAT<br>(</b> ', 
    '<br><b>LIMIT </b>', 
  ];
  $str  = str_replace($from, $to, $sql);

  $result = ''
        .'<dl class="bgy fg0 fss tal">'
        .   '<dt class="ooo">SQL:</dt>'
        .   '<dd>' .$str .'</dd>'
        .   '<dd>&nbsp;</dd>'
        .'</dl>';

  return $result;
  }


//=======================================================
function fnData
(
  object $pw, 
  string $search    = '',
  string $recTotals = '',
  string $LIMIT     = '4'
)
:string 
{
  $result = 'DATA';

  $cols    = ' `id`, `url`, `touch`, `text`, `guid` ';  
  $aParams = getParams($search);

# GET/BUILD QUERY
  $where   = getSqlWhere($aParams, $cols);
# $where   = ' `ref`=' .$_SESSION['id'] .' AND ' .$where;
  $where   = ' `ref`="' .$_GET['id'] .'" AND ' .$where;
  $sqlCnt  = getCombinedCount(dTABLE, $where, $cols);
  $sqlRows = getCombinedRows( dTABLE, $where, $cols, $LIMIT); // , LIMITRECS);

  # GET RECORDS

  $link = new mysqli(uHOST, uNAME, pWORD, dBASE);

  if(SHOWSQL): 
    echo showSql($sqlCnt); 
  endif;

  $resultCnt = mysqli_query($link, $sqlCnt);
  $recNo     = $resultCnt->fetch_object();      
  $recNo     = $recNo -> recNo;
  
  if(SHOWSQL): 
    echo showSql($sqlRows); 
  endif;

  $resultRows = mysqli_query($link, $sqlRows);

# $row  = 0;
  $lines = '';
  $i2    = 1;
  while($row = $resultRows->fetch_object()) :
    $tog  = ++$i2 % 2 ? 'bge' : 'bga';
    $lines .= $pw->render($row, $tog);
  endwhile; 

  # RENDER RESULTS
    echo '<h3 class="fgb tal">'
        .   'Found: <b>'
        .   number_format((float)$recNo)
        . '/'
        . $recTotals
        .   '</b>'
        .'</h3>'
        . $lines
        ;

  return $result;        
}// endif fnData()        

/*================================
# Debug Display:
#   usage:
#      fred( $anyValue );
//================================*/
function fred($val, $varDump=NULL)
:string
{
  echo '<pre class="w88 mga bgs fg3 p42">';
    echo '<br>';
    if($varDump):
      var_dump($val);
    else:
      print_r($val);
    endif;
    echo '<br><br>';
  echo '</pre>';
  echo '<div>&nbsp;</div>';

  return '';
}// endfunc fred
