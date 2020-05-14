<?php
class User extends Database {
    public function login($username, $password){
		{
            $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
            
			$sql = "SELECT * FROM users WHERE username = :username;";
			$stmt = $this->conn->prepare($sql);
			$stmt->bindParam(':username', $username);
			$stmt->execute();
			$users = $stmt->fetchAll();
			foreach ($users as $user) {
				$hashedPassword = $user['password'];
				if ($user['username'] == $username && password_verify($password, $hashedPassword)) {
					return true;
				} else {
					return false;
				}
			}
		}
    }

    public function createUser($username, $password, $usertype){
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        $usertype = filter_var($_POST['usertype'], FILTER_SANITIZE_STRING);
        
        if ($this->regexCheck($username, $password))
        {
            $hashed_pwd = password_hash($password, PASSWORD_DEFAULT);

		    $sql = "INSERT INTO users (username, password, usertype) VALUES (:username, :password, :usertype);";
		    $stmt = $this->conn->prepare($sql);
		    $stmt->bindParam(':username', $username);
		    $stmt->bindParam(':password', $hashed_pwd);
		    $stmt->bindParam(':usertype', $usertype);
		    $stmt->execute();	

		    return $username;
        }
	}

    private function regexCheck($username, $password)
        {
            $usrRegex = '/[A-Za-zÆØÅæøå1-9]{1,}/';
            $pswdRegex = '/[A-Za-zÆØÅæøå\d@$!%*#?&]{8,}/';
            if (preg_match($usrRegex, $username) && preg_match($pswdRegex, $password)) {
                return true;
            } else {
                return false;
            }
        }


}