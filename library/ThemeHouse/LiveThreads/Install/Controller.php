<?php

class ThemeHouse_LiveThreads_Install_Controller extends ThemeHouse_Install
{

    protected $_resourceManagerUrl = 'https://xenforo.com/community/resources/live_threads.4141/';

    protected $_minVersionId = 1020000;

    protected $_minVersionString = '1.2.0';

    protected function _getTableChanges()
    {
        return array(
            'xf_thread' => array(
                'live_th' => 'tinyint UNSIGNED NOT NULL DEFAULT 0'
            )
        );
    }


    protected function _postInstall()
    {
        $addOn = $this->getModelFromCache('XenForo_Model_AddOn')->getAddOnById('YoYo_');
        if ($addOn) {
            $db->query("
                UPDATE xf_thread
                    SET live_th=live_waindigo");
        }
    }
}