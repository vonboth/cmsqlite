<?php


namespace Admin\Models;

/**
 * Class CategoriesModel
 * @package Admin\Models
 */
class CategoriesModel extends BaseModel
{
  protected $table = 'categories';
  protected $returnType = 'Admin\Models\Entities\Category';
  protected $allowedFields = [
    'name',
    'description',
    'is_system'
  ];

  /**
   * Find a list id => value for select lists
   * @return array
   */
  public function findList()
  {
    $return = [];
    $cats = $this->findAll();
    foreach ($cats as $cat) {
      $return[$cat->id] = $cat->name;
    }
    return $return;
  }
}
