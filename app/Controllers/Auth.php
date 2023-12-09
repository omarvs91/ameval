<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function login() {
        return view('login');
    }
    public function authenticate() {
        if ($this->request->getMethod() === 'post') {
            // Handle user login here
            $data = $this->request->getPost();
            $userModel = new \App\Models\User();
            $user = $userModel->where('username', $data['username'])->first();
            
            if ($user && $user['habilitado'] == 1 && 
                $user['password'] === md5(sha1($data['password']))) {
                // Successful login
                // Set user session or token
                // Example for session:
                session()->set('user_id', $user['id']);
                session()->set('username', $user['username']);
                session()->set('role_id', $user['role_id']);
                return redirect()->to('/');
            } else {
                // Login failed, show errors or set an error message
                return redirect()->to('/login');
            }
        }
    }
    public function logout() {
        // Destroy the session
        session()->destroy();
        
        // Redirect to the login page
        return redirect()->to('/login');
    }
}
