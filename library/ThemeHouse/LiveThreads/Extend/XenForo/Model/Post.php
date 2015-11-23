<?php
if (false) {

    class XFCP_ThemeHouse_LiveThreads_Extend_XenForo_Model_Post extends XenForo_Model_Post
    {
    }
}

class ThemeHouse_LiveThreads_Extend_XenForo_Model_Post extends XFCP_ThemeHouse_LiveThreads_Extend_XenForo_Model_Post
{

    /**
     *
     * @see XenForo_Model_Post::alertQuotedMembers()
     */
    public function alertQuotedMembers(array $post, array $thread, array $forum)
    {
        $xenOptions = XenForo_Application::get('options');
        
        if ($xenOptions->th_liveThreads_disableTaggingQuoteAlerts) {
            return false;
        }
        
        return parent::alertQuotedMembers($post, $thread, $forum);
    }

    /**
     *
     * @see XenForo_Model_Post::alertTaggedMembers()
     */
    public function alertTaggedMembers(array $post, array $thread, array $forum, array $tagged, array $alreadyAlerted)
    {
        $xenOptions = XenForo_Application::get('options');
        
        if ($xenOptions->th_liveThreads_disableTaggingQuoteAlerts) {
            return false;
        }
        
        return parent::alertTaggedMembers($post, $thread, $forum, $tagged, $alreadyAlerted);
    }
}