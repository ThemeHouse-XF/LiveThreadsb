<?php
if (false) {

    class XFCP_ThemeHouse_LiveThreads_Extend_XenForo_ControllerPublic_Forum extends XenForo_ControllerPublic_Forum
    {
    }
}

class ThemeHouse_LiveThreads_Extend_XenForo_ControllerPublic_Forum extends XFCP_ThemeHouse_LiveThreads_Extend_XenForo_ControllerPublic_Forum
{

    /**
     *
     * @see XenForo_ControllerPublic_Forum::actionCreateThread()
     */
    public function actionCreateThread()
    {
        $response = parent::actionCreateThread();
        
        if ($response instanceof XenForo_ControllerResponse_View) {
            $forumModel = $this->_getForumModel();
            if (isset($response->params['forum'])) {
                $forum = $response->params['forum'];
                $response->params['canLiveUnliveThread'] = $forumModel->canLiveUnliveThreadInForum($forum);
            }
        }
        
        return $response;
    }

    /**
     *
     * @see XenForo_ControllerPublic_Forum::actionAddThread()
     */
    public function actionAddThread()
    {
        $GLOBALS['XenForo_ControllerPublic_Forum'] = $this;
        
        return parent::actionAddThread();
    }
}