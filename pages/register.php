<?php DECLARE(STRICT_TYPES=1);


?>
<form action="adduser" method="post">
  <!-- div class="login lh2" -->
  <main><section class="dib">

    <h2> Register </h1>
    <div id="mainmenu" class="w88 mga">

      <label class="fll" for="email">
        <i class="fll fss fas fa-envelope-square"> email </i>
      </label>

      <input 
        type="text"
        placeholder="email" 
        id="email" 
        name="email" 
        required="">
      <br><br>

      <label  class="fll" for="username">
        <i class="fll fss fas fa-user"> name: </i>
      </label>
      <input 
        type="text" 
        name="username" 
        placeholder="Username" 
        id="username" 
        required="">
      <br><br>

      <label class="fll" for="password">
        <i class="fss clb fas fa-lock"> password: </i>
      </label>
      <input 
        class="dib"
        type="password" 
        name="password" 
        placeholder="Password" 
        id="password" 
        required="" />
      <br><br>

      <label class="fll" for="password">
        <i class="fll fss clb fas fa-user-check"> verify </i>
      </label>
      <input 
        type="password" 
        name="password2" 
        placeholder="Password2" 
        id="password2" 
        required="">
    </div>
    <p class="tac p42">
      <input type="submit" value="Register">
    </p>  
  <!-- /div> -->
  </main></section>
</form>
