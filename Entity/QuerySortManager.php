<?php

namespace MQM\SortBundle\Entity;

use MQM\SortBundle\Sort\SortManagerInterface;

class QuerySortManager implements SortManagerInterface
{
    private $sortManager;

    public function __construct(SortManagerInterface $sortManager)
    {
        $this->sortManager = $sortManager;
    }
    
    public function init(array $sorts = null)
    {
        $this->sortManager->init($sorts);
        
        return $this;
    }
    
    public function sortQuery($query, $entityAlias = '')
    {
        if ($query == null) 
            return null;
        
        $currentSort = $this->getCurrentSort();
        $field = $currentSort->getField($entityAlias);
        if (is_string($query)) {
            $query .= ' ORDER BY ' . $field . ' ' . $currentSort->getMode();
        }
        else if (is_a($query, 'Doctrine\ORM\QueryBuilder')){
            $query->add('orderBy', $field . ' ' . $currentSort->getMode());
        }
        else if (is_a($query, 'Doctrine\ORM\Query')) {
            $dql = $query->getDQL();
            $dql .= ' ORDER BY ' . $field . ' ' . $currentSort->getMode();
            $query->setDQL($dql);
        }
        else {
            throw new \Exception('Type of query not supported, it must be of type string or Doctrine\DBAL\Query\QueryBuilder');
        }
        
        return $query;
    }


    public function addSort($id, $field, $name, $mode = self::ASC, array $options = array())
    {
        $this->sortManager->addSort($id, $field, $name, $mode, $options);
        
        return $this;
    }

    public function getCurrentSort()
    {
        return $this->sortManager->getCurrentSort();        
    }

    public function getSorts()
    {
        return $this->sortManager->getSorts();
    }

    public function setCurrentSort($currentSort)
    {
        $this->sortManager->setCurrentSort($currentSort);
        
        return $this;
    }

    public function switchMode()
    {
        $this->sortManager->switchMode();
        
        return $this;
    }
}
