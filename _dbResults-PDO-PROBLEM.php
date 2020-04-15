<?php DECLARE(STRICT_TYPES=1);
 
 define('SHOW_SQL', TRUE);

  require 'incs/Class-pw.php';
    $pw = new Class_pw;

//==========================================================
//
//          Display Search Results
//
//==========================================================
  $search   = isset($_GET['q']) ? $_GET['q'] : '';
  $aParams  = getParams($search);
  $sql      = getSqlPdo($aParams);

  try
  {
    # $result   = $CONN->prepare($sql);
    $result   = $pw->pdo->prepare($sql);
    $aParamsX = [];
      foreach($aParams as $param):
        $aParamsX[] = '%' .$param .'%';
      endforeach;

    $result->execute($aParamsX);
    $rowTot = $result->rowCount();

    echo '<b class="fs2 fgy">Total: ' .$rowTot .'</b>'; 
    if(12 <= $rowTot):
      echo '<i style="float:right; color:green;">but only showing the first dozen</i>';
      $sqlXXX = $sql .' LIMIT 0,42;';
     #$result = CONN->prepare($sqlXXX);
      $result = $pw->pdo->prepare($sqlXXX);
      $result->execute($aParamsX);
    endif;
    
    # echo '<h1>' .$_SESSION['id'] .'</h1>';

    foreach($result as $row):
      $nl2br = nl2br($row['text']);
      echo $tmp = <<< ____EOT
        <div class="tal">
          <dl class="bgs fg3 tal">
            <dt class="bd1">
              {$row['url']}
              <i class="flr">{$row['touch']} </i>
            </dt>
            <dd class="clb"> $nl2br </dd>
          </dl>
          <br>
        </div>  
____EOT;
    endforeach;          
        // $db = null; // Unnecessary
  }catch (PDOException $e){
      print "Error!: " . $e->getMessage() . "<br/>";
      die();
  }



//=================================
//
//  Validate and clean input text
//    
//=================================
function getParams
(
  $params=NULL
)
:array
{
  $aResult = NULL;
  while (strpos($params, '  ') ) :
echo jj, 'once ==> "', $params; echo '"';
    $params = str_replace('  ',  ' ', $params);
echo jj, 'once ==> "', $params; echo '"';
  endwhile; 

echo jj, 'once ==> "'; print_r($params); echo '"';
  $aResult = explode(' ', $params);
echo jj, 'once ==> "'; print_r($params); echo '"';

  if( 1 || empty($result) ):
    $aResult[] = $params;
  endif;

  return $aResult;
}//


//=================================
//
// dynamic build SQL statement
//
//=================================
function getSqlPdo($aParams=NULL)
:string
{
  $ref = $_SESSION['id'];

  $sql = <<< ____EOT
    SELECT 
      `ref`, `id`, `url`, `text`, `touch` 
    FROM 
      `password` 
    WHERE 
      `ref` = $ref
    AND  
      concat(`url`, `text`) 
____EOT;

  foreach($aParams as $i2 => $param):
    if($i2==0):
      $sql = $sql .' LIKE ? ';
    else:  
      $sql = $sql .' AND concat(url,text) LIKE ? ';
    endif;  
  endforeach;  

  if(SHOW_SQL):
    echo '<pre class="tal">';
      print_r($aParams);
      print_r($_GET);
      echo $sql;
    echo '</pre>';  
  endif;  
  return $sql;
}//