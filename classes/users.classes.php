<?php
class users
{
	protected $db = null;

	public function __construct($db){
		$this->db = $db;
	}

	public function checkUser($email, $password){
		//lets get user
		$query = "SELECT * FROM Users WHERE UserEmail = :email";
		$pdo = $this->db->prepare($query);
		$pdo->bindParam(':email', $email);
		$pdo->execute();
	
		$user = $pdo->fetch(PDO::FETCH_ASSOC);
	
		if(empty($user)){
			return false;
		}else if(password_verify($password, $user['UserPassword'])){
			return $user;
		}else{
			return false;
		}
	}

	public function getUser($userid){
		//Let's get the users information
		$query = "SELECT * FROM Users WHERE UserID = :userid";
		$pdo = $this->db->prepare($query);
		$pdo->bindParam(':userid', $userid);
		$pdo->execute();
	
		return $pdo->fetch(PDO::FETCH_ASSOC);
	}

	public function updateUser($userid, $name, $country, $gender, $profileImage = null){
		//Update a users record

		//Upload Image Here
		if($profileImage["tmp_name"]){
			//Let's add a random string of numbers to the start of the filename to make it unique!
			$newFilename = md5(uniqid(rand(), true)).$profileImage["name"];
			$target_file = "./user_images/" . basename($newFilename);
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

			// Check if image file is a actual image or fake image
			$check = getimagesize($profileImage["tmp_name"]);
			if($check === false) {
				$error = "File is not an image!";
			}

			//Check file already exists - It really, really shouldn't!
			if (file_exists($target_file)) {
				$error = "Sorry, file already exists.";
			}

			// Check file size
			if ($_FILES["profile_image"]["size"] > 500000) {
				$error = "Sorry, your file is too large.";
			}

			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				$error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			}

			// Did we hit an error?
			if (isset($error)) {
				return $error;
			} else {
				//Save file
				if (move_uploaded_file($profileImage["tmp_name"], $target_file)) {
					// success
				} else {
					return "Sorry, there was an error uploading your file.";
				}
			}
		}

		if(isset($target_file))
		{
			$query = "UPDATE Users SET UserForename = :forename, UserCountry = :country, UserGender = :gender, UserProfileImage = :profile_image WHERE userID = :userid";
		}
		else
		{
			$query = "UPDATE Users SET UserForename = :forename, UserCountry = :country, UserGender = :gender WHERE userID = :userid";
		}
		$pdo = $this->db->prepare($query);

		if(isset($target_file)) 
		{
			$pdo->bindParam(':profile_image', $newFilename);
		}			
		$pdo->bindParam(':forename', $name);
		$pdo->bindParam(':country', $country);
		$pdo->bindParam(':gender', $gender);
		$pdo->bindParam(':userid', $userid);
				
		if($pdo->execute())
		{
			return true;
		}
		else
		{
			$pdo->error_log();
			return false;
		}
	}

}
?>