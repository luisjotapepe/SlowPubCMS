<?php include "templates/include/header.php" ?>


	<div id="div-01">
        <img src="images/div_01.gif" width="1024" height="27" alt="">
	</div>
	<div id="div-02">
        <img src="images/div_02.gif" width="43" height="143" alt="">
	</div>
	<div id="HomeLink">
		<a href="websiteURL"></a>
	</div>
	<div id="div-04">
        <img src="images/div_04.gif" width="698" height="15" alt="">
	</div>
	<div id="div-05">
        <img src="images/div_05.gif" width="103" height="128" alt="">
	</div>
	<div id="MainTitle" class="fontStyle">
        <h1 class="mainTitle">Weekly Specials</h1>
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
        <p class="signoutLine">You are logged in as <b><?php echo htmlspecialchars( $_SESSION['username']) ?></b>. <a href="index.php?action=logout" class="Links"?> .:LOG OUT:.</a></p>
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
        <p><a  class="Links" href="index.php?action=addWeeklySpecialItem">ADD NEW ITEM</a></p>
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
        <table>
        <tr class="tableHeader">
            <th>DAY</th>
            <th>ON SCREEN</th>
            <th>ON BAR</th>
            <th>ON STEREO</th>
        </tr>

        <?php foreach ( $results['weeklySpecialItems'] as $weeklySpecialItem) { ?>
        <tr onclick="location='index.php?action=editWeeklySpecialItem&weeklySpecialItemId=<?php echo $weeklySpecialItem->id?>'">
            <td>
                <?php
                switch($weeklySpecialItem->day) {
                    case 1:
                        $day = 'Monday';
                        break;
                    case 2:
                        $day = 'Tuesday';
                        break;
                    case 3:
                        $day = 'Wednesday';
                        break;
                    case 4:
                        $day = 'Thursday';
                        break;
                    case 5:
                        $day = 'Friday';
                        break;
                    case 6:
                        $day = 'Saturday';
                        break;
                    case 7:
                        $day = 'Sunday';
                        break;
                }
                echo $day?>
            </td>
            <td>
                <?php
                    if(strlen($weeklySpecialItem->onScreen)<17) echo $weeklySpecialItem->onScreen;
                    else echo substr($weeklySpecialItem->onScreen, 0, 17).'...';
                ?>
            </td>
            <td>
                <?php
                    if(strlen($weeklySpecialItem->onBar)<17) echo $weeklySpecialItem->onBar;
                    else echo substr($weeklySpecialItem->onBar, 0, 17).'...';
                ?>
            </td>
            <td>
                <?php
                    if(strlen($weeklySpecialItem->onStereo)<17) echo $weeklySpecialItem->onStereo;
                    else echo substr($weeklySpecialItem->onStereo, 0, 17).'...';
                ?>
            </td>
        </tr>
        <?php } ?>
        </table>

        <p style="color:#64635a; font-style:\"Trebuchet MS\", Arial, Helvetica, sans-serif;"><?php echo $results['totalRows']?> item<?php echo ( $results['totalRows'] != 1 ) ? 's' : ''?> in total.
	</div>
	<div id="div-24">
        <img src="images/div_24.gif" width="713" height="37" alt="">
	</div>
	<div id="div-25"    >
        <img src="images/div_25.gif" width="230" height="36" alt="">
	</div>



<?php include "templates/include/footer.php" ?>