<?php declare(strict_types=1);

?>
<form action="?" method="post">
  <div class="w88 mga">
    <textarea id="editor" name="editor"></textarea>
      <div class="tac">
        <input type="submit" name="submit" value="submit">
      </div>
      http://localhost:2000/ 
  </div>
</form>

<script>
// var editor = new Jodit('#editor');
// editor.value = '<p>start</p>';
// const editor = Jodit.make('#editor');
// editor.value = '<p>start</p>';

var jodit = new Jodit('#editor', {
    buttons: [{
        icon: 'image',
        exec: function () {
            this.filebrowser.open();
        }
    }],
    uploader: {
        url: './connector/index.php?action=upload'
    },
    filebrowser: {
        ajax: {
            url: './connector/index.php',
            process: function (resp) {
                resp.baseurl = '/files/';
                return resp;
            },
        }
    }
});
$('.clicker').on('click', jodit.filebrowser.open);

</script>