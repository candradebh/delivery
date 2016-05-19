angular.module('starter.controllers')
    .controller('ClientViewOrderCtrl',[
        '$scope','$stateParams','ClientOrder','$ionicLoading',
            function($scope,$stateParams,ClientOrder,$ionicLoading){


                $scope.order = {};
                $ionicLoading.show({
                    template:'carregando...'
                });

                ClientOrder.get({id:$stateParams.id, include:"items,cupom"},function(data){
                    $scope.order = data.data;
                    $ionicLoading.hide();//esconde o carregando...
                },function(dataError){
                    $ionicLoading.hide();//esconde o carregando...
                });
            }
        ]
    );