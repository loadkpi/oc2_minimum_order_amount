<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-minimal_order_cost" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $heading_label; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-minimal_order_amount" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_currency; ?></label>
            <div class="col-sm-10">
              <input type="text" disabled="disabled" value="<?php echo $store_currency; ?>" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_amount_value; ?></label>
            <div class="col-sm-10">
              <input type="text" value="<?php echo $value_amount_value; ?>" class="form-control" name="minimal_order_amount_value_amount_value" />
              <?php if ($amount_value) { ?>
                <div class="text-danger"><?php echo $amount_value; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo $entry_error_msg; ?></label>
            <div class="col-sm-10">
              <textarea name="minimal_order_amount_value_error_msg" cols="40" rows="5" placeholder="<?php echo $placeholder_error_msg; ?>" class="form-control"><?php echo $value_error_msg; ?></textarea>
              <p><?php echo $tip_error_msg; ?></p>
              <?php if ($error_msg) { ?>
                <div class="text-danger"><?php echo $error_msg; ?></div>
              <?php } ?>
            </div>
          </div>          
        </form>
      </div>
	</div>
  </div>
</div>

<?php echo $footer; ?>