{{--share buttons js--}}
<script async defer src="//assets.pinterest.com/js/pinit.js"></script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<div id="fb-root" class="hidden"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6&appId=861532167251175";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
{{--end share button code--}}

<ul class="list-inline">
    {{--Facebook Share Button--}}
    @if (!$exclude || !in_array('facebook', $exclude))
        <li><div class="fb-share-button" data-href="{{ $shareUrl }}" data-layout="button"></div></li>
    @endif

    {{--Twitter Share Button--}}
    @if (!$exclude || !in_array('twitter', $exclude))
        <li><a href="https://twitter.com/share" class="twitter-share-button">Tweet</a></li>
    @endif

    {{--Google+ Share Button--}}
    @if (!$exclude || !in_array('google-plus', $exclude))
        <li><g:plus action="share" data-annotation="none"></g:plus></li>
    @endif

    {{--Pinterest share button--}}
    @if (!$exclude || !in_array('pinterest', $exclude))
        <li>
            <a href="https://www.pinterest.com/pin/create/button/?media={{ $shareSubject }}&url={{ $shareUrl }}&description={{ urlencode($shareText) }}"
               data-pin-do="buttonPin" data-pin-color="red">
            </a>
        </li>
    @endif
</ul>