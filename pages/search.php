<?php DECLARE(STRICT_TYPES=1);

# THREE CASES
  $mode = NULL;

  if( isset($_POST['newRecord'] ) ) :
    $mode     = 'newRecord';
    $lastFive = '';
  else:
    $lastFive = '<h3 class="tal fgb">'
              .   'Last five items from: ' 
              .     $_SESSION['name']              
              . '</h3>' //
              ;
    $lastFive .= $pw->fnLastFive();
  endif;  


  $textarea = '';
  $MODE = 'DEFAULT';
  switch($mode) :
# ADD 
    case 'newRecord':
/*      
      $MODE = <<< ____EOT
          <main><section>       
          <h2> QQQ New record </h2> 
          <dl><dt>
            <label> URL: </label>
            <input
              type  = "text"
              size  = "42"
              name  = "url"
              class = "fsn bge"
              value = ""
            >
            </dt>
          <dd>
            <br>
            <textarea
              rows  = "12"
              cols  = "42"
              name  = "text"
              class = "fsn bge"
            ></textarea>
          </dd>
          <dt class="tar">
            <input class="fll" type="submit" name="viewRecord" value="view">
            <input type="submit" name="addRecord" value="save">
          </dt>
          <dd> <br> </dd>  
        </dl>  
        </main></section>
____EOT;
*/        

      $MODE = <<< ____EOT
                  <textarea id="editor" name="editor"></textarea>            

          <main><section>       
          <h2> Add New record </h2> 
          <dl><dt>
            <label> URL: </label>
            <input
              type  = "text"
              size  = "42"
              name  = "url"
              class = "fsn bge"
              value = ""
            >
            </dt>
          <dd>
            <br>
            <!--
            <textarea
              rows  = "12"
              cols  = "42"
              name  = "editor"
              id    = "editor"
              class = "fsn bge"
            ></textarea>
            <textarea id="editor" name="editor"></textarea>            
            -->
          </dd>
          <dt class="tar">
            <input class="fll" type="submit" name="viewRecord" value="view">
            <input type="submit" name="newRecord" value="save">
          </dt>
          <dd> <br> </dd>  
        </dl>  
        </main></section>
____EOT;
    break;

  default: 
      $recTotals = $pw->recTotals( (int) $_SESSION['id']);
      
      $MODE = <<< ____EOT
          <main><section>       
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
              class="flr bgc"
              type="submit" 
              name="newRecord" 
              value="Add"
            > 
            <div class="clb tac fss">
              total records: $recTotals
            </div>  
          </main></section>       
____EOT;

  endswitch;  

  
# BEGIN RENDER SCREEN ==============================================
  $explode = $lastFive; // implode($lastFive, ''); 
  $tmp =  <<< ____EOT
    \n
    <form action="search" method="post">
      <div>
        $MODE
      </div>
    </form>  

    \n\n
    <form action="search" method="post">
      <div id="livesearch" class="w88 mga">
        $explode  
      </div>  
    </form>  

____EOT;
  echo $tmp;
  require 'incs/_java-MYSQLI.js';


 
