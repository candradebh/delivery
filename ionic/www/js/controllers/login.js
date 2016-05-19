angular.module('starter.controllers')
    .controller('LoginCtrl',
            ['$scope','OAuth','$ionicPopup','$state','UserData','User',
                function($scope,OAuth,$ionicPopup,$state,UserData,User){

                        $scope.user = {
                            username: '',
                            password:''
                        };


                        $scope.login = function () {
                            var promise = OAuth.getAccessToken($scope.user);
                            promise
                                .then(function (data) {
                                    return User.authenticated({include: 'client'}).$promise;
                                }
                                ).then(function (data) {
                                        UserData.set(data);

                                        if(data.data.role=='client'){
                                            $state.go('client.checkout');
                                        }else{
                                            $state.go('deliveryman.order');
                                        }

                                        },
                                        function (responseError) {
                                            UserData.set(null);
                                            OAuthToken.removeToken();

                                            $ionicPopup.alert({
                                                title: 'Advertência',
                                                template: 'Login e/ou Senha inválidos'
                                            });
                                            console.debug(responseError);
                                        }
                                );

                        }


                }
            ]
    );