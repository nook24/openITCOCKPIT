<?php

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Servicetemplate Entity
 *
 * @property int $id
 * @property string $uuid
 * @property string $template_name
 * @property string $name
 * @property int|null $container_id
 * @property int $servicetemplatetype_id
 * @property int|null $check_period_id
 * @property int|null $notify_period_id
 * @property string $description
 * @property int $command_id
 * @property string $check_command_args
 * @property string $checkcommand_info
 * @property int $eventhandler_command_id
 * @property int|null $timeperiod_id
 * @property int $check_interval
 * @property int $retry_interval
 * @property int $max_check_attempts
 * @property float $first_notification_delay
 * @property float $notification_interval
 * @property int $notify_on_warning
 * @property int $notify_on_unknown
 * @property int $notify_on_critical
 * @property int $notify_on_recovery
 * @property int $notify_on_flapping
 * @property int $notify_on_downtime
 * @property int $flap_detection_enabled
 * @property int $flap_detection_on_ok
 * @property int $flap_detection_on_warning
 * @property int $flap_detection_on_unknown
 * @property bool $flap_detection_on_critical
 * @property float $low_flap_threshold
 * @property float $high_flap_threshold
 * @property int $process_performance_data
 * @property int $freshness_checks_enabled
 * @property int|null $freshness_threshold
 * @property int $passive_checks_enabled
 * @property int $event_handler_enabled
 * @property int $active_checks_enabled
 * @property int $retain_status_information
 * @property int $retain_nonstatus_information
 * @property int $notifications_enabled
 * @property string $notes
 * @property int|null $priority
 * @property string|null $tags
 * @property string|null $service_url
 * @property bool $is_volatile
 * @property bool $check_freshness
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Container $container
 * @property \App\Model\Entity\Timeperiod $check_period
 * @property \App\Model\Entity\Timeperiod $notify_period
 * @property \App\Model\Entity\Command $command
 * @property \App\Model\Entity\EventhandlerCommand $eventhandler_command
 * @property \App\Model\Entity\Timeperiod $timeperiod
 * @property \App\Model\Entity\Contactgroup[] $contactgroups_to_servicetemplates
 * @property \App\Model\Entity\Contact[] $contacts_to_servicetemplates
 * @property \App\Model\Entity\DeletedService[] $deleted_services
 * @property \App\Model\Entity\Servicetemplatecommandargumentvalue[] $servicetemplatecommandargumentvalues
 * @property \App\Model\Entity\Servicetemplateeventcommandargumentvalue[] $servicetemplateeventcommandargumentvalues
 * @property \App\Model\Entity\ServicetemplatesToServicegroup[] $servicetemplates_to_servicegroups
 * @property \App\Model\Entity\ServicetemplatesToServicetemplategroup[] $servicetemplates_to_servicetemplategroups
 */
class Servicetemplate extends Entity {

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
        'uuid'                                      => true,
        'template_name'                             => true,
        'name'                                      => true,
        'container_id'                              => true,
        'servicetemplatetype_id'                    => true,
        'check_period_id'                           => true,
        'notify_period_id'                          => true,
        'description'                               => true,
        'command_id'                                => true,
        'check_command_args'                        => true,
        'checkcommand_info'                         => true,
        'eventhandler_command_id'                   => true,
        'timeperiod_id'                             => true,
        'check_interval'                            => true,
        'retry_interval'                            => true,
        'max_check_attempts'                        => true,
        'first_notification_delay'                  => true,
        'notification_interval'                     => true,
        'notify_on_warning'                         => true,
        'notify_on_unknown'                         => true,
        'notify_on_critical'                        => true,
        'notify_on_recovery'                        => true,
        'notify_on_flapping'                        => true,
        'notify_on_downtime'                        => true,
        'flap_detection_enabled'                    => true,
        'flap_detection_on_ok'                      => true,
        'flap_detection_on_warning'                 => true,
        'flap_detection_on_unknown'                 => true,
        'flap_detection_on_critical'                => true,
        'low_flap_threshold'                        => true,
        'high_flap_threshold'                       => true,
        'process_performance_data'                  => true,
        'freshness_checks_enabled'                  => true,
        'freshness_threshold'                       => true,
        'passive_checks_enabled'                    => true,
        'event_handler_enabled'                     => true,
        'active_checks_enabled'                     => true,
        'retain_status_information'                 => true,
        'retain_nonstatus_information'              => true,
        'notifications_enabled'                     => true,
        'notes'                                     => true,
        'priority'                                  => true,
        'tags'                                      => true,
        'service_url'                               => true,
        'is_volatile'                               => true,
        'check_freshness'                           => true,
        'created'                                   => true,
        'modified'                                  => true,
        'container'                                 => true,
        'check_period'                              => true,
        'notify_period'                             => true,
        'command'                                   => true,
        'eventhandler_command'                      => true,
        'timeperiod'                                => true,
        'contactgroups_to_servicetemplates'         => true,
        'contacts_to_servicetemplates'              => true,
        'servicetemplatecommandargumentvalues'      => true,
        'servicetemplateeventcommandargumentvalues' => true,
        'servicetemplates_to_servicegroups'         => true,
        'servicetemplates_to_servicetemplategroups' => true
    ];
}
