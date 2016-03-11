<div class="row">
<div class="col s12">
<h4 class="pad-left-15 capitalize">Edit article</h4>
</div>
</div>
<div class="row">
<form class='col s12' method='post' action='<?php echo site_url("site/editarticlesubmit");?>' enctype= 'multipart/form-data'>
<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before->id);?>" style="display:none;">
<div class="row">
<div class="input-field col s6">
<label for="title">title</label>
<input type="text" id="title" name="title" value='<?php echo set_value('title',$before->title);?>'>
</div>
</div>

<div class="row">
  <div class="file-field input-field col m6 s12">
    <span class="img-center big">
                                  <?php if($before->image == "") { } else {
                                  ?><img src="<?php echo base_url('uploads')."/".$before->image; ?>">
                          <?php } ?>
                          </span>
    <div class="btn blue darken-4">
      <span>Image</span>
      <input name="image" type="file" multiple>
    </div>
    <div class="file-path-wrapper">
      <input class="file-path validate" type="text" placeholder="Upload one or more files" value="<?php echo set_value('image',$before->image);?>">
    </div>
  </div>
</div>

<div class="row">
<div class="input-field col m6 s12">
<textarea name="content" class="materialize-textarea" length="120"><?php echo set_value('content',$before->content);?></textarea>
<label>Content</label>
</div>
</div>

<div class="row">
<div class="col s6">
<button type="submit" class="btn btn-primary waves-effect waves-light  blue darken-4">Save</button>
<a href='<?php echo site_url("site/viewarticle"); ?>' class='btn btn-secondary waves-effect waves-light red'>Cancel</a>
</div>
</div>
</form>
</div>
