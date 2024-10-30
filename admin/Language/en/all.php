<?php

return [
    'actions' => 'Actions',
    'add' => 'add',
    'back' => 'back',
    'cancel' => 'Cancel',
    'create' => 'Create',
    'created' => 'Created',
    'deleted' => 'Data deleted',
    'delete' => 'Delete',
    'delete_error' => 'Data not deleted',
    'edit' => 'Edit',
    'escape' => 'Escape',
    'no' => 'no',
    'new' => 'New',
    'readon' => 'read on ...',
    'save' => 'Save',
    'saved' => 'Data saved',
    'save_error' => 'Data not saved',
    'select' => 'Select',
    'start' => 'Start',
    'submit' => 'Submit',
    'updated' => 'Updated',
    'upload' => 'Upload',
    'view' => 'View',
    'yes' => 'yes',
    'admin' => [
        'welcome' => [
            'welcome_to_cmsqlite' => 'Welcome to CMSQLite',
            'next_steps' => 'Next Steps',
            'edit_startpage' => 'Edit Frontpage',
            'create_page' => 'Create New Page',
            'view_website' => 'Visit Your Website',
            'other_actions' => 'More Options',
            'edit_menus' => 'Edit Menus',
            'media_admin' => 'Manage Images',
            'edit_profile' => 'Edit Your Profile'
        ],
        'last_loggedin_users' => 'Last Loggedin Users',
        'last_edited_articles' => 'Last Updated Articles',
        'top_articles' => 'Top Articles',
        'reset_hits' => 'Reset Hits',
        'success_reset_hits' => 'All Hits Reset',
        'failed_reset_hits' => 'Hits Could Not Be Reset',
        'no_data' => 'No Data',
        'remove_install_folder' => 'Security warning: remove the installation folder!',
    ],
    'errors' => [
        [
            'no_content' => 'The entity is empty or does not exist',
        ]
    ],
    'media' => [
        'file_delete_success' => 'file deleted successfully',
        'dir_delete_success' => 'directory deleted successfully',
        'file_delete_error' => 'file was not deleted',
        'dir_delete_error' => 'directory was not deleted',
        'dir_not_empty' => 'directory not deleted. not empty?',
        'upload_file' => 'Upload file',
        'media_content' => 'Directory Content',
        'file_not_exist' => 'The file does not exist',
        'dir_not_exist' => 'Directory does not exist',
        'file_name' => 'name',
        'file_size' => 'size',
        'upload_success' => 'upload successful',
        'upload_error' => 'failed to upload file',
        'invalid_file' => 'invalid file submitted',
        'filetype_not_allowed' => 'the upload of this file type is not allowed',
        'mimetype_not_allowed' => 'the mime type of the upload file is not allowed',
        'create_folder' => 'Create new folder',
        'folder_name' => 'Folder name',
        'create_dir_success' => 'Folder created successfully',
        'create_dir_error' => 'Failed to create new folder',
        'empty_dir' => 'Empty Directory',
        'browse_files' => 'browse files',
        'upload_warning' => 'Heads up! All uploaded files are available to the public!'
    ],
    'menu' => [
        'startpage' => 'Start page',
        'articles' => 'Articles',
        'categories' => 'Categories',
        'media' => 'Media',
        'menus' => 'Menus',
        'users' => 'Users',
        'settings' => 'Settings',
        'system' => 'System',
        'add_menu' => 'Add menu',
        'add_menu_item' => 'Add menu item',
        'edit_menu_item' => 'Edit menu item',
        'delete_menu_item' => 'Delete menu item',
        'node_move_success' => 'Node moved successfully',
        'node_move_error' => 'Failed to move node',
        'move_item_up' => 'Move item up',
        'move_item_down' => 'Move item down',
        'self' => 'Same Window',
        'blank' => 'New Window',
    ],
    'user' => [
        'login' => 'Login',
        'username' => 'Username',
        'password' => 'Password',
        'logout' => 'Logout',
        'my_profile' => 'My Profile'
    ],
    'validation' => [
        'auth_failed' => 'Username and/or password wrong',
        'article_required' => 'The field "article" is required if you choose type "article"',
        'cateogry_required' => 'The field "category" is required if you choose type "category"',
        'url_required' => 'The field "url" is required if you choose type "other"',
        'password_length' => 'Passwors must be at least {param} characters long',
        'password_rule' => 'Passwords must be at least {param} characters long and must contain upper case characters, numbers and special characters (%$&!§)',
        'required' => 'Field "{field}" is required',
        'check_required' => 'Please fill in all required fields',
    ]
];
