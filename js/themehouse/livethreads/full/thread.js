/**
 * @author th
 */

/** @param {jQuery} $ jQuery Object */
!function($, window, document, _undefined)
{
	if (typeof ThemeHouse === "undefined") ThemeHouse = {};
	
	var liveThreadRemoveInProgress = false;
	
	$.extend(ThemeHouse,
	{
		liveThreadsOptions: {},
		quickReplyInProgress: false,
		quickReplyCount: 0,
		messageSinceReplyingInProgress: false
	}),
		
	ThemeHouse.NewMessageLoader = function($ctrl)
	{
		if (!ThemeHouse.quickReplyInProgress && !ThemeHouse.messageSinceReplyingInProgress) {
			if ($ctrl.parent().hasClass('messagesSinceReplyingNotice'))
			{
				ThemeHouse.messageSinceReplyingInProgress = true;
				XenForo.ajax(
					$ctrl.data('href') || $ctrl.attr('href'),
					{},
					function(ajaxData) {
						if (XenForo.hasResponseError(ajaxData))
						{
							return false;
						}

						var $form = $('#QuickReply'),
							$messageList = $('#messageList');

						$('input[name="last_date"]', $form).val(ajaxData.lastDate);

						new XenForo.ExtLoader(ajaxData, function()
						{
							$messageList.find('.messagesSinceReplyingNotice').remove();

							$(ajaxData.templateHtml).each(function()
							{
								if (this.tagName)
								{
									$(this).xfInsert('appendTo', $messageList);
								}
							});
						});
						
						ThemeHouse.messageSinceReplyingInProgress = false;
					}
				)
			}
		}
	};

	ThemeHouse.MessageInfo = function($messageInfo)
	{
		id = $messageInfo.parent().attr('id');
		if ($('li[id=' + id + ']').length > 1) {
			$messageInfo.parent().remove();
		}
		
		function removeIfMoreThan20Messages() {
			if (liveThreadRemoveInProgress) {
				return;
			}
			liveThreadRemoveInProgress = true;
			var messages = $('.messageList .message').length;
			if (messages > 20)
			{
				$('.messageList .message').first().remove(null, function() {
					liveThreadRemoveInProgress = false;
					removeIfMoreThan20Messages();
				});
			} else {
				liveThreadRemoveInProgress = false;
			}
		}
		
		removeIfMoreThan20Messages();
	};

	var Super = XenForo.BbCodeWysiwygEditor.prototype;
	
	$.extend(XenForo.BbCodeWysiwygEditor.prototype,
	{
		_superConstruct: Super.__construct,
		
		__construct: function($textarea)
		{
			this._superConstruct($textarea);
			
			this.initLiveRefresh();
		},
		
		initLiveRefresh: function()
		{
			var self = this,
				$form = this.$textarea.closest('form');

			if (!$form.length)
			{
				return;
			}

			refreshFrequency = this.getRefreshFrequency();
			
			window.setTimeout(function() {
				self.liveRefresh();
			}, refreshFrequency * 1000);
		},
		
		liveRefresh: function()
		{
			var self = this,
				$form = this.$textarea.closest('form');

			flagId = ThemeHouse.quickReplyCount;
			
			if (!ThemeHouse.quickReplyInProgress && !ThemeHouse.messageSinceReplyingInProgress && !this.autoSaveRunning) {
				this.autoSaveRunning = true;

				XenForo.ajax(
					ThemeHouse.liveThreadsOptions.liveRefreshUrl,
					$form.serialize(),
					function(ajaxData) {
						if (!ThemeHouse.quickReplyInProgress && flagId == ThemeHouse.quickReplyCount) {
							var e = $.Event('BbCodeWysiwygEditorAutoSaveComplete');
							e.ajaxData = ajaxData;
							$form.trigger(e);
						}
					},
					{global: false}
				).complete(function() {
					self.autoSaveRunning = false;
					refreshFrequency = self.getRefreshFrequency();
					
					window.setTimeout(function() {
						self.liveRefresh();
					}, refreshFrequency * 1000);
				});
			} else {
				refreshFrequency = this.getRefreshFrequency();
				
				window.setTimeout(function() {
					self.liveRefresh();
				}, refreshFrequency * 1000);
			}

			return true;
		},
		
		getRefreshFrequency: function()
		{
			lastDate = $('input[name=last_date]').val();
			
			if (!Date.now)
			{
			    Date.now = function() { return new Date().getTime(); }
			}
			
			secondsSinceLastPost = Math.floor(Date.now() / 1000) - lastDate;
			
			refreshFrequency = Math.max(1, ThemeHouse.liveThreadsOptions.refreshFrequencyMinimum, secondsSinceLastPost/10);
			refreshFrequency = Math.min(ThemeHouse.liveThreadsOptions.refreshFrequencyMaximum, refreshFrequency);
			
			return refreshFrequency;
		}
	});
	
	ThemeHouse.QuickReply = function($form)
	{
		$form.data('ThemeHouseQuickReply', this).bind(
		{
			/**
			 * Fires just before the form would be AJAX submitted,
			 * to detect whether or not the 'more options' button was clicked,
			 * and to abort AJAX submission if it was.
			 *
			 * @param event e
			 * @return
			 */
			AutoValidationBeforeSubmit: function(e)
			{
				var $messageList = $('#messageList'),
				$notice = $messageList.find('.messagesSinceReplyingNotice');

				if ($notice.length) {
					$notice.remove();
				}
			
				ThemeHouse.quickReplyInProgress = true;
				ThemeHouse.quickReplyCount = ThemeHouse.quickReplyCount + 1;
			},

			/**
			 * Fires after the AutoValidator form has successfully validated the AJAX submission
			 *
			 * @param event e
			 */
			AutoValidationComplete: function(e)
			{
				ThemeHouse.quickReplyInProgress = false;
			}
		});
	};

    XenForo.register('.NewMessageLoader', 'ThemeHouse.NewMessageLoader');
    XenForo.register('.messageInfo', 'ThemeHouse.MessageInfo');
	XenForo.register('#QuickReply', 'ThemeHouse.QuickReply');
}
(jQuery, this, document);