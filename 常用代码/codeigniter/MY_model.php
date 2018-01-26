<?php
/**
 * Created by lei
 * Class MY_Model
 * base model
 */
class MY_Model extends CI_Model{

    /**
     * 该Model对应的表名
     * @var string
     */
    var $_table = '';

    /**
     * 该Model对应的表名
     * @var string
     */
    var $_database = '';

    /**
     * @var string 主键
     */
    protected $primary_key = '';

    public function __construct(){
        parent::__construct();
        $this->_database = $this->db;
    }

    /**
     * 执行sql
     * @param $sql
     * @param bool $affect_num 是否返回影响行数
     * @return mixed
     */
    function query($sql,$affect_num=false){
        $query = $this->_database->query($sql);
        if($affect_num){
            $query = $this->_database->affected_rows();
        }
        return $query;
    }

    /**
     * 返回多行数据
     * @param $sql
     * @return mixed
     */
    function getRows($sql){
        $query = $this->_database->query($sql);
        return $query->result_array();
    }

    /**
     * 返回单行数据
     * @param $sql
     * @return mixed
     */
    function getRow($sql){
        $data = $this->getRows($sql);
        return $data[0];
    }

    /**
     * 返回单行首列数据
     * @param $sql
     * @return mixed
     */
    function getOne($sql){
        $data = $this->getRow($sql);
        return current($data);
    }

    /**
     * 插入数据
     * @param $data 插入的数据array
     * @param string $_table 表名
     * @param bool $return 是否需要返回插入成功的id
     * @return bool
     */
    function insert($data, $_table='', $return = false){
        if(!$_table){
            if(!$this->_table){
                return false;
            }
            $_table = $this->_table;
        }
        // 添加前置钩子操作
        if(false === $this->_before_insert($data)) {
            return false;
        }
        $query = $this->_database->insert($_table, $data);
        // 添加后置钩子操作
        if(false === $this->_after_insert($data)) {
            return false;
        }
        if($return){
            $query = $this->_database->insert_id();
        }
        return $query;
    }

    // 插入数据前的回调方法
    protected function _before_insert(&$data) {}
    // 插入成功后的回调方法
    protected function _after_insert($data) {}

    /**
     * 删除数据
     * @param $where where (e.g. array('field' =>'value',...))
     * @param string $_table
     * @return bool
     */
    function delete($where, $_table='',$limit=1){
        if(!$_table){
            if(!$this->_table){
                return false;
            }
            $_table = $this->_table;
        }
        $this->_database->where($where);
        $this->_database->limit($limit);
        $this->_database->delete($_table);
    }

    /**
     * 更新数据
     * @param $where where (e.g. array('field' =>'value',...))
     * @param $update update (e.g. array('field' =>'value',...))
     * @param string $_table
     * @param int $limit 如果为空，则修改所有能查询出的数据
     * @return bool
     */
    function update($where,$update,$_table='',$limit=1){
        if(!$_table){
            if(!$this->_table){
                return false;
            }
            $_table = $this->_table;
        }
        $this->_database->where($where);
        if ($limit){
            $this->_database->limit($limit);
        }
        // 前置钩子
        if(false === $this->_before_update($data)) {
            return false;
        }
        $this->_database->update($_table, $update);
        // 后置钩子
        if(false === $this->_after_update($data)) {
            return false;
        }
        return $this->_database->affected_rows();
    }

    // 更新数据前的回调方法
    protected function _before_update(&$data) {}
    // 更新成功后的回调方法
    protected function _after_update($data) {}

    /**
     * where (e.g. array('field' =>'value',...))
     * @param array $where
     * @return $this
     */
    function where($where=array()){
        $this->_database->where($where);
        return $this;
    }

    /**
     * limit $offset,$limit
     * @param int $limit
     * @param int $offset
     * @return $this
     */
    function limit($limit=1,$offset=0){
        $this->_database->limit($limit,$offset);
        return $this;
    }

    /**
     * @param string $group_by
     * @return $this
     */
    public function group_by($group_by)
    {
        $this->_database->group_by($group_by);
        return $this;
    }

    /**
     * order by (e.g. array('field1'=>'asc',...))
     * @param array $orderby
     * @return $this
     */
    function order_by($orderby=array()){
        if($orderby){
            foreach($orderby as $k=>$v){
                $this->_database->order_by($k, $v);
            }
        }
        return $this;
    }

    /**
     * where in (e.g. array('field1'=>array('value1','value2',...)))
     * @param array $wherein
     * @return $this
     */
    function where_in($wherein=array()){
        if($wherein){
            foreach($wherein as $k=>$v){
                $this->_database->where_in($k, $v);
            }
        }
        return $this;
    }

    /**
     * where not in (e.g. array('field1'=>array('value1','value2',...)))
     * @param array $wherenotin
     * @return $this
     */
    function where_not_in($wherenotin=array()){
        if($wherenotin){
            foreach($wherenotin as $k=>$v){
                $this->_database->where_not_in($k, $v);
            }
        }
        return $this;
    }

    /**
     * 获取总数
     * @return mixed
     */
    function count(){
        $this->_database->from($this->_table);
        return $this->_database->count_all_results();
    }

    /**
     * select (e.g. array('field1','field2',...) or 'filed1,filed2,...')
     * @param string $select
     * @return mixed
     */
    function select($select="*"){
        $this->_database->select($select);
        $query = $this->_database->get($this->_table);
        $data = $query->result_array();
        return $data;
    }

    /**
     * select (e.g. array('field1','field2',...) or 'filed1,filed2,...')
     * @param string $select
     * @return mixed
     */
    function get($select="*"){
        $this->_database->select($select);
        $query = $this->_database->get($this->_table);
        $data = $query->row_array();
        return $data;
    }

    /**
     * 查询单条数据
     * @param array $where 主键id||查询条件
     * @return mixed 一行数据
     */
    function find($where=array()){
        if(is_numeric($where) || is_string($where)) {
            $key = $where;
            $where = array();
            $where[$this->primary_key]  =   $key;
        }
        $data = $this->where($where)->limit(1)->select();
        return $data[0];
    }

    function last_query()
    {
        return $this->_database->last_query();
    }

}