/* Establish top-level namespace */
if (typeof Groupon === 'undefined') {
  Groupon = {};
}

Groupon.FacebookConnect = (function() {

  var userAttrs = [
    'email',
    'first_name',
    'last_name',
    'current_location',
    'hometown_location',
    'about_me',
    'email_hashes',
    'timezone',
    'proxied_email',
    'birthday_date',
    'sex'
  ];

  function init() {
    Event.addBehavior({
      'a[href="/logout"]:click': function(e) {
        e.stop();

        FB.getLoginStatus(function(response) {
          if (response.session) {
            FB.logout(Groupon.Application.logOut);
          } else {
            Groupon.Application.logOut();
          }
        });
      }
    });

    // this will fire when any of the facebook "like" widgets are "liked" by the user
    FB.Event.subscribe('edge.create', function(href, widget) {
      pageTracker._trackEvent('Share',widget.dom.nodeName,widget.dom.attributes["grp"].value);
      Groupon.FacebookConnect.postToFacebookConnect(href,null);
    });

    FB.Event.subscribe('comments.add', function(r) {
      // do something with response.session
      Groupon.FacebookConnect.postToFacebookConnect(r,null);
    });

  }

  function convertResultsToParams(results, password) {
    var user = results[0][0];
    var friendCount = results[1].length;
    var appFriendCount = results[2].length;

    var params = $H({
      'fb[uid]': Groupon.Facebook.userId(),
      'fb[email]': user.email,
      'fb[first_name]': user.first_name,
      'fb[last_name]': user.last_name,
      'fb[about_me]': user.about_me,
      'fb[timezone]': user.timezone,
      'fb[gender]': user.sex,
      'fb[birth_date]': user.birthday_date,
      'fb[email_hashes]': $A(user.email_hashes).join(','),
      'fb[friend_count]': friendCount,
      'fb[app_friend_count]': appFriendCount
    });

    var location = user.current_location && user.current_location.city ?
      (user.current_location) :
      (user.hometown_location);

    if (location) params.update({
      'fb[city]': location.city,
      'fb[state]': location.state,
      'fb[country]': location.country
    });

    if (password) params.update({password: password});

    return params.toQueryString();
  }

  function displayConfirmModal(confirmEmail, callback) {
    new Ajax.Request('/users/confirm_password_modal', {
      method: 'GET',
      parameters: {email_address: confirmEmail},

      onSuccess: function(response) {
        Control.Modal.close(); // in case we had a modal lying around

        $(document.body).insert(response.responseText);

        new Control.Modal($('modal_window'), {
          fade: true,
          afterClose: function() {
            this.destroy();
          }
        }).open();

        Event.addBehavior({
          '#modal_window input[type=submit]:click': function(e) {
            e.stop();
            $$('#modal_window .field.buttons').first().startWaiting();
            callback(true, $$('#modal_window input[name=password]').first().getValue());
          },

          '#modal_window #cancel:click': function(e) {
            e.stop();
            callback(false);
          }
        });
      }
    });
  }

  function postToFacebookConnect(results, password) {
    new Ajax.Request('/session', {
      method: 'POST',
      postBody: convertResultsToParams(results, password),

      onSuccess: function(response) {
        Control.Modal.close(); // in case we had a modal lying around

        // user is logged in and connected on server.
        // we reload the page in a logged-in state.
        var result = JSON.parse(response.responseText);
        if (result.confirmEmail) {
          if (password) {
            addAlert('error', 'Incorrect password.');
          } else {
            displayConfirmModal(result.confirmEmail, function(confirmed, password) {
              if (confirmed) {
                postToFacebookConnect(results, password);
              }
            });
          }
        } else if (result.subscribeEmail) {
          postToNewSubscription(result.subscribeEmail);
        } else if (result.location) {
          location.href = result.location;
        } else {
          Groupon.Application.reloadPage();
        }
      },

      // this should never happen unless the FB signature has been tampered with.
      // we forbibly log the user out of FB and do a refresh.
      onFailure: function() {
        FB.logout(Groupon.Application.reloadPage);
      }
    });
  }

  function postToNewSubscription(email) {
    var queryParams = location.search.parseQuery();
    var zipcode = $('subscription_zipcode');

    var form = $H({
      email_address: email,
      division_id: Groupon.Application.getDivision(),
      zipcode: (zipcode ? zipcode.getValue() : ''),
      utm_source: 'facebook',
      utm_campaign: queryParams.utm_campaign
    }).inject(new Element('form', {method: 'POST', action: '/subscriptions'}).hide(), function(f, pair) {
      return f.insert(new Element('input', {type: 'text', name: 'subscription[' + pair.key + ']', value: pair.value}));
    });

    $(document.body).insert(form);
    form.submit();
  }

  function onConnect() {
    var uid = Groupon.Facebook.userId();

    if (Groupon.Application.isConnectedWithFacebook()) {
      // already logged in and connected, just attempt to resubscribe with FB email
      FB.Data.query("SELECT email FROM user WHERE uid={0}", uid).wait(function(result) {
        postToNewSubscription(result[0].email);
      });
    } else {
      FB.Data.waitOn([
        FB.Data.query("SELECT " + userAttrs.join(",") + " FROM user WHERE uid={0}", uid),
        FB.Data.query("SELECT '' FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1={0})", uid),
        FB.Data.query("SELECT '' FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1={0}) AND is_app_user", uid)
      ], postToFacebookConnect);
    }
  }

  function getGrouponFriendCount(callback) {
    FB.getLoginStatus(function(response) {
      if (response.session) {
        FB.Data.query("SELECT '' FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1={0}) AND is_app_user", Groupon.Facebook.userId()).wait(function(results) {
          callback(results.length);
        });
      }
    });
  }
  function getGrouponFriendUid(callback) {
    FB.getLoginStatus(function(response) {
      if (response.session) {
        FB.Data.query("SELECT uid FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1={0}) AND is_app_user order by rand() limit 10", Groupon.Facebook.userId()).wait(function(results) {
          var facebook_friends = [];
          results.each(function(friend){
             facebook_friends.push(friend.uid);
            });
          callback(facebook_friends);
        });
      }
    });

  }
  function findFriendsWhoBought(container,user,campaign,callback){
    if( parseInt(navigator.userAgent.substring(navigator.userAgent.indexOf("MSIE")+5), 10)!=6 ){
      getGrouponFriendUid(function(results){
        Groupon.Application.post('/facebook_connect/'+campaign+'/'+user+'/friends-purchased',{'method': 'post', 'parameters':{'data':Object.toJSON({'friends': results})},
          onSuccess: function(response){
            callback(response.transport.responseText.evalJSON().friends,container);
          }});
      });
    }
  }
  function disconnect() {
    var uid = Groupon.Facebook.userId();

    if(uid) {
      FB.api({ method: 'auth.revokeAuthorization', uid: uid }, function(response) {
        window.location.href = window.location.href;
      });
    }
  }

  function publishCampaignPurchase(campaign) {
	FB.api(
	    {
		method: 'stream.publish',
		message: 'bought ' + campaign.title,
		attachment: {
		    name: 'Groupon ' + campaign.division.name,
		    href: campaign.url,
		    media: [
			{
			    type: 'image',
			    src: campaign.image,
			    href: campaign.url
			}
		    ]
		},
		action_links: [
		    { text: 'Deal', href: campaign.url }
		]
	    }
	);
  }

  function shareURL(url) {
  	FB.ui({
  	    method: 'stream.share',
  	    u: url
  	});
  }

  function shareBitlyCBURL(data) {
  	var shortUrlObj;
  	for(var longUrl in data.results) {
  	    shortUrlObj = data.results[longUrl];
  	    break;
  	}

  	shareURL(shortUrlObj["shortUrl"]);
  }

  // Groupon.FacebookConnect public API
  return {
    init: init,
    onConnect: onConnect,
    getGrouponFriendCount: getGrouponFriendCount,
    getGrouponFriendUid: getGrouponFriendUid,
    findFriendsWhoBought: findFriendsWhoBought,
    publishCampaignPurchase: publishCampaignPurchase,
    convertResultsToParams: convertResultsToParams, /* Made public so it can be tested */
    disconnect: disconnect,
    shareURL: shareURL,
    shareBitlyCBURL: shareBitlyCBURL,
    postToFacebookConnect: postToFacebookConnect
  };
})();

$(document).observe("facebook:loaded", function() {
  Groupon.FacebookConnect.init();
});
