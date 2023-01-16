<?php


namespace Admin\Config;


class Validation extends \Config\Validation
{
  /**
   * @inheritdoc
   */
  public array $templates = [
    'list' => 'Admin\Validation\list',
    'single' => 'CodeIgniter\Validation\Views\single',
  ];
}
