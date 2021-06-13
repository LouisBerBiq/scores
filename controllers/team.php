<?php
namespace Controllers;

use Intervention\Image\ImageManager;

define(__NAMESPACE__ . '\FULL_IMAGES_PATH', './assets/images/full/');
define(__NAMESPACE__ . '\THUMB_IMAGES_PATH', './assets/images/thumbs/');

// require('./controllers/exceptions/fileUpload.php');

class Team
{
	function store()
	{
		$teamModel = new \Models\Team();
	
		// validation
		$_SESSION['errors'] = [];
		$_SESSION['old'] = [];
	
		// we check if an image is given
		if (
			!isset($_FILES['team-logo']['error']) ||
			is_array($_FILES['team-logo']['error'])
		) {
			$_SESSION['errors']['team-logo'] = 'critical error';

			header('location: ./index.php?action=create&resource=team'); //major error so redirect
			exit();
		}

		// we check for $_FILES errors
		switch ($_FILES['team-logo']['error']) {
			case UPLOAD_ERR_OK:
				break;
			case UPLOAD_ERR_NO_FILE:
				$_SESSION['errors']['team-logo'] = 'No file sent';
				break;
			case UPLOAD_ERR_INI_SIZE:
			case UPLOAD_ERR_FORM_SIZE:
				$_SESSION['errors']['team-logo'] = 'Exceeded filesize limit'. ini_get('upload_max_filesize');
				break;
				default:
				$_SESSION['errors']['team-logo'] = 'Unknown error(s)';
			}

		// we harcode a size check
		if ($_FILES['team-logo']['size'] > 8000000) { // hardcoding is fun
			$_SESSION['errors']['team-logo'] = 'Exceeded filesize limit of 8Meg';
		}

		// we check if the temporary file is in the correct format
		$finfo = new \finfo(FILEINFO_MIME_TYPE);
		if (false === $ext = array_search(
			$finfo->file($_FILES['team-logo']['tmp_name']),
			array(
				'jpg' => 'image/jpeg',
				'png' => 'image/png',
			),
			true
		)) {
			$_SESSION['errors']['team-logo'] = 'Invalid file format';
		}

		// we create a unique name for the soon to be stored image
		$file_name = sprintf(FULL_IMAGES_PATH . '%s.%s',
						sha1_file($_FILES['team-logo']['tmp_name']),
						$ext
					);

		// note to self: learn why I can't call a static method here
		$imageManager = new ImageManager(['driver'=>'gd']);
		$image = $imageManager->make(($_FILES['team-logo']['tmp_name']));
		echo $image->width() . 'x' . $image->height();
		exit();

		// then we move the image
		if (!move_uploaded_file(
			$_FILES['team-logo']['tmp_name'], $file_name
		)) {
			$_SESSION['errors']['team-logo'] = 'serverside error: Failed to move uploaded file';

			header('location: ./index.php?action=create&resource=team');
			exit();
		}


		if (empty($_POST['team-name']) || trim(isset($_POST['team-name'])) === '') {
			$_SESSION['errors']['team-name'] = 'You have not provided a team name';
		}
		if (empty($_POST['team-slug']) || trim(isset($_POST['team-slug'])) === '') {
			$_SESSION['errors']['team-slug'] = 'You have not provided a slug';
		}
		// end of validation
		
		if (!$_SESSION['errors']) {
			$name = $_POST['team-name'];
			$slug = $_POST['team-slug'];
			$team = compact('name', 'slug', 'file_name');
			$teamModel->saveToDb('teams', $team);
			header('location: ./index.php');
			exit();
		}
		$_SESSION['old']['team-name'] = $_POST['team-name'];
		$_SESSION['old']['team-slug'] = $_POST['team-slug'];
		header('location: ./index.php?action=create&resource=team');
		exit();
	}
	
	function create()
	{
		$view = './views/team/view.php';
		return compact('view');
	}
}