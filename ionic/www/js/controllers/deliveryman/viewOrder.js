angular.module('starter.controllers')
    .controller('DeliverymanViewOrderCtrl',[
        '$scope','$stateParams','DeliverymanOrder','$ionicLoading','$ionicPopup', '$cordovaGeolocation',
            function($scope,$stateParams,DeliverymanOrder,$ionicLoading,$ionicPopup, $cordovaGeolocation){

                var watch, lat=null, long;

                $scope.order = {};
                $ionicLoading.show({
                    template:'carregando...'
                });

                DeliverymanOrder.get({id:$stateParams.id, include:"items,cupom"},function(data){
                    $scope.order = data.data;
                    $ionicLoading.hide();//esconde o carregando...
                },function(dataError){
                    $ionicLoading.hide();//esconde o carregando...
                });

                $scope.goToDelivery = function () {
                    $ionicPopup.alert({
                        title: 'Advertência',
                        template: 'Para parar a localização dê OK'
                    });

                    DeliverymanOrder.updateStatus({id: $stateParams.id},{status:1},function(){
                        var watchOptions = {
                            timeout:3000, //tres segundos
                            enableHighAccuracy:false //Habilitar acerto mais preciso. Se true depende muito da rede
                        };
                        watch = $cordovaGeolocation.watchPosition(watchOptions);
                        watch.then(null,
                            function(responseError){

                            },function(position){

                                if(!lat){
                                    lat : position.coords.latitude;
                                    long : position.coords.longitude;
                                }else{
                                    long -= 0.0444;
                                }

                                DeliverymanOrder.geo({id:$stateParams.id},
                                    {
                                        lat: position.coords.latitude,
                                        long: position.coords.longitude
                                    });
                            }
                        );

                    });
                };

                function stopWatchPosition(){
                    if(watch && typeof watch == 'object' && watch.hasOwnProperty('watchID')){
                        $cordovaGeolocation.clearWatch(watch.watchID);
                    }
                }

            }
        ]
    );