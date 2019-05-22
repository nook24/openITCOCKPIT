<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Hash;

/**
 * Service Entity
 *
 * @property int $id
 * @property string $uuid
 * @property int $servicetemplate_id
 * @property int $host_id
 * @property string|null $name
 * @property string|null $description
 * @property int|null $command_id
 * @property string $check_command_args
 * @property int|null $eventhandler_command_id
 * @property int|null $notify_period_id
 * @property int|null $check_period_id
 * @property float|null $check_interval
 * @property float|null $retry_interval
 * @property int|null $max_check_attempts
 * @property float|null $first_notification_delay
 * @property float|null $notification_interval
 * @property int|null $notify_on_warning
 * @property int|null $notify_on_unknown
 * @property int|null $notify_on_critical
 * @property int|null $notify_on_recovery
 * @property int|null $notify_on_flapping
 * @property int|null $notify_on_downtime
 * @property int|null $is_volatile
 * @property int|null $flap_detection_enabled
 * @property int|null $flap_detection_on_ok
 * @property int|null $flap_detection_on_warning
 * @property int|null $flap_detection_on_unknown
 * @property int|null $flap_detection_on_critical
 * @property float|null $low_flap_threshold
 * @property float|null $high_flap_threshold
 * @property int|null $process_performance_data
 * @property int|null $freshness_checks_enabled
 * @property int|null $freshness_threshold
 * @property int|null $passive_checks_enabled
 * @property int|null $event_handler_enabled
 * @property int|null $active_checks_enabled
 * @property int|null $notifications_enabled
 * @property string|null $notes
 * @property int|null $priority
 * @property string|null $tags
 * @property int|null $own_contacts
 * @property int|null $own_contactgroups
 * @property int|null $own_customvariables
 * @property string|null $service_url
 * @property int $service_type
 * @property int|null $disabled
 * @property int $usage_flag
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Host $host
 * @property \App\Model\Entity\Servicetemplate $servicetemplate
 * @property \MkModule\Model\Entity\Mkservicedata $mkservicedata
 * @property \NewModule\Model\Entity\Servicecommandargumentvalue[] $servicecommandargumentvalues
 * @property \App\Model\Entity\Servicegroup[] $servicegroups
 */
class Service extends Entity {
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'uuid'                              => true,
        'servicetemplate_id'                => true,
        'host_id'                           => true,
        'name'                              => true,
        'description'                       => true,
        'command_id'                        => true,
        'check_command_args'                => true,
        'eventhandler_command_id'           => true,
        'notify_period_id'                  => true,
        'check_period_id'                   => true,
        'check_interval'                    => true,
        'retry_interval'                    => true,
        'max_check_attempts'                => true,
        'first_notification_delay'          => true,
        'notification_interval'             => true,
        'notify_on_warning'                 => true,
        'notify_on_unknown'                 => true,
        'notify_on_critical'                => true,
        'notify_on_recovery'                => true,
        'notify_on_flapping'                => true,
        'notify_on_downtime'                => true,
        'is_volatile'                       => true,
        'flap_detection_enabled'            => true,
        'flap_detection_on_ok'              => true,
        'flap_detection_on_warning'         => true,
        'flap_detection_on_unknown'         => true,
        'flap_detection_on_critical'        => true,
        'low_flap_threshold'                => true,
        'high_flap_threshold'               => true,
        'process_performance_data'          => true,
        'freshness_checks_enabled'          => true,
        'freshness_threshold'               => true,
        'passive_checks_enabled'            => true,
        'event_handler_enabled'             => true,
        'active_checks_enabled'             => true,
        'notifications_enabled'             => true,
        'notes'                             => true,
        'priority'                          => true,
        'tags'                              => true,
        'own_contacts'                      => true,
        'own_contactgroups'                 => true,
        'own_customvariables'               => true,
        'service_url'                       => true,
        'service_type'                      => true,
        'disabled'                          => true,
        'usage_flag'                        => true,
        'created'                           => true,
        'modified'                          => true,
        'host'                              => true,
        'servicetemplate'                   => true,
        'mkservicedata'                     => true,
        'servicecommandargumentvalues'      => true,
        'serviceeventcommandargumentvalues' => true,
        'customvariables'                   => true,
        'contactgroups'                     => true,
        'contacts'                          => true,
        'servicegroups'                     => true,
    ];

    /**
     * @return array
     */
    public function getCommandargumentValuesForCfg() {
        $hostcommandargumentvaluesForCfg = [];
        $servicecommandargumentvalues = $this->get('servicecommandargumentvalues');

        foreach ($servicecommandargumentvalues as $servicecommandargumentvalue) {
            /** @var $servicecommandargumentvalue Servicecommandargumentvalue */
            $hostcommandargumentvaluesForCfg[] = [
                'name'       => $servicecommandargumentvalue->get('commandargument')->get('name'),
                'human_name' => $servicecommandargumentvalue->get('commandargument')->get('human_name'),
                'value'      => $servicecommandargumentvalue->get('value')
            ];
        }

        return Hash::sort($hostcommandargumentvaluesForCfg, '{n}.name', 'asc', 'natural');
    }

    /**
     * @return array
     */
    public function getEventhandlerCommandargumentValuesForCfg() {
        $hostcommandargumentvaluesForCfg = [];
        $serviceeventcommandargumentvalues = $this->get('serviceeventcommandargumentvalues');

        foreach ($serviceeventcommandargumentvalues as $serviceeventcommandargumentvalue) {
            /** @var $serviceeventcommandargumentvalue Serviceeventcommandargumentvalue */
            $hostcommandargumentvaluesForCfg[] = [
                'name'       => $serviceeventcommandargumentvalue->get('commandargument')->get('name'),
                'human_name' => $serviceeventcommandargumentvalue->get('commandargument')->get('human_name'),
                'value'      => $serviceeventcommandargumentvalue->get('value')
            ];
        }

        return Hash::sort($hostcommandargumentvaluesForCfg, '{n}.name', 'asc', 'natural');
    }

    public function hasEventhandler() {
        return $this->eventhandler_command_id > 0;
    }

    /**
     * @return bool
     */
    public function hasCustomvariables() {
        return !empty($this->customvariables);
    }

    /**
     * @return array
     */
    public function getCustomvariablesForCfg() {
        $cfgValues = [];
        foreach ($this->customvariables as $Customvariable) {
            /** @var Customvariable $Customvariable */
            $key = sprintf('_%s', $Customvariable->get('name'));
            $cfgValues[$key] = $Customvariable->get('value');
        }
        return $cfgValues;
    }

    /**
     * @return string
     */
    public function getServicegroupsForCfg() {
        $servicegroups = [];
        foreach ($this->servicegroups as $servicegroup) {
            /** @var Servicegroup $servicegroup */
            $servicegroups[] = $servicegroup->get('uuid');
        }
        return implode(',', $servicegroups);
    }

}
