<div class="row">
<div class="col s12">
<h4 class="pad-left-15 capitalize">Create article</h4>
</div>
<form class='col s12' method='post' action='<?php echo site_url("site/createarticlesubmit");?>' enctype= 'multipart/form-data'>
  <div class="row">
    <div class="input-field col m6 s12">
      <label for="name">Title</label>
      <input type="text" id="title" name="title" value="<?php echo set_value('title');?>">
    </div>
  </div>

  </div>


<div class="row">
  <div class="file-field input-field col m6 s12">
    <div class="btn blue darken-4">
      <span>Image</span>
      <input name="image" type="file" multiple>
    </div>
    <div class="file-path-wrapper">
      <input class="file-path validate" type="text" placeholder="Upload one or more files" value="<?php echo set_value('image');?>">
    </div>
  </div>
</div>

    <div class="row">
  <div class="input-field col m6 s12">
    <textarea name="content" class="materialize-textarea" length="120"><?php echo set_value( 'content');?></textarea>
    <label>Content</label>
  </div>
</div>
    <div class="row">
  <div class="input-field col m6 s12">
<?php
$brand_list = array(
        'small'         => 'Small Shirt',
        'med'           => 'Medium Shirt',
        'large'         => 'Large Shirt',
        'xlarge'        => 'Extra Large Shirt',
);

$shirts_on_sale = array('small', 'large');


/*
        Would produce:

        <select name="shirts">
                <option value="small">Small Shirt</option>
                <option value="med">Medium  Shirt</option>
                <option value="large" selected="selected">Large Shirt</option>
                <option value="xlarge">Extra Large Shirt</option>
        </select>
*/
$mtags = array('food','b');
//echo form_dropdown('shirts', $options, 'large');
//echo form_dropdown(multiple ,'brand[]', $brand_list, $mtags, 'id="brand"');

$array = array();
echo form_dropdown('shirts', $brand_list, $array, 'multiple'); 


 ?>


    <label>Tags</label>
  </div>
</div>



<div class="row">
<div class="col s12 m6">
<button type="submit" class="btn btn-primary waves-effect waves-light blue darken-4">Save</button>
<a href="<?php echo site_url("site/viewarticle"); ?>" class="btn btn-secondary waves-effect waves-light red">Cancel</a>
</div>
</div>
</form>
</div>
