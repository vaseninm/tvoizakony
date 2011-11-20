<?php
/**
 * ETreeBehavior class
 *
 * @author Sergey S. <feedback@blog-programmista.ru>
 * @version: 0.9.1 beta
 * @link http://blog-programmista.ru/
 */

class ETreeBehavior extends CActiveRecordBehavior
{
	/**
	 * Cascade delete flag
	 * 
	 * @var boolean
	 */
	public $deleteCascade = false; // TODO
	
	/**
	 * Parent id attribute name
	 * 
	 * @var string
	 */
	public $parentAttribude = 'pid';
	
	/**
	 * Position attribute name
	 * 
	 * @var string
	 */
	public $orderAttribude = 'position';
		
	/**
	 * Get children
	 * 
	 * @param array|CDbCriteria|null $criteria
	 * @return array
	 */
	public function children($criteria = null)
	{
		$owner = $this->getOwner();
		$_criteria = $this->makeCriteria($criteria);
		$_criteria->addCondition($this->parentAttribude . ' = :pid');
		$_criteria->params[':pid'] = $owner->getPrimaryKey();
		if ($_criteria->order === null) $_criteria->order = $this->orderAttribude;
		return $owner->findAll($_criteria);
	}		
	
	/**
	 * Get parent node
	 * 
	 * @param array|CDbCriteria|null $criteria
	 * @return CActiveRecord|null
	 */
	public function parent($criteria = null)
	{
		$owner = $this->getOwner();
		$_criteria = $this->makeCriteria($criteria);
		$pk = $owner->primaryKey();
		$_criteria->addCondition($pk . ' = :id');
		$_criteria->params[':id'] = $owner->{$this->parentAttribude};		
		return $owner->find($_criteria);
	}
	
	/**
	 * Get path from current node to root
	 * 
	 * @param array|CDbCriteria|null $criteria
	 * @param integer|null $breackOnNodeId
	 * @return array
	 */
	public function path($criteria = null, $breackOnNodeId = null)
	{
		$owner = $this->getOwner();
		$path = array();
		$parent = $this->parent($criteria);
		while ($parent !== null) {
			$path[] = $parent;
			if ($parent->id == $breackOnNodeId) break;
			$parent = $parent->parent($criteria);
		}
		return array_reverse($path);
	}
	
	/**
	 * Get branch of node
	 * 
	 * @param array|CDbCriteria|null $criteria
	 * @param integer|null $depth
	 * @param boolean $returnAsNestedArrays
	 * @return array
	 */
	public function branch($criteria = null, $depth = null, $returnAsNestedArrays = false)
	{
		if ($depth !== null && $depth <= 0) throw new CException(Yii::t('yiiext', 'Depth value="{depth}" is wrong.', array('{depth}' => $depth)));
		$owner = $this->getOwner();
		$_criteria = $this->makeCriteria($criteria);
		$_criteria->order = $this->orderAttribude;		
		$children = $this->children($_criteria);		
		return $this->createHierarchy($children, $criteria, $depth, $returnAsNestedArrays);
	}
	
	/**
	 * Get tree
	 * 
	 * @param array|CDbCriteria|null $criteria
	 * @param integer|null $depth
	 * @param boolean $returnAsNestedArrays
	 */
	public function tree($criteria = null, $depth = null, $returnAsNestedArrays = false)
	{
		if ($depth !== null && $depth <= 0) throw new CException(Yii::t('yiiext', 'Depth value="{depth}" is wrong.', array('{depth}' => $depth)));
		$owner = $this->getOwner();
		$_criteria = $this->makeCriteria($criteria);
		$_criteria->addCondition($this->parentAttribude . ' = 0');
		$_criteria->order = $this->orderAttribude;
		$nodes = $owner->findAll($_criteria);		
		return $this->createHierarchy($nodes, $criteria, $depth, $returnAsNestedArrays);
	}
	
	/**
	 * Sort nodes
	 * 
	 * @param array $order 
	 */
	public function order(array $order)
	{
		$position = 0;
		$owner = $this->getOwner();
		$command = $owner->dbConnection->createCommand();
		$pk = $owner->primaryKey();
		foreach ($order as $pkValue) {
			$command->update($owner->tableName(), array($this->orderAttribude => $position), $pk . ' = :pk', array(':pk' => $pkValue));
			$position++;
		}
	}
	
	/**
	 * Append node to parent
	 * 
	 * @param CActiveRecord $target
	 * @param boolean $save
	 * @return boolean
	 */
	public function appendTo($target, $save = true)
	{
		if ($target->isNewRecord) throw new CException(Yii::t('yiiext', 'Can\'t append node because target node is new.')); 
		$owner = $this->getOwner();
		$parentAttribude = $this->parentAttribude;
		$pk = $target->primaryKey();		
		$owner->$parentAttribude = $target->$pk;
		if ($save == true) {
			return $owner->save();
		} else {
			return true;
		}
	}
	
	/**
	 * Set this node as root
	 * 
	 * @param boolean $save
	 * @return boolean
	 */
	public function setAsRoot($save = true)
	{
		$owner = $this->getOwner();
		$owner->$parentAttribude = 0;
		if ($save == true) {
			return $owner->save();
		} else {
			return true;
		}
	}
	
	/**
	 * Create hierarchy
	 * 
	 * @param array $nodes
	 * @param array|CDbCriteria|null $criteria
	 * @param integer|null $depth
	 * @param boolean $returnAsNestedArrays
	 * @return array
	 */
	protected function createHierarchy(array $nodes, $criteria, $depth, $returnAsNestedArrays)
	{
		$recursion = $depth > 1 || $depth === null;
		$array = array();
		foreach ($nodes as $node) {
			if ($recursion) {
				$branch = $node->branch($criteria, $depth, $returnAsNestedArrays);				
				if ($returnAsNestedArrays) {
					$array[] = array($node, 'children' => $branch);
				} else {
					$array[] = $node;
					foreach ($branch as $branchNode) $array[] = $branchNode; 
				}
			} else {
				if ($returnAsNestedArrays ==  true) $node = array($node, 'children' => array());
				$array[] = $node;
			}
		}
		return $array;
	}

	/**
	 * Make criteria
	 * 
	 * @param array|CDbCriteria|null $criteria
	 * @return CDbCriteria
	 */
	protected function makeCriteria($criteria)
	{
		if (is_array($criteria)) {
			$_criteria = new CDbCriteria($criteria);
		} else if ($criteria instanceof CDbCriteria) {
			$_criteria = clone $criteria;
		} else if ($criteria === null) {
			$_criteria = new CDbCriteria();
		} else {
			throw new CException(Yii::t('yiiext', 'Wrong criteria param.'));
		}
		return $_criteria;
	}	
}