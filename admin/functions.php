<?php
    session_start([
        'cookie_lifetime' => time(),
    ]);
    include __DIR__ . "/config.php";
    include __DIR__ . "/src/Mysql.class.php";
    include __DIR__ . "/src/Article.class.php";
    include __DIR__ . "/src/User.class.php";
    include __DIR__ . "/src/SimpleImage.class.php";

    $config_pages = array('new', 'reviewed', 'published', 'old', 'categories', 'article', 'users', 'config', 'editor');
    $mysql = new Mysql($global_database_login, $global_database_password, $global_database_name);
    $A = new Article($mysql);
    $U = new User($mysql);

    $global_now = date('U');
    $global_success_msg = '';
    $global_error_msg = '';
    
    function getCurrentPage() {
        global $config_pages;
        
        $ret =  isset($_GET['page']) && in_array($_GET['page'], $config_pages) ? $_GET['page'] : $config_pages[0];
        
        if (isset($_GET['subpage'])) $ret .= "_" . $_GET['subpage'];
        
        return $ret;
    }
    
    function getBackUrl() {
        return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : getUrl();
    }
    
    function getURL($params = '')
    {
        $host = $_SERVER['HTTP_HOST'];
        $script = $_SERVER['SCRIPT_NAME'];
        //$params = $_SERVER['QUERY_STRING'] == '' ? '' : '?' . $_SERVER['QUERY_STRING'];

        return '//' . $host . $script . "?" . $params;
    }

    function getMainURL($params = '')
    {
        global $global_site_url;

        $ret = $global_site_url . '/' . $params;
        $ret = str_replace ("://", "@", $ret);
        $ret = str_replace ("//", "/", $ret);
        $ret = str_replace ("@", "://", $ret);

        return trim($ret, "/");
    }
    
    function redirectTo($url) {
        header("Location: {$url}");
        die();
    }
    
    function setSuccess($msg) {
        global $global_success_msg;
        
        $global_success_msg = $msg;
    }
    
    function setError($msg) {
        global $global_error_msg;
        
        $global_error_msg = $msg;
    }
    
    function getSuccess() {
        global $global_success_msg;
        return $global_success_msg;
    }
    
    function getError() {
        global $global_error_msg;
        return $global_error_msg;
    }

    function isLogged() {
        if(isset($_SESSION['user_login']) && isset($_COOKIE["user_id"])):
            global $U;
            $user = $U->getUser($_SESSION['user_id']);
            if(!$user):
                logout();
                return false;
            else:
                if($_COOKIE['session_id'] !== $user->password):
                    logout();
                    return false;
                endif;
            endif;
            return true;
        else:
            return false;
        endif;
    }

    function login($login = '', $id = 0, $password = '') {
        $_SESSION['user_login'] = $login;
        $_SESSION['user_id'] = $id;
        setcookie('user_id', $id, 2147483647);
        setcookie('session_id', $password, 2147483647);
        redirectTo(getUrl('page=new'));
    }

    function logout() {
        session_destroy();
        unset($_COOKIE['user_id']);
        unset($_COOKIE['session_id']);
        redirectTo(getUrl('page=login'));
    }
