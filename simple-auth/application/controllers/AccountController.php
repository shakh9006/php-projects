<?php

namespace application\controllers;

use core\base\Controller;
use core\db\DatabaseBuilder;

/**
 * Class AuthController
 * @package application\controllers
 */
class AccountController extends Controller {
    public function loginAction() {

        if ( !empty($_SESSION['id']) ) {
            header('Location:'.  SITE_URL);
            die;
        } else {
            $this->view('auth/login');
        }
    }

    public function registerAction() {
        if ( !empty($_SESSION['id']) ) {
            header('Location:'.  SITE_URL);
        } else {
            $this->view('auth/register');
        }
    }

    public function sign_in() {
        $result = [
            'info'    => [],
            'success' => true,
            'errors'  => []
        ];

        $email = !empty($_GET['email']) ? $_GET['email'] : '';
        $pass  = !empty($_GET['password']) ? $_GET['password'] : '';

        if ( empty( $email ) || empty( $pass ) ) {
            $result['success'] = false;
            $result['errors'][] = 'Invalid password or email';
            echo json_encode($result);
            die;
        }

        if ( $data = DatabaseBuilder::user_can_login($email, $pass) ) {
            $_SESSION['loggedin'] = true;
            $_SESSION['name']     = $data['username'];
            $_SESSION['id']       = $data['id'];
            $result['success']    = true;
            $result['info'][]     = 'Welcome, again ' . $data['username'] ;
            $result['redirect']   = SITE_URL . 'profile/' .  $data['id'];
        }

        echo json_encode( $result );
        die;
    }

    public function sign_up() {

        $result = [
            'info'    => [],
            'success' => true,
            'errors'  => []
        ];

        $name  = !empty($_GET['name']) ? $_GET['name'] : '';
        $email = !empty($_GET['email']) ? $_GET['email'] : '';
        $pass  = !empty($_GET['password']) ? $_GET['password'] : '';

        if ( empty( $name ) || empty( $email ) || empty( $pass ) ) {
            $result['success'] = false;
            $result['errors'][] = 'Something went wrong, Please try again';
            echo json_encode($result);
            die;
        }

        if ( DatabaseBuilder::email_exist( $email ) ) {
            $result['success'] = false;
            $result['errors'][] = 'Email already exist';
            echo json_encode($result);
            die;
        }

        if ( $data = DatabaseBuilder::create_user($name, $pass, $email) ) {
            $result['info'][]   = 'User created successfully';
            $result['redirect'] = SITE_URL . 'profile/' .  $data['id'];
            session_regenerate_id();
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $name;
            $_SESSION['id'] = $data['id'];
        }
        echo json_encode($result);
        die;
    }

    public function profile() {
        $id = $this->get_param('id');

        if ( $id !== $_SESSION['id'] ) {
            header('Location:' . SITE_URL . 'register');
            die;
        }

        if ( $data = DatabaseBuilder::select_by_id($id) ) {
            $this->view('auth/profile', ['data' => $data]);
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        // Redirect to the login page:
        header('Location: '. SITE_URL . '/login');
    }
}