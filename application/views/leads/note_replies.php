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

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="header">
                    <h4 class="title">Leads / Clients Detail</h4>
                </div>
				<div class="content view">
					<div class="row">
						<div class="col-md-12">
						<?= $lead->firstname ?> <?= $lead->lastname ?><br />
						<?= $lead->address ?><br />
						<?= $lead->city ?>, <?= $lead->state ?><br />
						C - <?= $lead->phone1 ?><br />
						<?= $lead->email ?>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card lead-notes-card">
                <div class="header">
                    <h4 class="title">Note Thread</h4>
                </div>
                <div class="content view">
                    <div class="row note-item">
                        <div class="col-md-12">
                            <label><?= $note->created_user_fullname ?></label>
                            <a href="<?= base_url('lead/' . $sub_base_path . $lead->id . '/note/' . $note->id . '/delete') ?>" data-method="POST" class="text-danger pull-right"><i class="fa fa-trash-o"></i></a></a>
                            <p><?= $note->note ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card lead-notes-card">
                <div class="header">
                    <h4 class="title">Note Replies</h4>
                </div>
                <div class="content view">
                    <?php
                    if ($note_replies) {
                        foreach ($note_replies as $note_reply) {
                            echo '<div class="row note-item">';
                            echo '<div class="col-md-12">';
                            echo '<label>' . $note_reply->created_user_fullname . '</label>';
                            echo '<a href="' . base_url('lead/' . $sub_base_path . $lead->id . '/note/' . $note->id . '/reply/' . $note_reply->id . '/delete') . '" data-method="POST" class="text-danger pull-right"><i class="fa fa-trash-o"></i></a></a>';
                            echo '<p>' . $note_reply->reply . '</p>';
                            echo '<small class="date-created">' . $note->created_at . '</small>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>-</p>';
                    }
                    ?>
                </div>
            </div>
            <div class="card add-note-card">
                <div class="header">
                    <h4 class="title">Reply on Note Thread</h4>
                </div>
                <div class="content view">
                    <div class="row add-note-form">
                        <div class="col-md-12">
                            <form action="<?= base_url('lead/' . $sub_base_path . $lead->id . '/note/' . $note->id . '/reply') ?>" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Your Reply<span class="red-mark">*</span></label>
                                            <textarea id="note-input" class="form-control" name="reply" placeholder="Your Reply (You can use Ctrl + Enter for Submit)" rows="10" ctrl-enter-submit></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <a href="<?= base_url('lead/' . $sub_base_path . $lead->id . '/notes') ?>" class="btn btn-info btn-fill">Back</a>
                                            <button type="submit" class="btn btn-info btn-fill pull-right">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#note-input').atwho({
            at: '@',
            data: <?= json_encode($users) ?>,
            headerTpl: '<div class="atwho-header">User List:</div>',
            displayTpl: '<li>${name} (@${username})</li>',
            insertTpl: '${atwho-at}${username}',
            searchKey: 'username',
            limit: 100
        });
    });
</script>