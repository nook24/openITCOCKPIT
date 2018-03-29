<header dashboard-widget-header-directive=""
        class="ui-draggable-handle pointer"
        wtitle="title"
        wid="id"
        update-title="updateTitle({id:id,title:title})">
</header>

<div class="content" style="">

    <!-- widget edit box -->
    <div class="jarviswidget-editbox not-draggable" style="display: none;">
        <!-- This area used as dropdown edit box -->
        <input class="form-control" type="text" placeholder="Widget title" ng-model="title"
               ng-model-options="{debounce: 1000}">
        <span class="note"><i class="fa fa-check text-success"></i>
            <?php echo __('Change title to update and save instantly'); ?>
        </span>
    </div>


    <div class="widget-body padding-0 not-draggable">

        <div class="row">
            <div class="col col-xs-12">
                <select id="ServiceId"
                        data-placeholder="<?php echo __('Please select...'); ?>"
                        class="form-control"
                        chosen="services"
                        callback="loadServices"
                        ng-options="value.id as value.label group by value.group for value in services"
                        ng-model="serviceIds"
                >
                </select>
                <div ng-repeat="error in errors.object_id">
                    <div class="help-block text-danger">{{ error }}</div>
                </div>
            </div>
        </div>

        <div style="padding:13px;">

            <div class="traffic-light" id="traffic-light{{id}}">
                <div ng-click="illuminateRed()" id="redLight{{id}}" class="bulb"></div>
                <div ng-click="illuminateYellow()" id="yellowLight{{id}}" class="bulb"></div>
                <div ng-click="illuminateGreen()" id="greenLight{{id}}" class="bulb"></div>
            </div>

        </div>
    </div>
</div>