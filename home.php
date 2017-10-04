<?php include('session.php'); ?>

<html>
    <head>
        <title>yourTracker</title>
        <link rel = "stylesheet" type="text/css" href="block.css"/>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </head>
    <body>
        <div id='mydiv'></div>
        <?php
        include("config.php");
        include("ajax.php");
        session_start();
        // Respond to CRUD operations
        if ($_GET) {
            if (isset($_GET['habit'])) {
                recHabit();
            } elseif (isset($_GET['todo'])) {
                recTodo();
            } elseif (isset($_GET['event'])) {
                recEvent();
            } elseif (isset($_GET['eventUpdate'])) {
                eventUpdater($qr);
            }
        }
        
        function createRecord()
        {
            global $db;
            global $login_session;
            $sql = "INSERT INTO record (rec_id, user_id) VALUES (DEFAULT, '$login_session')";
            if (mysqli_query($db, $sql)) {
                //echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($db);
            }
            $sql = "SELECT MAX(rec_id) FROM record";
            if ($result = mysqli_query($db, $sql)) {
                //echo "Grabbed rec_id successfully";
                $row = mysqli_fetch_row($result);
                if (!$row) {
                    echo "Row is empty";
                }
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($db);
            }
            return $row[0];
        }
        
        function createHabit()
        {
            global $db;
            global $login_session;
            $rec_id = createRecord();
            $sql    = "INSERT INTO habit (rec_id, time_stamp) VALUES ('$rec_id', now())";
            if (mysqli_query($db, $sql)) {
                //echo "New habit created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($db);
            }
            return $rec_id;
        }
        
        function recHabit()
        {
            global $db;
            // Grab total minutes
            $hours = $_GET['hours'];
            $mins  = $_GET['mins'];
            ;
            $total   = $hours * 60 + $mins;
            // Grab Macros
            $protein = $_GET['protein'];
            $carbs   = $_GET['carbs'];
            $fats    = $_GET['fats'];
            // Record to database
            $rec_id  = createHabit();
            if (!$rec_id) {
                echo "Error: " . $sql . "<br>" . mysqli_error($db);
            } else {
                // Put sleep in
                $sql = "INSERT INTO sleep (rec_id, duration) VALUES ('$rec_id', '$total')";
                if (mysqli_query($db, $sql)) {
                    // echo "New sleep created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($db);
                }
                // Put Macros in
                $sql = "INSERT INTO nutrition (rec_id, protein, carb, fat) VALUES ('$rec_id', '$protein', '$carbs', '$fats')";
                if (mysqli_query($db, $sql)) {
                    //echo "New macro created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($db);
                }
            }
            header("location:home.php?#");
        }
        
        function recTodo()
        {
            global $db;
            // Grab Fields
            $tname  = $_GET['todoName'];
            $tdesc  = $_GET['todoDesc'];
            $tdate  = $_GET['todoDate'];
            // Record to database
            $rec_id = createRecord();
            if (!$rec_id) {
                echo "Error: " . $sql . "<br>" . mysqli_error($db);
            } else {
                $sql = "INSERT INTO todo (rec_id, timedue, name, description) VALUES ('$rec_id', '$tdate', '$tname', '$tdesc')";
                if (mysqli_query($db, $sql)) {
                    //echo "New todo created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($db);
                }
            }
            header("location:home.php?#");
        }
        
        function recEvent()
        {
            global $db;
            // Grab Fields
            $ename      = $_GET['eventName'];
            $edesc      = $_GET['eventDesc'];
            $edate      = $_GET['edate'];
            $eloc       = $_GET['eventLoc'];
            $etimeStart = $_GET['etimeStart'];
            $etimeEnd   = $_GET['etimeEnd'];
            // Record to database
            $rec_id     = createRecord();
            if (!$rec_id) {
                echo "Error: " . $sql . "<br>" . mysqli_error($db);
            } else {
                $sql = "INSERT INTO event (rec_id, name, description, edate, time_start, time_end, location) VALUES ('$rec_id', '$ename', '$edesc', '$edate', '$etimeStart', '$etimeEnd', '$eloc')";
                if (mysqli_query($db, $sql)) {
                    //echo "New event created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($db);
                }
            }
            //echo ('Hello');
            header("location:home.php?#");
        }
        ?>
        
        <!-- Navbar -->
        <nav class="navbar navbar-inverse navbar-fixed-top">
         <div class="container">
            <div class="navbar-header">
               <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand" href="#">Tracker</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
               <ul class="nav navbar-nav">
                  <p class="navbar-text">Welcome <?php echo $login_email; ?></p>
                  <form class="navbar-form navbar-right">
                     <button id="myHabit"  class="btn btn-success">Add Habit</button>
                     <button id="todobtn"  class="btn btn-success">Add Todo</button>
                     <button id="eventbtn"  class="btn btn-success">Add Event</button>
                  </form>
               </ul>
               <ul class="nav navbar-nav navbar-right">
                  <li><a href = "login.php">Sign Out</a></li>
               </ul>
            </div>
            <!--/.nav-collapse -->
         </div>
        </nav>
        <div class="container">
        	<div class="row">
        		<!-- The Habit Modal -->
        		<div class="modal" id="myModal">
        			<!-- Habit Modal Content -->
        			<div class="modal-content">
        				<div class="modal-header">
        					<span class="close">&times;</span>
        					<h2>Enter your sleeping and eating habits</h2>
        				</div>
        				<div class="modal-body">
        				    <form action="" method="GET" name="">
        					<div class="col-md-12">
        						<div class="table-responsive">
        								<!-- sleep table-->
        								<h4 style="color: green">Sleep Duration</h4>
        								<table class="table table-condensed">
        									<thead>
        										<tr>
        											<th align="left">Hours</th>
        											<th align="left">Minutes</th>
        										</tr>
        									</thead>
        									<tbody>
        										<tr>
        											<td><!-- hour count-->
        											<input class="form-control" min="0" name="hours" type="number" value='0'></td>
        											<td><!-- minute count-->
        											<input class="form-control" min="0" name="mins" type="number" value='0'></td>
        										</tr>
        									</tbody>
        								</table><br>
        								<!-- macro table-->
        								<h4 style="color: green">Macro Count (Grams)</h4>
        								<table class="table table-condensed">
        									<thead>
        										<tr>
        											<th align="left">Proteins</th>
        											<th align="left">Carbohydrates</th>
        											<th align="left">Fats</th>
        										</tr>
        									</thead>
        									<tbody>
        										<tr>
        											<td><!-- protein count--><input class="form-control" min="0" name="protein" type="number" value='0'></td>
        											<td><!-- carb count-->
        											<input class="form-control" min="0" name="carbs" type="number" value='0'></td>
        											<td><!-- fat count-->
        											<input class="form-control" min="0" name="fats" type="number" value='0'></td>
        										</tr>
        									</tbody>
        								</table><br>
                						</div>
                					</div><!-- ends col-12 -->
                				</div>
            				    <div class="modal-footer">
            					    <input class="btn btn-default pull-right" name="habit" type="submit" value="submit">
            				    </div>
        				    </form>
        				<div class="clearfix"></div>
        			</div>
        		</div>
        	</div>
        </div>
        <div class="container">
        	<div class="row">
        		<!--========== Modal 2: Todos ==========-->
        		<!-- The Todo Modal -->
        		<div class="modal" id="todoModal">
        			<!-- Habit Modal Content -->
        			<div class="modal-content">
            				<div class="modal-header">
            					<span class="todoclose">&times;</span>
            					<h2>Enter Todo</h2>
            				</div>
            				<div class="modal-body">
            				<form action="" method="GET" name="">
            					<div class="col-md-12">
            						<div class="table-responsive">
        								<!-- Habit table-->
        								<h4 style="color: green">To Do</h4>
        								<table class="table table-condensed">
        									<thead>
        										<tr>
        											<th align="left">Name</th>
        											<th align="left">Description</th>
        											<th align="left">Date Due</th>
        										</tr>
        									</thead>
        									<tbody>
        										<tr>
        											<td><!-- Name -->
        											<input class="form-control" min="0" name="todoName" type="text" value='MyToDo'></td>
        											<td><!-- Description-->
        											<input class="form-control" min="0" name="todoDesc" type="text" value='MyDesc'></td>
        											<td><!-- Datetime -->
        											<input class="form-control" min="0" name="todoDate" type="datetime-local"></td>
        										</tr>
        									</tbody>
        								</table><br>
            						</div>
            					</div><!-- ends col-12 -->
            				</div>
        				    <div class="modal-footer">
        					    <input class="btn btn-default pull-right" name="todo" type="submit" value="submit">
        				    </div>
        				</form>
        				<div class="clearfix"></div>
        			</div>
        		</div>
        	</div>
        </div>
        <div class="container">
        	<div class="row">
        		<!--========== Modal 3: Events ==========-->
        		<!-- The Event Modal -->
        		<div class="modal" id="eventModal">
        			<!-- Event Modal Content -->
        			<div class="modal-content">
        				<div class="modal-header">
        					<span class="eventclose">&times;</span>
        					<h2>Enter Event</h2>
        				</div>
        				<div class="modal-body">
        					<div class="col-md-12">
        					    <form action="" method="GET" name="">
        						    <div class="table-responsive">
        								<!-- Event text table-->
        								<h4 style="color: green">Event</h4>
        								<table class="table table-condensed">
        									<thead>
        										<tr>
        											<th align="left">Name</th>
        											<th align="left">Description</th>
        											<th align="left">Location</th>
        										</tr>
        									</thead>
        									<tbody>
        										<tr>
        											<td><!-- Name -->
        											<input class="form-control" min="0" name="eventName" type="text" value='MyEvent'></td>
        											<td><!-- Description-->
        											<input class="form-control" min="0" name="eventDesc" type="text" value='MyDesc'></td>
        											<td><!-- Location-->
        											<input class="form-control" min="0" name="eventLoc" type="text" value='MyLoc'></td>
        										</tr>
        									</tbody>
        								</table><br>
        								<!-- Time table -->
        								<h4 style="color: green">Time</h4>
        								<table class="table table-condensed">
        									<thead>
        										<tr>
        											<th align="left">Date</th>
        											<th align="left">Time Start</th>
        											<th align="left">Time End</th>
        										</tr>
        									</thead>
        									<tbody>
        										<tr>
        											<td><!-- Time start--><input class="form-control" min="0" name="edate" type="date"></td>
        											<td><!-- Time start--><input class="form-control" min="0" name="etimeStart" type="time"></td>
        											<td><!-- Time end --><input class="form-control" min="0" name="etimeEnd" type="time"></td>
        										</tr>
        									</tbody>
        								</table>
            						</div>
            					</div><!-- ends col-12 -->
            				</div>
            				<div class="modal-footer">
            					    <input class="btn btn-default pull-right" name="event" type="submit" value="submit">
            				</div>
        				</form>
        				<div class="clearfix"></div>
        			</div>
        		</div>
        	</div>

        <div class="container">
        	<div class="row">
        		<!--========== Modal 4: Updates ==========-->
        		<!-- The Event Modal -->
        		<div class="modal" id="upeventModal">
        			<!-- Event Modal Content -->
        			<div class="modal-content">
        				<div class="modal-header">
        					<span class="upeventclose">&times;</span>
        					<h2>Enter Event</h2>
        				</div>
        				<div class="modal-body">
        					<div class="col-md-12">
        					    <form action="" method="GET" name="">
        						    <div class="table-responsive">
        								<!-- Event text table-->
        								<h4 style="color: green">Event</h4>
        								<table class="table table-condensed">
        									<thead>
        										<tr>
        											<th align="left">Name</th>
        											<th align="left">Description</th>
        											<th align="left">Location</th>
        										</tr>
        									</thead>
        									<tbody>
        										<tr>
        											<td><!-- Name -->
        											<input class="form-control" min="0" name="ueventName" type="text" value='MyEvent'></td>
        											<td><!-- Description-->
        											<input class="form-control" min="0" name="ueventDesc" type="text" value='MyDesc'></td>
        											<td><!-- Location-->
        											<input class="form-control" min="0" name="ueventLoc" type="text" value='MyLoc'></td>
        										</tr>
        									</tbody>
        								</table><br>
        								<!-- Time table -->
        								<h4 style="color: green">Time</h4>
        								<table class="table table-condensed">
        									<thead>
        										<tr>
        											<th align="left">Date</th>
        											<th align="left">Time Start</th>
        											<th align="left">Time End</th>
        										</tr>
        									</thead>
        									<tbody>
        										<tr>
        											<td><!-- Time start--><input class="form-control" min="0" name="uedate" type="date"></td>
        											<td><!-- Time start--><input class="form-control" min="0" name="uetimeStart" type="time"></td>
        											<td><!-- Time end --><input class="form-control" min="0" name="uetimeEnd" type="time"></td>
        										</tr>
        									</tbody>
        								</table>
            						</div>
            					</div><!-- ends col-12 -->
            				</div>
            				<div class="modal-footer">
            					    <input class="btn btn-default pull-right" name="eventUpdate" type="submit" value="submit">
            				</div>
        				</form>
        				<div class="clearfix"></div>
        			</div>
        		</div>
        	</div>
        <?php
        // Fetch Events to be dislayed
        $sql = "SELECT * FROM event e JOIN record r ON r.rec_id = e.rec_id WHERE r.user_id = $login_session";
        // Events to be displayed
        $toprint = array();
        // Time intervals to fix cell lengths
        $timeInts = array();
        for ($d = 0; $d<7; $d++) {
            $timeInts[$d] = array();
        }
        if ($result = mysqli_query($db, $sql)) {
            while ($row = mysqli_fetch_array($result)) {
                // TODO: fix overlapping events
                // Add events
                $st = $row['time_start'];
                $d = date('w', strtotime($row['edate']));
                sscanf($st, "%d:%d:%d", $h, $m, $s);
                $toprint[$d][$h][$m] = $row;
                
                // Add time intervals
                $et = $row['time_end'];
                array_push($timeInts[$d], array($st, $et));
            }
        }
        ?>
        
        <!-- Calendar View -->
        <div class="container" id='caldiv'>
            <table class="calendar table table-bordered">
                <thead>
                    <tr>
                        <th width="12%"> </th>
                        <th width="12%">Sunday</th>
                        <th width="12%">Monday</th>
                        <th width="12%">Tuesday</th>
                        <th width="12%">Wednesday</th>
                        <th width="12%">Thursday</th>
                        <th width="12%">Friday</th>
                        <th width="12%">Saturday</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // total minutes
                    function calcMin($strTime) {
                        sscanf($strTime, "%d:%d:%d", $hr, $mn, $sc);
                        $mintime = $hr*60 + $mn;
                        return $mintime;
                    }
                    // duration of range of times
                    function calcDuration($st, $et) {
                        return calcMin($et) - calcMin($st);
                    }
                    // Checks if there is an event at given time
                    function containsEvent($d, $h, $m, $dy, $mn, $yr) {
                        global $timeInts;
                        foreach ($timeInts[$d] as $range) {
                            $st = strtotime($range[0]);
                            $et = strtotime($range[1]);
                            $ct = mktime($h, $m, 0);
                            if (($ct >= $st) && ($ct <= $et)) {
                                return true;
                            }
                        }
                        return false;
                    }

                    for ($h=0; $h<24; $h++) {
                        for ($m=0; $m<60; $m++) {
                            echo '<tr>';
                            // Print Hour
                            if ($m == 0) {
                                $hstr = (string) $h . ':00';
                                echo "<td rowspan='60'>$hstr</td>";
                            }
                            // Print events
                            for ($d=0; $d<7; $d++) {
                                if (array_key_exists($d, $toprint) && array_key_exists($h, $toprint[$d]) && array_key_exists($m, $toprint[$d][$h])) {
                                    $row = $toprint[$d][$h][$m];
                                    $recid = $row['rec_id'];
                                    $name = $row['name'];
                                    $loc = $row['location'];
                                    $timeStart = $row['time_start'];
                                    $timeEnd = $row['time_end'];
                                    $duration = calcDuration($timeStart, $timeEnd);
                                    
                                    $edate = strtotime($row['edate']);
                                    $dy = date('j', $edate);
                                    $mn = date('m', $edate);
                                    $yr = date('Y', $edate);
                                    
                                    $hash = '02115' . $recid;
                                    echo "<td class='has-events' id = '$hash' rowspan='$duration'>
                                            <div class='row-fluid lecture' style='width: 100%; height: 100%;'>
                                                <span class='ebox' id = '$hash'>$timeStart - $timeEnd</span>
                                                <span class='ebox' id = '$hash'>$name</span>
                                                <span class='ebox' id = '$hash'>$loc</span>
                                            </div>
                                        </td>";
                                }
                                else if (!containsEvent($d, $h, $m, $dy, $mn, $yr)) {
                                    echo "<td class='no-events' rowspan='1'></td>";
                                }
                            }
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div id='popup' style='position:absolute; height:50px; zindex:2; width:150px; display:none; border:none;'>
                <button id='update' onclick="upbutton()" class="btn" style= 'display:block; float:left;'> Update </button>
                <button id='delete' onclick="delbutton()" class="btn" style= 'display:block; float:left;'> Delete </button>
            </div>
        </div>

        <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script>
            var lastClicked = 0;
            
            function delbutton() {
                console.log('helloooo');
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("caldiv").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET","ajax.php?q=" + lastClicked + "&f=deleter", true);
                xmlhttp.send();
                location.reload();
            }
            
            $(document).click(function(event) {
                var id = $(event.target)[0].id;
                var popup = document.getElementById('popup');
                if (id.substring(0,5) == '02115') {
                    var element = document.getElementById(id);
                    var rect = element.getBoundingClientRect();
                    var prect = popup.getBoundingClientRect();
                    popup.style.top = rect.bottom + scrollY;
                    popup.style.left = rect.left + scrollX;
                    popup.style.display = '';
                    lastClicked = id.substring(5);
                }
                console.log(lastClicked);
            })
            
            //document.onmousedown = function() { document.getElementById("popup").style.display = "none" };
            
            // <!-- Script for Habit Modal-->
            // Get the modal
            var modal = document.getElementById('myModal');
            // Get the button that opens the modal
            var btn = document.getElementById("myHabit");
            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];
            // When the user clicks the button, open the modal 
            btn.onclick = function() {
            		modal.style.display = "block";
            	}
            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
            		modal.style.display = "none";
            	}
            
            // <!-- Script for Todo Modal-->
            var tmodal = document.getElementById('todoModal');
            var tbtn = document.getElementById("todobtn");
            var tspan = document.getElementsByClassName("todoclose")[0];
            tbtn.onclick = function() {
            		tmodal.style.display = "block";
            	}
            tspan.onclick = function() {
            		tmodal.style.display = "none";
            	}
            
            // <!-- Script for Event Modal-->
            var emodal = document.getElementById('eventModal');
            var ebtn = document.getElementById("eventbtn");
            var espan = document.getElementsByClassName("eventclose")[0];
            ebtn.onclick = function() {
            		emodal.style.display = "block";
            	}
            espan.onclick = function() {
            		emodal.style.display = "none";
            	}
            
            // <!-- Script for update event modal -->
            var uemodal = document.getElementById('upeventModal');
            var uespan = document.getElementsByClassName("upeventclose")[0];
            uespan.onclick = function() {
            		uemodal.style.display = "none";
            	}
            
            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
            	if (event.target == tmodal) {
            		tmodal.style.display = "none";
            	} else if (event.target == modal) {
            		modal.style.display = "none";
            	} else if (event.target == emodal) {
            		emodal.style.display = "none";
            	} else if (event.target == uemodal) {
            		uemodal.style.display = "none";
            	}
            }
            
            function upbutton() {
            	uemodal.style.display = "block";
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("mydiv").innerHTML = this.responseText;
                    }
                };
                console.log(lastClicked);
                xmlhttp.open("GET","ajax.php?q=" + lastClicked + "&f=updater", true);
                xmlhttp.send();
            }
        </script>
    </body>
</html>