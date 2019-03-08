angular.module('openITCOCKPIT')
    .controller('HostsAddController', function($scope, $http, SudoService, $state, NotyService, LocalStorageService){

        $scope.data = {
            createAnother: false,
            dnsLookUp: LocalStorageService.getItemWithDefault('HostsDnsLookUpEnabled', 'false') === 'true',
            dnsHostnameNotFound: false,
            dnsAddressNotFound: false
        };

        var clearForm = function(){
            $scope.post = {
                Host: {
                    name: '',
                    description: '',
                    hosttemplate_id: 0,
                    address: '',
                    command_id: 0,
                    eventhandler_command_id: 0,
                    check_interval: 3600,
                    retry_interval: 60,
                    max_check_attempts: 3,
                    first_notification_delay: 0,
                    notification_interval: 7200,
                    notify_on_down: 1,
                    notify_on_unreachable: 1,
                    notify_on_recovery: 1,
                    notify_on_flapping: 0,
                    notify_on_downtime: 0,
                    flap_detection_enabled: 0,
                    flap_detection_on_up: 0,
                    flap_detection_on_down: 0,
                    flap_detection_on_unreachable: 0,
                    low_flap_threshold: 0,
                    high_flap_threshold: 0,
                    process_performance_data: 0,
                    freshness_checks_enabled: 0,
                    freshness_threshold: 0,
                    passive_checks_enabled: 1,
                    event_handler_enabled: 0,
                    active_checks_enabled: 1,
                    retain_status_information: 0,
                    retain_nonstatus_information: 0,
                    notifications_enabled: 0,
                    notes: '',
                    priority: 1,
                    check_period_id: 0,
                    notify_period_id: 0,
                    tags: '',
                    container_id: 0,
                    host_url: '',
                    satellite_id: 0,
                    contacts: {
                        _ids: []
                    },
                    contactgroups: {
                        _ids: []
                    },
                    hostgroups: {
                        _ids: []
                    },
                    containers: {
                        _ids: []
                    },
                    parenthosts: {
                        _ids: []
                    },
                    customvariables: [],
                    hostcommandargumentvalues: []
                }
            };
        };
        clearForm();

        $scope.init = true;

        var setValuesFromHosttemplate = function(){
            var fields = [
                'description',
                'hosttemplate_id',
                'address',
                'command_id',
                'eventhandler_command_id',
                'check_interval',
                'retry_interval',
                'max_check_attempts',
                'first_notification_delay',
                'notification_interval',
                'notify_on_down',
                'notify_on_unreachable',
                'notify_on_recovery',
                'notify_on_flapping',
                'notify_on_downtime',
                'flap_detection_enabled',
                'flap_detection_on_up',
                'flap_detection_on_down',
                'flap_detection_on_unreachable',
                'low_flap_threshold',
                'high_flap_threshold',
                'process_performance_data',
                'freshness_checks_enabled',
                'freshness_threshold',
                'passive_checks_enabled',
                'event_handler_enabled',
                'active_checks_enabled',
                'retain_status_information',
                'retain_nonstatus_information',
                'notifications_enabled',
                'notes',
                'priority',
                'check_period_id',
                'notify_period_id',
                'tags',
                'host_url'
            ];

            for(var index in fields){
                var field = fields[index];
                if($scope.hosttemplate.Hosttemplate.hasOwnProperty(field)){
                    $scope.post.Host[field] = $scope.hosttemplate.Hosttemplate[field];
                }
            }

            var hasManyAssociations = [
                'hostgroups', 'contacts', 'contactgroups'
            ];
            for(index in hasManyAssociations){
                field = hasManyAssociations[index];
                if($scope.hosttemplate.Hosttemplate.hasOwnProperty(field)){
                    $scope.post.Host[field]._ids = $scope.hosttemplate.Hosttemplate[field]._ids;
                }
            }

            $scope.post.Host.customvariables = [];
            for(index in $scope.hosttemplate.Hosttemplate.customvariables){
                $scope.post.Host.customvariables.push({
                    objecttype_id: 512, //OBJECT_HOSTTEMPLATE baecause value from host template
                    name: $scope.hosttemplate.Hosttemplate.customvariables[index].name,
                    value: $scope.hosttemplate.Hosttemplate.customvariables[index].value
                });
            }

            $('#HostTagsInput').tagsinput('removeAll');
            $('#HostTagsInput').tagsinput('add', $scope.post.Host.tags);
        };

        var highlight = function($selector){
            $selector = $selector.parent();
            var $div = $('<div class="highlight"></div>');
            $div.css({
                'width': $selector.width() + 'px',
                'height': $selector.height() + 'px',
                'left': $selector.css('padding-left')
            });
            $selector.append($div);
            $div.fadeOut(800, function(){
                $div.remove();
            });
        };

        $scope.loadContainers = function(){
            var params = {
                'angular': true
            };

            $http.get("/hosts/loadContainers.json", {
                params: params
            }).then(function(result){
                $scope.containers = result.data.containers;
                $scope.init = false;
            });
        };

        $scope.loadCommands = function(){
            var params = {
                'angular': true
            };

            $http.get("/hosts/loadCommands.json", {
                params: params
            }).then(function(result){
                $scope.commands = result.data.commands;
                $scope.init = false;
            });
        };

        $scope.loadCommandArguments = function(){
            return;
            var params = {
                'angular': true
            };

            var commandId = $scope.post.Host.command_id;
            $http.get("/hosts/loadCommandArguments/" + commandId + ".json", {
                params: params
            }).then(function(result){
                $scope.post.Host.hostcommandargumentvalues = result.data.hostcommandargumentvalues;
                $scope.init = false;
            });
        };

        $scope.loadElements = function(){
            var containerId = $scope.post.Host.container_id;
            $http.post("/hosts/loadElementsByContainerId/" + containerId + ".json?angular=true", {}).then(function(result){
                $scope.hosttemplates = result.data.hosttemplates;
                $scope.timeperiods = result.data.timeperiods;
                $scope.checkperiods = result.data.checkperiods;
                $scope.contacts = result.data.contacts;
                $scope.contactgroups = result.data.contactgroups;
                $scope.hostgroups = result.data.hostgroups;
                $scope.satellites = result.data.satellites;
                $scope.sharingContainers = result.data.sharingContainers;
            });
        };

        $scope.loadParentHosts = function(searchString){
            var containerId = $scope.post.Host.container_id;
            $http.get("/hosts/loadParentHostsByString.json", {
                params: {
                    'angular': true,
                    'filter[Host.name]': searchString,
                    'selected[]': $scope.post.Host.parenthosts._ids,
                    'containerId': containerId
                }
            }).then(function(result){
                $scope.parenthosts = result.data.hosts;
            });
        };

        $scope.loadHosttemplate = function(){
            var hosttemplateId = $scope.post.Host.hosttemplate_id;
            $http.post("/hosts/loadHosttemplate/" + hosttemplateId + ".json?angular=true", {}).then(function(result){
                $scope.hosttemplate = result.data.hosttemplate;
                setValuesFromHosttemplate();
            });
        };

        $scope.setPriority = function(priority){
            $scope.post.Host.priority = parseInt(priority, 10);
        };

        $scope.addMacro = function(){
            $scope.post.Host.customvariables.push({
                objecttype_id: 256, //OBJECT_HOST
                name: '',
                value: ''
            });
        };

        $scope.deleteMacroCallback = function(macro, index){
            $scope.post.Host.customvariables.splice(index, 1);
        };

        $scope.getMacroErrors = function(index){
            if(typeof $scope.errors !== "undefined"){
                if(typeof $scope.errors.customvariables !== "undefined"){
                    if(typeof $scope.errors.customvariables[index] !== 'undefined'){
                        return $scope.errors.customvariables[index];
                    }
                }
            }
            return false;
        };

        $scope.runDnsLoopup = function(lookupByHostname){
            $scope.data.dnsHostnameNotFound = false;
            $scope.data.dnsAddressNotFound = false;
            if($scope.data.dnsLookUp === false){
                return;
            }
            var data = {
                hostname: null,
                address: null
            };

            if(lookupByHostname){
                if($scope.post.Host.name == ''){
                    return;
                }
                data.hostname = $scope.post.Host.name;
            }else{
                if($scope.post.Host.address == ''){
                    return;
                }
                data.address = $scope.post.Host.address;
            }

            $http.post("/hosts/runDnsLoopup.json?angular=true",
                data
            ).then(function(result){
                if(lookupByHostname){
                    var address = result.data.result.address;
                    if(address === null){
                        $scope.data.dnsHostnameNotFound = true;
                    }else{
                        $scope.data.dnsHostnameNotFound = false;
                        $scope.post.Host.address = address;
                        highlight($('#HostAddress'));
                    }
                }else{
                    var hostname = result.data.result.hostname;
                    if(hostname === null){
                        $scope.data.dnsAddressNotFound = true;
                    }else{
                        $scope.data.dnsAddressNotFound = false;
                        $scope.post.Host.name = hostname;
                        highlight($('#HostName'));
                    }
                }
                }, function errorCallback(result){
                NotyService.genericError({
                    message: 'Error while running DNS lookup'
                });
            });
        };

        $scope.submit = function(){
            $http.post("/hosts/add.json?angular=true",
                $scope.post
            ).then(function(result){
                NotyService.genericSuccess();

                if($scope.data.createAnother === false){
                    $state.go('HostsIndex').then(function(){
                        NotyService.scrollTop();
                    });
                }else{
                    clearForm();
                    NotyService.scrollTop();
                }


                console.log('Data saved successfully');
            }, function errorCallback(result){

                NotyService.genericError();

                if(result.data.hasOwnProperty('error')){
                    $scope.errors = result.data.error;

                    if($scope.errors.hasOwnProperty('customvariables')){
                        if($scope.errors.customvariables.hasOwnProperty('custom')){
                            $scope.errors.customvariables_unique = [
                                $scope.errors.customvariables.custom
                            ];
                        }
                    }
                }
            });

        };

        $scope.loadContainers();
        $scope.loadCommands();

        jQuery(function(){
            $('.tagsinput').tagsinput();
        });

        $scope.$watch('post.Host.container_id', function(){
            if($scope.init){
                return;
            }
            $scope.loadElements();
            $scope.loadParentHosts('');
        }, true);

        $scope.$watch('post.Host.hosttemplate_id', function(){
            if($scope.init){
                return;
            }
            $scope.loadHosttemplate();
        }, true);

        $scope.$watch('post.Host.command_id', function(){
            if($scope.init){
                return;
            }
            $scope.loadCommandArguments();
        }, true);

        $scope.$watch('data.dnsLookUp', function(){
            if($scope.init){
                return;
            }

            if($scope.data.dnsLookUp === false){
                $scope.data.dnsHostnameNotFound = false;
                $scope.data.dnsAddressNotFound = false;
            }

            LocalStorageService.setItem('HostsDnsLookUpEnabled', $scope.data.dnsLookUp);
        }, true);


    });
