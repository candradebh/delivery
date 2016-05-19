// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
angular.module('starter.controllers',[]); //inicia todos os controlers
angular.module('starter.services',[]); //inicia todos os serviços
angular.module('starter.filters',[]);//inicia todos os filtros


angular.module('starter', [
    'ionic','ionic.service.core', 'starter.controllers', 'starter.services','starter.filters',
    'angular-oauth2','ngResource','ngCordova', 'uiGmapgoogle-maps', 'pusher-angular'
])


    .constant('appConfig', {
        baseUrl: 'http://localhost:8000', //localhost:8000
        pusherKey: 'c87b614d28fdfca69ce9'
    })

.run(function($ionicPlatform, $window, appConfig) {
  //iniciando o pusher junto com aplicação
  $window.client = new Pusher (appConfig.pusherKey);

  $ionicPlatform.ready(function() {
    if(window.cordova && window.cordova.plugins.Keyboard) {

      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);

      cordova.plugins.Keyboard.disableScroll(true);
    }
    if(window.StatusBar) {
      StatusBar.styleDefault();
    }
     Ionic.io();
      var push = new Ionic.Push({
          debug : true,
          onNotification: function(message){
              console.log(message);
          }
      });

      push.register(function(token){
          console.log(token);
      });

  });
})

//configuração das rotas
.config(function($stateProvider, $urlRouterProvider, OAuthProvider, OAuthTokenProvider, appConfig,$provide){

        OAuthProvider.configure({
            baseUrl: appConfig.baseUrl,
            clientId: 'appid01',
            clientSecret: 'secret', // optional
            grantPath: '/oauth/access_token'
        });

        OAuthTokenProvider.configure({
            name: 'token',
            options: {
                //tempo de vida do cookie, etc
                secure: false
            }
        });


      $stateProvider

          .state('login',{
              url: '/login',
              templateUrl: 'templates/login.html',
              controller: 'LoginCtrl'
          })
          .state('menu',{
              url: '/menu',
              template: 'templates/menu.html',
              controller: function($scope){

              }
          })

          .state('client',{
              abstract: true,
              cache: false,
              url: '/client',
              templateUrl: 'templates/client/menu.html',
              controller: 'ClientMenuCtrl'
          })
          .state('client.order',{
              url:'/order',
              templateUrl: 'templates/client/order.html',
              controller: 'ClientOrderCtrl'
          })
          .state('client.view_order',{
              url:'/view_order/:id',
              templateUrl: 'templates/client/view_order.html',
              controller: 'ClientViewOrderCtrl'
          })
          .state('client.view_delivery',{
              cache:false,
              url:'/view_delivery/:id',
              templateUrl: 'templates/client/view_delivery.html',
              controller: 'ClientViewDeliveryCtrl'
          })
          .state('client.checkout',{
              cache:false,
              url:'/checkout',
              templateUrl: 'templates/client/checkout.html',
              controller: 'ClientCheckoutCtrl'
          })
          .state('client.checkout_item_detail',{
              url:'/checkout/detail/:index',
              templateUrl: 'templates/client/checkout_item_detail.html',
              controller: 'ClientCheckoutDetailCtrl'
          })
          .state('client.checkout_successful',{
              cache:false,
              url:'/checkout/successful',
              templateUrl: 'templates/client/checkout_successful.html',
              controller: 'ClientCheckoutSuccessful'
          })
          .state('client.view_products',{
              url:'/view_products',
              templateUrl: 'templates/client/view_products.html',
              controller: 'ClientViewProductCtrl'
          })
          .state('deliveryman',{
              abstract: true,
              cache: false,
              url: '/deliveryman',
              templateUrl: 'templates/deliveryman/menu.html',
              controller: 'DeliverymanMenuCtrl'
          })
          .state('deliveryman.order',{
              url:'/order',
              templateUrl: 'templates/deliveryman/order.html',
              controller: 'DeliverymanOrderCtrl'
          })
          .state('deliveryman.view_order',{
              cache:false,
              url:'/view_order/:id',
              templateUrl: 'templates/deliveryman/view_order.html',
              controller: 'DeliverymanViewOrderCtrl'
          });



      //redireciona sempre para raiz do sistema para nao aceitar url que nao existe
      $urlRouterProvider.otherwise('/login');

      //configura o Oauth2 do angular para nao trabalhar com cookies pois o android 4 e superior nao permite
      $provide.decorator('OAuthToken',['$localStorage','$delegate', function($localStorage,$delegate){

        Object.defineProperties($delegate,{
            setToken:{
                value:function(data){
                    $localStorage.setObject('token',data);
                },
                enumerable:true,
                configurable:true,
                writable:true
            },
            getToken:{
                value:function(){
                    return $localStorage.getObject('token');
                },
                enumerable:true,
                configurable:true,
                writable:true
            },
            removeToken:{
                value:function(){
                    return $localStorage.getObject('token',null);
                },
                enumerable:true,
                configurable:true,
                writable:true
            }
        });
        return $delegate;
      }]);

    })
    .service('cart',function(){
        this.items = [];
    });

