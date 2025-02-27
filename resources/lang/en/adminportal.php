<?php

return [
     'auth' => [
          'login' => [
               'title' => 'Log In',
               'description' => 'Enter your email and password below to log into your account',
               'failed' => 'Email or password is invalid. Please try again.',
          ],
          'sigup' => [
               'title' => 'Sign Up',
               'description' => 'Enter your email and password to create an account.',
          ],
          'verification' => [
               'title' => 'Verify Your Email',
               'description' => "Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another."
          ],
          'forgot_password' => [
               'title' => 'Forgot Password',
               'continue' => 'Continue',
               'description' => 'Enter your registered email and we will send you a link to reset your password.',
               'mailed_link' => 'We have emailed your password reset link.'
          ],
          'reset_password' => [
               'title' => 'Reset Password',
               'description' => "Enter your new password below to reset your account access. Make sure to choose a strong password that you haven't used before."
          ]
     ],

     'form' => [
          'email' => 'Email Address',
          'current_password' => 'Current Password',
          'new_password' => 'New Password',
          'password' => 'Password',
          'password_confirmation' => 'Confirm Password',
          'name' => 'Name'
     ],

     'label' => [
          'dont_have_an_account' => "Don't have an account ?",
          'have_an_account' => "Already have an account?",
          'resend_verification_email' => "Resend Verification Email",
          'login_with_another_acount' => 'Try with another account?',
          "logout" => "Logout",
          'link_verification_expired' => 'Your verification link has expired. Please request a new one.',
     ],

     'expose' => [
          'create_data_module' => 'Create New :module',
          'create_data_module_description' => "Create new :module here. Click save when you're done.",
          'edit_module' => 'Edit :module',
          'edit_data_module_description' => "Update your :module here. Click save when you're done."
     ],

     'alert' => [
          'data_created' => 'Your data has been successfully created!',
          'data_updated' => 'Your data has been successfully updated!',
          'data_deleted' => 'Your data has been successfully deleted!',
          'bulk_action_success' => 'Your selected data has been successfully ":action"!',
          'profile_updated' => 'Your profile has been successfully updated!',
          'password_updated' => 'Your password has been successfully updated!',
          'import_success' => 'Your data has been successfully imported!',
          'confirmation' => [
               'logout_title' => 'Logout !',
               'logout_description' => 'Are you sure you want to leave this page?',
               'delete_title' => 'Are you sure you want to delete this data?',
               'delete_description' => 'This action will permanently remove the data from the system. This cannot be undone.'
          ]
     ],
     'export' => 'Export',
     'import' => 'Import',
     'create' => 'Create',
     'filter' => 'Filter',
     'reset' => 'Reset',
     'apply' => 'Apply',
     'bulk_actions' => 'Bulk Actions',
     'action' => 'Action',
     'cancel' => 'Cancel',
     'save' => 'Save Changes',
     'continue' => 'Continue'
];