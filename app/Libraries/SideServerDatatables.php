<?php

namespace App\Libraries;

use CodeIgniter\Database\RawSql;

class SideServerDatatables
{
    protected $table;
    protected $primaryKey;

    public function __construct($table, $primaryKey)
    {
        $this->table = $table;
        $this->primaryKey = $primaryKey;
    }

    private function _hendleSearch($builder, $searchableColumns, $searchValue)
    {
        if ($searchValue) {
            $builder->groupStart();
            foreach ($searchableColumns as $column) {
                $builder->orLike($column, $searchValue);
            }
            $builder->groupEnd();
        }
    }

    private function _hendleSearchCol($builder, $searchableColumns, $searchCol)
    {
        $i = 0;
        // $builder->groupStart();
        foreach ($searchableColumns as $column) {
            $val = $searchCol[$i++]['search']['value'];
            if($val !== '') $builder->like($column, $val);
        }
        // $builder->groupEnd();
    }   

    private function _hendleOrder($builder, $orderableColumns, $defaultOrder)
    {
        if (request()->getPost('order') && (request()->getPost('order')[0]['column'] < count($orderableColumns))) {
            $orderColumn = request()->getPost('order')[0]['column'] ?? 0;
            $orderDirection = request()->getPost('order')[0]['dir'] ?? 'asc';
            $builder->orderBy($orderableColumns[$orderColumn], $orderDirection); // Default order 
        } else {
            $builder->orderBy($defaultOrder[0], $defaultOrder[1]); // Default order 
        }
    }

    private function _hendleJoin($builder, $arrayJoin)
    {
        if ($arrayJoin) {
            foreach ($arrayJoin as $join) {
                $builder->join($join['table'], $join['on'], $join['type'] ?? 'inner');
            }
        }
    }

    private function _hendleWhere($builder, $where)
    {
        if ($where) {
            foreach ($where as $key => $val) {
                if (stripos($key, ' NOT IN') !== false && is_array($val) == false) {

                    $builder->where("$key ($val)");
                } elseif (stripos($key, ' IN') !== false && is_array($val)) {

                    $field = trim(str_ireplace('IN', '', $key));
                    $builder->whereIn($field, $val);
                } else {
                    $builder->where($key, $val);
                }
            }
        }
    }

    /**
     * Get data untuk DataTables side server processing.
     *
     * @param array $columns
     * @param array $orderableColumns
     * @param array $searchableColumns
     * @param array $defaultOrder
     * @param array|null $join
     * @param string|null $where
     * 
     * @return array
     */
    public function getData(array $columns, array $orderableColumns, array $searchableColumns, array $defaultOrder, array $join = [], $where = null)
    {
        $db = \Config\Database::connect(); // koneksi ke database

        $builder = $db->table($this->table);
        $builder->select($columns);

        // hendle join
        $this->_hendleJoin($builder, $join);

        // hendle where
        $this->_hendleWhere($builder, $where);

        // hendle search
        $searchValue = request()->getPost('search')['value'] ?? false;
        $this->_hendleSearch($builder, $searchableColumns, $searchValue);

        // hendle search col
        $searchCol = request()->getPost('columns') ?? false;
        $this->_hendleSearchCol($builder, $searchableColumns, $searchCol);

        // hendle order
        $this->_hendleOrder($builder, $orderableColumns, $defaultOrder);

        // sett limit
        $builder->limit(request()->getPost('length'), request()->getPost('start') ?? 0);

        // output
        $query = $builder->get();

        return $query->getResultArray();
    }

    /**
     * Get data untuk DataTables side server processing.
     *
     * @param array $columns
     * @param array $searchableColumns
     * @param array|null $join
     * @param string|null $where
     * 
     * @return array
     */

    public function getCountFilter(array $columns, array $searchableColumns, array $join = [], $where = null)
    {
        $db = \Config\Database::connect(); // koneksi ke database

        $builder = $db->table($this->table);
        $builder->select($columns);

        // hendle join
        $this->_hendleJoin($builder, $join);

        // hendle where
        $this->_hendleWhere($builder, $where);

        // hendle search col
        $searchCol = request()->getPost('columns') ?? false;
        $this->_hendleSearchCol($builder, $searchableColumns, $searchCol);

        // hendle search
        $searchValue = request()->getPost('search')['value'] ?? false;
        $this->_hendleSearch($builder, $searchableColumns, $searchValue);

        // output
        $query = $builder->get();
        return $query->getNumRows();
    }

    public function countAllData(array $join = [], $where = null)
    {
        $db = \Config\Database::connect(); // koneksi ke database
        $builder = $db->table($this->table);
        // hendle join
        $this->_hendleJoin($builder, $join);

        // hendle where
        $this->_hendleWhere($builder, $where);

        return $builder->countAllResults();
    }
}
