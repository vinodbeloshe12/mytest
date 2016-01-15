<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class tagarticle_model extends CI_Model
{
public function create($tag,$article)
{
$data=array("tag" => $tag,"article" => $article);
$query=$this->db->insert( "mytest_tagarticle", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("mytest_tagarticle")->row();
return $query;
}
function getsingletagarticle($id){
$this->db->where("id",$id);
$query=$this->db->get("mytest_tagarticle")->row();
return $query;
}
public function edit($id,$tag,$article)
{
if($image=="")
{
$image=$this->tagarticle_model->getimagebyid($id);
$image=$image->image;
}
$data=array("tag" => $tag,"article" => $article);
$this->db->where( "id", $id );
$query=$this->db->update( "mytest_tagarticle", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `mytest_tagarticle` WHERE `id`='$id'");
return $query;
}
public function getimagebyid($id)
{
$query=$this->db->query("SELECT `image` FROM `mytest_tagarticle` WHERE `id`='$id'")->row();
return $query;
}
public function getdropdown()
{
$query=$this->db->query("SELECT * FROM `mytest_tagarticle` ORDER BY `id`
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
