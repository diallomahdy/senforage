'use strict';

/**
 * Déclaration de l'application adminApp
 */
var rootApp = angular.module('rootApp', []);

rootApp.controller('villageCtrl',
        function ($scope, $http, $window) {

            $scope.villages = PHPData.villages;
            //alert(JSON.stringify($scope.villages));
            $scope.detail = PHPData.detail_village;

            $scope.ajouter = function () {
                dom.submit_btn.loader('before');
                dom.statusMsg.empty();
                var params = 'app=senforage&entity=village&action=ajouterVillage&' + dom.form.serialize();
                $http({
                    method: 'POST',
                    url: PHPConfig.api,
                    data: params,
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                })
                        .then(function onSuccess(response) {
                            $.removeLoader();
                            //alert(response.data);
                            if (response.data == 1) {
                                dom.statusMsg.handleStatus('Village ajouté.', 'success');
                            } else {
                                dom.statusMsg.handleStatus('Erreur survenu. Village non ajouter.');
                            }
                        }, function onError(response) {
                            $.removeLoader();
                            //alert(response.statusText);
                            dom.statusMsg.handleStatus('Erreur serveur.');
                        });
            };

            $(document).ready(function () {
                
                $('#vue_ajouter').hide();
                
                $('#bouton_ajouter').click(function(){
                    $('#vue_lister').hide();
                    $('#vue_ajouter').show();
                });
                
                if(typeof(PHPStatus)!='undefined' && PHPStatus!=''){
                    dom.statusMsg.handleStatus(PHPStatus, 'success');
                }

                $('.supprimerVillage').click(function(){
                    var id = $(this).attr('value');
                    var element_currant = $(this);
                    $(this).loader('after');
                    dom.statusMsg2.empty();
                    var params = 'app=senforage&entity=village&action=supprimerVillage&id=' + id;
                    $http({
                        method: 'POST',
                        url: PHPConfig.api,
                        data: params,
                        //context : this,
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                    })
                    .then(function onSuccess(response) {
                        $.removeLoader();
                        //alert(response.data);
                        if (response.data == 1) {
                            element_currant.parent().parent().remove();
                            dom.statusMsg2.handleStatus('Village supprimé.', 'success');
                        } else {
                            dom.statusMsg2.handleStatus('Erreur survenu. Village non supprimé.');
                        }
                    }, function onError(response) {
                        $.removeLoader();
                        //alert(response.statusText);
                        dom.statusMsg2.handleStatus('Erreur serveur.');
                    });
                });

            });

        }
);

rootApp.controller('chefCtrl',
        function ($scope, $http, $window) {

            $scope.villages = PHPData.villages;
            $scope.chefs = PHPData.chefs;
            $scope.detail = PHPData.detail_chef;
            //alert(JSON.stringify(PHPData));
            //$scope.detail = PHPData.detail_village;

            $(document).ready(function () {
                
                $('#vue_ajouter').hide();
                
                $('#bouton_ajouter').click(function(){
                    $('#vue_lister').hide();
                    $('#vue_ajouter').show();
                });
                
                if(typeof(PHPStatus)!='undefined' && PHPStatus!=''){
                    dom.statusMsg.handleStatus(PHPStatus, 'success');
                }

            });

        }
);