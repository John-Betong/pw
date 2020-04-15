<?php DECLARE(STRICT_TYPES=1);
error_reporting(-1);
ini_set('display_errors','1');
ini_set('error_log', 'ERROR_LOG.php');
touch('ERROR_LOG.php');


?><!DOCTYPE HTML><html lang="en">
<head>
<title>Responsive Textarea</title>
<style>
.container {
    max-width: 820px;
    margin: 0px auto;
    margin-top: 50px;
}
.comment {
    float: left;
    width: 90%;
    height: auto;
    padding: 0 1em;
    margin: 0 0 2em;
}
/*
.commenter {
    float: left;
}
.commenter img {
    width: 35px;
    height: 35px;
}
.comment-text-area {
    float: left;
    width: 100%;
    height: auto;
}
*/
input,
.textinput {
    float: left;
    margin-left: 2em;
    width: 100%;
    outline: none;
    resize: none;
    border: 1px solid grey;
}
.textinput {min-height: 75px;}
.bd1 {border: solid  1px red;}
.bd2 {border: dotted 1px blue;}
.bd3 {border: dotted 1px #0a0;}
.bg1 {background-color: red;}
.bg2 {background-color: blue;}
.bg3 {background-color: #0a0;}
div {padding: 1em;}
</style>
</head>
<body>
  <div class="container bd1 XXXbg1">
    <div class="comment bd2 XXXbg2">
      Title:
      <input type="text" name="" value="adsf">
    </div>  

    <div class="comment bd2 XXXbg2">
      Notes:
      <textarea 
        class="textinput bd3 bg3"
        placeholder="Comment">             
      </textarea>
    </div>
  </div>
</body>
</html>