<?php DECLARE(STRICT_TYPES=1);

# LOGGED IN ???
  if($_SESSION['loggedin']):
    //
  else:  
    header('Location: login');
    exit;
  endif ;

# THREE CASES
  $mode = NULL;

  if( isset($_POST['add'] ) ) :
    $mode     = 'add';
    $lastFive = '';
  else:
    $lastFive = '<h3 class="tal bgy"> Last five items </h2>' //
              . '<br>';

    foreach($pw->fnLastFive() as $id => $item) :
      $lastFive .= $item;  
    endforeach;      
  endif;  

  $textarea = '';
  $MODE = 'DEFAULT';
  switch($mode) :
# ADD 
    case 'add':
      $MODE = <<< ____EOT
          <main><section class="dib">       
          <h2> New record </h2> 
          <dl><dt>
            <label>URL: </label>
            <input
              type  = "text"
              size  = "42"
              name  = "url"
              class = "fsn"
              value = ""
            >
            </dt>
          <dd>
            <textarea
              rows  = "12"
              cols  = "42"
              name  = "text"
              class = "fsn"
            ></textarea>
          </dd>
          <dt class="flr">
            <input type="submit" name="addRecord" value="save">
          </dt>
          <dd> <br> </dd>  
        </dl>  
        </main></section>
____EOT;
    break;

  default: 
      $recTotals = $pw->recTotals( (int) $_SESSION['id']);

      $MODE = <<< ____EOT
          <main><section class="dib">       
          <h2> Search &amp; Add New Record </h2> 
            <label class="fll fsl"> Search: </label>
            <input
              id    = "bufferedInput"
              type  = "text"
              name  = "search"
              class = "fll dib w55"
              value = ""
            />
            <span class="flr"> &nbsp;&nbsp;&nbsp; </span>
            <input
              class="flr bgc XXXbdr"
              type="submit" 
              name="add" 
              value="Add"
            >  
            <br class="clb"><br>

          </main></section>       
____EOT;

  endswitch;  

  
# BEGIN RENDER SCREEN ==============================================
  if(0):
  $lastFive = '<h3 class="tal bgy"> Last five items </h2>' //
            . '<br>';

  foreach($pw->fnLastFive() as $id => $item) :
    $lastFive .= $item;  
  endforeach;  
  endif;

  $tmp =  <<< ____EOT
    <div>
      <pre class="fsl lh2 fwb">
        TINYMCE, 
        FCKEDITOR, 
        NICEDIT, 
        BXE, 
        MARKITUP, 
        CKEDITOR
      </pre>
      \$MODE
    </div>

    <div id="livesearch" class="w88 mga">
      <form action="search" method="post">
        $lastFive   
      </form>  
    </div>  

____EOT;
  echo $tmp;

  require 'incs/_java-MYSQLI.js';
  
  $sql   = NULL;
  # $_POST = NULL;
  # unset($_POST);
  # $_GET =[];


/*
      <div class="hhh mga tac bd1 dib bgs p42 bdr">
        <h4 class="tal p42"> Search examples: </h4>

        <dl><dt class="oo1"> &nbsp; </dt>
        <dd>
          <table class="p02 mga dib tal">
            <tr class="XXXfwb bgc">
              <th> value </th> 
              <th> search results </th>
            </tr><tr>  
              <td> com </td> 
              <td> records containing "com"  </td>
            </tr><tr>  
              <td> 2020- </td>
              <td> records saved for "2020-" </td>
            </tr><tr>  
              <td> 2020-03- </td>
              <td> records saved for 2020, March  </td>
            </tr><tr>  
              <td> 2020-03-29 </td>
              <td> records saved for 29<sup>th</sup> March 2020 </td>
            </tr>
          </table>
        </dd>
        </dl>
      </div>  
      <br class="clb">
      <strong class="hhh"> ¯¯\_(ツ)_/¯¯ </strong>
*/