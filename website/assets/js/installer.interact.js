'use strict';

/**
 * Déclaration de l'application adminApp
 */
var rootApp = angular.module('rootApp',[]);

rootApp.controller('entityCtrl',
    function ($scope, $http, $window) {

        $scope.generateEntities = function () {
            dom.generate_btn.loader('after');
            dom.statusMsg.empty();
            dom.statusNb.empty();
            var params = 'app=install&action=generateEntities';
            $http({
                method: 'POST',
                url: PHPConfig.api,
                data: params,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            })
            .then(function onSuccess(response) {
                $.removeLoader();
                //alert(response.data);
                if (response.data.nbEntities == 0){
                    var statusNb = '<div id="nbEntities" class="col-8 col-offset-1">';
                    statusNb += 'No class found.';
                    statusNb += '</div>';
                }
                else if (response.data.nbEntities > 0) {
                    if(response.data.nbEntities>1){
                        var plural = 'es';
                    }
                    else{
                        var plural = '';
                    }
                    var statusNb = '<div id="nbEntities" class="col-8 col-offset-1">';
                    statusNb += 'Building success : ' + response.data.nbEntities + ' class' + plural + ' builded.';
                    statusNb += '</div>';
                    dom.statusMsg.text(response.data.verbose);
                } else {
                    //$scope.siginError = "Username and password do not match.";
                    var statusNb = '<div class="alert alert-danger">';
                    statusNb += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">';
                    statusNb += '×</button>';
                    statusNb += '<span class="glyphicon glyphicon-hand-right"></span>&nbsp;&nbsp;Error while bulding classes.'
                    statusNb += '</div>';
                }
                dom.statusNb.html(statusNb);
            }, function onError(response) {
                
            });
        };

    }
);