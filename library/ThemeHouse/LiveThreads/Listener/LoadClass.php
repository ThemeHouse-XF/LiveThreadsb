<?php

class ThemeHouse_LiveThreads_Listener_LoadClass extends ThemeHouse_Listener_LoadClass
{

    protected function _getExtendedClasses()
    {
        return array(
            'ThemeHouse_LiveThreads' => array(
                'controller' => array(
                    'XenForo_ControllerPublic_Thread',
                    'XenForo_ControllerPublic_Forum'
                ),
                'model' => array(
                    'XenForo_Model_Thread',
                    'XenForo_Model_Forum',
                    'XenForo_Model_Post',
                    'XenForo_Model_ThreadWatch'
                ),
                'datawriter' => array(
                    'XenForo_DataWriter_Discussion_Thread'
                ),
            ),
        );
    }

    public static function loadClassController($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_LiveThreads_Listener_LoadClass', $class, $extend, 'controller');
    }

    public static function loadClassModel($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_LiveThreads_Listener_LoadClass', $class, $extend, 'model');
    }

    public static function loadClassDataWriter($class, array &$extend)
    {
        $extend = self::createAndRun('ThemeHouse_LiveThreads_Listener_LoadClass', $class, $extend, 'datawriter');
    }
}