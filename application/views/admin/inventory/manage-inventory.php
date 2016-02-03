<?php echo $this->load->view('admin/header') ?>
    <div class="global-cont">

    <div class='bg-body'>
        <div class="bg-body-top"> </div>
        <div class="bg-body-middle clearfix">
            <div id="left-sidebar" class="clearfix fl">
                <?php echo $this->load->view('admin/inventory/sidebar') ?>
            </div>
            <div class='right-cont clearfix fr'>
                <h3>Magane Inventory Page</h3>
                <p>
                    To delete inventory please select <b>delete.txt/delete.csv</b> file that has one column with SKUs in it.
                </p>
                <div class='informative-format'>
                    <!-- Form -->
                    <?php echo form_open_multipart(current_url());?>
                    <div class="" id="datafeed-file">
                        <input type="file" name="userfile" id="userfile"/>
                        <img src="<?php echo base_url()?>images/ajax-payment.gif" id="upload-loader" style="display: none;" />
                    </div>
                    <?php if($results['error']): ?>
                        <div class="import-error"><?php echo $results['error'] ?></div>
                    <?php endif ?>
                    <?php if($results && !$results['error'] && false): ?>
                        <div class="import-success">
                            <p>Imported <?php echo $results['imported'] ?> of <?php echo $results['total'] ?> rows.
                                Deleted: <?php echo $results['deleted'] ?>.
                            </p>
                        </div>
                        <?php if($results['verr']): ?>
                            <div class="import-error"><?php echo $results['verr'] ?></div>
                        <?php endif ?>
                    <?php endif ?>
                    <input type='submit' class='greenbutton' name="import" onclick="$('#upload-loader').show();return true;" value='Delete' />
                    <br/><br/>
                    <?php echo form_close();?>
                </div>

                <div class="violet-table">
                    <table class="list-product-result">
                        <tr>
                            <td>Time</td>
                            <td>Status</td>
                            <td>Total</td>
                            <td>Imported</td>
                            <td>Deleted</td>
                            <td>Validation Errors</td>
                            <td>File type</td>
                            <td>Type</td>
                        </tr>
                        <?php foreach($history as $row): ?>
                            <tr>
                                <td><?php echo date('m/d/Y H:i:s', strtotime($row->created_at)) ?> EST</td>
                                <td><?php if($row->success == -1): ?>In Process<?php elseif($row->success > 0): ?>Success<?php else: ?>Error: <?php echo $row->results['error'] ?><?php endif ?></td>
                                <td><?php echo $row->total ?></td>
                                <td><?php echo $row->updated + $row->inserted ?></td>
                                <td><?php echo $row->deleted ?></td>
                                <td>
                                    <a href="#" onclick="$.magnificPopup.open({items: {src: $('#verrors-<?php echo $row->id ?>'),type: 'inline'}});;return false;" rel="<?php echo $row->id ?>">view</a>
                                    <div id="verrors-<?php echo $row->id ?>" class="import-error white-popup mfp-hide">
                                        <?php echo $row->results['verr'] ?>
                                    </div>
                                </td>
                                <td><?php echo $row->file_type ?></td>
                                <td><?php if($row->type == 0): ?>Web<?php else: ?>FTP/Cron<?php endif ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                    <?php if($history_pages > 1): ?>
                        <ul class="pagination">
                            <?php for($i = 1; $i <= $history_pages; $i++): ?>
                                <?php if($i == $page): ?>
                                    <li><span><?php echo $i ?></span></li>
                                <?php else: ?>
                                    <li><a href="/inventory/manage?page=<?php echo $i ?>"><?php echo $i ?></a></li>
                                <?php endif ?>
                            <?php endfor ?>
                        </ul>
                    <?php endif ?>
                </div>
            </div>

            <div class="bg-body-bottom"> </div>
        </div>
    </div>
<?php echo $this->load->view('admin/footer') ?>