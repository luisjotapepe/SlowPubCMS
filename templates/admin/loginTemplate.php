<?php include "templates/include/header.php" ?>
	<div id="login-div-01">
		<img src="images/login_div_01.gif" width="1024" height="189" alt="">
	</div>
	<div id="login-div-02">
		<img src="images/login_div_02.gif" width="357" height="486" alt="">
	</div>
	<div id="errorMessage">
        <?php if ( isset( $results['errorMessage'] ) ) { ?>
            <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
        <?php } ?>
	</div>
	<div id="login-div-04">
		<img src="images/login_div_04.gif" width="355" height="113" alt="">
	</div>
	<div id="login-div-05">
		<img src="images/login_div_05.gif" width="312" height="69" alt="">
	</div>
	<div id="login-div-06">
		<img src="images/login_div_06.gif" width="59" height="373" alt="">
	</div>
	<div id="usernameField">
        <form action="index.php?action=listDailyMenuItems" method="post" style="width: 50%;">
        <input type="hidden" name="login" value="true" />
        <input type="text" name="username" id="username" class="loginInput" placeholder="Your admin username" required autofocus maxlength="20" style="background-color:white"/>
	</div>
	<div id="login-div-08">
		<img src="images/login_div_08.gif" width="293" height="373" alt="">
	</div>
	<div id="login-div-09">
		<img src="images/login_div_09.gif" width="315" height="37" alt="">
	</div>
	<div id="passwordField">
        <input type="password" name="password" id="password" class="loginInput" placeholder="Your admin password" required maxlength="20" style="background-color:white"/>
	</div>
	<div id="login-div-11">
		<img src="images/login_div_11.gif" width="315" height="35" alt="">
	</div>
	<div id="login-div-12">
		<img src="images/login_div_12.gif" width="49" height="250" alt="">
	</div>
	<div id="loginButton" >
        <input type="submit" name="login" value="" class="loginButton" style="cursor:pointer;"/>
	</div>
	<div id="login-div-14">
		<img src="images/login_div_14.gif" width="151" height="250" alt="">
	</div>
	<div id="login-div-15">
		<img src="images/login_div_15.gif" width="115" height="216" alt="">
	</div>
</form>

<?php include "templates/include/footer.php" ?>