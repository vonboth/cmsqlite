<?php

use Config\Services;

/**
 * Render errors from the Admin section in the View
 * @return string
 */
function render_errors(): string
{
  return (Services::renderer())
    ->setVar('errors', validation_errors())
    ->render('Admin\Validation\list');
}
