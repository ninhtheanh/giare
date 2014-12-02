if (typeof Groupon === 'undefined') {
  Groupon = {};
}

// The purpose of this class is to provide a javascript-library-agnostic facade
// between FB and the code that groupon uses to access Facebook data.
// Methods in this class ideally would either execute commands, or return primitives.
// If the FB library changes its api, we should just have to change it here.
Groupon.Facebook = {
  init : function() {
    FB.init({
      appId: Groupon.Attributes.facebook_appid,
      apiKey: Groupon.facebookApiKey,
      status: true,
      cookie: true,
      xfbml: true
    });
  },

  login : function(permissions, callback){
    FB.login(callback, { perms: permissions });
  },

  userId : function() {
    try {
      return FB.getSession().uid;
    } catch (e) {
      return null;
    }
  },

  getMyPages : function(callback) {
    FB.api('/me/accounts', callback);
  },

  updateShareLinksWithTracking: function() {
    var userTracking = Groupon.Attributes.user ? Groupon.Attributes.user.tracking_code : 'Anonymous'
    var shareMustache = new Groupon.Mustaches.ShareLinks(Groupon.Attributes.share_links, userTracking);
    $$('.share')[0].update(Mustache.to_html(Groupon.MustacheTemplates['groupon/deals/_share'], shareMustache));
    $$('.share_inline')[0].update(Mustache.to_html(Groupon.MustacheTemplates['groupon/deals/_inline_share'], shareMustache));
    FB.XFBML.parse($$('.facebook_share').first()); // re-init facebook like button from FBML
  }

};
