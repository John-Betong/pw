<?php DECLARE(STRICT_TYPES=1);

$aUsers   = ''; // $pw->getUsers();
$aGroups  = $pw->groupRefs();
 
$ref = 1;
# echo jj, 
$id = $XROW;;
# fred('SHIT'); ;die;

$INFO = <<< ____EOT
NO TITLE ==> Array
(
    [search] => 
    [id] => 23
    [url] => https://DuckDuckGo.com
    [text] => https://DuckDuckGo.com
https://DuckDuckGo.com

https://DuckDuckGo.com
    [shareLinx] => share
)
____EOT;

$sql = <<< ____EOT
    SELECT 
      `id`, `url`, `touch`, `text`, `guid`
    FROM   
      `password`
    WHERE 
     `guid` = "{$XROW}"
____EOT;


  $qry    = $pw->pdo->query($sql);
  $result = $qry->fetchObject();

  if($result) :
    $result = $pw->render($result, 'bga');
  else:
    $result = '<h2> Whoops - unable to find: the share page:</h2>'  
            . '<h3>' .$XROW .'</h3>';
  endif;  

?>

<div class="w88 mga tac">
  <?php print_r($result);?>
</div>

