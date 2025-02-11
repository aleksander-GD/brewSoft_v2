<?php
class User extends Database
{
    public function login()
    {

        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $sql = "SELECT * FROM users WHERE username = :username;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                $users = $stmt->fetchAll();
                foreach ($users as $user) {
                    $hashedPassword = $user['password'];
                    if (password_verify($password, $hashedPassword)) {
                        $_SESSION['logged_in'] = true;
                        $_SESSION['username'] = $username;
                        $_SESSION['usertype'] = $user['usertype'];
                        return true;
                    } else {
                        return false;
                    }
                }
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }

    public function createUser($username, $password, $usertype)
    {
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
        $usertype = filter_input(INPUT_POST, "usertype", FILTER_SANITIZE_STRING);

        if ($this->getConnection() == null) {
            echo 'Error: no database connection.';
            return false;
            exit();
        } else {
            if ($this->regexCheck($username, $password)) {
                $hashed_pwd = password_hash($password, PASSWORD_DEFAULT);

                if (!$this->userExists($username)) {
                    $sql = "INSERT INTO users (username, password, usertype) VALUES (:username, :password, :usertype);";
                    try {
                        $stmt = $this->conn->prepare($sql);
                        $stmt->bindParam(':username', $username);
                        $stmt->bindParam(':password', $hashed_pwd);
                        $stmt->bindParam(':usertype', $usertype);
                        $stmt->execute([$username, $hashed_pwd, $usertype]);
                        return true;
                    } catch (PDOException $e) {
                        return false;
                        exit();
                    }
                } else {
                    echo 'A user with that username already exists.';
                }
            } else {
                echo "Username must contain at least one character without any special characters. \n Password must contain at least 8 characters.";
            }
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

    public function userExists($username)
    {
        if ($this->getConnection() == null) {
            return false;
            exit();
        } else {
            $sql = "SELECT * FROM users WHERE username = :username;";
            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(":username", $username);
                $stmt->execute([$username]);
                return $stmt->fetchAll();
            } catch (PDOException $e) {
                return false;
                exit();
            }
        }
    }
}
