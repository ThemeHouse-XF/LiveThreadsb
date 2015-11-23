<?php
if (false) {

    class XFCP_ThemeHouse_LiveThreads_Extend_XenForo_ControllerPublic_Thread extends XenForo_ControllerPublic_Thread
    {
    }
}

class ThemeHouse_LiveThreads_Extend_XenForo_ControllerPublic_Thread extends XFCP_ThemeHouse_LiveThreads_Extend_XenForo_ControllerPublic_Thread
{

    /**
     *
     * @see XenForo_ControllerPublic_Thread::_getNewPosts()
     */
    public function actionIndex()
    {
        $response = parent::actionIndex();
        
        if ($response instanceof XenForo_ControllerResponse_View) {
            $threadModel = $this->_getThreadModel();
            if (isset($response->params['thread']) && isset($response->params['forum'])) {
                $thread = $response->params['thread'];
                $forum = $response->params['forum'];
                $response->params['canLiveUnliveThread'] = $threadModel->canLiveUnliveThread($thread, $forum);
            }
        }
        
        return $response;
    }

    /**
     *
     * @see XenForo_ControllerPublic_Thread::_getNewPosts()
     */
    protected function _getNewPosts(array $thread, array $forum, $lastDate, $limit = 3)
    {
        $xenOptions = XenForo_Application::get('options');
        
        if (!empty($thread['isLive'])) {
            $limit = $xenOptions->th_liveThreads_maximumPostsVisible;
        }
        
        $viewParams = parent::_getNewPosts($thread, $forum, $lastDate, $limit);
        
        if (!empty($thread['isLive'])) {
            unset($viewParams['firstUnshownPost']);
        }
        
        return $viewParams;
    }

    public function actionEdit()
    {
        $response = parent::actionEdit();
        
        if ($response instanceof XenForo_ControllerResponse_View) {
            $threadModel = $this->_getThreadModel();
            if (isset($response->params['thread']) && isset($response->params['forum'])) {
                $thread = $response->params['thread'];
                $forum = $response->params['forum'];
                $response->params['canLiveUnliveThread'] = $threadModel->canLiveUnliveThread($thread, $forum);
            }
        }
        
        return $response;
    }

    /**
     *
     * @see XenForo_ControllerPublic_Thread::actionSave()
     */
    public function actionSave()
    {
        $GLOBALS['XenForo_ControllerPublic_Thread'] = $this;
        
        return parent::actionSave();
    }

    /**
     *
     * @see XenForo_ControllerPublic_Thread::actionQuickUpdate()
     */
    public function actionQuickUpdate()
    {
        $GLOBALS['XenForo_ControllerPublic_Thread'] = $this;
        
        return parent::actionQuickUpdate();
    }

    public function actionLiveRefresh()
    {
        $this->_assertPostOnly();
        
        $threadId = $this->_input->filterSingle('thread_id', XenForo_Input::UINT);
        
        $ftpHelper = $this->getHelper('ForumThreadPost');
        list($thread, $forum) = $ftpHelper->assertThreadValidAndViewable($threadId);
        
        if (empty($thread['isLive'])) {
            return $this->responseNoPermission();
        }
        
        $lastDate = $this->_input->filterSingle('last_date', XenForo_Input::UINT);
        $lastKnownDate = $this->_input->filterSingle('last_known_date', XenForo_Input::UINT);
        $lastKnownDate = max($lastDate, $lastKnownDate);
        
        if ($lastDate) {
            $posts = $this->_getPostModel()->getNewestPostsInThreadAfterDate($threadId, $lastKnownDate);
            $visitor = XenForo_Visitor::getInstance();
            foreach ($posts as $key => $post) {
                if ($visitor->isIgnoring($post['user_id'])) {
                    unset($posts[$key]);
                }
            }
            
            $newPostCount = count($posts);
        } else {
            $newPostCount = 0;
        }
        
        $viewParams = array(
            'thread' => $thread,
            'newPostCount' => $newPostCount,
            'lastDate' => $lastDate,
            'draftSaved' => false,
            'draftDeleted' => false
        );
        return $this->responseView('XenForo_ViewPublic_Thread_SaveDraft', 'thread_save_draft', $viewParams);
    }
}