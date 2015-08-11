<div class="toolbar col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2">
    <div class="left">
        <!--For icon: http://getbootstrap.com/components/-->
        <a href="<?php echo site_url(); ?>users/accounts/add/<?php echo $this->uri->segment(4); ?>" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-plus-sign"></i> Create</a>
        <!--<a href="<?php echo site_url(); ?>users/permissions" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-lock"></i> Permission</a>-->
    </div>
    <div class="right">
        <h1><?php echo $title; ?></h1>
    </div>
</div>
<div class="content">
    <div class="filter">
        <form class="form-inline" role="form" method="post" action="<?php echo base_url(); ?>users/accounts/index">
            <div class="form-group">
                <label class="sr-only" for="use_name">Username</label>
                <input type="text" class="form-control input-sm" id="use_name" name="use_name" value="<?php echo set_value('use_name'); ?>" placeholder="Username">
            </div>
            <div class="form-group">
                <label class="sr-only" for="use_email">Email</label>
                <input type="text" class="form-control input-sm" id="use_name" name="use_email" value="<?php echo set_value('use_email'); ?>" placeholder="E-Mail">
            </div>
            <div class="form-group">
                <label class="sr-only" for="tbl_groups_gro_id">Group</label>
                <?php echo form_dropdown('tbl_groups_gro_id', array('' => '--All Groups--') + $groups, set_value('tbl_groups_gro_id', $this->session->userdata('tbl_groups_gro_id')), 'class="form-control input-sm"') ?>
            </div>
            <div class="form-group">
                <label class="sr-only" for="use_status">Status</label>
                <?php echo form_dropdown('use_status', array('' => '-- All Status --', '1' => 'Enabled', '0' => 'Desabled'), set_value('use_status', $this->session->userdata('use_status')), 'class="form-control input-sm"') ?>
            </div>
            <button type="submit" class="btn btn-<?php echo PRIMARY; ?> btn-sm" value="submit" name="submit"><i class="glyphicon glyphicon-filter"></i> Filter</button>
        </form>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">User Account List</h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover">
                <tr>
                    <th><input type="checkbox" class="checkall" /></th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Group</th>
                    <th>Mobile</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php if ($data->num_rows() > 0) { ?>
                    <?php foreach ($data->result_array() as $row) { ?>

                        <tr>
                            <td><input type="checkbox" name="id[]" value="<?php $row['use_id'] ?>" class="checkid" /></td>
                            <td><?php echo $row['use_name']; ?></td>
                            <td><?php echo $row['use_email']; ?></td>
                            <td><?php echo $row['gro_name']; ?></td>
                            <td><?php echo $row['use_tel']; ?></td>
                            <td><?php echo $row['use_address']; ?></td>
                            <td><?php echo status_string($row['use_status']); ?></td>
                            <td>
<!--                                <a class="btn btn-default btn-xs" href="<?php echo base_url(); ?>users/accounts/view/<?php
                                echo $row['use_id'];
                                echo '/' . $this->uri->segment(4);
                                ?>" title="View"><i class="glyphicon glyphicon-eye-open"></i> View</a>-->
                                <a class="btn btn-default btn-xs" href="<?php echo base_url(); ?>users/accounts/edit/<?php
                                   echo $row['use_id'];
                                   echo '/' . $this->uri->segment(4);
                                   ?>" title="Edit"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                                   <a class="btn btn-warning btn-xs" href="<?php echo base_url(); ?>users/accounts/resetPass/<?php
                           echo $row['use_id'];
                           echo '/' . $this->uri->segment(4);
                           ?>" title="Delete" onclick="return confirm('Are you sure you want to reset this user account? This user account password will be change to default  permanently.');"><i class="glyphicon glyphicon-remove-circle"></i> Reset password</a>
                                <a class="btn btn-danger btn-xs" href="<?php echo base_url(); ?>users/accounts/delete/<?php
                           echo $row['use_id'];
                           echo '/' . $this->uri->segment(4);
                           ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this user account? This user account will be deleted permanently.');"><i class="glyphicon glyphicon-remove-circle"></i> Delete</a>
                            </td>
                        </tr>

                    <?php } ?>
<?php } else { ?>
                    <tr><td colspan="7">Empty</td></tr>
    <?php } ?>
            </table>
        </div>
    </div>
<?php echo $this->pagination->create_links(); ?>
</div>

