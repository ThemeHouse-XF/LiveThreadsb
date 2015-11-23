<?php
if (false) {

    class XFCP_ThemeHouse_LiveThreads_Extend_XenForo_Model_Thread extends XenForo_Model_Thread
    {
    }
}

class ThemeHouse_LiveThreads_Extend_XenForo_Model_Thread extends XFCP_ThemeHouse_LiveThreads_Extend_XenForo_Model_Thread
{

    /**
     *
     * @see XenForo_Model_Thread::prepareThread()
     */
    public function prepareThread(array $thread, array $forum, array $nodePermissions = null, array $viewingUser = null)
    {
        $thread['isLive'] = $thread['live_th'] &&
             $this->canLiveRefreshThread($thread, $forum, $errorPhraseKey, $nodePermissions, $viewingUser);
        
        return parent::prepareThread($thread, $forum, $nodePermissions, $viewingUser);
    }

    /**
     * Determines if the thread can be live-refreshed with the given
     * permissions.
     * This does not check thread viewing permissions.
     *
     * @param array $thread
     * @param array $forum
     * @param string $errorPhraseKey
     * @param array|null $nodePermissions
     * @param array|null $viewingUser
     *
     * @return boolean
     */
    public function canLiveRefreshThread(array $thread, array $forum, &$errorPhraseKey = '', array $nodePermissions = null, 
        array $viewingUser = null)
    {
        $this->standardizeViewingUserReferenceForNode($thread['node_id'], $viewingUser, $nodePermissions);
        return ($viewingUser['user_id'] &&
             XenForo_Permission::hasContentPermission($nodePermissions, 'liveRefreshThread'));
    }

    /**
     * Determines if the thread can be made live with the given permissions.
     * This does not check thread viewing permissions.
     *
     * @param array $thread
     * @param array $forum
     * @param string $errorPhraseKey
     * @param array|null $nodePermissions
     * @param array|null $viewingUser
     *
     * @return boolean
     */
    public function canLiveUnliveThread(array $thread, array $forum, &$errorPhraseKey = '', array $nodePermissions = null, 
        array $viewingUser = null)
    {
        $this->standardizeViewingUserReferenceForNode($thread['node_id'], $viewingUser, $nodePermissions);
        return ($viewingUser['user_id'] && XenForo_Permission::hasContentPermission($nodePermissions, 
            'liveUnliveThread'));
    }
}