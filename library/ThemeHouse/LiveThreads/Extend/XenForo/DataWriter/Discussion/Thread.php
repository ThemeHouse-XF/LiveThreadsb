<?php
if (false) {

    class XFCP_ThemeHouse_LiveThreads_Extend_XenForo_DataWriter_Discussion_Thread extends XenForo_DataWriter_Discussion_Thread
    {
    }
}

class ThemeHouse_LiveThreads_Extend_XenForo_DataWriter_Discussion_Thread extends XFCP_ThemeHouse_LiveThreads_Extend_XenForo_DataWriter_Discussion_Thread
{

    /**
     *
     * @see XenForo_DataWriter_Discussion_Thread::_getFields()
     */
    protected function _getFields()
    {
        $fields = parent::_getFields();
        
        $fields['xf_thread']['live_th'] = array(
            'type' => self::TYPE_UINT,
            'default' => 0
        );
        
        return $fields;
    }

    /**
     *
     * @see XenForo_DataWriter_Discussion_Thread::_discussionPreSave()
     */
    protected function _discussionPreSave()
    {
        parent::_discussionPreSave();
        
        /* @var $controller XenForo_ControllerPublic_Abstract */
        if (!empty($GLOBALS['XenForo_ControllerPublic_Forum'])) {
            $controller = $GLOBALS['XenForo_ControllerPublic_Forum'];
        } elseif (!empty($GLOBALS['XenForo_ControllerPublic_Thread'])) {
            $controller = $GLOBALS['XenForo_ControllerPublic_Thread'];
        }
        
        if (!empty($controller)) {
            $input = $controller->getInput()->filter(
                array(
                    'live' => XenForo_Input::UINT,
                    'live_shown' => XenForo_Input::UINT
                ));
            
            if ($input['live_shown']) {
                $threadModel = $this->_getThreadModel();
                $thread = $this->getMergedData();
                $forum = $this->_getForumData();
                
                if ($threadModel->canLiveUnliveThread($thread, $forum)) {
                    $this->set('live_th', $input['live']);
                }
            }
        }
    }
}