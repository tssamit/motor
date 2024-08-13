<?php
session_start();
require_once '../config/config.php';
require_once '../config/helper.php';
$action = $_REQUEST[ 'submit' ];
switch ( $action ) {
	case 'addCountry':
		$cn_name = mysqli_real_escape_string( $db, $_POST[ 'cn_name' ] );
		$cn_cdate = date( 'Y-m-d H:i:s' );
		$results = $db->query( "SELECT * FROM `country` WHERE cn_name='$cn_name'" );
		if ( $results->num_rows > 0 ) {
			$_SESSION[ 'errormsg' ] = 'country ' . $cn_name . ' already exist.';
			$_SESSION[ 'errorValue' ] = 'warning';
			header( "Location: ../add-country?msg=" . md5( '1' ) . "" );
		} else {
			$db->query( "INSERT INTO `country` (`cn_id`, `cn_name`, `cn_status`, `cn_cdate`) VALUES (NULL, '$cn_name', '1', '$cn_cdate')" );
			$_SESSION[ 'errormsg' ] = 'country ' . $cn_name . ' added successfully.';
			$_SESSION[ 'errorValue' ] = 'success';
			header( "Location: ../add-country?msg=" . md5( '1' ) . "" );
		}
		break;
	case 'updateCountry':
		$cn_id = $_REQUEST[ 'cn_id' ];
		$cn_name = mysqli_real_escape_string( $db, $_POST[ 'cn_name' ] );
		$results = $db->query( "SELECT * FROM `country` WHERE cn_name='$cn_name'" );
		if ( $results->num_rows > 0 ) {
			$_SESSION[ 'errormsg' ] = 'country ' . $cn_name . ' already exist.';
			$_SESSION[ 'errorValue' ] = 'warning';
			header( "Location: ../add-country?cnid=$cn_id&msg=" . md5( '1' ) . "" );
		} else {
			$db->query( "UPDATE `country` SET cn_name='$cn_name' WHERE cn_id = '$cn_id'" );

			$_SESSION[ 'errormsg' ] = 'country ' . $cn_name . ' updated successfully.';
			$_SESSION[ 'errorValue' ] = 'success';
			header( "Location: ../add-country?msg=" . md5( '5' ) . "" );
		}
		break;
	case 'deleteCountry':
		$cn_id = $_REQUEST[ 'cn_id' ];
		$db->query( "DELETE from country where `cn_id`='$cn_id'" );
		$_SESSION[ 'errormsg' ] = 'country deleted';
		$_SESSION[ 'errorValue' ] = 'success';
		header( "Location: ../add-country?msg=" . md5( '5' ) . "" );
		break;
	case 'Disable':
		$cn_id = $_REQUEST[ 'cn_id' ];
		$db->query( "UPDATE country SET cn_status='2' WHERE cn_id = '$cn_id'" );
		$_SESSION[ 'errormsg' ] = 'Sucessfully disabled.';
		$_SESSION[ 'errorValue' ] = 'success';
		header( "Location: ../add-country?msg=" . md5( '5' ) . "" );
		break;
	case 'Enable':
		$cn_id = $_REQUEST[ 'cn_id' ];
		$db->query( "UPDATE country SET cn_status='1' WHERE cn_id = '$cn_id'" );
		$_SESSION[ 'errormsg' ] = 'Sucessfully enabled.';
		$_SESSION[ 'errorValue' ] = 'success';
		header( "Location: ../add-country?msg=" . md5( '5' ) . "" );
		break;
	default:
		$_SESSION[ 'errormsg' ] = 'Invalid page access.';
		$_SESSION[ 'errorValue' ] = 'warning';
		header( "Location: ../404?msg=" . md5( '11' ) . "" );
}