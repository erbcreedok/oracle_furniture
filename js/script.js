var app = angular.module('myApp', ['ngRoute','ngFileUpload']);

app.config(function($routeProvider) {
   $routeProvider
       .when('/', {
           templateUrl: 'templates/furnitures.htm',
           controller: 'furnituresCtrl'
       })
       .when('/shops', {
           templateUrl: 'templates/shops.htm',
           controller: 'shopsCtrl'
       })
       .when('/basket', {
           templateUrl: 'templates/basket.htm',
           controller: 'basketCtrl'
       })
       .when('/admin', {
           templateUrl: 'templates/admin.htm',
           controller: 'adminCtrl'
       })
       .when('/admin/orders', {
           templateUrl: 'templates/admin.htm',
           controller: 'ordersCtrl'
       });

});

app.run(function($rootScope, $location) {
    $rootScope.basket = loadBasketState();
    $rootScope.isPath = function (path) {
        return ($location.path() === path);
    }
});

app.controller('appCtrl', function($scope, $rootScope) {
   $rootScope.modalOn = false;

   $scope.onShowModal = function (target) {
       $rootScope.modalOn = target;
   }

   $scope.onHideModal = function() {
       $rootScope.modalOn = undefined;
   }
});

app.controller('basketCtrl', function ($scope, $rootScope) {
    $scope.opened = false;

    $scope.onRemoveFromBasket = function (index) {
        $rootScope.basket.splice(index, 1);
        $scope.opened = $rootScope.basket.length;
        saveBasketState($rootScope.basket);
    }

    $scope.totalPrice = function() {
        return $rootScope.basket.reduce(function(a, b) { return a + b.furniture_price }, 0);
    }

    $scope.onClearBasket = function() {
        if (confirm('Вы действительно хотите очистить всю корзину?')) {
            $rootScope.basket = [];
            $scope.opened = $rootScope.basket.length;
            saveBasketState($rootScope.basket);
        }
    }


});

app.controller('navbarCtrl', function () {});

app.controller('furnituresCtrl', function($scope,$http,$rootScope,Upload) {
	$scope.furnitures = [];

    $http({
        method: 'GET',
        url: 'https://furniture-683c0.firebaseio.com/furnitures.json'
    }).success(function(res) {
        $scope.furnitures = res;
    });

    $scope.onAddToBasket = function (furniture) {
        $rootScope.basket.push(furniture);
        saveBasketState($rootScope.basket);
    }
});

app.controller('shopsCtrl', function($scope, $http, $rootScope) {
   $scope.shops = [
       {
           shop_id: 0,
           shop_title: 'Profil-Doors',
           shop_address: 'г.Алмата ул.Бокейханова 35',
           shop_image: 'http://www.rpbc.ru/upload/iblock/7d2/20140806_113425.jpg',
           shop_url: 'http://profildoors.kz',
           furnitures: [1,0,2]
       },
       {
           shop_id: 1,
           shop_title: 'Glory Company',
           shop_address: 'ул. Кабдолова 1/8 (бывш. ул. Маречека)',
           shop_image: 'https://hh.kz/employer-logo/782706.jpeg',
           shop_url: 'http://www.glory-c.kz/',
           furnitures: [1, 3, 4]
       },
       {
           shop_id: 2,
           shop_title: 'ТЦ "Армада"',
           shop_address: 'ул. Кабдолова 1/8 (бывш. ул. Маречека)',
           shop_image: 'http://www.armada-mall.ru/assets/images/modx_Slider/66_.jpg',
           shop_url: 'http://armada.kz/',
           furnitures: [4,3,2,1,0]
       }
   ];

   $scope.furnitures = [];
   $http({
       method: 'GET',
       url: 'https://furniture-683c0.firebaseio.com/furnitures.json'
   }).success(function(res) {
       $scope.furnitures = res;
   });

   $scope.getFurnitures = function(arr){
       return $scope.furnitures.filter(function(furniture) {
           return arr.indexOf(furniture.furniture_id) !== -1;
       });
   }

   $scope.onAddToBasket = function (furniture) {
       $rootScope.basket.push(furniture);
       saveBasketState($rootScope.basket);
   }
});

app.controller('adminCtrl', function ($scope, $rootScope, $http) {
    $scope.furnitures = [];

    $http({
        method: 'GET',
        url: 'https://furniture-683c0.firebaseio.com/furnitures.json'
    }).success(function(res) {
        $scope.furnitures = res;
    });
});

app.controller('ordersCtrl', function($scope, $rootScope, $http) {
    
});

function saveBasketState(basketState) {
    localStorage.setItem('basketState', JSON.stringify(basketState))
}
function loadBasketState() {
    var basket = localStorage.getItem('basketState');
    return isJson(basket) ? JSON.parse(basket) : [];
}
function isJson(text) {
    return text ? /^[\],:{}\s]*$/.test(text.replace(/\\["\\\/bfnrtu]/g, '@').
        replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
        replace(/(?:^|:|,)(?:\s*\[)+/g, '')) : false;
}
