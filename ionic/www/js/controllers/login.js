angular.module('starter.controllers')
    .controller('LoginCtrl',['$scope', '$auth' ,'$cordovaTouchID',
        function($scope, $auth,$cordovaTouchID){

           $scope.user = {
                   username: '',
                   password:''
           };

            $scope.isSupportTouchID=false;

            $scope.login = function () {
                  $auth.login($scope.user.username,$scope.user.password)

            };

            $scope.loginWithTouchID = function () {
                if($scope.isSupportTouchID){
                    $cordovaTouchID.authenticate("Passe o dedo para autenticar").then(function() {

                        $auth.login($scope.user.username, $scope.user.password);

                    }, function () {
                        // error
                    });
                }
            };

            if(ionic.Platform.isWebView() && ionic.Platform.isIOS() && ionic.Platform.isIPad() ){

                $cordovaTouchID.checkSupport().then(function() {

                    $scope.isSupportTouchID=true;
                });
            }


    }]);