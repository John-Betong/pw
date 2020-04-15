<?php DECLARE(STRICT_TYPES=1);

# 
  # $_SESSION['loggedin']  = FALSE;
  $uName = 'test'; // john
  $pWord = 'test';  // john

?>
<p> <br><br><br> </p>
<form action="search" method="post">
  <main><section class="dib">
    <h2> Login </h2>
    <div class="w88 mga XXXdib XXXtal">

      <label class="fll" for="username">
        <i class="fll fas fa-user"> &nbsp; </i>
        <i class="fll"> User </i>
      </label>
      <input 
        type  = "text" 
        id    = "username" 
        name  = "username" 
        value = "<?= $uName ?>"
        required=""
        placeholder = "Username">
      <br><br>

      <label class="fll" for="password">
        <i class="fas fa-lock">&nbsp;</i>
        Password
      </label>
      <input 
        type  = "password" 
        id    = "password" 
        name  = "password" 
        value = "<?= $pWord ?>"
        placeholder = "Password" 
        required=""
      >
      <br>
    </div>
    <br>

    <p class="tac fsl">
      <input class="bdr bgn fgs" type="submit" name="login" value="Login">
    </p>  

    <p class="hhh tac XXXbdr fsl XXXfgs">
      <?php # if(0 && $_SESSION['loggedin']) : ?>
        <!--
        <input class="bdr bgn fgs" type="submit" name="search" value="Search">
        &nbsp; &nbsp; 
      -->
      <?php # endif ?>  

      <input  class="bdr bgn fgs" type="submit" value="Login">
    </p>  
  </section></main>
</form>
