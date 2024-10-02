<?php

namespace Admin\Models\Traits;


use Admin\Models\ArticlesModel;
use Admin\Models\Entities\Article;
use Admin\Models\Entities\Base;

trait RelationsTrait
{
    /**
     * @var array $with relations to capture
     */
    protected array $_with = [];

    private array $_hasOne = [];

    private array $_belongsTo = [];

    private array $_hasMany = [];

    /**
     * @param string|array $relation
     * @return Article|ArticlesModel|RelationsTrait
     */
    public function with(string|array $relation): self
    {
        if (is_array($relation)) {
            $this->_with = array_merge($this->_with, $relation);
        } elseif (is_string($relation) && !in_array($relation, $this->_with)) {
            $this->_with[] = $relation;
        }

        return $this;
    }

    /**
     * ad
     * @param string $table
     * @param array $options
     * @return $this
     */
    public function hasOne(string $table, array $options)
    {
        if (!isset($this->_hasOne[$table])) {
            $this->_hasOne[$table] = $options;
        }

        return $this;
    }

    /**
     * @param string $table
     * @param array $options
     * @return $this
     */
    public function belongsTo(string $table, array $options)
    {
        if (!isset($this->_belongsTo[$table])) {
            $this->_belongsTo[$table] = $options;
        }

        return $this;
    }

    /**
     * @param string $table
     * @param array $options
     * @return $this
     */
    public function hasMany(string $table, array $options)
    {
        if (!isset($this->_hasMany[$table])) {
            $this->_hasMany[$table] = $options;
        }

        return $this;
    }

    /**
     * Overwriting the find method to add relations
     * @param array|int|string|null $id
     * @return false|mixed|null
     */
    public function find($id = null)
    {
        $rows = parent::find($id);

        if (is_numeric($id) || is_string($id)) {
            $rows = $this->addRelations([$rows]);

            return reset($rows);
        }

        return $this->addRelations($rows);
    }

    /**
     * Overwriting the findAll method to add relations
     * @param int|null $limit
     * @param int $offset
     * @return array|null
     */
    public function findAll(int $limit = null, int $offset = 0)
    {
        $rows = parent::findAll($limit, $offset);

        return $this->addRelations($rows);
    }

    /**
     * Overwriting the first method to add relations
     * @return array|object|null
     */
    public function first()
    {
        $row = parent::first();

        // For singletons, wrap them as a one-item array and then unwrap on return
        $data = $this->addRelations([$row]);

        return reset($data);
    }

    /**
     * Add relational data to the entites
     * @param array $rows
     * @return array|object|null
     */
    public function addRelations(array $rows): ?array
    {
        foreach ($this->_hasOne as $table => $options) {
            $singular = strtolower(singular($table));
            if (in_array($table, $this->_with) || in_array($singular, $this->_with)) {
                $query = $this->builder($table);
                foreach ($rows as $row) {
                    if (isset($options['finder']) && is_callable($options['finder'])) {
                        $row->{$singular} = $options['finder']($query, $row->{$options['foreign_key']});
                    } else {
                        $type = $options['entity'] ?? 'object';
                        $row->{$singular} = $query->where('id', $row->{$options['foreign_key']})
                            ->get()
                            ->getFirstRow($type);
                    }
                }
            }
        }

        foreach ($this->_belongsTo as $table => $options) {
            $singular = strtolower(singular($table));
            if (in_array($table, $this->_with) || in_array($singular, $this->_with)) {
                $query = $this->builder($table);
                foreach ($rows as $row) {
                    if (isset($options['finder']) && is_callable($options['finder'])) {
                        $row->{$singular} = $options['finder']($query, $row->{$options['foreign_key']});
                    } else {
                        $type = $options['entity'] ?? 'object';
                        $row->{$singular} = $query->where('id', $row->{$options['foreign_key']})
                            ->get()
                            ->getFirstRow($type);
                    }
                }
            }
        }

        foreach ($this->_hasMany as $table => $options) {
            if (in_array($table, $this->_with)) {
                $query = $this->builder($table);
                foreach ($rows as $row) {
                    if (isset($options['finder']) && is_callable($options['finder'])) {
                        $row->{$table} = $options['finder']($query, $row->id);
                    } else {
                        $type = $options['entity'] ?? 'object';
                        $row->{$table} = $query->where($options['foreign_key'], $row->id)
                            ->get()
                            ->getResult($type);
                    }
                }
            }
        }

        return $rows;
    }
}
