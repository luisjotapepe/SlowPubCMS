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
        <p class="signoutLine">You are logged in as <b><?php echo htmlspecialchars( $_SESSION['username']) ?></b>.    <a href="index.php?action=logout" class="Links"?> .:LOG OUT:.</a></p>
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
        <?php if ( $results['supplierItem']->id) { ?>
            <p><a class="Links" href="index.php?action=deleteSupplierItem&amp;supplierItemId=<?php echo $results['supplierItem']->id ?>" onclick="return confirm('Delete this item')">Delete this supplier</a> </p>
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
        <input type="hidden" name="supplierItemId" value="<?php echo $results['supplierItem']->id ?>"/>
        <input type="hidden" name="date" value="<?php echo date( "Y-m-d")?>"/>
        <ul>
            <li>
                <label for="name">Name</label>
                <input style="width:250px" type="text" name="name" id="name" placeholder="Name of supplier" required autofocus maxlength="50" value="<?php echo htmlspecialchars( $results['supplierItem']->name )?>" />
            </li>
            <li>
                <label for="description">Description</label>
                <textarea name="description" id="description" placeholder="Description of supplier" required maxlength="100" style="vertical-align:top;" rows="2" cols="50"><?php echo htmlspecialchars( $results['supplierItem']->description )?></textarea>
            </li>
            <li>
                <label for="url">URL</label>
                <input style="width:400px" type="text" name="url" id="url" placeholder="Supplier's web address" maxlength="100" value="<?php echo htmlspecialchars( $results['supplierItem']->url )?>" />
            </li>
            <li>
<!--                <label for="picture">Picture</label>-->
<!--                <input type="hidden" name="picture" accept="image/jpeg,image/png" id="picture" value="--><?php //echo htmlspecialchars( $results['supplierItem']->picture )?><!--" />-->
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