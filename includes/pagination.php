<?php
class Pagination{
  public $current_page;
  public $per_page;
  public $total_count;

  public function __construct($page=1,$per_page=3,$total_count=0){
    $this->current_page=(int)$page;
    $this->per_page=(int)$per_page;
    $this->total_count=(int)$total_count;

  }

  public function offset(){
    //Assuming 20 items per page
    //page 1 has a offset of 0 (1-1) * 20
    //page 2 has a offset of 20 (2-1) * 20
    //in other words , page 2 starts with item 21
    return ($this->current_page -1) * $this->per_page; 
  }

  public function total_page(){
    return ceil($this->total_count/$this->per_page);
  }

  public function prev_page(){
    return $this->current_page-1;
  }

  public function next_page(){
    return $this->current_page+1;
  }

  public function has_prev_page(){
    return $this->prev_page() >= 1 ? true:false;
  }

  public function has_next_page(){
    return $this->next_page() <= $this->total_page() ? true:false;
  }
}
 ?>
