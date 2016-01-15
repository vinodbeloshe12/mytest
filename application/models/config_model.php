<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class config_model extends CI_Model
{
public function create($title,$content)
{
$data=array("title" => $title,"content" => $content);
$query=$this->db->insert( "mytest_config", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("mytest_config")->row();
return $query;
}
function getsingleconfig($id){
$this->db->where("id",$id);
$query=$this->db->get("mytest_config")->row();
return $query;
}
public function edit($id,$title,$content)
{
// if($image=="")
// {
// $image=$this->config_model->getimagebyid($id);
// $image=$image->image;
// }
$data=array("title" => $title,"content" => $content);
$this->db->where( "id", $id );
$query=$this->db->update( "mytest_config", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `mytest_config` WHERE `id`='$id'");
return $query;
}
public function getimagebyid($id)
{
$query=$this->db->query("SELECT `image` FROM `mytest_config` WHERE `id`='$id'")->row();
return $query;
}
public function getdropdown()
{
$query=$this->db->query("SELECT * FROM `mytest_config` ORDER BY `id`
                    ASC")->row();
$return=array(
"" => "Select Option"
);
foreach($query as $row)
{
$return[$row->id]=$row->name;
}
return $return;
}
}
?>
