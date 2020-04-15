<?php declare(strict_types=1);

# session_start();
# print_r($_SESSION);

?><script>
var liveSearch = function(inputID) {
  this.input = document.getElementById(inputID);
  if (this.input) {
    this.initialise();
  }
}
liveSearch.prototype = {
  initialise: function()
  {
    this.previousSearch = null;
    this.canSearch = 1;
    this.input.addEventListener("keyup", this.onKeyUp.bind(this));
  },
  onKeyUp : function()
  {
    if (this.canSearch) {
      this.canSearch = 0;
      setTimeout(function(){
        var value = this.input.value.toLowerCase();
        if (value != this.previousSearch) {
          this.doSearch(value);
        }
        this.previousSearch = value;
        this.canSearch = 1;
      }.bind(this), 500);
    }
  },
  doSearch : function(str)
  {
    // START: do your ajax call here ============================================
      if (str.length==0)
      {
        document.getElementById("livesearch").innerHTML="";
        // document.getElementById("livesearch").style.border="0px";
        return;
      }
      if (window.XMLHttpRequest)
      {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
      }else{  // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
          document.getElementById("livesearch").innerHTML=xmlhttp.responseText;
          // document.getElementById("livesearch").style.border="1px solid #A5ACB2";
        }
      }
      // xmlhttp.open("GET", "_dbResults-PASSWORD.php?q="+str,true);
      xmlhttp.open("GET", "_dbResults-MYSQLI.php?id=<?= $_SESSION['id'] ?>&q="+str,true);
      xmlhttp.send();
    // END: do your ajax call here ============================================
  }
}
var myLiveSearch = new liveSearch("bufferedInput");
</script>