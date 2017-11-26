<?php $this->load->view('admin/partials/admin_header.php'); ?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.5/fullcalendar.min.css">

<style>
    .fc-day-grid-event > .fc-content {
        white-space: nowrap;
        overflow: hidden;
    }
</style>
<!-- page content -->
<div class="right_col" role="main">
    <div class="productsList">
        <div class="page-title">
            <div class="title_left">
                <h3>Employée</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Détails
                            <!--<small>Activity report</small>-->
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Settings 1</a>
                                    </li>
                                    <li><a href="#">Settings 2</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                       <div class="row">
                           <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                               <div class="profile_img">
                                   <div id="crop-avatar">
                                       <!-- Current avatar -->
                                       <img class="img-responsive avatar-view"
                                            src="<?php echo base_url('assets/images/').'/'. $employee['image']; ?>" alt="Avatar"
                                            title="Change the avatar">
                                   </div>
                               </div>
                               <h3><span class="provider-firstName"><?php echo $employee['prenom'];?></span> <span class="provider-lastName"><?php echo $employee['name']; ?></span>
                               </h3>
                               <input type="hidden" value="1" id="provider_id"
                                      data-id="<?php echo $employee['id']; ?>"/>
                               <ul class="list-unstyled user_data">
                                   <li><i class="fa fa-map-marker user-profile-icon"></i><span class="provider-address"><?php echo $employee['address']; ?></span>
                                   </li>

                                   <li>
                                       <i class="fa fa-briefcase user-profile-icon"> <?php echo $employee['workType']; ?></i>
                                   </li>

                                   <li>
                                       <i class="fa fa-phone provider-phone"><?php echo $employee['phone']; ?></i>
                                   </li>
                               </ul>

                              <!-- <a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>-->
                               <br/>

                           </div>
                           <div class="col-md-9 col-sm-9 col-xs-12">

                               <div class="profile_title">
                                   <div class="col-md-12">
                                       <div class="x_panel">
                                           <div class="x_title">
                                               <h2>Calendrier de <?php echo $employee['prenom'];?></h2>
                                               <ul class="nav navbar-right panel_toolbox">
                                                   <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                                   </li>
                                                   <li class="dropdown">
                                                       <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                                          role="button"
                                                          aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                                       <ul class="dropdown-menu" role="menu">
                                                           <li><a href="#">Settings 1</a>
                                                           </li>
                                                           <li><a href="#">Settings 2</a>
                                                           </li>
                                                       </ul>
                                                   </li>
                                                   <li><a class="close-link"><i class="fa fa-close"></i></a>
                                                   </li>
                                               </ul>
                                               <div class="clearfix"></div>
                                           </div>
                                           <div class="x_content">

                                               <div class="row">
                                                   <div class="col-md-12">
                                                       <!--<header>
                                                           <h5>Calendar</h5>
                                                       </header>-->
                                                       <div id="calendar_content" class="body">
                                                           <div id='calendar1'></div>
                                                       </div>
                                                   </div>
                                               </div>

                                           </div>
                                       </div>
                                   </div>
                                   <!--<div id="reportrange" class="pull-right"
                                        style="margin-top: 5px; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #E6E9ED">
                                       <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                       <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                                   </div>-->

                               </div>
                           </div>
                       </div>
                        <div class="row table-responsive">
                            <table id="datatable-salary"
                                   class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th>Salaire</th>
                                    <th>Avance</th>
                                    <th>Reste<br></th>
                                    <th>Absences</th>
                                    <th>Soustraction</th>
                                    <th>Date de paiement<br></th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Salaire</th>
                                    <th>Avance</th>
                                    <th>Reste<br></th>
                                    <th>Absences</th>
                                    <th>Soustraction</th>
                                    <th>Date de paiement<br></th>
                                </tr>
                                </tfoot>
                                <tbody>
                                <?php foreach ($salaries as $salary) { ?>
                                    <tr>
                                        <td><?php echo $salary['salary']?>DH</td>
                                        <td><?php echo $salary['advance'];?>DH</td>
                                        <td><?php echo $salary['remain'];?>DH</td>
                                        <td><?php echo $salary['absence'];?></td>
                                        <td><?php echo $salary['substraction'];?></td>
                                        <!--<td><?php /*if($salary['paid']==="true"){echo $salary['paymentDate'];}*/?></td>-->
                                        <td><?php echo $salary['paymentDate']; ?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>


<?php $this->load->view('admin/partials/admin_footer'); ?>






<script src="<?php echo base_url('assets/vendors/moment/min/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/vendors/fullcalendar/dist/fullcalendar.js');  ?>"></script>
<script src="<?php echo base_url("assets/vendors/datatables.net/js/jquery.dataTables.min.js"); ?>"></script>
<script>
    $(document).ready(function () {
        var handleDataTableButtons = function () {
            if ($("#datatable-salary").length) {
                $("#datatable-salary").DataTable({
                    aaSorting: [[0, 'desc']],
                    responsive: true,
                });
            }
        };

        TableManageButtons = function () {
            "use strict";
            return {

                init: function () {
                    handleDataTableButtons();
                }
            };
        }();

        TableManageButtons.init();
    });
</script>

<script>
    $(document).ready(function () {
        function init_calendar() {

            if (typeof ($.fn.fullCalendar) === 'undefined') {
                return;
            }
            console.log('init_calendar');

            var date = new Date(),
                d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear(),
                started,
                categoryClass;
            <?php
            $js_array = json_encode($events);
            echo "var events = " . $js_array . ";\n";
            ?>

            console.log(events);

            var eventsData=[];
              $.each(events, function (key, event) {
                eventItem={
                    'title':event['remarque'],
                    'start':event['day'],
                    'id':event['id']
                };
                eventsData.push(eventItem);
              });

            var calendar = $('#calendar1').fullCalendar({
               /* header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listMonth'
                },*/
                selectable: true,
                selectHelper: true,
                select: function (start, end, jsEvent, view) {
                    var abc = prompt('Enter Title');
                    var allDay = !start.hasTime && !end.hasTime;
                    var newEvent = new Object();
                    newEvent.title = abc;
                    newEvent.start = moment(start).format();
                    newEvent.allDay = false;

                    $('#calendar1').fullCalendar('renderEvent', newEvent);

                    var createEvent={
                       'createEvent':{
                           'day': start.format(),
                           'remarque': abc,
                           'employee': <?php echo $employee['id']; ?>
                       }
                    };

                    var url = "<?php echo base_url('admin/employee/apiCreateEvent')?>";

                    employeeEventService(createEvent, url,'createEvent');

                },
                eventRender: function (event, element) {
                    element.append("<span class='closeon'  style='position: absolute;right: 5px;top: 0px;z-index: 99;'>X</span>");
                    element.find(".closeon").click(function () {
                        $('#calendar1').fullCalendar('removeEvents', event._id);

                        var eventDelete = {
                            'deleteEvent':{
                                'id': event.id,
                                'day': event.start.format(),
                                'employee':'<?php echo $employee['id'];?>'
                            }
                        };

                        var url="<?php echo base_url('admin/employee/apiDeleteEvent')?>"

                        employeeEventService(eventDelete, url,'deleteEvent');
                    });

                   /* element.find(".fc-bg").css("pointer-events", "none");
                    element.append("<div style='position:absolute;bottom:0px;right:0px' ><button type='button'  class='btn btn-block btn-primary btn-flat closeon'>X</button></div>");
                    element.find("#btnDeleteEvent").click(function () {
                        $('#calendar').fullCalendar('removeEvents', event._id);
                    });*/
                },
                eventDrop: function (event, delta, revertFunc) {

                   // alert(event.id + " was dropped on " + event.start.format());

                    /*if (!confirm("Are you sure about this change?")) {
                        revertFunc();
                    }*/
                    var eventUpdate={
                        'updateEvent':{
                            'remarque': event.title,
                            'day': event.start.format(),
                            'employee': <?php echo $employee['id']; ?>,
                            'id': event.id
                        }
                    };
                    var url = "<?php echo base_url('admin/employee/apiUpdateEvent')?>";
                    employeeEventService(eventUpdate, url,'updateEvent');

                },
                eventClick: function (calEvent, jsEvent, view) {
                    $('#fc_edit').click();
                    $('#title2').val(calEvent.title);
                    categoryClass = $("#event_type").val();

                    var title = prompt('Titre:', calEvent.title, {buttons: {Ok: true, Cancel: false}});

                    if (title) {
                        calEvent.title = title;
                        calendar.fullCalendar('updateEvent', calEvent);

                        eventUpdate = {
                           'updateEvent':{
                               'remarque': calEvent.title,
                               'day': calEvent.start.format(),
                               'employee': <?php echo $employee['id']; ?>,
                               'id': calEvent.id
                           }
                        };

                        var url="<?php echo base_url('admin/employee/apiUpdateEvent')?>";

                        employeeEventService(eventUpdate,url,'updateEvent');

                    }
                    calendar.fullCalendar('unselect');
                },
                editable: true,
                events: eventsData
            });

        };

        init_calendar();

        function employeeEventService(data,url,eventType) {
            $.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data: data,
                success: function (data) {
                    if (data.status === 'success') {

                    }
                    else {
                        console.log('Error');
                    }
                },
                error: function (data) {
                }
            });
        }
    });
</script>





