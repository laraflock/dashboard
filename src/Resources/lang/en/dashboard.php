<?php

/**
 * @package     Dashboard
 * @author      Ian Olson <me@ianolson.io>
 * @license     MIT
 * @copyright   2015, Laraflock
 * @link        https://github.com/laraflock
 */

return [
    'global'       => [
        'title'           => config('laraflock.dashboard.title'),
        'small_title'     => config('laraflock.dashboard.smallTitle'),
        'version'         => 'Version',
        'copyright'       => 'Copyright',
        'rights_reserved' => 'All rights reserved.',
        'version_num'     => config('laraflock.dashboard.version'),
        'credits'         => config('laraflock.dashboard.credits'),
        'toggle_nav'      => 'Toggle Navigation',
        'actions'         => 'Actions',
    ],
    'flash'        => [
        'access_denied' => 'Access Denied',
        'account'       => [
            'success' => 'Account successfully updated.',
        ],
        'password'      => [
            'fail'    => 'Old password is incorrect.',
            'success' => 'Password successfully updated.',
        ],
        'registration'  => [
            'not_active' => 'Registration is not active. Please login.',
            'activated'  => 'Account activated. Please login below.',
            'created'    => 'Account created. Activation needed, please check your email.',
        ],
        'activation'    => [
            'not_active' => 'Activations are not active. Please login.',
            'success'    => 'Account successfully activated.',
        ],
        'permission'    => [
            'create' => [
                'success' => 'Permission successfully created.',
            ],
            'edit'   => [
                'success' => 'Permission successfully updated.',
            ],
            'delete' => [
                'success' => 'Permission successfully deleted.',
            ],
        ],
        'role'          => [
            'create' => [
                'success' => 'Role successfully created.',
            ],
            'edit'   => [
                'success' => 'Role successfully updated.',
            ],
            'delete' => [
                'success' => 'Role successfully deleted.',
            ],
        ],
        'user'          => [
            'create' => [
                'success' => 'User successfully created.',
            ],
            'edit'   => [
                'success' => 'User successfully updated.',
            ],
            'delete' => [
                'success' => 'User successfully deleted.',
            ],
        ],
    ],
    'form'         => [
        'name'                         => 'Name',
        'slug'                         => 'Slug',
        'permissions'                  => 'Permissions',
        'first_name'                   => 'First Name',
        'last_name'                    => 'Last Name',
        'email'                        => 'E-mail',
        'email_placeholder'            => 'E-mail address',
        'password'                     => 'Password',
        'password_placeholder'         => 'Password',
        'confirm_password'             => 'Confirm Password',
        'confirm_password_placeholder' => 'Confirm Password',
        'old_password'                 => 'Old Password',
        'new_password'                 => 'New Password',
        'role'                         => 'Role',
        'current'                      => 'Current',
        'activation_code'              => 'Activation Code',
        'activation_code_placeholder'  => 'Enter Code Here',
        'remember_me'                  => 'Remember me',
    ],
    'table'        => [
        'id'         => 'ID',
        'name'       => 'Name',
        'slug'       => 'Slug',
        'first_name' => 'First',
        'last_name'  => 'Last',
        'email'      => 'E-mail',
        'role'       => 'Role',
        'actions'    => 'Actions',
    ],
    'buttons'      => [
        'update_account'  => 'Update Account',
        'change_password' => 'Change Password',
        'activate'        => 'Activate',
        'login'           => 'Login',
        'register'        => 'Register',
        'profile'         => 'Profile',
        'logout'          => 'Sign Out',
        'save'            => 'Save',
        'reset'           => 'Reset',
        'delete'          => 'Delete',
        'edit'            => 'Edit',
    ],
    'account'      => [
        'title'              => 'Edit Profile - Dashboard',
        'page_title'         => 'Profile',
        'page_subtitle'      => 'Edit',
        'edit_profile_title' => 'Edit Account',
        'change_pass_title'  => 'Change Password',
    ],
    'activate'     => [
        'title'       => 'Activate Account - Dashboard',
        'form_title'  => 'Activate Account',
        'resend_code' => 'Resend Code?',
    ],
    'login'        => [
        'title'       => 'Login - Dashboard',
        'form_title'  => 'Login',
        'forgot_pass' => 'I forgot my password',
        'register'    => 'Register a new membership',
    ],
    'register'     => [
        'title'        => 'Register - Dashboard',
        'form_title'   => 'Register',
        'have_account' => 'Have an account?',
        'login'        => 'Sign In',
    ],
    'unauthorized' => [
        'title'   => 'Access Denied - Dashboard',
        'access'  => 'Unauthorized Access',
        'message' => 'There was an error with your request.',
    ],
    'dashboard'    => [
        'title'     => 'Dashboard',
        'page_title' => 'Dashboard',
    ],
    'header'       => [
        'member_since' => 'Member since',
    ],
    'layouts'      => [

    ],
    'permissions'  => [
        'all'    => [
            'title'         => 'Permissions - Dashboard',
            'page_title'    => 'Permissions',
            'page_subtitle' => 'All Permissions',
            'table_title'   => 'Permissions',
        ],
        'create' => [
            'title'         => 'Add New Permission - Dashboard',
            'page_title'    => 'Permissions',
            'page_subtitle' => 'Create',
        ],
        'edit'   => [
            'title'         => 'Edit Permission - Dashboard',
            'page_title'    => 'Permissions',
            'page_subtitle' => 'Edit',
        ],
    ],
    'roles'        => [
        'all'    => [
            'title'         => 'Roles - Dashboard',
            'page_title'    => 'Roles',
            'page_subtitle' => 'All Roles',
            'table_title'   => 'Roles',
        ],
        'create' => [
            'title'         => 'Add New Role - Dashboard',
            'page_title'    => 'Roles',
            'page_subtitle' => 'Create',
        ],
        'edit'   => [
            'title'         => 'Edit Role - Dashboard',
            'page_title'    => 'Roles',
            'page_subtitle' => 'Edit',
        ],
    ],
    'users'        => [
        'all'    => [
            'title'         => 'Users - Dashboard',
            'page_title'    => 'Users',
            'page_subtitle' => 'All Users',
            'table_title'   => 'Users',
        ],
        'create' => [
            'title'         => 'Add New User - Dashboard',
            'page_title'    => 'Users',
            'page_subtitle' => 'Create',
        ],
        'edit'   => [
            'title'         => 'Edit User - Dashboard',
            'page_title'    => 'Users',
            'page_subtitle' => 'Edit',
        ],
    ],
    'nav'          => [
        'dividers'   => [
            'main' => 'MAIN NAVIGATION',
            'user' => 'USER MANAGEMENT',
        ],
        'dashboard'  => 'Dashboard',
        'permission' => [
            'title'  => 'Permissions',
            'all'    => 'All Permissions',
            'create' => 'Add New Permission',
        ],
        'role'       => [
            'title'  => 'Roles',
            'all'    => 'All Roles',
            'create' => 'Add New Role',
        ],
        'user'       => [
            'title'  => 'Users',
            'all'    => 'All Users',
            'create' => 'Add New User',
        ],
    ],
    'errors'       => [
        'auth'       => [
            'incorrect'  => 'Email \ Password combination incorrect.',
            'create'     => 'User could not be created.',
            'activation' => [
                'create'   => 'Activation could not be created.',
                'complete' => 'Activation could not be completed.',
            ],
        ],
        'form'       => [
            'validation' => 'Fix errors in the form below.',
        ],
        'permission' => [
            'create' => 'Permission could not be created.',
            'found'  => 'Permission could not be found.',
        ],
        'role'       => [
            'create' => 'Role could not be created.',
            'found'  => 'Role could not be found.',
        ],
        'user'       => [
            'found' => 'User could not be found.',
        ],
    ],
];