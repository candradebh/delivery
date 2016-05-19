angular.module('starter.controllers')
    .controller('ClientViewDeliveryCtrl',[
        '$scope','$stateParams','ClientOrder','$ionicLoading', '$ionicPopup',
        'UserData','$pusher','$window','$map','uiGmapGoogleMapApi',
            function($scope,$stateParams,ClientOrder,$ionicLoading,$ionicPopup,
                     UserData,$pusher,$window,$map,uiGmapGoogleMapApi){

                var iconUrl = "http://maps.google.com/mapfiles/kml/pal2/";

                $scope.order = {};
                $scope.map = $map;
                $scope.markers = [];

                $ionicLoading.show({
                    template:'carregando...'
                });

                uiGmapGoogleMapApi.then(function(maps){
                    $ionicLoading.hide();//esconde o carregando...
                },function(){
                    $ionicLoading.hide();//esconde o carregando...
                });

                ClientOrder.get({id:$stateParams.id, include:"items,cupom"},function(data){
                    $scope.order = data.data;

                    if(parseInt($scope.order.status,10)==1){
                        initMarkers($scope.order);
                    }else{
                        $ionicPopup.alert({
                            title: 'Advertência',
                            template: 'O pedido nao esta com status de entrega'
                        });
                    }
                });

                $scope.$watch('markers.length',function(value){
                    if(value == 2){
                        createBounds();
                    }
                });

                function initMarkers(order){
                    var client = UserData.get().data.client.data,
                        address = client.zipcode + ', ' +
                            client.address + ', ' +
                            client.city + ' - ' +
                            client.state;

                    createMarkerClient(address);
                    watchPositionDeliveryman(order.hash);
                }

                function createMarkerClient(address){
                    var geocoder = new google.maps.Geocoder();

                    geocoder.geocode({

                                address: address

                        },function(results,status){

                           if(status==google.maps.GeocoderStatus.OK){
                                var lat = results[0].geometry.location.lat(),
                                    long = results[0].geometry.location.lng();
                                $scope.markers.push({
                                    id: 'client',
                                    coords: {
                                        latitude: lat,
                                        longitude: long
                                    },
                                    options:{
                                        title: "Local de entrega",
                                        icon: iconUrl + "icon10.png"
                                    }
                                });
                           }else{
                                 $ionicPopup.alert({
                                           title: 'Advertência',
                                           template: 'Não foi possivel encontrar seu endereço'
                                 });
                           }
                        });

                    }


                    function watchPositionDeliveryman(channel){

                            var pusher = $pusher($window.client); //sempre que usar o serviço de pusher
                            var channel = pusher.subscribe(channel); //abrir canal de cominicação

                            channel.bind('Delivery\\Events\\GetLocationDeliveryman',function(data){
                                var lat = data.geo.lat, long= data.geo.long;

                                if($scope.markers.length==1){
                                    $scope.markers.push({
                                        id: 'entregador',
                                        coords: {
                                            latitude: lat,
                                            longitude: long
                                        },
                                        options:{
                                            title: "Entregador",
                                            icon: iconUrl + "icon47.png"
                                        }
                                    });
                                }
                            });

                    }

                function createBounds(){
                    var bounds = new google.maps.LatLngBounds(),
                        latlng;

                        angular.forEach($scope.markers,function(value){
                            latlng = new google.maps.LatLng(Number(value.coords.latitude),Number(value.coords.longitude));
                            bounds.extend(latlng);
                        });
                    $scope.map.bounds = {
                        northeast:{
                            latitude: bounds.getNorthEast().lat(),
                            longitude: bounds.getNorthEast().lng()
                        },
                        southwest:{
                            latitude: bounds.getSouthWest().lat(),
                            longitude: bounds.getSouthWest().lng()
                        }
                    };
                }


    }]).controller('CvdDescentralize',['$scope','$map',function($scope,$map){
            $scope.map = $map;
            $scope.fit = function(){
                            $scope.map.fit = !$scope.map.fit;
                        }
    }]).controller('CvdControlReload',['$scope','$window','$timeout',function($scope,$window,$timeout){
            $scope.reload = function(){
                $timeout (function(){
                    $window.location.reload(true);
                },100);
            }
    }]);