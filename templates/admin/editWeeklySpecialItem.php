<?php include "templates/include/header.php" ?>

	<div id="div-01">
		<img src="images/div_01.gif" width="1024" height="27" alt="">
	</div>
	<div id="div-02">
		<img src="images/div_02.gif" width="43" height="143" alt="">
	</div>
	<div id="HomeLink">
		
	</div>
	<div id="div-04">
		<img src="images/div_04.gif" width="698" height="15" alt="">
	</div>
	<div id="div-05">
		<img src="images/div_05.gif" width="103" height="128" alt="">
	</div>
	<div id="MainTitle" class="fontStyle">
        <h1 class="mainTitle"><?php echo $results['pageTitle']?></h1>
	</div>
	<div id="div-07">
		<img src="images/div_07.gif" width="88" height="128" alt="">
	</div>
	<div id="div-08">
		<img src="images/div_08.gif" width="507" height="74" alt="">
	</div>
	<div id="div-09">
		<img src="images/div_09.gif" width="283" height="9" alt="">
	</div>
	<div id="div-10">
		<img src="images/div_10.gif" width="18" height="44" alt="">
	</div>
	<div id="ErrorStatusMessage" class="fontStyle">
        <?php if ( isset( $results['errorMessage'] ) ) { ?>
            <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
        <?php } ?>
        <?php if ( isset( $results['statusMessage'] ) ) { ?>
            <div class="statusMessage"><?php echo $results['statusMessage'] ?></div>
        <?php } ?>
	</div>
	<div id="Signout" class="fontStyle">
        <p class="signoutLine">You are logged in as <b><?php echo htmlspecialchars( $_SESSION['username']) ?></b>.   <a href="index.php?action=logout" class="Links"?> .:LOG OUT:.</a></p>
	</div>
	<div id="div-13">
		<img src="images/div_13.gif" width="9" height="505" alt="">
	</div>
	<div id="div-14">
		<img src="images/div_14.gif" width="624" height="17" alt="">
	</div>
	<div id="div-15">
		<img src="images/div_15.gif" width="373" height="16" alt="">
	</div>
	<div id="div-16">
		<img src="images/div_16.gif" width="17" height="461" alt="">
	</div>
	<div id="LeftMenu" class="fontStyle">
        <?php include "templates/include/leftMenu.php" ?>
	</div>
	<div id="div-18">
		<img src="images/div_18.gif" width="45" height="64" alt="">
	</div>
	<div id="AddDeleteButtons" class="fontStyle">
        <?php if ( $results['weeklySpecialItem']->id) { ?>
            <p><a class="Links" href="index.php?action=deleteWeeklySpecialItem&amp;weeklySpecialItemId=<?php echo $results['weeklySpecialItem']->id ?>" onclick="return confirm('Delete this item')">Delete this item</a> </p>
        <?php } ?>
	</div>
	<div id="div-20">
		<img src="images/div_20.gif" width="11" height="461" alt="">
	</div>
	<div id="div-21">
		<img src="images/div_21.gif" width="712" height="28" alt="">
	</div>
	<div id="div-22">
		<img src="images/div_22.gif" width="44" height="397" alt="">
	</div>
	<div id="MainContent" class="fontStyle">
        <form action="index.php?action=<?php echo $results['formAction']?>" method="post">
        <input type="hidden" name="weeklySpecialItemId" value="<?php echo $results['weeklySpecialItem']->id ?>"/>
        <input type="hidden" name="date" value="<?php echo date( "Y-m-d")?>"/>
        <ul>
            <li>
                <label for="day">Day</label>
                <select name="day" id="day" required>
                    <option value="1" <?php if($results['weeklySpecialItem']->day =='1') echo 'selected'; ?> >Monday</option>
                    <option value="2" <?php if($results['weeklySpecialItem']->day =='2') echo 'selected'; ?> >Tuesday</option>
                    <option value="3" <?php if($results['weeklySpecialItem']->day =='3') echo 'selected'; ?> >Wednesday</option>
                    <option value="4" <?php if($results['weeklySpecialItem']->day =='4') echo 'selected'; ?> >Thursday</option>
                    <option value="5" <?php if($results['weeklySpecialItem']->day =='5') echo 'selected'; ?> >Friday</option>
                    <option value="6" <?php if($results['weeklySpecialItem']->day =='6') echo 'selected'; ?> >Saturday</option>
                    <option value="7" <?php if($results['weeklySpecialItem']->day =='7') echo 'selected'; ?> >Sunday</option>
                </select>
            </li>
            <li>
                <label for="onScreen">On Screen</label>
                <textarea name="onScreen" id="onScreen" placeholder="Text for what's happening on screen" required maxlength="100" style="vertical-align:top;" rows="2" cols="50"><?php echo htmlspecialchars( $results['weeklySpecialItem']->onScreen )?></textarea>
            </li>
            <li>
                <label for="onBar">On Bar</label>
                <textarea name="onBar" id="onBar" placeholder="Text for what are the specials on bar" required maxlength="100" style="vertical-align:top;" rows="2" cols="50"><?php echo htmlspecialchars( $results['weeklySpecialItem']->onBar )?></textarea>
            </li>
            <li>
                <label for="onStereo">On Stereo</label>
                <textarea name="onStereo" id="onStereo" placeholder="Text for what's playing on stereo" required maxlength="100" style="vertical-align:top;" rows="2" cols="50"><?php echo htmlspecialchars( $results['weeklySpecialItem']->onStereo )?></textarea>
            </li>
        </ul>
        <div class="buttonsDiv">
            <input type="submit" name="saveChanges" value="Save" class="buttons"/>
            <input type="submit" formnovalidate name="cancel" value="Cancel" class="buttons"/>
        </div>
    </form>
	</div>
	<div id="div-24">
		<img src="images/div_24.gif" width="713" height="37" alt="">
	</div>
	<div id="div-25">
		<img src="images/div_25.gif" width="230" height="36" alt="">
	</div>

<?php include "templates/include/footer.php" ?>