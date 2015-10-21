<?php
require_once("libraries/phpmailer/class.phpmailer.php");
include_once("components/user/model/user.php");
include_once("components/user/model/access_level.php");
include_once("components/user/model/group.php");
include_once("components/user/model/group_access_level_map.php");
include_once("components/user/model/user_group_map.php");

class UserModelUser {

	public static function login($user,$pass)
	{
		$sql="SELECT * FROM user WHERE username='".$user."' AND state=1";
		//echo $sql;
		$qry=DB_query ($sql,$b);

		if ($result=$qry)
		{
			$numrows=DB_num_rows($result);
			if($numrows)
			{
				$row = DB_fetch_array($result);
				$password=$row['password'];
				
				if($password==mt2_auth::generateHash($pass,$password))
				{
					$loginUser = new user();
                    // print_r($loginUser);
					$loginUser->fromArray($row);
					mt2_session::_set($loginUser);
					return true	;
				}
				else
				{
					return false;
				}
			}
			return false;
		}
		return false;
	}

    public static function load_users()
    {
        $allUsers=array();
        $userGroups=array();
        $sql = "SELECT  user.*,
                        uploads.path as avatar_path,
                        uploads.title as avatar_title
                        FROM user
                        LEFT JOIN uploads on user.upload_id = uploads.id";
        $qry=DB_query($sql,$b);

        if($result = $qry)
        {
            while ($row = DB_fetch_array($result))
            {
                $user=new user();
                $user->fromArray($row);
                // print_r($row);
                $allUsers[$user->id]=$user;
            }
        }
        // $sql = "SELECT * FROM users WHERE state IN (1,3)";
        $sql = "SELECT  g.*, 
                        user_group_map.user_id
                        FROM `group` as g
                        INNER JOIN user_group_map on g.id = user_group_map.group_id 
                        WHERE g.state=1 and user_group_map.user_id IN (".join(",",array_keys($allUsers)).")";
        // echo $sql;
        $qry=DB_query($sql,$b);
        if($result = $qry)
        {
            while ($row = DB_fetch_array($result))
            {
                $group=new group();
                $group->fromArray($row);
                // print_r($row);
                $allUsers[$group->user_id]->userGroups[$group->id]=$group ;
            }
        }

        return $allUsers;
    }

	public static function verify($user,$code)
	{
		$sql = "UPDATE user SET state=2 WHERE username='".$user."' and activation_code='".$code."'";
		//print_r( $sql);
		if($qry=DB_query($sql,$b))
		{
			return true;
		}
		return false;
	}

	public static function send_verify_email($name,$email,$subject,$body) 
	{
        $mail = new PHPMailer();
        $mail->IsSMTP();// SET mailer to use SMTP
        $mail->Host = smtpServer;  // specify main and backup server
        $mail->SMTPAuth = true;     // turn on SMTP authentication
        $mail->Username = smtpUserName; // SMTP username
        $mail->Password = smtpSecret; // SMTP password
        $mail->From = smtpEMail;
        $mail->AddAddress(smtpEMail);
        $mail->AddAddress($email);
        $mail->FromName=$name;
        $mail->WordWrap = 50;
        $mail->IsHTML(true);
        $mail->Port =smtpPort;
        $mail->Subject =$subject;
        $mail->Body = $body;
        if (!$mail->Send()) 
        {
        	return false;
        }
        else 
        {
        	return true;
   	 	}
    }

    public static function load_groups()
    {
        $all_groups=array();
        $accessLevel=array();

        $sql = "SELECT * FROM `group` WHERE state <> 10";
        $qry=DB_query($sql,$b);

        if($result = $qry)
        {
            while ($row = DB_fetch_array($result))
            {
                $group=new group();
                $group->fromArray($row);
                $all_groups[$group->id]=$group;
            }
        }

        // $sql = "SELECT * FROM users WHERE state IN (1,3)";
        $sql = "SELECT  access_level.*, 
                        group_access_level_map.group_id as group_id
                        FROM `access_level`
                        INNER JOIN group_access_level_map on access_level.id = group_access_level_map.access_level_id 
                        WHERE access_level.state=1 and group_access_level_map.group_id IN (".join(",",array_keys($all_groups)).")";
        // echo $sql;
        $qry=DB_query($sql,$b);
        if($result = $qry)
        {
            while ($row = DB_fetch_array($result))
            {
                $access_level=new access_level();
                $access_level->fromArray($row);
                $all_groups[$access_level->group_id]->accessLevel[$access_level->id]=$access_level ;
            }
        }
        return $all_groups;
    }


    public static function load_access_levels()
    {
        $all_access_levels=array();
        $sql = "SELECT * FROM `access_level`";
        $qry=DB_query($sql,$b);

        if($result = $qry)
        {
            while ($row = DB_fetch_object($result))
            {
                $all_access_levels[]=$row;
            }
        }
        return $all_access_levels;
    }

    public static function load_user_sessions()
    {
        $all_user_sessions=array();
        $sql = "SELECT  user_session.*, user.username as username 
                        FROM user_session 
                        INNER JOIN user on user_session.user_id = user.id ";
        $qry=DB_query($sql,$b);

        if($result = $qry)
        {
            while ($row = DB_fetch_object($result))
            {
                $all_user_sessions[]=$row;
            }
        }
        return $all_user_sessions;
    }
}
?>