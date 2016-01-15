<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class article_model extends CI_Model
{
public function create($title)
{
$data=array("title" => $title);
$query=$this->db->insert( "mytest_article", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("mytest_article")->row();
return $query;
}
function getsinglearticle($id){
$query=$this->db->query("SELECT `mytest_article`.`id`,`mytest_article`.`title`,`mytest_article`.`image`,`mytest_article`.`timestamp`,`mytest_article`.`content`,  group_concat(`mytest_tags`.`name` separator ',') as `tags` FROM `mytest_article` LEFT OUTER JOIN `mytest_tagarticle` ON `mytest_article`.`id` = `mytest_tagarticle`.`article` LEFT OUTER JOIN `mytest_tags` ON `mytest_tags`.`id` = `mytest_tagarticle`.`tag`   WHERE `mytest_article`.`id` = $id GROUP BY `mytest_article`.`id`")->row();
return $query;
}
public function edit($id,$title,$image,$content)
{
if($image=="")
{
$image=$this->article_model->getimagebyid($id);
$image=$image->image;
}
$data=array("title" => $title,   'image'=> $image ,  'content'=> $content);
$this->db->where( "id", $id );
$query=$this->db->update( "mytest_article", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `mytest_article` WHERE `id`='$id'");
return $query;
}
public function getimagebyid($id)
{
$query=$this->db->query("SELECT `image` FROM `mytest_article` WHERE `id`='$id'")->row();
return $query;
}
public function getdropdown()
{
$query=$this->db->query("SELECT * FROM `mytest_article` ORDER BY `id`
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
