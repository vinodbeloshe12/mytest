<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");
class Json extends CI_Controller
{
  function getallarticle()
{

  $this->chintantable->createelement("`mytest_article`.`id`", '1', "ID", "id");
  $this->chintantable->createelement("`mytest_article`.`title`", '1', "title", "title");
  $this->chintantable->createelement("`mytest_article`.`image`", '0', "image", "image");
  $this->chintantable->createelement("`mytest_article`.`timestamp`", '1', "timestamp", "timestamp");
  $this->chintantable->createelement("`mytest_article`.`content`", '0', "content", "content");
  $this->chintantable->createelement("group_concat(`mytest_tags`.`name` separator ',')", '0', "tags", "tags");
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=  5;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `mytest_article` LEFT OUTER JOIN `mytest_tagarticle` ON `mytest_article`.`id` = `mytest_tagarticle`.`article` LEFT OUTER JOIN `mytest_tags` ON `mytest_tags`.`id` = `mytest_tagarticle`.`tag`","","GROUP BY `mytest_article`.`id`");

$this->load->view("json",$data);
}


public function getsinglearticle()
{
$id=$this->input->get_post("id");
$data["message"]=$this->article_model->getsinglearticle($id);
$this->load->view("json",$data);
}
public function responseCheck()
{
$id= $_GET;
$data["message"]=$id;
$this->load->view("json",$data);
}


public function getarticlebytagname()
{
$tag=$this->input->get_post("tag");

$this->chintantable->createelement("`mytest_article`.`id`", '1', "ID", "id");
$this->chintantable->createelement("`mytest_article`.`title`", '1', "title", "title");
$this->chintantable->createelement("`mytest_article`.`image`", '0', "image", "image");
$this->chintantable->createelement("`mytest_article`.`timestamp`", '1', "timestamp", "timestamp");
$this->chintantable->createelement("`mytest_article`.`content`", '0', "content", "content");
$this->chintantable->createelement("group_concat(`mytest_tags`.`name` separator ',')", '0', "tags", "tags");
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=  5;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `mytest_article` LEFT OUTER JOIN `mytest_tagarticle` ON `mytest_article`.`id` = `mytest_tagarticle`.`article` LEFT OUTER JOIN `mytest_tags` ON `mytest_tags`.`id` = `mytest_tagarticle`.`tag`"," WHERE `mytest_tags`.`name` = '$tag'","GROUP BY `mytest_article`.`id`");

$this->load->view("json",$data);
}








function getallconfig()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`mytest_config`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`mytest_config`.`title`";
$elements[1]->sort="1";
$elements[1]->header="title";
$elements[1]->alias="title";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`mytest_config`.`content`";
$elements[2]->sort="1";
$elements[2]->header="content";
$elements[2]->alias="content";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `mytest_config`");
$this->load->view("json",$data);
}
public function getsingleconfig()
{
$id=$this->input->get_post("id");
$data["message"]=$this->config_model->getsingleconfig($id);
$this->load->view("json",$data);
}
function getalltags()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`mytest_tags`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`mytest_tags`.`name`";
$elements[1]->sort="1";
$elements[1]->header="name";
$elements[1]->alias="name";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
  // getalltags
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `mytest_tags`");
$this->load->view("json",$data);
}

public function getsingletags()
{
$id=$this->input->get_post("id");
$data["message"]=$this->tags_model->getsingletags($id);
$this->load->view("json",$data);
}

// public function getalltags()
// {
//
// $data["message"]=$this->tags_model->getalltag();
// $this->load->view("json",$data);
// }


function getalltagarticle()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`mytest_tagarticle`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";

$elements=array();
$elements[1]=new stdClass();
$elements[1]->field="`mytest_tagarticle`.`tag`";
$elements[1]->sort="1";
$elements[1]->header="tag";
$elements[1]->alias="tag";

$elements=array();
$elements[2]=new stdClass();
$elements[2]->field="`mytest_tagarticle`.`article`";
$elements[2]->sort="1";
$elements[2]->header="article";
$elements[2]->alias="article";

$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `mytest_tagarticle`");
$this->load->view("json",$data);
}
public function getsingletagarticle()
{
$id=$this->input->get_post("id");
$data["message"]=$this->tagarticle_model->getsingletagarticle($id);
$this->load->view("json",$data);
}
} ?>
