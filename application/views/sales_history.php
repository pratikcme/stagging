<?php
   include('header.php');
   $vendor_id = $this->session->userdata('id');
   ?> 
<style>
   @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
    body{
        font-family: 'Roboto', sans-serif;
    }
   .panel-heading {
   background: #5b6e84;
   font-size: 16px;
   font-weight: 300;
   color: white;
   }
   .btn-primary {
   margin-bottom: 3px;
   margin-top: 3px;
   }
   .btn-primary {
   background-color: #41cac0;
   border-color: #41cac0;
   color: #FFFFFF;
   }
   .section-title{
      background:transparent;
      padding: 10px 0px;
   }
   .section-title h3 {
      color:#000;
      font-weight:bold;
      text-transform:capitalize;
      margin:0px;
   }
   .sales-history-sec{
      background: #fff;
    padding: 10px 0px;
    margin-top: 10px;
   }
   .search-sales-history label{
      color: #000000;
    text-transform: capitalize;
    font-size: 14px;
   }
   .search-sales-history .form-control{
      font-weight: 400;
    font-size: 14px;
    width: 100%;
    height: auto;
    padding: 8px 10px;
    outline: none;
    box-shadow: none;
    background-color: #fff;
    border: 2px solid #e7e5e8;
    border-radius: 4px;
}
.search-sales-history .form-control::placeholder{
   text-transform:capitalize;
}
.table-wrapper{
   background-color:#fff;
   border-radius: 5px;
   margin-top: 25px;
}
.profile-avatar {
    width: 40px;
    height: 40px;
    background: #5b6e84;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 5px;
    color: #fff;
    font-weight: 600;
}

.customer-wrap {
    display: flex;
    align-items: center;
}

.customer-wrap .list-items {
    margin-left: 15px;
}

.customer-wrap .list-items h4,
.customer-wrap .list-items p {
    margin: 0;
}

.sales-table {
   margin-top: 15px;
   color: #000000;
}

.sales-table>tbody>tr>td {
   vertical-align: middle;
}

.sales-table>tbody>tr {
   border-bottom: 1px solid #ddd;
   border-top: 1px solid #ddd;
}

.sales-table tr td span {
   display: inline-block;
   background-color: #5b6e84;
   width: 35px;
   height: 35px;
   border-radius: 3px;
   text-align: center;
   line-height: 35px;
}

.sales-table tr td span i {
   color: #fff;
}

.sale-detail {
   color: #000
}

#view .modal-dialog {
   width: 100%;
    max-width: 800px;
}

.order_data_view {
   text-align: right;
}

.order_data_view ul {
   max-width: 288px;
    width: 100%;
    margin-left: auto;
}

.order_data_view ul li div {
   display: flex;
   align-items: center;
   justify-content: flex-end;
   border-bottom: 1px solid #ddd;
}

.order_data_view ul li div h6 {
   color: #000;
   width: 50%;
}

.order_data_view ul li div h6:first-child {
   text-align: left;
}

.customer_name_date {
   display: flex;
   align-items: center;
   justify-content: space-between;
   margin-bottom: 15px;
   color: #000;
}

#view .modal-header {
   background-color: #fff;
   color: #000;
} 

#view .modal-header h4.modal-title {
   font-weight: bold;
   font-size: 28px;
}

</style>
<section id="main-content">
   <section class="wrapper site-min-height">
      <!-- page start-->
   <section class="section-title">
      <div class="container">
         <h3>Sales History</h3>
      </div>
   </section>   
   <section class="sales-history-sec" style="display: none">
          <div class="container">
         <div class="row">
            <div class="col-lg-4">
               <div class="search-sales-history">
                  <!-- <label for="">Status</label> -->
                 <select name="" id="" class="form-control">
                     <option>All</option>
                     <option>Parked Sale</option>
                     <option>Completed Sale</option>
                     <option>Delivered Sales</option>
                 </select>
               </div>
            </div>
            <div class="col-lg-4">
               <div class="search-sales-history">
                  <!-- <label for="">Customer</label> -->
                  <input type="text" class="form-control" placeholder="search for customer"/>
               </div>
            </div>
            <div class="col-lg-4">
               <div class="search-sales-history">
                  <!-- <label for="">Receipt </label> -->
                  <input type="text" class="form-control"  placeholder="search for receipt number"/>
               </div>
            </div>
         </div>
      </div>
</section>

<!-- table -->
<section class="table-wrapper">
   <div class="container">
      <table class="table sales-table" id="sales_history">
         <thead>
            <tr>
               <th>Sno.</th>
               <th>Receipt</th>
               <th>Customer</th>
               <th>Sold by</th>
               <th>Sale Total	</th>
               <!-- <th>Status</th> -->
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
         <!--    <tr>
               <td>
                  <div>
                     <div>
                        <h5>1</h5>
                        <h5>18 Jan 2022, 3:58pm</h5>
                     </div>
                  </div>
               </td>
               <td>
                  <ul>
                     <li class="popover-list-item">
                        <a href="#">
                           <div class="customer-wrap">
                              <div class="profile-avatar">
                                 HM
                              </div>
                              <div class="list-items">
                                 <h4><a href="#">hinal</a></h4> 
                                 <p>hinal-H2YK | IN</p>
                              </div>
                           </div>
                        </a>
                     </li>
                  </ul>                 
               </td>
               <td>
                  <ul>
                     <li class="popover-list-item">
                        <a href="#">
                           <div class="customer-wrap">
                              <div class="profile-avatar">
                                 SH
                              </div>
                              <div class="list-items">
                                 <h4>Shahid</h4> 
                                 <p>Main Outlet</p>
                              </div>
                           </div>
                        </a>
                     </li>
                  </ul>
               </td>
               <td>10.00</td>
               <td>Completed</td>
               <td>
                  <span data-toggle="modal" data-target="#view"><i class="fa fa-eye" aria-hidden="true"></i></span>
                  <span><i class="fa fa-trash" aria-hidden="true"></i></span>
               </td>
            </tr>

            <tr>
               <td>
                  <div>
                     <div>
                        <h5>1</h5>
                        <h5>18 Jan 2022, 3:58pm</h5>
                     </div>
                  </div>
               </td>
               <td>
                  <ul>
                     <li class="popover-list-item">
                        <a href="#">
                           <div class="customer-wrap">
                              <div class="profile-avatar">
                                 HM
                              </div>
                              <div class="list-items">
                                 <h4><a href="#">hinal</a></h4> 
                                 <p>hinal-H2YK | IN</p>
                              </div>
                           </div>
                        </a>
                     </li>
                  </ul>                 
               </td>
               <td>
                  <ul>
                     <li class="popover-list-item">
                        <a href="#">
                           <div class="customer-wrap">
                              <div class="profile-avatar">
                                 HM
                              </div>
                              <div class="list-items">
                                 <h4>Hinal Modi</h4> 
                                 <p>Main Outlet</p>
                              </div>
                           </div>
                        </a>
                     </li>
                  </ul>
               </td>
               <td>10.00</td>
               <td>Completed</td>
               <td>
                  <span data-toggle="modal" data-target="#view"><i class="fa fa-eye" aria-hidden="true"></i></span>
                  <span><i class="fa fa-trash" aria-hidden="true"></i></span>
               </td>
            </tr> -->
         </tbody>
      </table>
   </div>
</section>

  <!-- Modal -->
  <div class="modal fade" id="view" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Sale Details</h4>
        </div>
        <div class="modal-body">
           <div class="customer_name_date" id="dynamic_date">
              <!--  <h4>Hinal Modi</h4>
               <h5> <span>Date : </span> 2022-01-18 </h5> -->
           </div>
            <table class="table sale-detail">
               <thead>
                  <tr>
                     <th>Product Name</th>
                     <th>Quantity</th>
                     <th>Discount(%)</th>
                     <th>Price($)</th>
                  </tr>
               </thead>
               <tbody id="dynamic_tr">
               </tbody>
            </table>
            <div class="order_data_view">
               <ul id="dynamic_li">
                  
               </ul>
            </div>
        </div>
      </div>
    </div>
  </div>
  

      <!-- page end-->
   </section>
</section>
<script src="<?php echo base_url(); ?>public/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript">
   setTimeout( function(){$('#msg').hide();} , 4000);
   
   $(document).ready(function() {
       oTable = $('#example_sales').dataTable({
           "aaSorting": [[8,'desc']],
           "oLanguage": {
               "sEmptyTable" : "Sell History Not Available",
               "sZeroRecords": "Sell History Not Available",
        }
       });
   });
   
   /*Single Delete Script*/
   function single_delete(value) {
   
       bootbox.confirm("Are you sure you want to delete ?" , function (confirmed) {
           if (confirmed == true) {
   
               var id = value;
   
               $.ajax({
                   url: '<?php echo base_url().'index.php/sell/single_delete_sell_sales_history/'; ?>' ,
                   data: {
                       ids: id.toString(),
                   },
                   success: function (data) {
   
   
   
                       if (data.status == 1) {
                           bootbox.alert("Sales history has been deleted successfully.", function() {
                               window.location.reload(true);
                           });
                       }
                       else {
                           alert('Failed to delete selected sales history.');
                       }
                   },
                   error: function () {
                       alert('Failed to delete selected sales history.');
                   }
               });
           }
           else
           {
               window.location.reload(true);
           }
       });
   }
</script>
<?php include('footer.php'); ?>