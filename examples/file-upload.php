<?php
include "../config/koneksi.php";

// Check if the request is an AJAX request
$ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

$result = array();

// Check if $_FILES['avatar'] is set
if (isset($_FILES['avatar'])) {
	$file = $_FILES['avatar'];

	// Check file type and extension
	if (!preg_match('/^image\//', $file['type']) || !preg_match('/\.(jpe?g|gif|png)$/', $file['name'])) {
		$result['status'] = 'ERR';
		$result['message'] = 'Invalid file format!';
	}
	// Check file size
	else if ($file['size'] > 110000) {
		$result['status'] = 'ERR';
		$result['message'] = 'Please choose a smaller file!';
	}
	// Check for upload errors
	else if ($file['error'] != 0 || !is_uploaded_file($file['tmp_name'])) {
		$result['status'] = 'ERR';
		$result['message'] = 'Unspecified error!';
	} else {
		// File is valid, proceed with saving and resizing

		// Generate save path (assuming save_path is in the same directory as script)
		$save_path = dirname(__FILE__) . '/' . $file['name'];
		$thumb_path = dirname(__FILE__) . '/thumb.jpg'; // Thumbnail path (you may adjust this)

		// Move uploaded file to save path
		if (!move_uploaded_file($file['tmp_name'], $save_path)) {
			$result['status'] = 'ERR';
			$result['message'] = 'Unable to save file!';
		} else {
			// Resize image
			if (!resize($save_path, $thumb_path, 150)) {
				$result['status'] = 'ERR';
				$result['message'] = 'Unable to resize image!';
			} else {
				// Image saved and resized successfully
				$result['status'] = 'OK';
				$result['message'] = 'Avatar changed successfully!';
				$result['url'] = dirname($_SERVER['SCRIPT_NAME']) . '/' . $file['name'];

				// Update database with photo URL
				$photo_url = mysqli_real_escape_string($mysqli, $result['url']);
				mysqli_query($mysqli, "UPDATE tbl_user SET photo='$photo_url'");
				mysqli_query($mysqli, "UPDATE pegawai SET foto='$photo_url'");
			}
		}
	}
} else {
	$result['status'] = 'ERR';
	$result['message'] = 'No file uploaded!';
}

$result = json_encode($result);

if ($ajax) {
	echo $result;
} else {
	// If not AJAX, assume upload is via iframe
	echo '<script language="javascript" type="text/javascript">';
	echo 'var iframe = window.top.window.jQuery("#' . $_POST['temporary-iframe-id'] . '").data("deferrer").resolve(' . $result . ');';
	echo '</script>';
}

function resize($in_file, $out_file, $new_width, $new_height = FALSE)
{
	$image = null;
	$extension = strtolower(pathinfo($in_file, PATHINFO_EXTENSION));

	// Create image resource based on file extension
	switch ($extension) {
		case 'jpg':
		case 'jpeg':
			$image = imagecreatefromjpeg($in_file);
			break;
		case 'png':
			$image = imagecreatefrompng($in_file);
			break;
		case 'gif':
			$image = imagecreatefromgif($in_file);
			break;
		default:
			return false; // Invalid file type
	}

	if (!$image || !is_resource($image)) {
		return false; // Failed to create image resource
	}

	$width = imagesx($image);
	$height = imagesy($image);

	// Calculate new height if not specified
	if ($new_height === FALSE) {
		$new_height = (int)(($height * $new_width) / $width);
	}

	// Create new image resource
	$new_image = imagecreatetruecolor($new_width, $new_height);
	if (!$new_image) {
		return false; // Failed to create new image
	}

	// Resize and save image
	if (!imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height)) {
		imagedestroy($image);
		imagedestroy($new_image);
		return false; // Failed to resize image
	}

	// Save resized image to file
	$ret = false;
	switch ($extension) {
		case 'jpg':
		case 'jpeg':
			$ret = imagejpeg($new_image, $out_file, 80);
			break;
		case 'png':
			$ret = imagepng($new_image, $out_file);
			break;
		case 'gif':
			$ret = imagegif($new_image, $out_file);
			break;
	}

	// Clean up resources
	imagedestroy($new_image);
	imagedestroy($image);

	return $ret;
}
