<?php
if (false) {

    class XFCP_ThemeHouse_LiveThreads_Extend_XenForo_Model_ThreadWatch extends XenForo_Model_ThreadWatch
    {
    }
}

class ThemeHouse_LiveThreads_Extend_XenForo_Model_ThreadWatch extends XFCP_ThemeHouse_LiveThreads_Extend_XenForo_Model_ThreadWatch
{

    /**
     *
     * @see XenForo_Model_ThreadWatch::sendNotificationToWatchUsersOnReply()
     */
    public function sendNotificationToWatchUsersOnReply(array $reply, array $thread = null, array $noAlerts = array())
    {
        $xenOptions = XenForo_Application::get('options');
        
        if ($xenOptions->th_liveThreads_disableWatchAlerts && !empty($thread['live_th'])) {
            return false;
        }
        
        return parent::sendNotificationToWatchUsersOnReply($reply, $thread, $noAlerts);
    }
}