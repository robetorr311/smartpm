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
    <div class="col-md-12">
      <div class="card">
        <div class="header">
          <h4 class="title">Archive Job List</h4>
        </div>
        <div class="content table-responsive table-full-width">
          <table class="table table-hover table-striped">
            <thead>
              <th>View</th>
              <th>Job Number</th>
              <th>Lead Name</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Address</th>
              <th>Status</th>
              <th>Contract</th>
            </thead>
            <tbody id="myTable">
              <?php if (!empty($leads)) : ?>
                <?php
                foreach ($leads as $lead) : ?>
                  <?php $date =  date("Y-m-d h:i:s", strtotime('-30 days'));
                  if (strtotime($lead->date) < strtotime($date) and strtotime($lead->date) != 0) {
                    ?>
                    <tr>
                      <td style="width: 30px"><a href="<?php echo base_url('lead/' . $lead->id); ?>"><i class="pe-7s-look" style="font-size: 30px" /></a></td>
                      <td><?php echo $lead->job_number; ?></td>
                      <td><?php echo $lead->job_name ?></td>
                      <td><?php echo $lead->firstname ?></td>
                      <td><?php echo $lead->lastname ?></td>
                      <td><?php echo $lead->address ?></td>
                      <td><?php echo $lead->lead_status ?></td>
                      <td><?php echo $lead->contract_status ?></td>
                    </tr>
                  <?php
                  }
                endforeach; ?>
              <?php else : ?>
                <tr>
                  <td colspan="8" class="text-center">No Record Found!</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
          <div class="pagination">
            <?= $pagiLinks ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>