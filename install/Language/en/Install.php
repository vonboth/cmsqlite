<?php

return [
    'installation_routine' => 'CMSQLite Installation',
    'step' => 'Setp',
    'next' => 'Next',
    'back' => 'Back',
    'done' => 'Done',
    'directory_check' => 'Directory Check',
    'database_writable' => 'Database Is Writable',
    'database_not_writable' => 'Database Is Not Writable',
    'directory_writable' => 'Directory "{0}" Is Writable ({1})',
    'directory_not_writable' => 'Directory "{0}" Is Not Writable ({1})',
    'set_admin_user' => 'Administrator Credentials',
    'username' => 'Username',
    'email' => 'Email',
    'password' => 'Password',
    'password_confirm' => 'Confirm Password',
    'firstname' => 'First Name',
    'lastname' => 'Last Name',
    'saved' => 'Data Saved',
    'save_error' => 'Error While Saving Data',
    'success' => 'Installation Successful',
    'website_settings' => 'Website Settings',
    'base_url' => 'Website Address',
    'base_url_placeholder' => 'https://www.my-domain.com',
    'base_url_help' => 'Enter the address of your website in the format "https://www.meine-seite.de"',
    'language' => 'Default Language',
    'language_help' => 'Enter the default language of your website, e.g. "de" or "en"',
    'timezone' => 'Timezone',
    'timezone_help' => 'Enter the timezone for your website, e.g. "Europe/Berlin"',
    'invalid_data' => 'You have entered invalid data',
    'root_not_writable' => 'We could not write an important installation file!',
    'create_file' => 'Create a .env file!',
    'create_file_text' => 'Create a file named ".env" on your PC. Copy the following text into this file ' .
        'and upload the file using a FTP program to the root path of your installation.',
    'env_file_note' => 'CMSQLite will not work properly until you uploaded the required file',
    'recommend_delete_install' => 'We recommend to delete the directory "install" due to security reasons!',
    'permission_explanation' => 'If any of the above mentioned folders is not writable CMSQLite will not function. ' .
        'Set the rights (chmod) to 777 for all of the above listed folders or change the group rights.',
    'password_help' => 'Must be at least 8 chars long must contain upper case chars, numbers and special chars one of: %$&!§'
];