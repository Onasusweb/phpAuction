 <?php 
 error_reporting(E_ALL);
 ini_set('display_errors', '1');
 
 include('db.php');
 include('header.php');
 ?>
	   <div id="row">
	   
	   		<h1 class="addPaddingH1">Welcome...</h1>
			<p class="lead">This is a demo site for an auction. Please note that this code does not have any payment methods. It will be up to you to decide how to do this. In this example, an email will be sent to the winning bidder to contact someone.</p> 
		 
			<!-- start item list -->
			<ul class="thumbnails list-unstyled">
				<?php frontPageSelectListings();?>
			</ul>
	    </div>
		<div class="clearfix">&nbsp;</div>
	<!-- Modal -->
	 <div class="modal fade" id="auctionmodals">
		    <div class="modal-dialog">
		      <div class="modal-content">
		        <div class="modal-header">
		          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		          <h4 class="modal-title"></h4>
		        </div>
		        <div class="modal-body">
           
            <div id="auctioninfo"></div>
        </div>
		        <div class="modal-footer">
		        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </div>
		      </div><!-- /.modal-content -->
		    </div><!-- /.modal-dialog -->
		  </div><!-- /.modal -->

<?php include('footer.php');?>