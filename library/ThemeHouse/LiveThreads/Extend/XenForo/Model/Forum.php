<?php
if (false) {

    class XFCP_ThemeHouse_LiveThreads_Extend_XenForo_Model_Forum extends XenForo_Model_Forum
    {
    }
}

class ThemeHouse_LiveThreads_Extend_XenForo_Model_Forum extends XFCP_ThemeHouse_LiveThreads_Extend_XenForo_Model_Forum
{

    /**
     * Determines if a thread can be created live with the given permissions.
     * This does not check thread viewing permissions.
     *
     * @param array $forum
     * @param string $errorPhraseKey
     * @param array|null $nodePermissions
     * @param array|null $viewingUser
     *
     * @return boolean
     */
    public function canLiveUnliveThreadInForum(array $forum, &$errorPhraseKey = '', array $nodePermissions = null, 
        array $viewingUser = null)
    {
        $this->standardizeViewingUserReferenceForNode($forum['node_id'], $viewingUser, $nodePermissions);
        return ($viewingUser['user_id'] && XenForo_Permission::hasContentPermission($nodePermissions, 
            'liveUnliveThread'));
    }
}