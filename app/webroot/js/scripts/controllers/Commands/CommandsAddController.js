angular.module('openITCOCKPIT')
    .controller('CommandsAddController', function($scope, $http, SudoService, $state, NotyService, RedirectService){
        $scope.post = {
            Command: {
                name: '',
                command_type: '1',
                command_line: '',
                description: '',
                commandarguments: []
            }
        };

        $scope.init = true;
        $scope.hasError = null;
        $scope.hasWebSocketError = false;

        $scope.args = [];
        $scope.macros = [];
        $scope.jqConsole = null;

        $scope.removeArg = function(arg){
            var args = [];
            for(var i in $scope.args){
                if($scope.args[i].id !== arg.id){
                    args.push($scope.args[i])
                }
            }

            $scope.args = _.sortBy(args, 'id');
        };

        $scope.addArg = function(){
            var argsCount = 1;
            var allIds = _.map($scope.args, 'id');
            while(in_array(argsCount, allIds)){
                argsCount++;
            }
            $scope.args.push({
                id: argsCount,
                name: '$ARG' + argsCount + '$',
                human_name: ''
            });
            $scope.args = _.sortBy($scope.args, 'id');
        };


        $scope.submit = function(){
            var index = 0;
            for(var i in $scope.args){
                if(!/\S/.test($scope.args[i].human_name)){
                    continue;
                }
                $scope.post.Command.commandarguments[index] = {
                    'name': $scope.args[i].name,
                    'human_name': $scope.args[i].human_name
                };
                index++;
            }
            $http.post("/commands/add.json?angular=true",
                $scope.post
            ).then(function(result){
                var url = $state.href('CommandsEdit', {id: result.data.id});
                NotyService.genericSuccess({
                    message: '<u><a href="' + url + '" class="txt-color-white"> '
                        + $scope.successMessage.objectName
                        + '</a></u> ' + $scope.successMessage.message
                });
                RedirectService.redirectWithFallback('CommandsIndex');
            }, function errorCallback(result){
                if(result.data.hasOwnProperty('error')){
                    NotyService.genericError();
                    $scope.errors = result.data.error;
                }
            });
        };

        $scope.showMacros = function(){
            $http.get('/macros/index/.json', {
                params: {
                    'angular': true
                }
            }).then(function(result){
                $scope.macros = result.data.all_macros;
                $("#MacrosOverview").modal("show");
            });
        };

        $scope.createJQConsole = function(){

            if(SudoService.hasError()){
                $scope.hasWebSocketError = true;
                $('#console').block({
                    fadeIn: 1000,
                    message: '<i class="fa fa-minus-circle fa-5x"></i>',
                    theme: false
                });
                $('.blockElement').css({
                    'background-color': '',
                    'border': 'none',
                    'color': '#FFFFFF'
                });
            }

            $scope.jqConsole = $('#console').jqconsole('', 'nagios$ ');
            $http.get('/commands/getConsoleWelcome/.json', {
                params: {
                    'angular': true
                }
            }).then(function(result){
                $scope.jqConsole.Write(result.data.welcomeMessage);
            });

            SudoService.onResponse(function(response){
                if(typeof response.data !== 'undefined'){
                    var payload = JSON.parse(response.data);
                    $scope.jqConsole.Write(payload.payload, 'jqconsole-output');
                }
            });

            var newLineInPromt = function(){
                $scope.jqConsole.Prompt(true, function(input){
                    SudoService.send(SudoService.toJson('execute_nagios_command', input));
                    newLineInPromt();
                });
            };
            newLineInPromt();
        };
        setTimeout($scope.createJQConsole, 250);
    });
