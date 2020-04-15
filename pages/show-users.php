<?php DECLARE(STRICT_TYPES=1);

$aUsers   = ''; // $pw->getUsers();
$aGroups  = $pw->groupRefs();
 
?>
<h1> Show Users </h1>

<div class="tac ">
    <p class="dib tal"> <?= $aUsers ?> </p>
    <?php print_r($aGroups);?>
</div>

