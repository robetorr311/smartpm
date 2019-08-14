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
        <div class="col-lg-9">
            <div class="card lead-notes-card">
                <div class="header">
                    <h4 class="title">Lead Notes</h4>
                </div>
                <div class="content view">
                    <?php
                    if ($notes) {
                        foreach ($notes as $note) {
                            echo '<div class="row note-item">';
                            echo '<div class="col-md-12">';
                            echo '<label>' . $note->created_user_fullname . '</label>';
                            echo '<a href="' . base_url('lead/' . $lead->id . '/note/' . $note->id . '/delete') . '" data-method="POST" class="text-danger pull-right"><i class="fa fa-trash-o"></i></a></a>';
                            echo '<p>' . $note->note . '</p>';
                            echo '<div style="text-align: right;">';
                            echo '<small><a href="' . base_url('lead/' . $lead->id . '/note/' . $note->id . '/replies') . '">Thread Details</a></small>';
                            echo '</div>';
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
                    <h4 class="title">Add Note</h4>
                </div>
                <div class="content view">
                    <div class="row add-note-form">
                        <div class="col-md-12">
                            <form action="<?= base_url('lead/' . $lead->id . '/add-note') ?>" method="post">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Your Note<span class="red-mark">*</span></label>
                                            <textarea id="note-input" class="form-control" name="note" placeholder="Your Note (You can use Ctrl + Enter for Submit)" rows="10" ctrl-enter-submit></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <a href="<?= base_url('lead/' . $lead->id) ?>" class="btn btn-info btn-fill">Back</a>
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
        <div class="col-lg-3">
            <div class="card">
                <div class="header">
                    <h4 class="title">Task Details</h4>
                </div>
                <div class="content view">
                    <div class="row">
                        <div class="col-md-12">
                            <label>Lead Name</label>
                            <p><?= $lead->job_name ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>First Name</label>
                            <p><?= $lead->firstname ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Last Name</label>
                            <p><?= $lead->lastname ?></p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
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