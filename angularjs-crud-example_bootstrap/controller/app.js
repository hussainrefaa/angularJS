
// angular js codes will be here
var app = angular.module('myApp', []);

app.controller('employeesCtrl', function ($scope, $http) {
    // more angular JS codes will be here
    $scope.showModal = false;
    $scope.toggleModal = function () {
        $scope.showModal = !$scope.showModal;
    };
    $scope.go = function () {
        if ($(".search-details-form").is(":hidden")) {
            $(".search-details-form").slideDown();
        }
        else {
            $(".search-details-form").slideUp();
        }
    }


    $scope.closeDialog = function () {
        // close modal
        $('#modal-employee-form').slideUp();
        $scope.clearForm();
    }
    $scope.showCreateForm = function () {

        // clear form
        $scope.clearForm();

        // change modal title
        $('#modal-employee-title').text("Create New Employee");

        // hide update employee button
        $('#btn-update-employee').hide();

        // show create employee button
        $('#btn-create-employee').show();
        $('#modal-employee-form').slideDown();

    }


// clear variable / form values
    $scope.clearForm = function () {
        $scope.id = "";
        $scope.name = "";
        $scope.dept = "";
        $scope.salary = "";
        $scope.age = "";
    }
// create new employee 
    $scope.createEmployee = function () {
       
        // fields in key-value pairs
        $http.post('php/actions/create_employee.php', {
            'name': $scope.name,
            'dept': $scope.dept,
            'salary': $scope.salary,
            'age': $scope.age
        }
        ).success(function (data, status, headers, config) {
            console.log(data);
            // tell the user new employee was created
            //Materialize.toast(data, 4000);

            // close modal
            $scope.closeDialog();

            // clear modal content
            $scope.clearForm();

            // refresh the list
            $scope.getAll();
        });
    }

// read employees
    $scope.getAll = function () {
        $http.get("php/actions/read_employees.php").success(function (response) {
            $scope.names = response.records;
        });
    }

// retrieve record to fill out the form
    $scope.readOne = function (id) {
        // change modal title
        $('#modal-employee-title').text("Edit Employee");

        // show udpate employee button
        $('#btn-update-employee').show();

        // show create employee button
        $('#btn-create-employee').hide();

        // post id of employee to be edited
        $http.post('php/actions/read_one.php', {
            'id': id
        })
                .success(function (data, status, headers, config) {

                    // put the values in form
                    $scope.id = data[0]["id"];
                    $scope.name = data[0]["name"];
                    $scope.dept = data[0]["dept"];
                    $scope.salary = data[0]["salary"];
                    $scope.age = data[0]["age"];

                    // show modal
                    $('#modal-employee-form').slideDown();
                })
                .error(function (data, status, headers, config) {
                    // Materialize.toast('Unable to retrieve record.', 4000);
                });
    }

// update employee record / save changes
    $scope.updateEmployee = function () {
        $http.post('php/actions/update_employee.php', {
            'id': $scope.id,
            'name': $scope.name,
            'dept': $scope.dept,
            'salary': $scope.salary,
            'age': $scope.age
        })
                .success(function (data, status, headers, config) {
                    // tell the user employee record was updated
                    //Materialize.toast(data, 4000);

                    // close modal
                    $scope.closeDialog();

                    // clear modal content
                    $scope.clearForm();

                    // refresh the employee list
                    $scope.getAll();
                });
    }

// delete employee
    $scope.deleteEmployee = function (id) {

        // ask the user if he is sure to delete the record
        if (confirm("Are you sure?")) {
            // post the id of employee to be deleted
            $http.post('php/actions/delete_employee.php', {
                'id': id
            }).success(function (data, status, headers, config) {

                // tell the user employee was deleted
                /// Materialize.toast(data, 4000);

                // refresh the list
                $scope.getAll();
            });
        }
    }
});
// jquery codes will be here

 app.filter('findEmployee', function(){

    // pass employees recored to function and return output
    return function (records, minSalary, minAage) {

        // check if employees array did not have any record
        if(!records){
            return;
        }

        // check if minSalary is not define
        // if minSalary is not define then consider it as 0
        if(!minSalary){
            minSalary = 0;
        }

        // check if minAage is not define
        // if minAage is not define then consider it as 0
        if(!minAage){
            minAage = 0;
        }

        // declear output array
        var output = [];

        // loop of record array
        // forEach is angular function
        // check if employee employee record have salary more then minSalary
        // if employee salary is more then minSalary push that record to out array
        // check if employee employee record have age more then minAage
        // if employee age is more then minAage push that record to out array
        angular.forEach(records, function(record){

            if(record.salary > minSalary && record.age > minAage){
                output.push(record);
            }

        });
       
        // return output array as filter output
        return output;

      };
});