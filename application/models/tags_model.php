<?php
if ( !defined( "BASEPATH" ) )
exit( "No direct script access allowed" );
class tags_model extends CI_Model
{
public function create($name)
{
$data=array("name" => $name);
$query=$this->db->insert( "mytest_tags", $data );
$id=$this->db->insert_id();
if(!$query)
return  0;
else
return  $id;
}
public function beforeedit($id)
{
$this->db->where("id",$id);
$query=$this->db->get("mytest_tags")->row();
return $query;
}
function getarticlebytagname($name){

  // $query=$this->db->query("SELECT `mytest_article`.'title', `mytest_tags`.`name`, `mytest_tagarticle`.`tag`, `mytest_tagarticle`.`article`FROM `mytest_tagarticle`
  //     LEFT JOIN `mytest_article` ON `mytest_article`.id = `mytest_tagarticle`.`article`
  //       LEFT JOIN `mytest_tags`
  //         ON `mytest_tags`.id =`mytest_tagarticle`.`tag` where `mytest_tags`.`name`='$name'");

          $query="SELECT `mytest_article`.id,`mytest_article`.title, `mytest_article`.image,`mytest_article`.content,`mytest_article`.views, `mytest_tags`.name as 'Tag name' FROM `mytest_tagarticle`
              LEFT JOIN `mytest_article` ON `mytest_article`.id = `mytest_tagarticle`.article
                LEFT JOIN `mytest_tags`
                  ON `mytest_tags`.id =`mytest_tagarticle`.tag where `mytest_tags`.name='$name'";
         $query=$this->db->query($query)->result();

             $return=new stdClass();
             $return->query=$query;
             return $return;


return $query;
}

function getalltag(){

  
         $query=$this->db->query("SELECT *from mytest_tags")->result();

      return $query;
}
//tagsbyname



public function edit($id,$name)
{
// if($image=="")
// {
// $image=$this->tags_model->getimagebyid($id);
// $image=$image->image;
// }
$data=array("name" => $name);
$this->db->where( "id", $id );
$query=$this->db->update( "mytest_tags", $data );
return 1;
}
public function delete($id)
{
$query=$this->db->query("DELETE FROM `mytest_tags` WHERE `id`='$id'");
return $query;
}
public function getimagebyid($id)
{
$query=$this->db->query("SELECT `image` FROM `mytest_tags` WHERE `id`='$id'")->row();
return $query;
}
public function getdropdown()
{
$query=$this->db->query("SELECT * FROM `mytest_tags` ORDER BY `id`
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
