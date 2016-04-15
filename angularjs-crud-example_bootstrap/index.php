<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- user-scalable=no This disables zooming -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Read Employees</title>
        <!-- Bootstrap -->
        <link href = "http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel = "stylesheet">
        <link href="http://getbootstrap.com/2.3.2/assets/css/bootstrap-responsive.min.css" rel="stylesheet">

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
            <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="libs/bootstrap/js/ie-emulation-modes-warning.js" type="text/javascript"></script>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <!-- custom CSS -->
        <link href="css/custom.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>


        <!-- page content and controls will be here -->
        <div class="container" ng-app="myApp" ng-controller="employeesCtrl">
            <div class="row">
                <div ng-include='"templates/nav.php"'></div>
            </div>
            <!-- floating button for creating employee -->
            <div class="row">
                <div ng-include='"templates/left_col.php"'></div>


                <div class="col-md-9">
                    <div class="row">
                        <div class="fixed-bottom" >
                            <button class="btn btn-primary" ng-click="showCreateForm()" type="button">New Employee</button>
                        </div>
                        <h4>Employees</h4>
                        <!-- used for searching the current list -->
                        <input type="text" ng-model="search" class="form-control" placeholder="Search employee...">
                       
                        <!-- used for searching the current list -->
                        <input type="number" ng-model="minSalary" class="form-control" placeholder="Give minimum employee salary">
                    
                        <!-- used for searching the current list -->
                        <input type="number" ng-model="minAge" class="form-control" placeholder="Give minimum age">
                    </div>
                    <div class="row">
                        <!-- table that shows employee record list -->
                        <table class = "table table-striped">

                            <thead>
                                <tr>
                                    <th class="text-align-center">ID</th>
                                    <th class="width-30-pct">Name</th>
                                    <th class="width-30-pct">Dept</th>
                                    <th class="text-align-center">Salary</th>
                                    <th class="text-align-center">Age</th>
                                    <th class="text-align-center">Action</th>
                                </tr>
                            </thead>
                            <tbody ng-init="getAll()">
                                <tr ng-repeat="d in names| filter:search | findEmployee : minSalary : minAge">
                                    <td class="text-align-center">{{ d.id}}</td>
                                    <td>{{ d.name}}</td>
                                    <td>{{ d.dept}}</td>
                                    <td class="text-align-center">{{ d.salary}}</td>
                                    <td class="text-align-center">{{ d.age}}</td>
                                    <td>
                                        <a ng-click="readOne(d.id)" class="waves-effect waves-light btn margin-bottom-1em"><span class="glyphicon glyphicon-pencil">Edit</span></a>
                                    </td>
                                    <td>
                                        <a ng-click="deleteEmployee(d.id)" class="waves-effect waves-light btn margin-bottom-1em"><span class="glyphicon glyphicon-trash"></span>Delete</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <!-- modal for for creating new employee -->
                        <div class="modal" id="modal-employee-form"  role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" ng-click="closeDialog()" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 id="modal-employee-title">Create New Employee</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <span class="control-label" id="basic-addon1">Emp Name (Hussain Refaa)</span>
                                            <input id="form-name" class="form-control" ng-model="name" type="text"  placeholder="Type name here..." aria-describedby="basic-addon1">
                                        </div>
                                        <div class="form-group">
                                            <span class="control-label" id="basic-addon1">Dept (Maneger)</span>
                                            <input id="form-dept" class="form-control" ng-model="dept" type="text"  placeholder="Type dept here..." aria-describedby="basic-addon1">
                                        </div>
                                        <div class="form-group">
                                            <span class="control-label" id="basic-addon1">Salary (0000.0000)</span>
                                            <input id="form-salary" class="form-control"  ng-model="salary" type="text"  placeholder="Type salary here..." aria-describedby="basic-addon1">
                                        </div>
                                        <div class="form-group">
                                            <span class="control-label" id="basic-addon1">Age</span>
                                            <input id="form-age" class="form-control"  ng-model="age" type="text"  placeholder="Type salary here..." aria-describedby="basic-addon1">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button id="btn-create-employee" class="btn btn-primary" ng-click="createEmployee()" type="button">Create</button>
                                        <button id="btn-update-employee" class="btn btn-primary" ng-click="updateEmployee()" type="button">Save Changes</button>
                                        <button id="btn-update-employee" class="btn btn-default" ng-click="closeDialog()" type="button">Close</button>

                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                    </div>

                </div> <!-- end col s12 -->

            </div>
            <div class="row">
                <div  ng-include='"templates/footer.php"'></div>
            </div>
        </div> <!-- end container -->

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src = "https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src = "//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

        <!-- include angular js -->
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js"></script>
        <script src="controller/app.js"></script>

    </body>
</html>