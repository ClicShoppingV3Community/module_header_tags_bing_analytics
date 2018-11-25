<?php
/**
 *
 *  @copyright 2008 - https://www.clicshopping.org
 *  @Brand : ClicShopping(Tm) at Inpi all right Reserved
 *  @Licence GPL 2 & MIT
 *  @licence MIT - Portion of osCommerce 2.4
 *
 *
 */

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\CLICSHOPPING;

  class ht_bing_metatag_analytics {
    public $code;
    public $group;
    public $title;
    public $description;
    public $sort_order;
    public $enabled = false;

    public function __construct() {
      $this->code = get_class($this);
      $this->group = basename(__DIR__);

      $this->title = CLICSHOPPING::getDef('module_header_tags_bing_metatag_analytics_title');
      $this->description = CLICSHOPPING::getDef('module_header_tags_bing_metatag_analytics_description');

      if ( defined('MODULE_HEADER_TAGS_BING_METATAG_ANALYTICS_STATUS') ) {
        $this->sort_order = MODULE_HEADER_TAGS_BING_METATAG_ANALYTICS_SORT_ORDER;
        $this->enabled = (MODULE_HEADER_TAGS_BING_METATAG_ANALYTICS_STATUS == 'True');
      }
    }

    public function execute() {

      $CLICSHOPPING_Template = Registry::get('Template');

      $CLICSHOPPING_Template->addBlock('<meta name="msvalidate.01" content="'. MODULE_HEADER_TAGS_BING_METATAG_ANALYTICS_NUMBER .'">', $this->group);
    }

    public function isEnabled() {
      return $this->enabled;
    }

    public function check() {
      return defined('MODULE_HEADER_TAGS_BING_METATAG_ANALYTICS_STATUS');
    }

    public function install() {
      $CLICSHOPPING_Db = Registry::get('Db');

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Souhaitez vous activer ce module ?',
          'configuration_key' => 'MODULE_HEADER_TAGS_BING_METATAG_ANALYTICS_STATUS',
          'configuration_value' => 'True',
          'configuration_description' => 'Souhaitez vous activer ce module ?',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_boolean_value(array(\'true\', \'false\'))',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Souhaitez-vous insérer le code de Bing Webmaster Tools (Gestion des statistiques) ?',
          'configuration_key' => 'MODULE_HEADER_TAGS_BING_METATAG_ANALYTICS_NUMBER',
          'configuration_value' => '',
          'configuration_description' => 'Veuillez insérer le code  que Microsoft Bing Webmaster Tools vous a fourni<br /><br />(ex : CC2D9D08C5051AF18516581728430C18)',
          'configuration_group_id' => '6',
          'sort_order' => '2',
          'set_function' => '',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Ordre de tri d\'affichage',
          'configuration_key' => 'MODULE_HEADER_TAGS_BING_METATAG_ANALYTICS_SORT_ORDER',
          'configuration_value' => '10',
          'configuration_description' => 'Ordre de tri pour l\'affichage (Le plus petit nombre est montré en premier)',
          'configuration_group_id' => '6',
          'sort_order' => '10',
          'set_function' => '',
          'date_added' => 'now()'
        ]
      );

      return $CLICSHOPPING_Db->save('configuration', ['configuration_value' => '1'],
                                               ['configuration_key' => 'WEBSITE_MODULE_INSTALLED']
                            );
    }

    public function remove() {
      return Registry::get('Db')->exec('delete from :table_configuration where configuration_key in ("' . implode('", "', $this->keys()) . '")');
    }

    public function keys() {
      return array('MODULE_HEADER_TAGS_BING_METATAG_ANALYTICS_STATUS',
                   'MODULE_HEADER_TAGS_BING_METATAG_ANALYTICS_NUMBER',
                   'MODULE_HEADER_TAGS_BING_METATAG_ANALYTICS_SORT_ORDER');
    }
  }
