<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <?php
            if (!empty($this->session->flashdata('errors'))) {
                echo '<div class="alert alert-danger fade in alert-dismissable" title="Error:"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>';
                echo $this->session->flashdata('errors');
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>
<div id="show-section" class="container-fluid show-edit-visible">
    <div class="row page-header-buttons">
        <div class="col-md-12">
            <a href="<?= base_url('lead/closed-jobs') ?>" class="btn btn-info btn-fill"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
            <a href="#" class="btn btn-info btn-fill show-edit-toggler"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp; Edit</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="header">
                    <h4 class="title">Job Details</h4>
                </div>
				<div class="content view">
					<div class="row">
						<div class="col-md-12">
                        #<?= (1600 + $job->id); ?><br />
						<?= $job->firstname ?> <?= $job->lastname ?><br />
						<?= $job->address ?><br />
						<?= $job->city ?>, <?= $job->state ?><br />
						C - <?= $job->phone1 ?><br />
						<?= $job->email ?>
						</div>
					</div>
				</div>
                <div class="footer">
                    <a href="<?= base_url('lead/closed-job/' . $job->id . '/photos') ?>" class="btn btn-fill">Photos</a>
                    <a href="<?= base_url('lead/closed-job/' . $job->id . '/reports') ?>" class="btn btn-fill">Photo Report</a>
                    <a href="<?= base_url('lead/closed-job/' . $job->id . '/docs') ?>" class="btn btn-fill">Docs</a>
                    <a href="<?= base_url('lead/closed-job/' . $job->id . '/notes') ?>" class="btn btn-fill">Notes</a>
                    <a href="<?= base_url('lead/closed-job/' . $job->id . '/public-folder') ?>" class="btn btn-fill">Public Folder</a>
                </div>
            </div>
            <div class="card">
                <div class="header">
                    <h4 class="title" style="float: left;">Additional Party Detail</h4>
                    <div class="clearfix"></div>
                </div>
                <div class="content view">
                    <?php if (!empty($add_info)) : ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <p><?= $add_info->fname ? $add_info->fname : '-' ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <p><?= $add_info->lname ? $add_info->lname : '-' ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <p><?= $add_info->phone ? $add_info->phone : '-' ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <p><?= $add_info->email ? $add_info->email : '-' ?></p>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="row">
                            <div class="col-md-12">
                                No record!
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card">
                <div class="header">
                    <h4 class="title" style="float: left;">Status</h4>
                    <span class="status">
                        <?= LeadModel::statusToStr($job->status) ?>
                    </span>
                    <div class="clearfix" style="padding: 10px;"></div>
                    <?php if($job->category !== null) { ?>
                    <h4 class="title" style="float: left;">Category</h4>
                    <span class="status">
                        <?= LeadModel::categoryToStr($job->category); ?>
                    </span>
                    <div class="clearfix" style="padding: 10px;"></div>
                    <?php } ?>
                    <h4 class="title" style="float: left;">Job Type</h4>
                    <span class="status">
                        <?= LeadModel::typeToStr($job->type) ?>
                    </span>
                    <div class="clearfix" style="padding: 10px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="header">
                    <h4 class="title" style="float: left;">Team Detail</h4>
                    <?php if (!empty($teams_detail)) : ?>
                        <?php foreach ($teams_detail as $data) : ?>
                            <div style="float: right;text-align: right;">
                                <p><?= $data->name ?></p>
                                <p><?= $data->assign_date ?></p>
                            </div>
                        <?php endforeach ?>
                    <?php else : ?>
                        <p style="float: right;color: red;margin-bottom: 20px;"> No Team Assigned!</p>
                    <?php endif ?>
                </div>
            </div>
            <?php if ($job->status == 7) : ?>
                <div class="card">
                    <div class="header">
                        <h4 class="title" style="float: left;">Insurance Details</h4>
                        <div class="clearfix"></div>
                    </div>
                    <div class="content">
                        <?php if ($insurance_job_details) : ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Insurance Carrier</label>
                                        <p><?= $insurance_job_details->insurance_carrier ?></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Carrier Phone #</label>
                                        <p><?= $insurance_job_details->carrier_phone ?></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Carrier Email</label>
                                        <p><?= $insurance_job_details->carrier_email ?></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Policy #</label>
                                        <p><?= $insurance_job_details->policy_number ?></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Date of Loss</label>
                                        <p><?= date('M j, Y', strtotime($insurance_job_details->date_of_loss)) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="row">
                                <div class="col-md-12">
                                    No record!
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card">
                    <div class="header">
                        <h4 class="title">Adjuster List</h4>
                    </div>
                    <div class="content">
                        <div class="content table-responsive table-full-width">
                            <table class="table table-hover table-striped">
                                <tr>
                                    <th>Adjuster</th>
                                    <th>Adjuster Phone #</th>
                                    <th>Adjuster Email</th>
                                </tr>
                                <?php if (!empty($insurance_job_adjusters)) : ?>
                                    <?php foreach ($insurance_job_adjusters as $insurance_job_adjuster) : ?>
                                        <tr>
                                            <td><?= $insurance_job_adjuster->adjuster ?></td>
                                            <td><?= $insurance_job_adjuster->adjuster_phone ?></td>
                                            <td><?= $insurance_job_adjuster->adjuster_email ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="3" class="text-center">No Record Found!</td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-4">
			<div class="row">
				<div class="col-md-12">
					<h3>Activity Log</h3>
				</div>
			</div>
			<div class="row activity-logs">
				<div class="col-md-12">
					<?php
					foreach ($aLogs as $aLog) {
						echo '<p>' . ActivityLogsModel::stringifyLog($aLog) . '</p>';
					}
					?>
				</div>
			</div>
        </div>
    </div>
</div>
<!-- Edit Section -->
<div id="edit-section" class="container-fluid">
    <div class="row page-header-buttons">
        <div class="col-md-8">
            <a href="#" class="btn btn-info btn-fill show-edit-toggler"><i class="fa fa-chevron-left" aria-hidden="true"></i>&nbsp; Back</a>
            <a href="<?= base_url('lead/' . $job->id . '/delete') ?>" data-method="POST" class="btn btn-danger btn-fill show-edit-toggler pull-right"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp; Delete</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="header">
                    <h4 class="title">Update Leads / Clients</h4>
                </div>
                <div class="content">
                    <div class="row">
                        <div id="validation-errors" class="col-md-12">
                        </div>
                    </div>
                    <?= form_open('lead/closed-job/' . $job->id . '/update', array('id' => 'lead_edit', 'method' => 'post', 'novalidate' => true)) ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name<span class="red-mark">*</span></label>
                                <input class="form-control" name="firstname" value="<?= $job->firstname ?>" placeholder="" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last Name<span class="red-mark">*</span></label>
                                <input class="form-control" placeholder="Last Name" name="lastname" value="<?= $job->lastname ?>" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Address<span class="red-mark">*</span></label>
                                <input class="form-control" placeholder="Address" name="address" value="<?= $job->address ?>" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>City<span class="red-mark">*</span></label>
                                <input class="form-control" placeholder="City" value="<?= $job->city ?>" name="city" type="text">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>State<span class="red-mark">*</span></label>
                                <input class="form-control" placeholder="State" Name="state" value="<?= $job->state ?>" type="text">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Postal Code<span class="red-mark">*</span></label>
                                <input class="form-control" placeholder="ZIP Code" value="<?= $job->zip ?>" name="zip" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cell Phone<span class="red-mark">*</span></label>
                                <input class="form-control" placeholder="Phone 1" name="phone1" value="<?= $job->phone1 ?>" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Home Phone</label>
                                <input class="form-control" placeholder="Phone 2" name="phone2" value="<?= $job->phone2 ?>" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" name="email" placeholder="Email" value="<?= $job->email ?>" type="email">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Lead Source</label>
                                <select name="lead_source" class="form-control">
                                    <option value="" disabled<?= (empty($job->lead_source) ? ' selected' : '') ?>>Select Lead Source</option>
                                    <?php foreach ($leadSources as $leadSource) {
                                        echo '<option value="' . $leadSource->id . '"' . ($job->lead_source == $leadSource->id ? ' selected' : '') . '>' . $leadSource->name . '</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-info btn-fill pull-right">Update</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <?= form_close() ?>
                </div>

            </div>
            <div class="card">
                <div class="header">
                    <h4 class="title">Additional Party</h4>
                </div>
                <div class="content">
                    <?php if (!empty($add_info)) : ?>
                        <?= form_open('lead/closed-job/' . $job->id . '/party/update', array('method' => 'post')) ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input class="form-control" name="firstname" value="<?= $add_info->fname ?>" placeholder="First Name" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input class="form-control" placeholder="Last Name" name="lastname" value="<?= $add_info->lname ?>" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input class="form-control" placeholder="Phone" name="phone" value="<?= $add_info->phone ?>" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" placeholder="Email" name="email" value="<?= $add_info->email ?>" type="text">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-info btn-fill pull-right">Update</button>
                            </div>
                        </div>
                        <?= form_close() ?>
                    <?php else : ?>
                        <?= form_open('lead/closed-job/' . $job->id . '/party/add', array('method' => 'post')) ?>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input class="form-control" name="firstname" value="" placeholder="First Name" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input class="form-control" placeholder="Last Name" name="lastname" value="" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input class="form-control" placeholder="Phone" name="phone" value="" type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input class="form-control" placeholder="Email" name="email" value="" type="text">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-info btn-fill pull-right">Save</button>
                            </div>
                        </div>
                        <?= form_close() ?>

                    <?php endif; ?>
                </div>
            </div>
            <div class="card">
                <?= form_open('lead/closed-job/' . $job->id . '/updatestatus', array('method' => 'post')) ?>
                <div class="header">
                    <h4 class="title" style="float: left;">Contract Status</h4>
                    <span class="status">
                        <?= LeadModel::statusToStr($job->status) ?>
                    </span>
                    <div class="clearfix"></div>
                    <div class="content">
                        <select class="form-control" id="lead" name="status">
                            <option value="" disabled <?= is_null($job->status) ? 'selected' : '' ?>>Select Contract Status</option>
                            <optgroup label="Leads">
                                <option value="0" <?= ("0" == $job->status) ? 'selected' : '' ?>>New</option>
                                <option value="1" <?= ("1" == $job->status) ? 'selected' : '' ?>>Appointment Scheduled</option>
                                <option value="2" <?= ("2" == $job->status) ? 'selected' : '' ?>>Needs Follow Up Call</option>
                                <option value="3" <?= ("3" == $job->status) ? 'selected' : '' ?>>Needs Site Visit</option>
                                <option value="4" <?= ("4" == $job->status) ? 'selected' : '' ?>>Needs Estimate / Bid</option>
                            </optgroup>
                            <optgroup label="Prospects">
                                <option value="5" <?= ("5" == $job->status) ? 'selected' : '' ?>>Estimate Sent</option>
                                <option value="6" <?= ("6" == $job->status) ? 'selected' : '' ?>>Ready to Sign / Verbal Go</option>
                                <option value="12" <?= ("12" == $job->status) ? 'selected' : '' ?>>Cold</option>
                                <option value="13" <?= ("13" == $job->status) ? 'selected' : '' ?>>Postponed</option>
                                <option value="14" <?= ("14" == $job->status) ? 'selected' : '' ?>>Dead / Lost</option>
                            </optgroup>
                            <optgroup label="Prospects">
                                <option value="7" <?= ("7" == $job->status) ? 'selected' : '' ?>>Signed</option>
                                <option value="8" <?= ("8" == $job->status) ? 'selected' : '' ?>>In Production</option>
                                <option value="9" <?= ("9" == $job->status) ? 'selected' : '' ?>>Completed</option>
                                <option value="10" <?= ("10" == $job->status) ? 'selected' : '' ?>>Closed</option>
                                <option value="11" <?= ("11" == $job->status) ? 'selected' : '' ?>>Archive</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="header">
                    <h4 class="title" style="float: left;">Category</h4>
                    <?php if ($job->category !== null) { ?>
                        <span class="status">
                            <?= LeadModel::categoryToStr($job->category) ?>
                        </span>
                    <?php } ?>
                    <div class="clearfix"></div>
                    <div class="content">
                        <select class="form-control" id="category" name="category">
                            <option value="" disabled <?= is_null($job->category) ? 'selected' : '' ?>>Select Category</option>
                            <?php foreach ($lead_category_tags as $s_id => $s_tags) : ?>
                                <option value="<?= $s_id ?>" <?= ((!is_null($job->category)) && $s_id === intval($job->category)) ? 'selected' : '' ?>><?= $s_tags ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="header">
                    <h4 class="title" style="float: left;">Job Type</h4>
                    <span class="status">
                        <?= LeadModel::typeToStr($job->type) ?>
                    </span>
                    <div class="clearfix"></div>
                    <div class="content">
                        <select class="form-control lead-status" id="job" name="type">
                            <option value="" disabled <?= is_null($job->type) ? 'selected' : '' ?>>Select Job Type</option>
                            <?php foreach ($job_type_tags as $j_id => $j) : ?>
                                <option value="<?= $j_id ?>" <?= ((!is_null($job->type)) && $j_id == intval($job->type)) ? 'selected' : '' ?>><?= $j ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-info btn-fill pull-right">Update</button>
                    <div class="clearfix" style="padding: 10px;"></div>
                </div>
                <?= form_close() ?>
            </div>
        </div>

        <div class="col-md-4">
            <?php if (in_array($job->status, [7, 8, 9, 10, 13])) : ?>
                <div class="card">
                    <div class="header">
                        <h4 class="title" style="float: left;">Team Detail</h4>
                        <?php if (!empty($teams_detail)) : ?>
                            <?php foreach ($teams_detail as $data) : ?>
                                <div style="float: right;text-align: right;">
                                    <p><?= $data->name ?></p>
                                    <p><?= $data->assign_date ?></p>
                                    <a href="<?= base_url('lead/closed-job/' . $job->id . '/remove-team') ?>" data-method="POST">Remove</a>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p style="float: right;color: red;margin-bottom: 20px;"> No Team Assigned!</p>
                            <div class="content team-block">
                                <?= form_open('lead/closed-job/' . $job->id . '/add-team', array('method' => 'post')) ?>
                                <select name="team_id" class="form-control team_assign">
                                    <option value="">Select Team</option>
                                    <?php foreach ($teams as $team) : ?>
                                        <option value="<?= $team->id ?>"><?= $team->team_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input class="btn btn-success btn-fill" type="submit" value="Add Team">
                                <?= form_close() ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($job->status == 7) : ?>
                <?php if ($insurance_job_details) : ?>
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Insurance Details</h4>
                        </div>
                        <div class="content">
                            <?= form_open('lead/closed-job/' . $job->id . '/update-insurance-details', array('method' => 'post')) ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Insurance Carrier</label>
                                        <input class="form-control" name="insurance_carrier" placeholder="Insurance Carrier" type="text" value="<?= $insurance_job_details->insurance_carrier ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Carrier Phone #</label>
                                        <input class="form-control" placeholder="Carrier Phone #" name="carrier_phone" type="text" value="<?= $insurance_job_details->carrier_phone ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Carrier Email</label>
                                        <input class="form-control" placeholder="Carrier Email" name="carrier_email" type="text" value="<?= $insurance_job_details->carrier_email ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Policy #</label>
                                        <input class="form-control" placeholder="Policy #" name="policy_number" type="text" value="<?= $insurance_job_details->policy_number ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Date of Loss</label>
                                        <input class="form-control" placeholder="Date of Loss" name="date_of_loss" type="date" value="<?= $insurance_job_details->date_of_loss ?>">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info btn-fill pull-right">Update</button>
                                    </div>
                                </div>
                            </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Insurance Details</h4>
                        </div>
                        <div class="content">
                            <?= form_open('lead/closed-job/' . $job->id . '/insert-insurance-details', array('method' => 'post')) ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Insurance Carrier</label>
                                        <input class="form-control" name="insurance_carrier" placeholder="Insurance Carrier" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Carrier Phone #</label>
                                        <input class="form-control" placeholder="Carrier Phone #" name="carrier_phone" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Carrier Email</label>
                                        <input class="form-control" placeholder="Carrier Email" name="carrier_email" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Policy #</label>
                                        <input class="form-control" placeholder="Policy #" name="policy_number" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label>Date of Loss</label>
                                        <input class="form-control" placeholder="Date of Loss" name="date_of_loss" type="date">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info btn-fill pull-right">Save</button>
                                    </div>
                                </div>
                            </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="card">
                    <div class="header">
                        <h4 class="title">Adjuster List</h4>
                    </div>
                    <div class="content">
                        <div class="content table-responsive table-full-width">
                            <table class="table table-hover table-striped">
                                <tr>
                                    <th>Adjuster</th>
                                    <th>Adjuster Phone #</th>
                                    <th>Adjuster Email</th>
                                    <th>Delete</th>
                                </tr>
                                <?php if (!empty($insurance_job_adjusters)) : ?>
                                    <?php foreach ($insurance_job_adjusters as $insurance_job_adjuster) : ?>
                                        <tr>
                                            <td><?= $insurance_job_adjuster->adjuster ?></td>
                                            <td><?= $insurance_job_adjuster->adjuster_phone ?></td>
                                            <td><?= $insurance_job_adjuster->adjuster_email ?></td>
                                            <td><a href="<?= base_url('lead/closed-job/' . $job->id . '/delete-adjuster/' . $insurance_job_adjuster->id) ?>" data-method="POST" class="text-danger"><i class="fa fa-trash-o"></i></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No Record Found!</td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                        <?= form_open('lead/closed-job/' . $job->id . '/insert-adjuster', array('method' => 'post')) ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Adjuster</label>
                                    <input class="form-control" placeholder="Adjuster" name="adjuster" type="text">
                                </div>
                                <div class="form-group">
                                    <label>Adjuster Phone #</label>
                                    <input class="form-control" placeholder="Adjuster Phone #" name="adjuster_phone" type="text">
                                </div>
                                <div class="form-group">
                                    <label>Adjuster Email</label>
                                    <input class="form-control" placeholder="Adjuster Email" name="adjuster_email" type="text">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-info btn-fill pull-right">Add Adjuster</button>
                                </div>
                            </div>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/leads/edit.js') ?>"></script>