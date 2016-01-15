<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site extends CI_Controller
{
	public function __construct( )
	{
		parent::__construct();

		$this->is_logged_in();
	}
	function is_logged_in( )
	{
		$is_logged_in = $this->session->userdata( 'logged_in' );
		if ( $is_logged_in !== 'true' || !isset( $is_logged_in ) ) {
			redirect( base_url() . 'index.php/login', 'refresh' );
		} //$is_logged_in !== 'true' || !isset( $is_logged_in )
	}
	function checkaccess($access)
	{
		$accesslevel=$this->session->userdata('accesslevel');
		if(!in_array($accesslevel,$access))
			redirect( base_url() . 'index.php/site?alerterror=You do not have access to this page. ', 'refresh' );
	}
    public function getOrderingDone()
    {
        $orderby=$this->input->get("orderby");
        $ids=$this->input->get("ids");
        $ids=explode(",",$ids);
        $tablename=$this->input->get("tablename");
        $where=$this->input->get("where");
        if($where == "" || $where=="undefined")
        {
            $where=1;
        }
        $access = array(
            '1',
        );
        $this->checkAccess($access);
        $i=1;
        foreach($ids as $id)
        {
            //echo "UPDATE `$tablename` SET `$orderby` = '$i' WHERE `id` = `$id` AND $where";
            $this->db->query("UPDATE `$tablename` SET `$orderby` = '$i' WHERE `id` = '$id' AND $where");
            $i++;
            //echo "/n";
        }
        $data["message"]=true;
        $this->load->view("json",$data);

    }
	public function index()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$data[ 'page' ] = 'dashboard';
		$data[ 'title' ] = 'Welcome';
		$this->load->view( 'template', $data );
	}
	public function createuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
        $data['gender']=$this->user_model->getgenderdropdown();
//        $data['category']=$this->category_model->getcategorydropdown();
		$data[ 'page' ] = 'createuser';
		$data[ 'title' ] = 'Create User';
		$this->load->view( 'template', $data );
	}
	function createusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)
		{
			$data['alerterror'] = validation_errors();
            $data['gender']=$this->user_model->getgenderdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'status' ] =$this->user_model->getstatusdropdown();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
            $data[ 'page' ] = 'createuser';
            $data[ 'title' ] = 'Create User';
            $this->load->view( 'template', $data );
		}
		else
		{
            $name=$this->input->post('name');
            $email=$this->input->post('email');
            $password=$this->input->post('password');
            $accesslevel=$this->input->post('accesslevel');
            $status=$this->input->post('status');
            $socialid=$this->input->post('socialid');
            $logintype=$this->input->post('logintype');
            $json=$this->input->post('json');
            $firstname=$this->input->post('firstname');
            $lastname=$this->input->post('lastname');
            $phone=$this->input->post('phone');
            $billingaddress=$this->input->post('billingaddress');
            $billingcity=$this->input->post('billingcity');
            $billingstate=$this->input->post('billingstate');
            $billingcountry=$this->input->post('billingcountry');
            $billingpincode=$this->input->post('billingpincode');
            $billingcontact=$this->input->post('billingcontact');

            $shippingaddress=$this->input->post('shippingaddress');
            $shippingcity=$this->input->post('shippingcity');
            $shippingstate=$this->input->post('shippingstate');
            $shippingcountry=$this->input->post('shippingcountry');
            $shippingpincode=$this->input->post('shippingpincode');
            $shippingcontact=$this->input->post('shippingcontact');
            $shippingname=$this->input->post('shippingname');
            $currency=$this->input->post('currency');
            $credit=$this->input->post('credit');
            $companyname=$this->input->post('companyname');
            $registrationno=$this->input->post('registrationno');
            $vatnumber=$this->input->post('vatnumber');
            $country=$this->input->post('country');
            $fax=$this->input->post('fax');
            $gender=$this->input->post('gender');

            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];

                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }

			}

			if($this->user_model->create($name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json,$firstname,$lastname,$phone,$billingaddress,$billingcity,$billingstate,$billingcountry,$billingpincode,$billingcontact,$shippingaddress,$shippingcity,$shippingstate,$shippingcountry,$shippingpincode,$shippingcontact,$shippingname,$currency,$credit,$companyname,$registrationno,$vatnumber,$country,$fax,$gender)==0)
			$data['alerterror']="New user could not be created.";
			else
			$data['alertsuccess']="User created Successfully.";
			$data['redirect']="site/viewusers";
			$this->load->view("redirect",$data);
		}
	}
    function viewusers()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['page']='viewusers';
        $data['base_url'] = site_url("site/viewusersjson");

		$data['title']='View Users';
		$this->load->view('template',$data);
	}
    function viewusersjson()
	{
		$access = array("1");
		$this->checkaccess($access);


        $elements=array();
        $elements[0]=new stdClass();
        $elements[0]->field="`user`.`id`";
        $elements[0]->sort="1";
        $elements[0]->header="ID";
        $elements[0]->alias="id";


        $elements[1]=new stdClass();
        $elements[1]->field="`user`.`name`";
        $elements[1]->sort="1";
        $elements[1]->header="Name";
        $elements[1]->alias="name";

        $elements[2]=new stdClass();
        $elements[2]->field="`user`.`email`";
        $elements[2]->sort="1";
        $elements[2]->header="Email";
        $elements[2]->alias="email";

        $elements[3]=new stdClass();
        $elements[3]->field="`user`.`socialid`";
        $elements[3]->sort="1";
        $elements[3]->header="SocialId";
        $elements[3]->alias="socialid";

        $elements[4]=new stdClass();
        $elements[4]->field="`user`.`logintype`";
        $elements[4]->sort="1";
        $elements[4]->header="Logintype";
        $elements[4]->alias="logintype";

        $elements[5]=new stdClass();
        $elements[5]->field="`user`.`json`";
        $elements[5]->sort="1";
        $elements[5]->header="Json";
        $elements[5]->alias="json";

        $elements[6]=new stdClass();
        $elements[6]->field="`accesslevel`.`name`";
        $elements[6]->sort="1";
        $elements[6]->header="Accesslevel";
        $elements[6]->alias="accesslevelname";

        $elements[7]=new stdClass();
        $elements[7]->field="`statuses`.`name`";
        $elements[7]->sort="1";
        $elements[7]->header="Status";
        $elements[7]->alias="status";


        $search=$this->input->get_post("search");
        $pageno=$this->input->get_post("pageno");
        $orderby=$this->input->get_post("orderby");
        $orderorder=$this->input->get_post("orderorder");
        $maxrow=$this->input->get_post("maxrow");
        if($maxrow=="")
        {
            $maxrow=20;
        }

        if($orderby=="")
        {
            $orderby="id";
            $orderorder="ASC";
        }

        $data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `user` LEFT OUTER JOIN `logintype` ON `logintype`.`id`=`user`.`logintype` LEFT OUTER JOIN `accesslevel` ON `accesslevel`.`id`=`user`.`accesslevel` LEFT OUTER JOIN `statuses` ON `statuses`.`id`=`user`.`status`");

		$this->load->view("json",$data);
	}


	function edituser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
        $data["before1"]=$this->input->get('id');
        $data["before2"]=$this->input->get('id');
        $data["before3"]=$this->input->get('id');
        $data["before4"]=$this->input->get('id');
        $data["before5"]=$this->input->get('id');
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data['gender']=$this->user_model->getgenderdropdown();
		$data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
		$data['before']=$this->user_model->beforeedit($this->input->get('id'));
		$data['page']='edituser';
		$data['page2']='block/userblock';
		$data['title']='Edit User';
		$this->load->view('templatewith2',$data);
	}
	function editusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);

		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('email','Email','trim|required|valid_email');
		$this->form_validation->set_rules('password','Password','trim|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('socialid','Socialid','trim');
		$this->form_validation->set_rules('logintype','logintype','trim');
		$this->form_validation->set_rules('json','json','trim');
		if($this->form_validation->run() == FALSE)
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
            $data['gender']=$this->user_model->getgenderdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data[ 'logintype' ] =$this->user_model->getlogintypedropdown();
			$data['before']=$this->user_model->beforeedit($this->input->post('id'));
			$data['page']='edituser';
//			$data['page2']='block/userblock';
			$data['title']='Edit User';
			$this->load->view('template',$data);
		}
		else
		{

            $id=$this->input->get_post('id');
            $name=$this->input->get_post('name');
            $email=$this->input->get_post('email');
            $password=$this->input->get_post('password');
            $accesslevel=$this->input->get_post('accesslevel');
            $status=$this->input->get_post('status');
            $socialid=$this->input->get_post('socialid');
            $logintype=$this->input->get_post('logintype');
            $json=$this->input->get_post('json');
//            $category=$this->input->get_post('category');
            $firstname=$this->input->post('firstname');
            $lastname=$this->input->post('lastname');
            $phone=$this->input->post('phone');
            $billingaddress=$this->input->post('billingaddress');
            $billingcity=$this->input->post('billingcity');
            $billingstate=$this->input->post('billingstate');
            $billingcountry=$this->input->post('billingcountry');
            $billingpincode=$this->input->post('billingpincode');
            $billingcontact=$this->input->post('billingcontact');

            $shippingaddress=$this->input->post('shippingaddress');
            $shippingcity=$this->input->post('shippingcity');
            $shippingstate=$this->input->post('shippingstate');
            $shippingcountry=$this->input->post('shippingcountry');
            $shippingpincode=$this->input->post('shippingpincode');
            $shippingcontact=$this->input->post('shippingcontact');
            $shippingname=$this->input->post('shippingname');
            $currency=$this->input->post('currency');
            $credit=$this->input->post('credit');
            $companyname=$this->input->post('companyname');
            $registrationno=$this->input->post('registrationno');
            $vatnumber=$this->input->post('vatnumber');
            $country=$this->input->post('country');
            $fax=$this->input->post('fax');
            $gender=$this->input->post('gender');
            $config['upload_path'] = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$this->load->library('upload', $config);
			$filename="image";
			$image="";
			if (  $this->upload->do_upload($filename))
			{
				$uploaddata = $this->upload->data();
				$image=$uploaddata['file_name'];

                $config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
                $config_r['maintain_ratio'] = TRUE;
                $config_t['create_thumb'] = FALSE;///add this
                $config_r['width']   = 800;
                $config_r['height'] = 800;
                $config_r['quality']    = 100;
                //end of configs

                $this->load->library('image_lib', $config_r);
                $this->image_lib->initialize($config_r);
                if(!$this->image_lib->resize())
                {
                    echo "Failed." . $this->image_lib->display_errors();
                    //return false;
                }
                else
                {
                    //print_r($this->image_lib->dest_image);
                    //dest_image
                    $image=$this->image_lib->dest_image;
                    //return false;
                }

			}

            if($image=="")
            {
            $image=$this->user_model->getuserimagebyid($id);
               // print_r($image);
                $image=$image->image;
            }

			if($this->user_model->edit($id,$name,$email,$password,$accesslevel,$status,$socialid,$logintype,$image,$json,$firstname,$lastname,$phone,$billingaddress,$billingcity,$billingstate,$billingcountry,$billingpincode,$billingcontact,$shippingaddress,$shippingcity,$shippingstate,$shippingcountry,$shippingpincode,$shippingcontact,$shippingname,$currency,$credit,$companyname,$registrationno,$vatnumber,$country,$fax,$gender)==0)
			$data['alerterror']="User Editing was unsuccesful";
			else
			$data['alertsuccess']="User edited Successfully.";

			$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);

		}
	}

	function deleteuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->deleteuser($this->input->get('id'));
//		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="User Deleted Successfully";
		$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
		$this->load->view("redirect",$data);
	}
	function changeuserstatus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->changestatus($this->input->get('id'));
		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="Status Changed Successfully";
		$data['redirect']="site/viewusers";
        $data['other']="template=$template";
        $this->load->view("redirect",$data);
	}
    public function viewcart()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewcart";
    $data["before1"]=$this->input->get('id');
        $data["before2"]=$this->input->get('id');
        $data["before3"]=$this->input->get('id');
        $data["before4"]=$this->input->get('id');
        $data["before5"]=$this->input->get('id');
$data['page2']='block/userblock';
$data["base_url"]=site_url("site/viewcartjson?id=").$this->input->get('id');
$data["title"]="View cart";
$this->load->view("templatewith2",$data);
}
function viewcartjson()
{
    $id=$this->input->get('id');
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`fynx_cart`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`fynx_cart`.`user`";
$elements[1]->sort="1";
$elements[1]->header="User";
$elements[1]->alias="user";
$elements[2]=new stdClass();
$elements[2]->field="`fynx_cart`.`quantity`";
$elements[2]->sort="1";
$elements[2]->header="Quantity";
$elements[2]->alias="quantity";
$elements[3]=new stdClass();
$elements[3]->field="`fynx_cart`.`product`";
$elements[3]->sort="1";
$elements[3]->header="Product";
$elements[3]->alias="product";
$elements[4]=new stdClass();
$elements[4]->field="`fynx_cart`.`timestamp`";
$elements[4]->sort="1";
$elements[4]->header="Timestamp";
$elements[4]->alias="timestamp";

$elements[5]=new stdClass();
$elements[5]->field="`fynx_cart`.`size`";
$elements[5]->sort="1";
$elements[5]->header="Size";
$elements[5]->alias="size";

$elements[6]=new stdClass();
$elements[6]->field="`fynx_cart`.`color`";
$elements[6]->sort="1";
$elements[6]->header="Color";
$elements[6]->alias="color";
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `fynx_cart`","WHERE `fynx_cart`.`user`='$id'");
$this->load->view("json",$data);
}
    public function viewwishlist()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewwishlist";
    $data["before1"]=$this->input->get('id');
        $data["before2"]=$this->input->get('id');
        $data["before3"]=$this->input->get('id');
        $data["before4"]=$this->input->get('id');
        $data["before5"]=$this->input->get('id');
$data['page2']='block/userblock';
$data["base_url"]=site_url("site/viewwishlistjson?id=".$this->input->get('id'));
$data["title"]="View wishlist";
$this->load->view("templatewith2",$data);
}
function viewwishlistjson()
{
    $user=$this->input->get('id');
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`fynx_wishlist`.`id`";
$elements[0]->sort="1";
$elements[0]->header="ID";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`fynx_wishlist`.`user`";
$elements[1]->sort="1";
$elements[1]->header="User";
$elements[1]->alias="user";
$elements[2]=new stdClass();
$elements[2]->field="`fynx_wishlist`.`product`";
$elements[2]->sort="1";
$elements[2]->header="Product";
$elements[2]->alias="product";
$elements[3]=new stdClass();
$elements[3]->field="`fynx_wishlist`.`timestamp`";
$elements[3]->sort="1";
$elements[3]->header="Timestamp";
$elements[3]->alias="timestamp";

$elements[4]=new stdClass();
$elements[4]->field="`fynx_product`.`name`";
$elements[4]->sort="1";
$elements[4]->header="Product Name";
$elements[4]->alias="productname";
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `fynx_wishlist` LEFT OUTER JOIN `fynx_product` ON `fynx_product`.`id`=`fynx_wishlist`.`product`","WHERE `fynx_wishlist`.`user`='$user'");
$this->load->view("json",$data);
}




public function viewarticle()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewarticle";
$data["base_url"]=site_url("site/viewarticlejson");
$data["title"]="View article";
$this->load->view("template",$data);
}
function viewarticlejson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`mytest_article`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`mytest_article`.`title`";
$elements[1]->sort="1";
$elements[1]->header="title";
$elements[1]->alias="title";
$elements[2]=new stdClass();
$elements[2]->field="`mytest_article`.`content`";
$elements[2]->sort="1";
$elements[2]->header="content";
$elements[2]->alias="content";
$elements[3]=new stdClass();
$elements[3]->field="`mytest_article`.`image`";
$elements[3]->sort="1";
$elements[3]->header="image";
$elements[3]->alias="image";
$search=$this->input->get_post("search");
$pageno=$this->input->get_post("pageno");
$orderby=$this->input->get_post("orderby");
$orderorder=$this->input->get_post("orderorder");
$maxrow=$this->input->get_post("maxrow");
if($maxrow=="")
{
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `mytest_article`");
$this->load->view("json",$data);
}

public function createarticle()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createarticle";
$data["title"]="Create article";
$this->load->view("template",$data);
}



function createarticlesubmit()
{
	$access = array("1");
	$this->checkaccess($access);
	$this->form_validation->set_rules('title','Title','trim|required|max_length[30]');
	$this->form_validation->set_rules('json','json','trim');
	if($this->form_validation->run() == FALSE)
	{
		$data['alerterror'] = validation_errors();
					$data[ 'page' ] = 'createarticle';
					$data[ 'title' ] = 'Create Article';
					$this->load->view( 'template', $data );
	}
	else
	{
					$title=$this->input->post('title');
				  $content=$this->input->post('content');


					$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$this->load->library('upload', $config);
		$filename="image";
		$image="";
		if (  $this->upload->do_upload($filename))
		{
			$uploaddata = $this->upload->data();
			$image=$uploaddata['file_name'];

							$config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
							$config_r['maintain_ratio'] = TRUE;
							$config_t['create_thumb'] = FALSE;///add this
							$config_r['width']   = 800;
							$config_r['height'] = 800;
							$config_r['quality']    = 100;
							//end of configs

							$this->load->library('image_lib', $config_r);
							$this->image_lib->initialize($config_r);
							if(!$this->image_lib->resize())
							{
									echo "Failed." . $this->image_lib->display_errors();
									//return false;
							}
							else
							{
									//print_r($this->image_lib->dest_image);
									//dest_image
									$image=$this->image_lib->dest_image;
									//return false;
							}

		}

		if($this->user_model->createart($title,$content,$image)==0)
		$data['alerterror']="New article could not be created.";
		else
		$data['alertsuccess']="Article created Successfully.";
		$data['redirect']="site/viewarticle";
		$this->load->view("redirect",$data);
	}
}


public function editarticle()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editarticle";
$data["title"]="Edit article";
$data["before"]=$this->article_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editarticlesubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","id","trim");
$this->form_validation->set_rules("title","title","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editarticle";
$data["title"]="Edit article";
$data["before"]=$this->article_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$title=$this->input->get_post("title");
$content=$this->input->get_post("content");
$config['upload_path'] = './uploads/';
$config['allowed_types'] = 'gif|jpg|png|jpeg';
$this->load->library('upload', $config);
$filename="image";
$image="";
if (  $this->upload->do_upload($filename))
{
$uploaddata = $this->upload->data();
$image=$uploaddata['file_name'];

		$config_r['source_image']   = './uploads/' . $uploaddata['file_name'];
		$config_r['maintain_ratio'] = TRUE;
		$config_t['create_thumb'] = FALSE;///add this
		$config_r['width']   = 800;
		$config_r['height'] = 800;
		$config_r['quality']    = 100;
		//end of configs

		$this->load->library('image_lib', $config_r);
		$this->image_lib->initialize($config_r);
		if(!$this->image_lib->resize())
		{
				echo "Failed." . $this->image_lib->display_errors();
				//return false;
		}
		else
		{
				//print_r($this->image_lib->dest_image);
				//dest_image
				$image=$this->image_lib->dest_image;
				//return false;
		}

}

if($image=="")
{
$image=$this->user_model->getuserimagebyid($id);
	 // print_r($image);
		$image=$image->image;
}
if($this->article_model->edit($id,$title,$image,$content)==0)
$data["alerterror"]="New article could not be Updated.";
else
$data["alertsuccess"]="article Updated Successfully.";
$data["redirect"]="site/viewarticle";
$this->load->view("redirect",$data);
}
}
public function deletearticle()
{
$access=array("1");
$this->checkaccess($access);
$this->article_model->delete($this->input->get("id"));
$data["redirect"]="site/viewarticle";
$this->load->view("redirect",$data);
}
public function viewconfig()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewconfig";
$data["base_url"]=site_url("site/viewconfigjson");
$data["title"]="View config";
$this->load->view("template",$data);
}
function viewconfigjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`mytest_config`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`mytest_config`.`title`";
$elements[1]->sort="1";
$elements[1]->header="title";
$elements[1]->alias="title";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `mytest_config`");
$this->load->view("json",$data);
}

public function createconfig()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createconfig";
$data["title"]="Create config";
$this->load->view("template",$data);
}
public function createconfigsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("title","title","trim");
$this->form_validation->set_rules("content","content","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createconfig";
$data["title"]="Create config";
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$title=$this->input->get_post("title");
$content=$this->input->get_post("content");
if($this->config_model->create($title,$content)==0)
$data["alerterror"]="New config could not be created.";
else
$data["alertsuccess"]="config created Successfully.";
$data["redirect"]="site/viewconfig";
$this->load->view("redirect",$data);
}
}
public function editconfig()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="editconfig";
$data["title"]="Edit config";
$data["before"]=$this->config_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function editconfigsubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","id","trim");
$this->form_validation->set_rules("title","title","trim");
$this->form_validation->set_rules("content","content","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="editconfig";
$data["title"]="Edit config";
$data["before"]=$this->config_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$title=$this->input->get_post("title");
$content=$this->input->get_post("content");
if($this->config_model->edit($id,$title,$content)==0)
$data["alerterror"]="New config could not be Updated.";
else
$data["alertsuccess"]="config Updated Successfully.";
$data["redirect"]="site/viewconfig";
$this->load->view("redirect",$data);
}
}
public function deleteconfig()
{
$access=array("1");
$this->checkaccess($access);
$this->config_model->delete($this->input->get("id"));
$data["redirect"]="site/viewconfig";
$this->load->view("redirect",$data);
}
public function viewtags()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewtags";
$data["base_url"]=site_url("site/viewtagsjson");
$data["title"]="View tags";
$this->load->view("template",$data);
}
function viewtagsjson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`mytest_tags`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `mytest_tags`");
$this->load->view("json",$data);
}

public function createtags()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createtags";
$data["title"]="Create tags";
$this->load->view("template",$data);
}
public function createtagssubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("name","name","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createtags";
$data["title"]="Create tags";
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
if($this->tags_model->create($name)==0)
$data["alerterror"]="New tags could not be created.";
else
$data["alertsuccess"]="tags created Successfully.";
$data["redirect"]="site/viewtags";
$this->load->view("redirect",$data);
}
}
public function edittags()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="edittags";
$data["title"]="Edit tags";
$data["before"]=$this->tags_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function edittagssubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","id","trim");
$this->form_validation->set_rules("name","name","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="edittags";
$data["title"]="Edit tags";
$data["before"]=$this->tags_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$name=$this->input->get_post("name");
if($this->tags_model->edit($id,$name)==0)
$data["alerterror"]="New tags could not be Updated.";
else
$data["alertsuccess"]="tags Updated Successfully.";
$data["redirect"]="site/viewtags";
$this->load->view("redirect",$data);
}
}
public function deletetags()
{
$access=array("1");
$this->checkaccess($access);
$this->tags_model->delete($this->input->get("id"));
$data["redirect"]="site/viewtags";
$this->load->view("redirect",$data);
}
public function viewtagarticle()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="viewtagarticle";
$data["base_url"]=site_url("site/viewtagarticlejson");
$data["title"]="View tagarticle";
$this->load->view("template",$data);
}
function viewtagarticlejson()
{
$elements=array();
$elements[0]=new stdClass();
$elements[0]->field="`mytest_tagarticle`.`id`";
$elements[0]->sort="1";
$elements[0]->header="id";
$elements[0]->alias="id";
$elements[1]=new stdClass();
$elements[1]->field="`mytest_tagarticle`.`tag`";
$elements[1]->sort="1";
$elements[1]->header="tag";
$elements[1]->alias="tag";
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
$maxrow=20;
}
if($orderby=="")
{
$orderby="id";
$orderorder="ASC";
}
$data["message"]=$this->chintantable->query($pageno,$maxrow,$orderby,$orderorder,$search,$elements,"FROM `mytest_tagarticle`");
$this->load->view("json",$data);
}

public function createtagarticle()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="createtagarticle";
$data["title"]="Create tagarticle";
$this->load->view("template",$data);
}
public function createtagarticlesubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("tag","tag","trim");
$this->form_validation->set_rules("article","article","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="createtagarticle";
$data["title"]="Create tagarticle";
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$tag=$this->input->get_post("tag");
$article=$this->input->get_post("article");
if($this->tagarticle_model->create($tag,$article)==0)
$data["alerterror"]="New tagarticle could not be created.";
else
$data["alertsuccess"]="tagarticle created Successfully.";
$data["redirect"]="site/viewtagarticle";
$this->load->view("redirect",$data);
}
}
public function edittagarticle()
{
$access=array("1");
$this->checkaccess($access);
$data["page"]="edittagarticle";
$data["title"]="Edit tagarticle";
$data["before"]=$this->tagarticle_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
public function edittagarticlesubmit()
{
$access=array("1");
$this->checkaccess($access);
$this->form_validation->set_rules("id","id","trim");
$this->form_validation->set_rules("tag","tag","trim");
$this->form_validation->set_rules("article","article","trim");
if($this->form_validation->run()==FALSE)
{
$data["alerterror"]=validation_errors();
$data["page"]="edittagarticle";
$data["title"]="Edit tagarticle";
$data["before"]=$this->tagarticle_model->beforeedit($this->input->get("id"));
$this->load->view("template",$data);
}
else
{
$id=$this->input->get_post("id");
$tag=$this->input->get_post("tag");
$article=$this->input->get_post("article");
if($this->tagarticle_model->edit($id,$tag,$article)==0)
$data["alerterror"]="New tagarticle could not be Updated.";
else
$data["alertsuccess"]="tagarticle Updated Successfully.";
$data["redirect"]="site/viewtagarticle";
$this->load->view("redirect",$data);
}
}
public function deletetagarticle()
{
$access=array("1");
$this->checkaccess($access);
$this->tagarticle_model->delete($this->input->get("id"));
$data["redirect"]="site/viewtagarticle";
$this->load->view("redirect",$data);
}

}
?>
