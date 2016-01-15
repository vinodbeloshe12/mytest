<div class="row">
<div class="col s12">
<h4 class="pad-left-15 capitalize">Create tagarticle</h4>
</div>
<form class='col s12' method='post' action='<?php echo site_url("site/createtagarticlesubmit");?>' enctype= 'multipart/form-data'>
<div class="row">
<div class="input-field col s6">
<label for="tag">tag</label>
<input type="text" id="tag" name="tag" value='<?php echo set_value('tag');?>'>
</div>
</div>
<div class="row">
<div class="input-field col s6">
<label for="article">article</label>
<input type="text" id="article" name="article" value='<?php echo set_value('article');?>'>
</div>
</div>
<div class="row">
<div class="col s12 m6">
<button type="submit" class="btn btn-primary waves-effect waves-light blue darken-4">Save</button>
<a href="<?php echo site_url("site/viewtagarticle"); ?>" class="btn btn-secondary waves-effect waves-light red">Cancel</a>
</div>
</div>
</form>
</div>
