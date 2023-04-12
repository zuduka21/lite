<?php

final class User {
    private $mysql;
    public $users;
    const ADMINISTRATOR = 1;
    const AUTHOR = 2;
    const EDITOR = 3;

    /**
     * User constructor.
     * @param $mysql
     */
    public function __construct ($mysql)
    {
        date_default_timezone_set ('Europe/Moscow');

        $this->mysql = $mysql;
    }

    /**
     * @param int $user_id
     * @return mixed
     */
    public function getRole($role_id) {
        switch ($role_id):
            case(self::ADMINISTRATOR):
                return 'Администратор';
                break;
            case(self::AUTHOR):
                return 'Автор';
                break;
            case(self::EDITOR):
                return 'Редактор';
                break;
            default:
                return '—';
                break;
        endswitch;
    }

    public function getUsers($params = []) {
        $res = $this->mysql->getQuery("SELECT * FROM  `users` ORDER BY `users`.`id` ASC");

        foreach ($res as $i) $this->users[$i->id] = $i;
        return $this->users;
    }

    public function getUser($id) {
        $res = $this->mysql->getQuery("SELECT * FROM  `users` WHERE `id` = '{$id}' LIMIT 1");
        $ret = [];

        if ($res && isset($res[0])) {
            $ret = $res[0];
        }

        return $ret;
    }

    public function getUserByLogin($login) {
        $res = $this->mysql->getQuery("SELECT * FROM  `users` WHERE `login` = '{$login}' LIMIT 1");

        if ($res && isset($res[0])) {
            $ret = $res[0];
        }else{
            $ret = false;
        }

        return $ret;
    }

    public function getLogin($id = 0 ) {
        $res = $this->mysql->getQuery("SELECT login FROM  `users` WHERE `id` = '{$id}'");
        $ret = [];

        if ($res && isset($res[0])) {
            $ret = $res[0]->login;
        }else{
            $ret = '—';
        }

        return $ret;
    }

    public function getRoleId($id = 0) {
        $res = $this->mysql->getQuery("SELECT role_id FROM `users` WHERE `id` = '{$id}'");
        $ret = [];

        if ($res && isset($res[0])) {
            $ret = $res[0]->role_id;
        }else{
            $ret = false;
        }

        return $ret;
    }

    public function getName($id = 0) {
        if($this->users && $this->users[$id]):
            return $this->users[$id]->firstname . ' ' . $this->users[$id]->lastname;
        else:
            $user = $this->getUser($id);
            return $user->firstname . ' ' . $user->lastname;
        endif;
    }

    public function isAdmin($id = 0) {
        $id = ($id ?: isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0);
        if((int)$this->getRoleId($id) === self::ADMINISTRATOR):
            return true;
        else:
            return false;
        endif;
    }

    public function isAuthor($id = 0) {
        $id = ($id ?: isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0);
        if((int)$this->getRoleId($id) === self::AUTHOR):
            return true;
        else:
            return false;
        endif;
    }

    public function isEditor($id = 0) {
        $id = ($id ?: isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0);
        if((int)$this->getRoleId($id) === self::EDITOR):
            return true;
        else:
            return false;
        endif;
    }

}