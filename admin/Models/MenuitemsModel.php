<?php


namespace Admin\Models;

/**
 * Class MenuitemsModel
 * @package Admin\Models
 */
class MenuitemsModel extends BaseModel
{
  protected $table = 'menuitems';
  protected $returnType = 'Admin\Models\Entities\Menuitem';
  protected $beforeInsert = ['beforeInsertTree'];
  protected $allowedFields = [
    'id',
    'title',
    'parent_id',
    'menu_id',
    'article_id',
    'category_id',
    'type',
    'url',
    'alias',
    'target',
    'layout',
    'li_class',
    'li_attributes',
    'a_class',
    'a_attributes',
    'lft',
    'rgt'
  ];

  /**
   * @param null $menu_id
   */
  public function findNodes($menu_id = null): array
  {
    $builder = $this->builder();
    $builder
      ->where('menu_id', $menu_id)
      ->groupBy('lft')
      ->orderBy('lft');
    return $builder
      ->get()
      ->getResultArray();
  }

  /**
   * creates a nested tree from the menuitems
   *
   * @param int $menu_id
   * @return mixed
   */
  public function findTree(int $menu_id)
  {
    $menuItems = $this->findNodes($menu_id);
    $nodes = [];
    foreach ($menuItems as $menuItem) {
      $nodes[$menuItem['id']] = $menuItem;
    }
    $nodes = array_reverse($nodes, true);
    foreach ($nodes as &$node) {
      $children = $this
        ->where('parent_id', $node['id'])
        ->groupBy('lft')
        ->orderBy('lft')
        ->findAll();
      foreach ($children as $child) {
        $nodes[$child->parent_id]['children'][$child->id] = $child->toArray();
      }
    }

    foreach ($nodes as &$item) {
      if ($item['parent_id']) {
        $nodes[$item['parent_id']]['children'][$item['id']] = $item;
      }
    }

    $tree = [];
    $nodes = array_reverse($nodes, true);
    foreach ($nodes as $parent) {
      if (!$parent['parent_id']) {
        $tree[] = $parent;
      }
    }

    return array_values($tree);
  }

  /**
   * Move an item up within
   * it's branch (lft/rgt borders)
   *
   * @param int|null $id the id of the item
   * @return bool
   */
  public function moveUp($id = null)
  {
    $nodeToMove = $this->find($id);
    return $this->_move($nodeToMove);
  }

  /**
   * move an item down within
   * it's branch (lft/rgt borders)
   *
   * @param int|null $id the id of the item
   * @return bool
   */
  public function moveDown($id)
  {
    $nodeToMove = $this->find($id);
    $lowerNode = $this
      ->where('lft', ($nodeToMove->rgt + 1))
      ->where('menu_id', $nodeToMove->menu_id)
      ->first();

    return $this->_move($lowerNode);
  }

  /**
   * Move node
   *
   * @param array|null|object $nodeToMove
   *
   * @return bool
   */
  private function _move($nodeToMove)
  {
    $upperNode = $this
      ->where('rgt', ($nodeToMove->lft - 1))
      ->where('menu_id', $nodeToMove->menu_id)
      ->first();

    // no item available? return;
    if (!$upperNode) {
      return true;
    }
    $lftDist = $nodeToMove->lft - $upperNode->lft;
    $rgtDist = $nodeToMove->rgt - $upperNode->rgt;

    $nodesToMoveUp = $this
      ->where("lft BETWEEN $nodeToMove->lft AND $nodeToMove->rgt")
      ->where('menu_id', $nodeToMove->menu_id)
      ->orderBy('lft')
      ->get()
      ->getResult();
    $nodesToMoveDown = $this
      ->where("lft BETWEEN $upperNode->lft AND $upperNode->rgt")
      ->where('menu_id', $nodeToMove->menu_id)
      ->orderBy('lft')
      ->get()
      ->getResult();

    try {
      // set lft/rgt for node in new pos
      foreach ($nodesToMoveUp as $node) {
        $node->lft = $node->lft - $lftDist;
        $node->rgt = $node->rgt - $lftDist;
        $this->save($node);
      }

      // set lft/rgt for node moved down
      foreach ($nodesToMoveDown as $node) {
        $node->lft = $node->lft + $rgtDist;
        $node->rgt = $node->rgt + $rgtDist;
        $this->save($node);
      }
    } catch (\Exception $exception) {
      return false;
    }

    return true;
  }


  /**
   * before delete handler
   * for deleting menuitems
   * - recover lft/rgt values
   * @param int $id
   * @param bool $removeTree whether to remove the complete branch
   * @return bool
   */
  public function removeFromTree($id, $removeTree = false)
  {
    /* einzelnes entfernen
     * DELETE FROM tree WHERE lft=3;
      UPDATE tree SET lft=lft-2 WHERE lft>4;
      UPDATE tree SET rgt=rgt-2 WHERE rgt>4;
     *
     * ganzen Baum löschen
     * DELETE FROM tree WHERE lft BETWEEN $LFT AND $RGT;
      UPDATE tree SET lft=lft-ROUND(($RGT-$LFT+1)) WHERE lft>$RGT;
      UPDATE tree SET rgt=rgt-ROUND(($RGT-$LFT+1)) WHERE rgt>$RGT;
     *
     * erhalten
     * DELETE FROM tree WHERE lft = $LFT;
      UPDATE tree SET lft=lft-1, rgt=rgt-1 WHERE lft BETWEEN $LFT AND $RGT;
      UPDATE tree SET lft=lft-2 WHERE lft>$RGT;
      UPDATE tree SET rgt=rgt-2 WHERE rgt>$RGT;
     */

    $builder = $this->builder();
    $item = $this->find($id);

    if (!$item) {
      return false;
    }

    $menuId = $item->menu_id;
    $rgt = $item->rgt;
    $lft = $item->lft;

    if ($rgt - $lft == 1) {
      // remove single
      $builder->delete("id={$item->id} AND menu_id = {$menuId}");
      $this->db->query("UPDATE menuitems SET lft=lft-2 WHERE lft>{$rgt} AND menu_id = {$menuId}");
      $this->db->query("UPDATE menuitems SET rgt=rgt-2 WHERE rgt>{$rgt} AND menu_id = {$menuId}");
      return true;
    } elseif (($rgt - $lft > 1) && $removeTree) {
      // remove tree
      $builder->delete("(lft BETWEEN $lft AND $rgt) AND menu_id = {$menuId}");
      $this->db->query(
        'UPDATE menuitems SET lft=lft-ROUND(' . ($rgt - $lft + 1) . ') WHERE lft>' . $rgt . ' AND menu_id = ' . $menuId
      );
      $this->db->query(
        'UPDATE menuitems SET rgt=rgt-ROUND(' . ($rgt - $lft + 1) . ') WHERE rgt>' . $rgt . ' AND menu_id = ' . $menuId
      );
      return true;
    } elseif (($rgt - $lft > 1) && !$removeTree) {
      // remove single but keep elements below the item
      $parentId = is_null($item->parent_id) ? 'NULL' : $item->parent_id;
      $builder->delete("id=$item->id AND menu_id = {$menuId}");
      $this->db->query(
        "UPDATE menuitems SET lft=lft-1, rgt=rgt-1, parent_id=$parentId WHERE lft BETWEEN $lft AND $rgt AND menu_id = {$menuId}"
      );
      $this->db->query("UPDATE menuitems SET lft=lft-2 WHERE lft>$rgt AND menu_id = {$menuId}");
      $this->db->query("UPDATE menuitems SET rgt=rgt-2 WHERE rgt>$rgt AND menu_id = {$menuId}");
    }
    return false;
  }

  /**
   * Update the tree before inserting
   * a new menuitem
   * @param array $data
   * @return array
   */
  protected function beforeInsertTree(array $data)
  {
    if (!isset($data['data']['parent_id']) || $data['data']['parent_id'] == '') {
      $menuId = $data['data']['menu_id'];
      $max = $this->select('max(rgt) as maxRgt')
        ->where('menu_id', $menuId)
        ->first();

      $data['data']['lft'] = $max->maxRgt + 1;
      $data['data']['rgt'] = $max->maxRgt + 2;
      if (!is_null($max->maxRgt)) {
        $this->db->query('UPDATE menuitems SET rgt=rgt+2 WHERE rgt > ' . $max->maxRgt . ' AND menu_id = ' . $menuId);
        $this->db->query('UPDATE menuitems SET lft=lft+2 WHERE lft > ' . $max->maxRgt . ' AND menu_id = ' . $menuId);
      }
    } else {
      $parentItem = $this->where('id', $data['data']['parent_id'])->first();
      $menuId = $parentItem->menu_id;
      $rgt = $parentItem->rgt;
      $data['data']['lft'] = $rgt;
      $data['data']['rgt'] = $rgt + 1;
      if ($parentItem) {
        $this->db->query('UPDATE menuitems SET rgt=rgt+2 WHERE rgt >= ' . $rgt . ' AND menu_id = ' . $menuId);
        $this->db->query('UPDATE menuitems SET lft=lft+2 WHERE lft > ' . $rgt . ' AND menu_id = ' . $menuId);
      }
    }

    return $data;
  }
}
