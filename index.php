<?php
/**
 * Created by Luis Pizarro
 * Date: 24/01/12
 * Time: 11:07 AM
 */

require ( "config.php" );
session_start();
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";
$username = isset( $_SESSION['username'] ) ? $_SESSION['username'] : "";

if ( $action != "login" && $action != "logout" && !$username ) {
    login();
    exit;
}

switch ( $action ) {
    case 'logout':
        logout();
        break;
    case 'listDailyMenuItems':
        listDailyMenuItems();
        break;
    case 'addDailyMenuItem':
        addDailyMenuItem();
        break;
    case 'editDailyMenuItem':
        editDailyMenuItem();
        break;
    case 'deleteDailyMenuItem':
        deleteDailyMenuItem();
        break;
    case 'listRegularMenuItems':
        lisRegularMenuItems();
        break;
    case 'editRegularMenuItem':
        editRegularMenuItem();
        break;
    case 'addRegularMenuItem':
        addRegularMenuItem();
        break;
    case 'deleteRegularMenuItem':
        deleteRegularMenuItem();
        break;
    case 'listWeeklySpecialItems':
        listWeeklySpecialItems();
        break;
    case 'addWeeklySpecialItem':
        addWeeklySpecialItem();
        break;
    case 'editWeeklySpecialItem':
        editWeeklySpecialItem();
        break;
    case 'deleteWeeklySpecialItem':
        deleteWeeklySpecialItem();
        break;
    case 'listDrinkCollectionItems':
        listDrinkCollectionItems();
        break;
    case 'addDrinkCollectionItem':
        addDrinkCollectionItem();
        break;
    case 'editDrinkCollectionItem':
        editDrinkCollectionItem();
        break;
    case 'deleteDrinkCollectionItem':
        deleteDrinkCollectionItem();
        break;
    case 'listEventItems':
        listEventItems();
        break;
    case 'addEventItem':
        addEventItem();
        break;
    case 'editEventItem':
        editEventItem();
        break;
    case 'deleteEventItem':
        deleteEventItem();
        break;
    case 'listSupplierItems':
        listSupplierItems();
        break;
    case 'addSupplierItem':
        addSupplierItem();
        break;
    case 'editSupplierItem':
        editSupplierItem();
        break;
    case 'deleteSupplierItem':
        deleteSupplierItem();
        break;
    case 'offsalePage':
        offsalePage();
        break;
    default:
        listDailyMenuItems();
}

function login() {

    $results = array();
    $results['pageTitle'] = "Admin Login | SlowPub CMS";

    if ( isset( $_POST['login'] ) ) {

        if ( $_POST['username'] == ADMIN_USERNAME && $_POST['password'] == ADMIN_PASSWORD ) {

            $_SESSION['username'] = ADMIN_USERNAME;
            header( "Location: index.php");
        } else {
            $results['errorMessage'] = "Incorrect username or password. Please try again.";
            //require( TEMPLATE_PATH . "/admin/loginForm.php" );
            require( TEMPLATE_PATH . "/admin/loginTemplate.php" );
        }
    } else {
        //require( TEMPLATE_PATH . "/admin/loginForm.php" );
        require( TEMPLATE_PATH . "/admin/loginTemplate.php" );
    }
}

function logout() {
    unset( $_SESSION['username'] );
    header( "Location: index.php" );
}

function addDailyMenuItem() {
    $results = array();
    $results['pageTitle'] = "New Daily Menu Item";
    $results['formAction'] = "addDailyMenuItem";

    if ( isset( $_POST['saveChanges'] ) ) {
        $dailyMenuItem = new DailyMenuItem();
        $dailyMenuItem->storeFormValues( $_POST );
        $dailyMenuItem->insert();
        header( "Location: index.php?status=changesSaved&action=listDailyMenuItems" );
    } elseif ( isset( $_POST['cancel'] ) ) {
        header( "Location: index.php?action=listDailyMenuItems" );
    } else {
        $results['dailyMenuItem'] = new DailyMenuItem();
        require( TEMPLATE_PATH . "/admin/editDailyMenuItem.php" );
    }
}

function addRegularMenuItem() {
    $results = array();
    $results['pageTitle'] = "New Regular Menu Item";
    $results['formAction'] = "addRegularMenuItem";

    if ( isset( $_POST['saveChanges'] ) ) {
        $regularMenuItem = new RegularMenuItem();
        $regularMenuItem->storeFormValues( $_POST );
        $regularMenuItem->insert();
        header( "Location: index.php?status=changesSaved&action=listRegularMenuItems" );
    } elseif ( isset( $_POST['cancel'] ) ) {
        header( "Location: index.php?action=listRegularMenuItems" );
    } else {
        $results['regularMenuItem'] = new RegularMenuItem();
        require( TEMPLATE_PATH . "/admin/editRegularMenuItem.php" );
    }
}

function addWeeklySpecialItem() {
    $results = array();
    $results['pageTitle'] = "New Weekly Special";
    $results['formAction'] = 'addWeeklySpecialItem';

    if ( isset( $_POST['saveChanges'] ) ) {
        $weeklySpecialItem = new WeeklySpecialItem();
        $weeklySpecialItem->storeFormValues( $_POST );
        $weeklySpecialItem->insert();
        header( "Location: index.php?status=changesSaved&action=listWeeklySpecialItems" );
    } elseif ( isset( $_POST['cancel'] ) ) {
        header( "Location: index.php?action=listWeeklySpecialItems" );
    } else {
        $results['weeklySpecialItem'] = new WeeklySpecialItem();
        require( TEMPLATE_PATH . "/admin/editWeeklySpecialItem.php" );
    }
}

function addDrinkCollectionItem() {
    $results = array();
    $results['pageTitle'] = "New Drink Collection Item";
    $results['formAction'] = 'addDrinkCollectionItem';

    if ( isset( $_POST['saveChanges'] ) ) {
        $drinkCollectionItem = new DrinkCollectionItem();
        $drinkCollectionItem->storeFormValues( $_POST );
        $drinkCollectionItem->insert();
        header( "Location: index.php?status=changesSaved&action=listDrinkCollectionItems" );
    } elseif ( isset( $_POST['cancel'] ) ) {
        header( "Location: index.php?action=listDrinkCollectionItems" );
    } else {
        $results['drinkCollectionItem'] = new DrinkCollectionItem();
        require( TEMPLATE_PATH . "/admin/editDrinkCollectionItem.php" );
    }
}

function addEventItem(){
    $results = array();
    $results['pageTitle'] = "New Event";
    $results['formAction'] = 'addEventItem';

    if ( isset( $_POST['saveChanges'] ) ) {
        $eventItem = new EventItem();
        $eventItem->storeFormValues( $_POST );
        $eventItem->insert();
        header( "Location: index.php?status=changesSaved&action=listEventItems" );
    } elseif ( isset( $_POST['cancel'] ) ) {
        header( "Location: index.php?action=listEventItems" );
    } else {
        $results['eventItem'] = new EventItem();
        require( TEMPLATE_PATH . "/admin/editEventItem.php" );
    }
}

function addSupplierItem(){
    $results = array();
    $results['pageTitle'] = "New Supplier";
    $results['formAction'] = 'addSupplierItem';

    if ( isset( $_POST['saveChanges'] ) ) {
        $supplierItem = new SupplierItem();
        $supplierItem->storeFormValues( $_POST );
        $supplierItem->printOut();
        $supplierItem->insert();
        header( "Location: index.php?status=changesSaved&action=listSupplierItems" );
    } elseif ( isset( $_POST['cancel'] ) ) {
        header( "Location: index.php?action=listSupplierItems" );
    } else {
        $results['supplierItem'] = new SupplierItem();
        require( TEMPLATE_PATH . "/admin/editSupplierItem.php" );
    }
}

function editDailyMenuItem() {

    $results = array();
    $results['pageTitle'] = "Edit Daily Menu Item";
    $results['formAction'] = "editDailyMenuItem";

    if ( isset( $_POST['saveChanges'] ) ) {
        if ( !$DailyMenuItem = DailyMenuItem::getById( (int)$_POST['dailyMenuItemId'] ) ) {
            header( "Location: index.php?error=dailyMenuItemNotFound&action=listDailyMenuItems" );
            return;
        }
        $DailyMenuItem->storeFormValues( $_POST );
        $DailyMenuItem->update();
        header( "Location: index.php?status=changesSaved&action=listDailyMenuItems" );
    } elseif ( isset( $_POST['cancel'] ) ) {
        header( "Location: index.php?action=listDailyMenuItems" );
    } else {
        $results['dailyMenuItem'] = DailyMenuItem::getById( (int)$_GET['dailyMenuItemId'] );
        require( TEMPLATE_PATH . "/admin/editDailyMenuItem.php" );
    }
}

function editRegularMenuItem() {
    $results = array();
    $results['pageTitle'] = "Edit Regular Menu Item";
    $results['formAction'] = "editRegularMenuItem";

    if( isset( $_POST['saveChanges'] ) ) {
        if( !$RegularMenuItem = RegularMenuItem::getById( (int)$_POST['regularMenuItemId'] ) ) {
            header( "Location: index.php?error=regularMenuItemNotFound&action=listRegularMenuItems" );
            return;
        }
        $RegularMenuItem->storeFormValues( $_POST );
        $RegularMenuItem->update();
        header( "Location: index.php?status=changesSaved&action=listRegularMenuItems" );
    } elseif ( isset( $_POST['cancel'] ) ) {
        header( "Location: index.php?action=listRegularMenuItems" );
    } else {
        $results['regularMenuItem'] = RegularMenuItem::getById( (int)$_GET['regularMenuItemId'] );
        require( TEMPLATE_PATH . "/admin/editRegularMenuItem.php" );
    }
}

function editWeeklySpecialItem() {
    $results = array();
    $results['pageTitle'] = "Edit Weekly Special";
    $results['formAction'] = "editWeeklySpecialItem";

    if( isset( $_POST['saveChanges'] ) ) {
        if( !$WeeklySpecialItem = WeeklySpecialItem::getById( (int)$_POST['weeklySpecialItemId'] ) ) {
            header( "Location: index.php?error=weeklySpecialItemNotFound&action=listWeeklySpecialItems" );
            return;
        }
        $WeeklySpecialItem->storeFormValues( $_POST );
        $WeeklySpecialItem->update();
        header( "Location: index.php?status=changesSaved&action=listWeeklySpecialItems" );
    } elseif ( isset( $_POST['cancel'] ) ) {
        header( "Location: index.php?action=listWeeklySpecialItems" );
    } else {
        $results['weeklySpecialItem'] = WeeklySpecialItem::getById( (int)$_GET['weeklySpecialItemId'] );
        require( TEMPLATE_PATH . "/admin/editWeeklySpecialItem.php" );
    }
}

function editDrinkCollectionItem() {
    $results = array();
    $results['pageTitle'] = "Edit Drink Collection Item";
    $results['formAction'] = "editDrinkCollectionItem";

    if( isset( $_POST['saveChanges'] ) ) {
        if( !$DrinkCollectionItem = DrinkCollectionItem::getById( (int)$_POST['drinkCollectionItemId'] ) ) {
            header( "Location: index.php?error=drinkCollectionNotFound&action=listDrinkCollectionItems" );
            return;
        }
        $DrinkCollectionItem->storeFormValues( $_POST );
        $DrinkCollectionItem->update();
        header( "Location: index.php?status=changesSaved&action=listDrinkCollectionItems" );
    } elseif ( isset( $_POST['cancel'] ) ) {
        header( "Location: index.php?action=listDrinkCollectionItems" );
    } else {
        $results['drinkCollectionItem'] = DrinkCollectionItem::getById( (int)$_GET['drinkCollectionItemId'] );
        require( TEMPLATE_PATH . "/admin/editDrinkCollectionItem.php" );
    }
}

function editEventItem(){
    $results = array();
    $results['pageTitle'] = "Edit Event";
    $results['formAction'] = "editEventItem";

    if( isset( $_POST['saveChanges'] ) ) {
        if( !$EventItem = EventItem::getById( (int)$_POST['eventItemId'] ) ) {
            header( "Location: index.php?error=eventNotFound&action=listEventItems" );
            return;
        }
        $EventItem->storeFormValues( $_POST );
        $EventItem->update();
        header( "Location: index.php?status=changesSaved&action=listEventItems" );
    } elseif ( isset( $_POST['cancel'] ) ) {
        header( "Location: index.php?action=listEventItems" );
    } else {
        $results['eventItem'] = EventItem::getById( (int)$_GET['eventItemId'] );
        require( TEMPLATE_PATH . "/admin/editEventItem.php" );
    }
}

function editSupplierItem(){
    $results = array();
    $results['pageTitle'] = "Edit Supplier";
    $results['formAction'] = "editSupplierItem";

    if( isset( $_POST['saveChanges'] )) {
        if( !$SupplierItem = SupplierItem::getById( (int)$_POST['supplierItemId'] ) ) {
            header( "Location: index.php?error=supplierNotFound&action=listSupplierItems" );
            return;
        }

//        if( isset($_POST['supplierItem']->url && $SupplierItem = SupplierItem::checkURL((int)$_POST['supplierItem']->url) ) {
//            $results['supplierItem'] = SupplierItem::getById( (int)$_GET['supplierItemId'] );
//            require( TEMPLATE_PATH . "/admin/editSupplierItem.php" );
//        }

        $SupplierItem->storeFormValues( $_POST );
        $SupplierItem->update();
        header( "Location: index.php?status=changesSaved&action=listSupplierItems" );
    } elseif ( isset( $_POST['cancel'] ) ) {
        header( "Location: index.php?action=listSupplierItems" );
    } else {
        $results['supplierItem'] = SupplierItem::getById( (int)$_GET['supplierItemId'] );
        require( TEMPLATE_PATH . "/admin/editSupplierItem.php" );
    }
}

function deleteDailyMenuItem() {
    if ( !$dailyMenuItem = DailyMenuItem::getById( (int)$_GET['dailyMenuItemId'] ) ) {
        header( "Location: index.php?error=dailyMenuItemNotFound&action=listDailyMenuItems" );
        return;
    }
    $dailyMenuItem->delete();
    header( "Location: index.php?status=dailyMenuItemDeleted&action=listDailyMenuItems" );
}

function deleteRegularMenuItem() {
    if( !$regularMenuItem = RegularMenuItem::getById( (int)$_GET['regularMenuItemId'] ) ) {
        header( "Location: index.php?error=regularMenuItemNotFound&action=listRegularMenuItems" );
        return;
    }
    $regularMenuItem->delete();
    header( "Location:index.php?status=regularMenuItemDeleted&action=listRegularMenuItems");
}

function deleteWeeklySpecialItem() {
    if( !$weeklySpecialItem = WeeklySpecialItem::getById( (int)$_GET['weeklySpecialItemId'] ) ) {
        header( "Location: index.php?error=WeeklySpecialItemNotFound&action=listWeeklySpecialItems" );
        return;
    }
    $weeklySpecialItem->delete();
    header( "Location:index.php?status=weeklySpecialItemDeleted&action=listWeeklySpecialItems");
}

function deleteDrinkCollectionItem() {
    if( !$drinkCollectionItem = DrinkCollectionItem::getById( (int)$_GET['drinkCollectionItemId'] ) ) {
        header( "Location: index.php?error=DrinkCollectionItemNotFound&action=listDrinkCollectionItems" );
        return;
    }
    $drinkCollectionItem->delete();
    header( "Location:index.php?status=drinkCollectionItemDeleted&action=listDrinkCollectionItems");
}

function deleteEventItem(){
    if( !$eventItem = EventItem::getById( (int)$_GET['eventItemId'] ) ) {
        header( "Location: index.php?error=EventItemNotFound&action=listEventItems" );
        return;
    }
    $eventItem->delete();
    header( "Location:index.php?status=eventItemDeleted&action=listEventItems");
}

function deleteSupplierItem(){
    if( !$supplierItem = SupplierItem::getById( (int)$_GET['supplierItemId'] ) ) {
        header( "Location: index.php?error=SupplierItemNotFound&action=listSupplierItems" );
        return;
    }
    $supplierItem->delete();
    header( "Location:index.php?status=supplierItemDeleted&action=listSupplierItems");
}

function listDailyMenuItems() {
    $results = array();
    $data = DailyMenuItem::getDailyMenuItemList();
    $results['dailyMenuItems'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['pageTitle'] = "Daily Menu";

    if ( isset( $_GET['error'] ) ) {
        if( $_GET['error'] == "dailyMenuItemNotFound" ) $results['errorMessage'] = "Error: Daily Menu Items not found.";
    }

    if ( isset( $_GET['status'] ) ) {
        if( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
        if( $_GET['status'] == "dailyMenuItemDeleted" ) $results['statusMessage'] = "Daily Menu item deleted";
    }
    //require( TEMPLATE_PATH . "/admin/listDailyMenuItems.php");
    require( TEMPLATE_PATH . "/admin/listDailyMenuItems.php");
}

function lisRegularMenuItems() {
    $results = array();
    $data = RegularMenuItem::getRegularMenuItemList();
    $results['regularMenuItems'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['pageTitle'] = "Regular Menu";

    if ( isset( $_GET['error'] ) ) {
        if( $_GET['error'] == "regularMenuItemNotFound" ) $results['errorMessage'] = "Error: Regular Menu Item not found.";
    }

    if ( isset( $_GET['status'] ) ) {
        if( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
        if( $_GET['status'] == "regularMenuItemDeleted" ) $results['statusMessage'] = "Regular Menu Item Deleted";
    }

    /////////////////This is for the pagination////////////////////

    //This checks to see if there is a page number. If not, it will set it to page 1
    if ( !(isset($pageNum))) {
        $pageNum = 1;
    }

    //This gets checks and gets the pageNum variable passed page to page
    if ( isset( $_GET['pageNum'] ) ) {
        $pageNum = $_GET['pageNum'];
    }

    //Here we count the number of results
    //$results['totalRows'];

    //This is the number of rows displayed per page
    $page_rows = 7;

    //This tells us the last page number
    $lastPageNum = (int) ceil($results['totalRows']/$page_rows);
    $results['lastPageNum'] = $lastPageNum;

    //This makes sure the page number isnt below one, or more than our maximum pages
    if( $pageNum < 1 ) {
        $pageNum = 1;
    } elseif( $pageNum > $lastPageNum ){
        $pageNum = $lastPageNum;
    }

    //This sets the range to display our query
    $max = 'LIMIT '.( $pageNum - 1 )*$page_rows.','.$page_rows;

    //We call the second query
    $data2 = RegularMenuItem::secondQueryForPagination($max);

    //Place new results in $results array
    $results['newResults'] = $data2;
    $results['pageNum'] = $pageNum;
    $results['separator'] = 1;


    //First we check if we are on page one. If we are then we dont need to link the previous page or the first page so we do nothing.
    //If we arent then we generate links to the first page, and to the previous page.

    if ( $pageNum == 1 ){
        //DO NOTHING
    } else {
        $previous = $pageNum - 1;
        $results['firstLink1'] = "'{$_SERVER['PHP_SELF']}?action=listRegularMenuItems&pageNum=1'";
        $results['firstLink2'] = "'{$_SERVER['PHP_SELF']}?action=listRegularMenuItems&pageNum=$previous'";
    }

    //This does the same as above, only checking if we are on the last page and then generating the Next and Last links
    if ( $pageNum == $lastPageNum ){
        //DO NOTHING
    } else {
        $next = $pageNum + 1;
        $results['lastLink1'] = "'{$_SERVER['PHP_SELF']}?action=listRegularMenuItems&pageNum=$next'";
        $results['lastLink2'] = "'{$_SERVER['PHP_SELF']}?action=listRegularMenuItems&pageNum=$lastPageNum'";
    }

    require( TEMPLATE_PATH. "/admin/listRegularMenuItems.php");
}

function listWeeklySpecialItems() {
    $results = array();
    $data = WeeklySpecialItem::getWeeklySpecialItemList();
    $results['weeklySpecialItems'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['pageTitle'] = "Weekly Specials";

    if ( isset($_GET['error'] ) ) {
        if($_GET['error'] == "weeklySpecialItemsNotFound") $results['errorMessage'] = "Error: Weekly Specials not found.";
    }
    if ( isset($_GET['status'] ) ){
        if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
        if ( $_GET['status'] == "weeklySpecialDeleted" ) $results['statusMessage'] = "Weekly Special deleted.";
    }

    require( TEMPLATE_PATH . "/admin/listWeeklySpecialItems.php");
}

function listDrinkCollectionItems() {
    $results = array();
    $data = DrinkCollectionItem::getDrinkCollectionItemList();
    $results['drinkCollectionItems'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['pageTitle'] = "Drink Collection";

    if ( isset( $_GET['error'] ) ) {
        if( $_GET['error'] == "drinkCollectionItemNotFound" ) $results['errorMessage'] = "Error: Drink Collection Item not found.";
    }

    if ( isset( $_GET['status'] ) ) {
        if( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
        if( $_GET['status'] == "drinkCollectionItemDeleted" ) $results['statusMessage'] = "Drink Collection Item Deleted";
    }

    /////////////////This is for the pagination////////////////////

    //This checks to see if there is a page number. If not, it will set it to page 1
    if ( !(isset($pageNum))) {
        $pageNum = 1;
    }

    //This gets checks and gets the pageNum variable passed page to page
    if ( isset( $_GET['pageNum'] ) ) {
        $pageNum = $_GET['pageNum'];
    }

    //Here we count the number of results
    //$results['totalRows'];

    //This is the number of rows displayed per page
    $page_rows = 7;

    //This tells us the last page number
    $lastPageNum = (int) ceil($results['totalRows']/$page_rows);
    $results['lastPageNum'] = $lastPageNum;

    //This makes sure the page number isnt below one, or more than our maximum pages
    if( $pageNum < 1 ) {
        $pageNum = 1;
    } elseif( $pageNum > $lastPageNum ){
        $pageNum = $lastPageNum;
    }

    //This sets the range to display our query
    $max = 'LIMIT '.( $pageNum - 1 )*$page_rows.','.$page_rows;

    //We call the second query
    $data2 = DrinkCollectionItem::secondQueryForPagination($max);

    //Place new results in $results array
    $results['newResults'] = $data2;
    $results['pageNum'] = $pageNum;
    $results['separator'] = 1;


    //First we check if we are on page one. If we are then we dont need to link the previous page or the first page so we do nothing.
    //If we arent then we generate links to the first page, and to the previous page.

    if ( $pageNum == 1 ){
        //DO NOTHING
    } else {
        $previous = $pageNum - 1;
        $results['firstLink1'] = "'{$_SERVER['PHP_SELF']}?action=listDrinkCollectionItems&pageNum=1'";
        $results['firstLink2'] = "'{$_SERVER['PHP_SELF']}?action=listDrinkCollectionItems&pageNum=$previous'";
    }

    //This does the same as above, only checking if we are on the last page and then generating the Next and Last links
    if ( $pageNum == $lastPageNum ){
        //DO NOTHING
    } else {
        $next = $pageNum + 1;
        $results['lastLink1'] = "'{$_SERVER['PHP_SELF']}?action=listDrinkCollectionItems&pageNum=$next'";
        $results['lastLink2'] = "'{$_SERVER['PHP_SELF']}?action=listDrinkCollectionItems&pageNum=$lastPageNum'";
    }

    require( TEMPLATE_PATH. "/admin/listDrinkCollectionItems.php");
}

function listEventItems(){
    $results = array();
    $data = EventItem::getEventItemList();
    $results['eventItems'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['pageTitle'] = "Events";

    if ( isset( $_GET['error'] ) ) {
        if( $_GET['error'] == "eventItemNotFound" ) $results['errorMessage'] = "Error: Event Item not found.";
    }

    if ( isset( $_GET['status'] ) ) {
        if( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
        if( $_GET['status'] == "eventItemDeleted" ) $results['statusMessage'] = "Event Item Deleted";
    }

    /////////////////This is for the pagination////////////////////

    //This checks to see if there is a page number. If not, it will set it to page 1
    if ( !(isset($pageNum))) {
        $pageNum = 1;
    }

    //This gets checks and gets the pageNum variable passed page to page
    if ( isset( $_GET['pageNum'] ) ) {
        $pageNum = $_GET['pageNum'];
    }

    //Here we count the number of results
    //$results['totalRows'];

    //This is the number of rows displayed per page
    $page_rows = 7;

    //This tells us the last page number
    $lastPageNum = (int) ceil($results['totalRows']/$page_rows);
    $results['lastPageNum'] = $lastPageNum;

    //This makes sure the page number isnt below one, or more than our maximum pages
    if( $pageNum < 1 ) {
        $pageNum = 1;
    } elseif( $pageNum > $lastPageNum ){
        $pageNum = $lastPageNum;
    }

    //This sets the range to display our query
    $max = 'LIMIT '.( $pageNum - 1 )*$page_rows.','.$page_rows;

    //We call the second query
    $data2 = EventItem::secondQueryForPagination($max);

    //Place new results in $results array
    $results['newResults'] = $data2;
    $results['pageNum'] = $pageNum;
    $results['separator'] = 1;


    //First we check if we are on page one. If we are then we dont need to link the previous page or the first page so we do nothing.
    //If we arent then we generate links to the first page, and to the previous page.

    if ( $pageNum == 1 ){
        //DO NOTHING
    } else {
        $previous = $pageNum - 1;
        $results['firstLink1'] = "'{$_SERVER['PHP_SELF']}?action=listEventItems&pageNum=1'";
        $results['firstLink2'] = "'{$_SERVER['PHP_SELF']}?action=listEventCollectionItems&pageNum=$previous'";
    }

    //This does the same as above, only checking if we are on the last page and then generating the Next and Last links
    if ( $pageNum == $lastPageNum ){
        //DO NOTHING
    } else {
        $next = $pageNum + 1;
        $results['lastLink1'] = "'{$_SERVER['PHP_SELF']}?action=listEventCollectionItems&pageNum=$next'";
        $results['lastLink2'] = "'{$_SERVER['PHP_SELF']}?action=listEventCollectionItems&pageNum=$lastPageNum'";
    }

    require( TEMPLATE_PATH. "/admin/listEventItems.php");
}

function listSupplierItems(){
    $results = array();
    $data = SupplierItem::getSupplierItemList();
    $results['supplierItems'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['pageTitle'] = "Suppliers";

    if ( isset($_GET['error'] ) ) {
        if($_GET['error'] == "supplierItemsNotFound") $results['errorMessage'] = "Error: Supplier not found.";
    }
    if ( isset($_GET['status'] ) ){
        if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
        if ( $_GET['status'] == "supplierDeleted" ) $results['statusMessage'] = "Supplier deleted.";
    }

    require( TEMPLATE_PATH . "/admin/listSupplierItems.php");
}

function offsalePage(){
    $results = array();
    $data = OffsaleItem::getOffsaleItemList();
    $results['offsaleItems'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['pageTitle'] = "Offsale";

    if ( isset($_GET['error'] ) ) {
        if($_GET['error'] == "offsaleItemsNotFound") $results['errorMessage'] = "Error: Offsale item not found.";
    }
    if ( isset($_GET['status'] ) ){
        if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
        if ( $_GET['status'] == "offsaleDeleted" ) $results['statusMessage'] = "Offsale item deleted.";
    }

    if ( isset($_GET['option'] ) ) {
        $results['formAction'] = "offsalePage";
        if ( $_GET['option'] == "edit" ){
            if( isset( $_POST['saveChanges'] ) ) {
                if( !$OffsaleItem = OffsaleItem::getById( (int)$_POST['offsaleItemId'] ) ) {
                    header( "Location: index.php?error=offsaleNotFound&action=offsalePage" );
                    return;
                }
                $OffsaleItem->printOut();
                $OffsaleItem->storeFormValues( $_POST );
                $OffsaleItem->update();
                header( "Location: index.php?status=changesSaved&action=offsalePage" );
            } elseif ( isset( $_POST['cancel'] ) ) {
                $results['printOut'] = "testing";
                header( "Location: index.php?action=offsalePage" );
            } else {
                $results['option']="edit";
                $results['offsaleItem'] = OffsaleItem::getById( (int)$_GET['offsaleItemId'] );
            }
        }elseif( $_GET['option'] == 'delete') {
            if( !$offsaleItem = OffsaleItem::getById( (int)$_GET['offsaleItemId'] ) ) {
                header( "Location: index.php?error=OffsaleItemNotFound&action=offsalePage" );
                return;
            }
            $offsaleItem->delete();
            header( "Location:index.php?status=offsaleItemDeleted&action=offsalePage");
        }elseif( $_GET['option'] == 'add') {
            if ( isset( $_POST['saveChanges'] ) ) {
                $offsaleItem = new OffsaleItem();
                $offsaleItem->storeFormValues( $_POST );
                $offsaleItem->insert();
                header( "Location: index.php?status=changesSaved&action=offsalePage" );
            } elseif ( isset( $_POST['cancel'] ) ) {
                header( "Location: index.php?action=offsalePAge" );
            } else {
                $results['option'] = "add";
                $results['offsaleItem'] = new OffsaleItem();
            }
        }
    }

    require( TEMPLATE_PATH . "/admin/offsale.php");
}


?>